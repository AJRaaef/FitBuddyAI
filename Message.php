<?php
session_start();
require 'db.php';

// Get logged-in user
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo "Please login to send messages.";
    exit;
}

// Handle sending new message
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['message'])) {
    $message = trim($_POST['message']);
    if ($message !== "") {
        $stmt = $conn->prepare("INSERT INTO replay (user_id, message) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $message);
        $stmt->execute();
    }
}

// Fetch all messages for this user
$stmt = $conn->prepare("SELECT * FROM replay WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$messages = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages | FitBuddy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --secondary: #7209b7;
            --accent: #4cc9f0;
            --success: #2ecc71;
            --warning: #f39c12;
            --danger: #e74c3c;
            --info: #1abc9c;
            --dark: #2b2d42;
            --light: #f8f9fa;
            --gray: #8d99ae;
            --light-gray: #e9ecef;
            --card-bg: #ffffff;
            --border-radius: 16px;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e9f2 100%);
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .chat-container {
            width: 100%;
            max-width: 900px;
            background: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 85vh;
        }

        .chat-header {
            padding: 20px 25px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .chat-header h2 {
            font-weight: 600;
            font-size: 22px;
        }

        .chat-header i {
            font-size: 24px;
        }

        .messages-container {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background-color: #f9fafb;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .message {
            display: flex;
            flex-direction: column;
            max-width: 75%;
            animation: fadeIn 0.4s ease forwards;
        }

        .message.user {
            align-self: flex-end;
        }

        .message.admin {
            align-self: flex-start;
        }

        .message-bubble {
            padding: 15px 20px;
            border-radius: 20px;
            position: relative;
            box-shadow: var(--shadow);
        }

        .message.user .message-bubble {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border-bottom-right-radius: 5px;
        }

        .message.admin .message-bubble {
            background: white;
            color: var(--dark);
            border-bottom-left-radius: 5px;
            border: 1px solid var(--light-gray);
        }

        .message-text {
            font-size: 15px;
            line-height: 1.5;
            margin-bottom: 5px;
        }

        .message-time {
            font-size: 12px;
            opacity: 0.8;
            text-align: right;
        }

        .message.admin .message-time {
            text-align: left;
        }

        .waiting-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 18px;
            background-color: #fff8e6;
            border-radius: 20px;
            border: 1px solid #ffeeba;
            color: #856404;
            font-size: 14px;
            max-width: fit-content;
            margin-top: 10px;
        }

        .chat-form {
            padding: 20px;
            background: white;
            border-top: 1px solid var(--light-gray);
            display: flex;
            gap: 15px;
        }

        .message-input {
            flex: 1;
            padding: 15px 20px;
            border: 2px solid var(--light-gray);
            border-radius: 30px;
            font-size: 15px;
            transition: var(--transition);
            outline: none;
        }

        .message-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        .send-button {
            padding: 15px 25px;
            border: none;
            border-radius: 30px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .send-button:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, #5e18a5 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(67, 97, 238, 0.3);
        }

        .send-button:active {
            transform: translateY(0);
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 40px 20px;
            color: var(--gray);
        }

        .empty-state i {
            font-size: 60px;
            margin-bottom: 20px;
            color: var(--light-gray);
        }

        .empty-state h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: var(--dark);
        }

        .empty-state p {
            font-size: 15px;
            max-width: 400px;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Scrollbar styling */
        .messages-container::-webkit-scrollbar {
            width: 8px;
        }

        .messages-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .messages-container::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
        }

        .messages-container::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .chat-container {
                height: 92vh;
                border-radius: 0;
            }
            
            body {
                padding: 0;
            }
            
            .message {
                max-width: 85%;
            }
            
            .chat-header {
                padding: 15px 20px;
            }
            
            .chat-form {
                padding: 15px;
            }
        }

        @media (max-width: 480px) {
            .message {
                max-width: 90%;
            }
            
            .send-button span {
                display: none;
            }
            
            .send-button {
                padding: 15px;
            }
            
            .message-bubble {
                padding: 12px 16px;
            }
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <i class="fas fa-comments"></i>
            <h2>Messages</h2>
        </div>
        
        <div class="messages-container">
            <?php if (empty($messages)): ?>
                <div class="empty-state">
                    <i class="fas fa-comment-slash"></i>
                    <h3>No messages yet</h3>
                    <p>Start a conversation by sending a message below. Our admin team will respond as soon as possible.</p>
                </div>
            <?php else: ?>
                <?php foreach ($messages as $msg): ?>
                    <div class="message user">
                        <div class="message-bubble">
                            <div class="message-text"><?= htmlspecialchars($msg['message']) ?></div>
                            <div class="message-time"><?= date('M j, g:i A', strtotime($msg['created_at'])) ?></div>
                        </div>
                        
                        <?php if ($msg['replay'] === 'waiting for reply'): ?>
                            <div class="waiting-indicator">
                                <i class="fas fa-clock"></i>
                                <span>Waiting for admin reply</span>
                            </div>
                        <?php else: ?>
                            <div class="message admin">
                                <div class="message-bubble">
                                    <div class="message-text"><?= htmlspecialchars($msg['replay']) ?></div>
                                    <div class="message-time">Admin • <?= date('M j, g:i A', strtotime($msg['created_at'])) ?></div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <form method="POST" class="chat-form">
            <input type="text" name="message" class="message-input" placeholder="Type your message..." required>
            <button type="submit" class="send-button">
                <i class="fas fa-paper-plane"></i>
                <span>Send</span>
            </button>
        </form>
    </div>

    <script>
        // Auto-scroll to bottom of messages
        const messagesContainer = document.querySelector('.messages-container');
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
        
        // Focus on input field when page loads
        document.querySelector('.message-input').focus();
        
        // Prevent form submission if message is empty
        document.querySelector('.chat-form').addEventListener('submit', function(e) {
            const messageInput = this.querySelector('input[name="message"]');
            if (messageInput.value.trim() === '') {
                e.preventDefault();
                messageInput.focus();
            }
        });
    </script>
</body>
</html>