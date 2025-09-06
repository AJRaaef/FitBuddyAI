import unittest

registered_emails = set()  

def sign_up(email, password):
    if not email or not password:
        return False  # Empty input not allowed
    if email in registered_emails:
        return False  # Email already exists
    registered_emails.add(email)
    return True

class TestSignUp(unittest.TestCase):

    def setUp(self):
        # Clear registered emails before each test
        registered_emails.clear()

    # Test 1: Successful signup
    def test_successful_signup(self):
        self.assertTrue(sign_up("newuser@example.com", "pass123"))

    # Test 2: Empty email
    def test_empty_email(self):
        self.assertFalse(sign_up("", "pass123"))

    # Test 3: Empty password
    def test_empty_password(self):
        self.assertFalse(sign_up("user@example.com", ""))

    # Test 4: Both email and password empty
    def test_empty_email_password(self):
        self.assertFalse(sign_up("", ""))

    # Test 5: Duplicate email
    def test_duplicate_email(self):
        sign_up("existing@example.com", "pass123")  # First signup
        self.assertFalse(sign_up("existing@example.com", "newpass"))

if __name__ == "__main__":
    result = unittest.main(exit=False)
    if result.result.wasSuccessful():
        print("\n✅Sign Up tests passed!\n")
