import unittest
from nutrition import generate_nutrition_plan 

class TestNutritionPlan(unittest.TestCase):

    def test_underweight_plan(self):
        user = {
            "goal": "weight gain",
            "age": 22,
            "weight_kg": 45,
            "height_cm": 165,
            "activity_level": "Moderately Active"
        }
        plan = generate_nutrition_plan(user)
        self.assertIn("high protein", plan.lower())

    def test_overweight_plan(self):
        user = {
            "goal": "weight loss",
            "age": 28,
            "weight_kg": 85,
            "height_cm": 170,
            "activity_level": "Sedentary"
        }
        plan = generate_nutrition_plan(user)
        self.assertIn("calorie deficit", plan.lower())

    def test_muscle_building_plan(self):
        user = {
            "goal": "muscle building",
            "age": 25,
            "weight_kg": 70,
            "height_cm": 175,
            "activity_level": "Active"
        }
        plan = generate_nutrition_plan(user)
        self.assertIn("strength training", plan.lower())

if __name__ == "__main__":
    # Run the tests
    runner = unittest.TextTestRunner(verbosity=2)
    result = runner.run(unittest.defaultTestLoader.loadTestsFromTestCase(TestNutritionPlan))

    if result.wasSuccessful():
        print("\n✅ Nutrition plan tests passed!\n")
    else:
        print("\n❌ Some tests failed.\n")
