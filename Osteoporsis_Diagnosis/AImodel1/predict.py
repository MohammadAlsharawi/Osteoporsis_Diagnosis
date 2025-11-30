# densenet_inference.py
# Cleanest possible inference code for DenseNet121 (no GradCAM)

import os
import torch
import torch.nn as nn
import torch.nn.functional as F
from torchvision import models, transforms
from PIL import Image
import numpy as np
import matplotlib.pyplot as plt

# -------------------------------------------------------------
# USER SETTINGS - EDIT THESE
# -------------------------------------------------------------
MODEL_PATH = r"C:\Users\mhd20\Downloads\final_model.pth"  # <-- your model
IMAGE_PATH = r"C:\Users\mhd20\Desktop\New folder\kaggle\osteoporosis\osteoporosis\15.png"           # <-- image to predict
CLASS_NAMES = ["normal", "osteopenia", "osteoporosis"]  # your class order
# -------------------------------------------------------------

DEVICE = torch.device("cuda" if torch.cuda.is_available() else "cpu")
print("Using device:", DEVICE)

# Preprocessing
preprocess = transforms.Compose([
    transforms.Resize((224, 224)),
    transforms.ToTensor(),
    transforms.Normalize([0.485, 0.456, 0.406],
                         [0.229, 0.224, 0.225])
])


# -------------------------------------------------------------
# Load DenseNet121
# -------------------------------------------------------------
def load_model(model_path, num_classes=len(CLASS_NAMES), device=DEVICE):
    model = models.densenet121(weights=None)  # No ImageNet weights
    in_features = model.classifier.in_features
    model.classifier = nn.Linear(in_features, num_classes)

    # Load weights safely
    try:
        state = torch.load(model_path, map_location=device, weights_only=True)
    except TypeError:
        state = torch.load(model_path, map_location=device)

    # Support checkpoint format
    if isinstance(state, dict) and "model_state_dict" in state:
        state = state["model_state_dict"]

    model.load_state_dict(state)
    model.to(device)
    model.eval()
    return model


# -------------------------------------------------------------
# Predict single image
# -------------------------------------------------------------
def predict_image(model, image_path, class_names=CLASS_NAMES, device=DEVICE):
    if not os.path.exists(image_path):
        raise FileNotFoundError(f"Image not found: {image_path}")

    img = Image.open(image_path).convert("RGB")
    input_tensor = preprocess(img).unsqueeze(0).to(device)

    with torch.no_grad():
        logits = model(input_tensor)
        probs = F.softmax(logits, dim=1).cpu().numpy()[0]

    pred_idx = int(np.argmax(probs))
    pred_label = class_names[pred_idx]

    # Print results
    print("\n===== Prediction Result =====")
    print(f"Predicted class: {pred_label}")
    print("Probabilities:")
    for i, cls in enumerate(class_names):
        print(f"  {cls}: {probs[i]:.4f}")

    # Show image
    plt.imshow(img)
    plt.title(f"Prediction: {pred_label}")
    plt.axis("off")
    plt.show()

    return pred_label, probs


# -------------------------------------------------------------
# RUN
# -------------------------------------------------------------
model = load_model(MODEL_PATH)
predict_image(model, IMAGE_PATH)
