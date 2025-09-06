import sys
import json
import numpy as np
import mysql.connector
import subprocess
from sklearn.ensemble import RandomForestClassifier

def main():
    try:
        # ---------------------------
        # 1. Load model JSON
        # ---------------------------
        with open("fitness_goal_model/model2_workout_goal.json", "r") as f:
            data = json.load(f)

        model_params = data["model_params"]
        classes = data["classes"]
        encoders = data["label_encoders"]

        # ---------------------------
        # 2. Parse command-line args
        # ---------------------------
        if len(sys.argv) < 10:
            print("Error: Not enough arguments passed to script.")
            return

        user_id = int(sys.argv[1])
        age = int(sys.argv[2])
        gender = sys.argv[3]
        weight = float(sys.argv[4])
        height = float(sys.argv[5])
        activity_level = sys.argv[6]
        dietary_pref = sys.argv[7]
        disease = sys.argv[8]
        calories_per_kg = float(sys.argv[9])

        # ---------------------------
        # 3. Calculate BMI category
        # ---------------------------
        bmi = weight / ((height / 100) ** 2)
        if bmi < 18.5:
            bmi_category = "Underweight"
        elif 18.5 <= bmi < 25:
            bmi_category = "Normal weight"
        elif 25 <= bmi < 30:
            bmi_category = "Overweight"
        elif 30 <= bmi < 35:
            bmi_category = "Obese Class I"
        elif 35 <= bmi < 40:
            bmi_category = "Obese Class II"
        else:
            bmi_category = "Obese Class III"

        # ---------------------------
        # 4. Encode features
        # ---------------------------
        try:
            gender_enc = encoders["Gender"][gender]
            bmi_enc = encoders["BMI Category"][bmi_category]
            activity_enc = encoders["Activity Level"][activity_level]
            diet_enc = encoders["Dietary Preference"][dietary_pref]
            disease_enc = encoders["Disease"][disease]
        except KeyError as e:
            print("Encoding error: Key not found ->", e)
            return

        X = np.array([[age, gender_enc, bmi_enc, activity_enc, diet_enc, disease_enc, calories_per_kg]])

        # ---------------------------
        # 5. Build model & predict
        # ---------------------------
        model = RandomForestClassifier(**model_params)

        dummy_X = np.random.randint(0, 5, size=(10, X.shape[1]))
        dummy_y = np.random.randint(0, len(classes), size=(10,))
        model.fit(dummy_X, dummy_y)

        y_pred = model.predict(X)[0]
        predicted_goal = classes[y_pred]

        # ---------------------------
        # 6. Call model_determine.py
        # ---------------------------
        try:
            result = subprocess.check_output(
                ["python", "model_determine.py", str(user_id)],
                stderr=subprocess.STDOUT
            )
            result = result.decode("utf-8").strip()
            real_goal_data = json.loads(result)
            real_goal = real_goal_data.get("determine_goal")
        except Exception as e:
            print("Error calling model_determine.py:", e)
            real_goal = None

        # ---------------------------
        # 7. Compare & decide final goal
        # ---------------------------
        final_goal = predicted_goal
        if real_goal and real_goal != predicted_goal:
            final_goal = real_goal

        # ---------------------------
        # 8. Save final prediction in DB
        # ---------------------------
        conn = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database="fitbuddyai"
        )
        cursor = conn.cursor()

        update_query = "UPDATE users SET fitness_goal = %s WHERE user_id = %s"
        cursor.execute(update_query, (final_goal, user_id))
        conn.commit()

        cursor.close()
        conn.close()

        print("[OK] Fitness goal updated in database:", final_goal)

    except Exception as e:
        print("Unexpected error:", e)

if __name__ == "__main__":
    main()
