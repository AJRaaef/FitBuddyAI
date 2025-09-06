import sys
import mysql.connector
import json

def get_db_connection():
    return mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="fitbuddyai"
    )

def determine_goal(user):
    weight = float(user["weight_kg"])
    height = float(user["height_cm"])
    age = int(user["age"])
    activity = user["activity_level"]
    gender = user["gender"]
    diseases = [d.strip().lower() for d in user["disease"].split(',')] if user["disease"] else []
    pressure = user.get("pressure_level","").lower()
    sugar = user.get("sugar_level","").lower()
    bmi = weight / ((height / 100) ** 2) if height > 0 else 0

    # BMI Category
    if bmi < 18.5:
        bmi_cat = "Underweight"
    elif 18.5 <= bmi < 25:
        bmi_cat = "Normal"
    elif 25 <= bmi < 30:
        bmi_cat = "Overweight"
    else:
        bmi_cat = "Obese"

    # Real-world rules
    # 1. Underweight → weight gain priority
    if bmi_cat == "Underweight":
        if "sedentary" in activity.lower():
            return "maintain fitness"
        else:
            return "weight gain"

    # 2. Overweight/Obese → weight loss priority
    if bmi_cat in ["Overweight", "Obese"]:
        return "weight loss"

    # 3. Normal BMI
    if bmi_cat == "Normal":
        if age < 20:
            if activity.lower() in ["active","very active"]:
                return "muscle building"
            else:
                return "maintain fitness"
        elif 20 <= age <= 40:
            if activity.lower() in ["active","very active"]:
                return "muscle building"
            else:
                return "maintain fitness"
        else:  # >40
            return "maintain fitness"

    # 4. Check diseases
    risk_diseases = ["hypertension","diabetes","high cholesterol","fatty liver"]
    if any(d in diseases for d in risk_diseases):
        if bmi_cat in ["Overweight","Obese"]:
            return "weight loss"
        else:
            return "maintain fitness"

    # 5. Pressure/Sugar high → conservative approach
    if "high" in pressure or "high" in sugar:
        return "maintain fitness"

    return "maintain fitness"

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
