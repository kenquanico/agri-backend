import onnx
import torch
import onnx2pytorch

onnx_model = onnx.load("yolov8.onnx")
from onnx2pytorch import ConvertModel
pytorch_model = ConvertModel(onnx_model)
torch.save(pytorch_model.state_dict(), "yolov8_reconstructed.pt")
