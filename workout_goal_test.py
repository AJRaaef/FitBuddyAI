import unittest
from model_determine import determine_goal 

class TestDetermineGoal(unittest.TestCase):

    def test_underweight_no_disease(self):
        user = {
            "weight_kg": 45, "height_cm": 170, "age": 20, "activity_level": "Moderately Active",
            "gender": "Male", "disease": "", "sugar_label": "Normal",
            "cholostrol_label": "Normal", "pressure_label": "Normal"
        }
        self.assertEqual(determine_goal(user), "weight gain")

    def test_overweight_no_disease(self):
        user = {
            "weight_kg": 85, "height_cm": 170, "age": 25, "activity_level": "Sedentary",
            "gender": "Male", "disease": "", "sugar_label": "Normal",
            "cholostrol_label": "Normal", "pressure_label": "Normal"
        }
        self.assertEqual(determine_goal(user), "weight loss")

    def test_normal_active(self):
        user = {
            "weight_kg": 65, "height_cm": 170, "age": 23, "activity_level": "Moderately Active",
            "gender": "Male", "disease": "", "sugar_label": "Normal",
            "cholostrol_label": "Normal", "pressure_label": "Normal"
        }
        self.assertEqual(determine_goal(user), "muscle building")

    def test_normal_sedentary(self):
        user = {
            "weight_kg": 65, "height_cm": 170, "age": 23, "activity_level": "Sedentary",
            "gender": "Male", "disease": "", "sugar_label": "Normal",
            "cholostrol_label": "Normal", "pressure_label": "Normal"
        }
        self.assertEqual(determine_goal(user), "maintain fitness")

    def test_high_risk_condition(self):
        user = {
            "weight_kg": 70, "height_cm": 170, "age": 40, "activity_level": "Moderately Active",
            "gender": "Male", "disease": "Diabetes", "sugar_label": "High",
            "cholostrol_label": "Normal", "pressure_label": "Normal"
        }
        self.assertEqual(determine_goal(user), "maintain fitness")

if __name__ == "__main__":
    result = unittest.main(exit=False)
    if result.result.wasSuccessful():
        print("\n✅tests passed successfully!\n")
