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

app = FastAPI()
model = YOLO("best.pt")
executor = ThreadPoolExecutor()

class ImageRequest(BaseModel):
    image: str
    format: str = "png"  # optional

async def run_model(image: np.ndarray):
    loop = asyncio.get_running_loop()
    return await loop.run_in_executor(executor, lambda: model(image))

@app.post("/detect")
async def detect(data: ImageRequest):
    try:
        # Remove Base64 prefix if present
        image_base64 = data.image.split(",", 1)[1] if data.image.startswith("data:") else data.image

        # Decode Base64
        image_bytes = base64.b64decode(image_base64)

        # Open image and convert to RGB
        pil_image = Image.open(io.BytesIO(image_bytes)).convert("RGB")

        # Convert to numpy array
        image = np.array(pil_image)

        # Run YOLO inference asynchronously
        results = await run_model(image)

        detections = []
        boxes = results[0].boxes.data.tolist() if hasattr(results[0].boxes, 'data') else []
        classes = results[0].boxes.cls.tolist() if hasattr(results[0].boxes, 'cls') else []
        confidences = results[0].boxes.conf.tolist() if hasattr(results[0].boxes, 'conf') else []

        for box, cls, conf in zip(boxes, classes, confidences):
            if conf >= 0.2:
                class_name = model.names[int(cls)] if model.names else str(int(cls))
                detections.append({
                    "box": box,
                    "class": class_name,
                    "confidence": conf
                })

        return {"detections": detections}

    except Exception as e:
        return {
            "error": str(e),
            "trace": traceback.format_exc()
        }
