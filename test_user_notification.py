import unittest


notifications_db = {
    "user1@example.com": [],
    "user2@example.com": []
}

# Function to add notification
def add_notification(email, notification_type, message):
    if email not in notifications_db:
        return False
    notifications_db[email].append({
        "type": notification_type,
        "message": message
    })
    return True

# Function to get notifications for a user
def get_notifications(email):
    return notifications_db.get(email, [])

class TestNotificationSystem(unittest.TestCase):

    # Setup before each test
    def setUp(self):
        # Clear notifications
        for key in notifications_db:
            notifications_db[key] = []

    # Test 1: Add new meal plan notification
    def test_new_meal_plan_notification(self):
        result = add_notification("user1@example.com", "meal_plan", "New meal plan available!")
        self.assertTrue(result)
        notifs = get_notifications("user1@example.com")
        self.assertEqual(len(notifs), 1)
        self.assertEqual(notifs[0]["type"], "meal_plan")

    # Test 2: Add new workout notification
    def test_new_workout_notification(self):
        add_notification("user1@example.com", "workout", "New workout plan available!")
        notifs = get_notifications("user1@example.com")
        self.assertEqual(notifs[0]["message"], "New workout plan available!")

    # Test 3: Add health update notification
    def test_health_update_notification(self):
        add_notification("user2@example.com", "health_update", "Your health metrics updated!")
        notifs = get_notifications("user2@example.com")
        self.assertEqual(notifs[0]["type"], "health_update")

    # Test 4: Invalid user
    def test_invalid_user_notification(self):
        result = add_notification("nonexistent@example.com", "meal_plan", "Test")
        self.assertFalse(result)

if __name__ == "__main__":
    result = unittest.main(exit=False)
    if result.result.wasSuccessful():
        print("\n✅ All Notification System tests passed!\n")
