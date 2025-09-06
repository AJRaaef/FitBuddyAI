import unittest


user_data_db = {
    "user1@example.com": {
        "name": "Alice",
        "age": 25,
        "weight_kg": 55,
        "height_cm": 165,
        "bmi": 20.2,
        "progress": {"weight_change": 1.5, "bmi_change": 0.3},
        "ai_recommendations": ["Increase protein intake", "30 min cardio daily"]
    },
    "user2@example.com": {
        "name": "Bob",
        "age": 30,
        "weight_kg": 78,
        "height_cm": 172,
        "bmi": 26.4,
        "progress": {"weight_change": -0.5, "bmi_change": -0.2},
        "ai_recommendations": ["Reduce sugar intake", "Strength training 3x/week"]
    }
}

# Function to get dashboard data
def get_dashboard_data(email):
    return user_data_db.get(email, None)

class TestUserDashboard(unittest.TestCase):

    # Test 1: Valid user data
    def test_valid_user_dashboard(self):
        data = get_dashboard_data("user1@example.com")
        self.assertIsNotNone(data)
        self.assertIn("bmi", data)
        self.assertIn("progress", data)
        self.assertIn("ai_recommendations", data)
        self.assertEqual(len(data["ai_recommendations"]), 2)

    # Test 2: Invalid user
    def test_invalid_user_dashboard(self):
        data = get_dashboard_data("nonexistent@example.com")
        self.assertIsNone(data)

    # Test 3: Check specific AI recommendation
    def test_ai_recommendation_content(self):
        data = get_dashboard_data("user2@example.com")
        self.assertIn("Reduce sugar intake", data["ai_recommendations"])

if __name__ == "__main__":
    result = unittest.main(exit=False)
    if result.result.wasSuccessful():
        print("\n✅ All User Dashboard tests passed!\n")
