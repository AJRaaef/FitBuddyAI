import unittest


users_db = {
    1: {"name": "Alice", "email": "alice@example.com", "status": "active"},
    2: {"name": "Bob", "email": "bob@example.com", "status": "inactive"}
}

health_tips_db = [
    {"id": 1, "title": "Stay Hydrated", "description": "Drink at least 8 glasses of water daily."},
    {"id": 2, "title": "Exercise Regularly", "description": "Do 30 mins of cardio daily."}
]

messages_db = [
    {"id": 1, "from_user": "alice@example.com", "message": "Need advice", "reply": None},
    {"id": 2, "from_user": "bob@example.com", "message": "Diet plan?", "reply": None}
]

# Admin functions
def view_users():
    return list(users_db.values())

def edit_user_status(user_id, status):
    if user_id in users_db:
        users_db[user_id]["status"] = status
        return True
    return False

def add_health_tip(title, description):
    new_id = len(health_tips_db) + 1
    health_tips_db.append({"id": new_id, "title": title, "description": description})
    return True

def reply_to_message(msg_id, reply_text):
    for msg in messages_db:
        if msg["id"] == msg_id:
            msg["reply"] = reply_text
            return True
    return False

# Unit Tests
class TestAdminDashboard(unittest.TestCase):

    # Test 1: View users
    def test_view_users(self):
        users = view_users()
        self.assertEqual(len(users), 2)
        self.assertIn("name", users[0])

    # Test 2: Edit user status
    def test_edit_user_status(self):
        result = edit_user_status(2, "active")
        self.assertTrue(result)
        self.assertEqual(users_db[2]["status"], "active")

    # Test 3: Edit non-existent user
    def test_edit_invalid_user(self):
        result = edit_user_status(99, "inactive")
        self.assertFalse(result)

    # Test 4: Add health tip
    def test_add_health_tip(self):
        result = add_health_tip("Sleep Well", "Sleep 7-8 hours daily")
        self.assertTrue(result)
        self.assertEqual(len(health_tips_db), 3)
        self.assertEqual(health_tips_db[-1]["title"], "Sleep Well")

    # Test 5: Reply to message
    def test_reply_to_message(self):
        result = reply_to_message(1, "Drink more water daily")
        self.assertTrue(result)
        self.assertEqual(messages_db[0]["reply"], "Drink more water daily")

    # Test 6: Reply to non-existent message
    def test_reply_invalid_message(self):
        result = reply_to_message(99, "Hello")
        self.assertFalse(result)

if __name__ == "__main__":
    result = unittest.main(exit=False)
    if result.result.wasSuccessful():
        print("\n✅ All Admin Dashboard tests passed!\n")
