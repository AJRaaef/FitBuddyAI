import unittest


user_db = {
    "user1@example.com": "pass123",
    "user2@example.com": "mypassword"
}


def sign_in(email, password):
    if not email or not password:
        return "empty_fields"
    if email in user_db and user_db[email] == password:
        return "login_success"
    return "invalid_credentials"

class TestSignIn(unittest.TestCase):

    # Test 1: Valid login
    def test_valid_login(self):
        result = sign_in("user1@example.com", "pass123")
        self.assertEqual(result, "login_success")

    # Test 2: Invalid password
    def test_invalid_password(self):
        result = sign_in("user1@example.com", "wrongpass")
        self.assertEqual(result, "invalid_credentials")

    # Test 3: Invalid email
    def test_invalid_email(self):
        result = sign_in("nonexistent@example.com", "pass123")
        self.assertEqual(result, "invalid_credentials")

    # Test 4: Empty email
    def test_empty_email(self):
        result = sign_in("", "pass123")
        self.assertEqual(result, "empty_fields")

    # Test 5: Empty password
    def test_empty_password(self):
        result = sign_in("user1@example.com", "")
        self.assertEqual(result, "empty_fields")

    # Test 6: Both email and password empty
    def test_empty_email_password(self):
        result = sign_in("", "")
        self.assertEqual(result, "empty_fields")

if __name__ == "__main__":
    result = unittest.main(exit=False)
    if result.result.wasSuccessful():
        print("\n✅ All Sign In tests passed!\n")
