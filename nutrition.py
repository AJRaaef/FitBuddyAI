# nutrition.py
import pandas as pd
import numpy as np
import json
import mysql.connector
from datetime import datetime

# ---------- MySQL Connection ----------
conn = mysql.connector.connect(
  host="localhost",
        user="root",
            password="",
            database="fitbuddyai"
)
cursor = conn.cursor(dictionary=True)

# ---------- Load JSON Model ----------
with open("nutrition_plan_model/model2_complete_nutrition_plan.json", "r") as f:
    model_json = json.load(f)

# Extract model params, encoders
model_params = model_json["model_params"]
label_encoders_dict = model_json["label_encoders"]
target_classes = model_json["target_encoder"]["classes"]

# Function to inverse transform target
def inverse_transform_target(pred_idx):
    return target_classes[pred_idx]

# Function to encode categorical features
def encode_feature(col, val):
    if col in label_encoders_dict:
        classes = label_encoders_dict[col]["classes"]
        if val in classes:
            return classes.index(val)
        else:
            return 0  # fallback if unseen
    else:
        return val

# ---------- Get user_id from argument ----------
import sys
if len(sys.argv) < 2:
    print("Usage: python nutrition.py <user_id>")
    sys.exit()
user_id = int(sys.argv[1])

# ---------- Fetch user data ----------
cursor.execute(f"SELECT * FROM users WHERE user_id = {user_id}")
user = cursor.fetchone()

if not user:
    print("User not found!")
    sys.exit()

# ---------- Prepare user data for prediction ----------
X_user = pd.DataFrame([{
    "Age": user["age"],
    "Gender": encode_feature("Gender", user["gender"]),
    "BMI": user["bmi"],
    "BMI Category": encode_feature("BMI Category", user["bmi_category"] if "bmi_category" in user else "Normal"),
    "Activity Level": encode_feature("Activity Level", user["activity_level"]),
    "Dietary Preference": encode_feature("Dietary Preference", user["dietary_pref"]),
    "Disease": encode_feature("Disease", user["disease"]),
    "Calories per kg": user["calories_per_kg"]
}])

# ---------- Simple prediction using model params ----------
# NOTE: We cannot fully reconstruct RandomForest from JSON easily.
# We'll just simulate prediction using feature_importances_ as a dummy (for demo purposes)
# In production, save using joblib or ONNX for real predictions.
# Here, we pick first class as prediction (for JSON demo)
pred_idx = 0  # just placeholder
predicted_plan = inverse_transform_target(pred_idx)

# ---------- Insert/Update nutrition suggestion ----------
now = datetime.now().strftime("%Y-%m-%d %H:%M:%S")

cursor.execute(f"""
    INSERT INTO user_nutrition_data
    (user_id, weight_kg, height_cm, bmi, bmr, calories_per_kg,
    activity_level, dietary_pref, fitness_goal, disease, allergy,
    pressure_level, sugar_level, age, nutrition_suggestion, created_at, updated_at)
    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
    ON DUPLICATE KEY UPDATE
    nutrition_suggestion=%s, updated_at=%s
""", (
    user["user_id"], user["weight_kg"], user["height_cm"], user["bmi"], user["bmr"], user["calories_per_kg"],
    user["activity_level"], user["dietary_pref"], user["fitness_goal"], user["disease"], user["allergy"],
    user["pressure_level"], user["sugar_level"], user["age"], predicted_plan, now, now,
    predicted_plan, now
))

conn.commit()
cursor.close()
conn.close()

print(predicted_plan)
