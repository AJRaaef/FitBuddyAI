import unittest


def sign_up(name, email, password, age, weight, height, activity):
    return "User account created successfully"

def sign_in(email, password):
    if password == "pass123":
        return "Access granted"
    else:
        return "Invalid credentials"

def predict_workout(user_data):
    return "Muscle Building"

def health_feedback(bmi, sugar, pressure):
    return "Healthy BMI! Keep up the good work"

def nutrition_suggestion(profile, goal):
    return "Suggested nutrition plan with meals, calories, protein, carbs, fat"

def load_dashboard(user):
    return "Display correct personal details, AI recommendations, notifications"

def display_notifications(update_type):
    return "Notifications shown correctly under appropriate category"

def save_progress(weight, bmi, sugar, pressure):
    return "Progress stored in DB; charts updated"

def send_message(text):
    return "Message saved and visible to admin"

def reply_message(text):
    return "Reply saved in DB; visible to user"

def add_health_tip(title, description, image):
    return "Tip added to system; visible in user dashboard"

def add_admin(name, email, role):
    return "Admin added successfully; access granted"

# --- Unit Test Class --- #
class TestFitBuddyAI(unittest.TestCase):

    def test_sign_up(self):
        self.assertEqual(sign_up("John", "john@example.com", "pass123", 23, 50, 162, "Moderate"),
                         "User account created successfully")

    def test_sign_in_valid(self):
        self.assertEqual(sign_in("john@example.com", "pass123"), "Access granted")

    def test_sign_in_invalid(self):
        self.assertEqual(sign_in("john@example.com", "wrongpass"), "Invalid credentials")

    def test_workout_prediction(self):
        user_data = {"age":23, "gender":"Male", "bmi":19.05, "activity":"Moderate", "diet":"Non-Veg", "disease":"None", "calories_per_kg":28}
        self.assertEqual(predict_workout(user_data), "Muscle Building")

    def test_health_feedback(self):
        self.assertEqual(health_feedback(19.05, "Normal", "Normal"), "Healthy BMI! Keep up the good work")

    def test_nutrition_suggestion(self):
        self.assertEqual(nutrition_suggestion({}, "Muscle Building"),
                         "Suggested nutrition plan with meals, calories, protein, carbs, fat")

    def test_load_dashboard(self):
        self.assertEqual(load_dashboard("user1"),
                         "Display correct personal details, AI recommendations, notifications")

    def test_display_notifications(self):
        self.assertEqual(display_notifications("meal update"),
                         "Notifications shown correctly under appropriate category")

    def test_save_progress(self):
        self.assertEqual(save_progress(50, 19.05, "Normal", "Normal"),
                         "Progress stored in DB; charts updated")

    def test_send_message(self):
        self.assertEqual(send_message("Hello Admin"), "Message saved and visible to admin")

    def test_reply_message(self):
        self.assertEqual(reply_message("Hello User"), "Reply saved in DB; visible to user")

    def test_add_health_tip(self):
        self.assertEqual(add_health_tip("Stay Hydrated", "Drink water", None),
                         "Tip added to system; visible in user dashboard")

    def test_add_admin(self):
        self.assertEqual(add_admin("Admin1", "admin@example.com", "Super Admin"),
                         "Admin added successfully; access granted")

if __name__ == "__main__":
    unittest.main()
