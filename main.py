from fastapi import FastAPI
from pydantic import BaseModel
from ultralytics import YOLO
import base64
import io
from PIL import Image
import numpy as np
import asyncio
from concurrent.futures import ThreadPoolExecutor
import traceback
from fastapi import UploadFile, File

app = FastAPI()
executor = ThreadPoolExecutor()

class ImageRequest(BaseModel):
    image: str
    model_path: str = "best.pt"
    confidence: float = 0.2
    format: str = "png"

loaded_models = {}

async def run_model(model: YOLO, image: np.ndarray):
    loop = asyncio.get_running_loop()
    return await loop.run_in_executor(executor, lambda: model(image))

@app.post("/get-classes")
async def get_classes(model_file: UploadFile = File(...)):
    try:
        temp_path = f"temp_{model_file.filename}"
        with open(temp_path, "wb") as f:
            f.write(await model_file.read())

        model = YOLO(temp_path)

        class_list = list(model.names.values()) if isinstance(model.names, dict) else list(model.names)

        return {"classes": class_list}

    except Exception as e:
        return {"error": str(e), "trace": traceback.format_exc()}

@app.post("/detect")
async def detect(data: ImageRequest):
    try:
        image_base64 = data.image.split(",", 1)[1] if data.image.startswith("data:") else data.image
        image_bytes = base64.b64decode(image_base64)
        pil_image = Image.open(io.BytesIO(image_bytes)).convert("RGB")
        image = np.array(pil_image)

        if data.model_path not in loaded_models:
            loaded_models[data.model_path] = YOLO(data.model_path)
        model = loaded_models[data.model_path]

        results = await run_model(model, image)

        detections = []
        boxes = results[0].boxes.data.tolist() if hasattr(results[0].boxes, 'data') else []
        classes = results[0].boxes.cls.tolist() if hasattr(results[0].boxes, 'cls') else []
        confidences = results[0].boxes.conf.tolist() if hasattr(results[0].boxes, 'conf') else []

        for box, cls, conf in zip(boxes, classes, confidences):
            if conf >= data.confidence:  # use dynamic confidence threshold
                class_name = model.names[int(cls)] if model.names else str(int(cls))
                detections.append({
                    "box": box,
                    "class": class_name,
                    "confidence": conf
                })

        return {"detections": detections}

    except Exception as e:
        return {"error": str(e), "trace": traceback.format_exc()}
