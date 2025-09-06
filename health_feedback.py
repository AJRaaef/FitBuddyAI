# health_feedback
import pandas as pd
import mysql.connector
import json
import sys
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
with open("Healthfeedback_model\model3_Health_feedback.json", "r") as f:
    model_json = json.load(f)

# Extract label encoders + target classes
label_encoders = model_json.get("label_encoders", {})
target_classes = model_json.get("target_encoder", {}).get("classes", [])

# ---------- Helper Functions ----------
def inverse_transform_target(pred_idx):
    """Return class label from index"""
    if 0 <= pred_idx < len(target_classes):
        return target_classes[pred_idx]
    return "Unknown"

def encode_feature(col, val):
    """Encode categorical feature using JSON encoders"""
    if col in label_encoders:
        classes = label_encoders[col]["classes"]
        return classes.index(val) if val in classes else 0
    return val

# ---------- Get user_id from command line ----------
if len(sys.argv) < 2:
    print("Usage: python nutrition.py <user_id>")
    sys.exit()
user_id = int(sys.argv[1])

# ---------- Fetch user data ----------
cursor.execute("SELECT * FROM users WHERE user_id = %s", (user_id,))
user = cursor.fetchone()

if not user:
    print("User not found!")
    sys.exit()

# ---------- Prepare features ----------
X_user = {
    "Age": user["age"],
    "Gender": encode_feature("Gender", user["gender"]),
    "BMI": user["bmi"],
    "BMI Category": encode_feature("BMI Category", user.get("bmi_category", "Normal")),
    "Activity Level": encode_feature("Activity Level", user["activity_level"]),
    "Dietary Preference": encode_feature("Dietary Preference", user["dietary_pref"]),
    "Disease": encode_feature("Disease", user["disease"]),
    "Calories per kg": user["calories_per_kg"]
}

# ---------- Dummy Prediction (replace with real model) ----------
pred_idx = 0  # just pick first class for now
predicted_plan = inverse_transform_target(pred_idx)

# ---------- Save to Database ----------
now = datetime.now().strftime("%Y-%m-%d %H:%M:%S")

cursor.execute("""
    INSERT INTO user_nutrition_data
    (user_id, weight_kg, height_cm, bmi, bmr, calories_per_kg,
     activity_level, dietary_pref, fitness_goal, disease, allergy,
     pressure_level, sugar_level, age, nutrition_suggestion,
     created_at, updated_at)
    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
    ON DUPLICATE KEY UPDATE
    nutrition_suggestion=%s, updated_at=%s
""", (
    user["user_id"], user["weight_kg"], user["height_cm"], user["bmi"], user["bmr"], user["calories_per_kg"],
    user["activity_level"], user["dietary_pref"], user["fitness_goal"], user["disease"], user.get("allergy", "None"),
    user["pressure_level"], user["sugar_level"], user["age"], predicted_plan, now, now,
    predicted_plan, now
))

conn.commit()
cursor.close()
conn.close()

print("Nutrition Suggestion:", predicted_plan)
