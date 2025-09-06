# test_health_feedback.py
import unittest
from health_feedback import generate_health_feedback  

class TestHealthFeedback(unittest.TestCase):

    def test_normal_bmi(self):
        user = {"weight_kg": 65, "height_cm": 170, "sugar_label": "Normal", "pressure_label": "Normal"}
        feedback = generate_health_feedback(user)
        self.assertIn("healthy bmi", feedback.lower())

    def test_low_bmi(self):
        user = {"weight_kg": 45, "height_cm": 170, "sugar_label": "Normal", "pressure_label": "Normal"}
        feedback = generate_health_feedback(user)
        self.assertIn("gaining weight", feedback.lower())

    def test_high_bmi(self):
        user = {"weight_kg": 85, "height_cm": 170, "sugar_label": "Normal", "pressure_label": "Normal"}
        feedback = generate_health_feedback(user)
        self.assertIn("reducing weight", feedback.lower())

    def test_high_sugar(self):
        user = {"weight_kg": 65, "height_cm": 170, "sugar_label": "High", "pressure_label": "Normal"}
        feedback = generate_health_feedback(user)
        self.assertIn("manage sugar", feedback.lower())

    def test_high_pressure(self):
        user = {"weight_kg": 65, "height_cm": 170, "sugar_label": "Normal", "pressure_label": "High"}
        feedback = generate_health_feedback(user)
        self.assertIn("monitor blood pressure", feedback.lower())

if __name__ == "__main__":
    result = unittest.main(exit=False)
    if result.result.wasSuccessful():
        print("\n✅ Health feedback tests passed!\n")
