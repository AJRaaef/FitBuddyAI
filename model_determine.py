import sys
import mysql.connector
import json

# -----------------------------
# Database connection
# -----------------------------
def get_db_connection():
    return mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="fitbuddyai"
    )

# -----------------------------
# Determine fitness goal
# -----------------------------
def determine_goal(user):
    weight = float(user["weight_kg"])
    height = float(user["height_cm"])
    age = int(user["age"])
    activity = user["activity_level"]
    gender = user["gender"]
    diseases = [d.strip().lower() for d in user["disease"].split(',')] if user["disease"] else []

    # Use labels from DB (default to "Normal")
    sugar_label = user.get("sugar_label", "Normal")
    cholostrol_label = user.get("cholostrol_label", "Normal")
    pressure_label = user.get("pressure_label", "Normal")

    # -----------------------------
    # BMI Calculation & Category
    # -----------------------------
    bmi = weight / ((height / 100) ** 2) if height > 0 else 0
    if bmi < 18.5:
        bmi_cat = "Underweight"
    elif 18.5 <= bmi < 25:
        bmi_cat = "Normal weight"
    elif 25 <= bmi < 30:
        bmi_cat = "Overweight"
    elif 30 <= bmi < 35:
        bmi_cat = "Obese Class I"
    elif 35 <= bmi < 40:
        bmi_cat = "Obese Class II"
    else:
        bmi_cat = "Obese Class III"

    # -----------------------------
    # Rule 1: Prioritize health screening
    # -----------------------------
    high_risk_diseases = ["hypertension", "diabetes", "high cholesterol", "fatty liver"]
    high_risk_labels = ["High", "Very High"]

    has_high_risk_condition = any(d in high_risk_diseases for d in diseases) or \
                              sugar_label in high_risk_labels or \
                              cholostrol_label in high_risk_labels or \
                              pressure_label in high_risk_labels

    if has_high_risk_condition:
        # Suggest fitness maintenance if health risk exists
        if bmi_cat == "Underweight":
            return "weight gain"
        elif bmi_cat in ["Overweight", "Obese Class I", "Obese Class II", "Obese Class III"]:
            return "weight loss"
        else:
            return "maintain fitness"

    # -----------------------------
    # Rule 2: BMI-based weight management
    # -----------------------------
    if bmi_cat == "Underweight":
        return "weight gain"
    if bmi_cat in ["Overweight", "Obese Class I", "Obese Class II", "Obese Class III"]:
        return "weight loss"

    # -----------------------------
    # Rule 3: Normal weight -> muscle building or maintain fitness
    # -----------------------------
    if bmi_cat == "Normal weight":
        if activity.lower() in ["moderately active", "very active"]:
            return "muscle building"
        else:  # sedentary or lightly active
            return "maintain fitness"

    # -----------------------------
    # Default fallback
    # -----------------------------
    return "maintain fitness"

# -----------------------------
# Main execution
# -----------------------------
def main():
    if len(sys.argv) < 2:
        print(json.dumps({"error":"user_id missing"}))
        return

    user_id = sys.argv[1]
    try:
        conn = get_db_connection()
        cursor = conn.cursor(dictionary=True)
        cursor.execute("SELECT * FROM users WHERE user_id = %s", (user_id,))
        user = cursor.fetchone()
        if not user:
            print(json.dumps({"error": f"No user with user_id {user_id}"}))
            return

        goal = determine_goal(user)
        print(json.dumps({"user_id": user_id, "determine_goal": goal}))

        cursor.close()
        conn.close()
    except Exception as e:
        print(json.dumps({"error": str(e)}))

if __name__ == "__main__":
    main()
