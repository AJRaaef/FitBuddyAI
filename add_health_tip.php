<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $admin_id = $_SESSION['admin_id'];

    // Handle file upload
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $target_dir = "uploads/";
        $filename = time() . '_' . basename($_FILES['image']['name']);
        $target_file = $target_dir . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = $target_file;
        }
    }

    $stmt = $conn->prepare("INSERT INTO health_tips (title, description, image_url, created_at, admin_id) VALUES (?, ?, ?, NOW(), ?)");
    $stmt->bind_param("sssi", $title, $description, $image_path, $admin_id);
    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?msg=Health tip added successfully");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Health Tip | Admin Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f0f7ff;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background: linear-gradient(135deg, #4c6ef5, #228be6);
            color: white;
            padding: 1.5rem 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 0 0 15px 15px;
            margin-bottom: 2rem;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .logo i {
            font-size: 1.8rem;
        }

        .admin-actions {
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background-color: #fff;
            color: #4c6ef5;
        }

        .btn-primary:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-secondary:hover {
            background-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .page-title {
            text-align: center;
            margin-bottom: 2rem;
            color: #343a40;
            font-size: 2.2rem;
            position: relative;
            padding-bottom: 15px;
        }

        .page-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, #4c6ef5, #228be6);
            border-radius: 2px;
        }

        .card {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #495057;
            font-size: 1.1rem;
        }

        .form-control {
            width: 100%;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: #4c6ef5;
            box-shadow: 0 0 0 3px rgba(76, 110, 245, 0.25);
        }

        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }

        .file-upload {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .file-upload-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            background-color: #f8f9fa;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
        }

        .file-upload-label:hover {
            border-color: #4c6ef5;
            background-color: #f0f7ff;
        }

        .file-upload-label i {
            font-size: 2.5rem;
            color: #4c6ef5;
            margin-bottom: 1rem;
        }

        .file-upload-label span {
            color: #495057;
            font-weight: 500;
        }

        .file-upload-label .hint {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 0.5rem;
        }

        .file-upload-input {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .submit-btn {
            background: linear-gradient(135deg, #4c6ef5, #228be6);
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s;
            display: block;
            width: 100%;
            text-align: center;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(76, 110, 245, 0.3);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .image-preview {
            display: none;
            max-width: 100%;
            margin-top: 1.5rem;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .image-preview img {
            width: 100%;
            display: block;
        }

        footer {
            text-align: center;
            margin-top: 3rem;
            padding: 1.5rem;
            color: #6c757d;
            font-size: 0.9rem;
            border-top: 1px solid #dee2e6;
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 15px;
            }
            
            .admin-actions {
                width: 100%;
                justify-content: center;
            }
            
            .card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <i class="fas fa-heartbeat"></i>
                    <span>HealthPlus Admin</span>
                </div>
                <div class="admin-actions">
                    <a href="admin_dashboard.php" class="btn btn-primary">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="logout.php" class="btn btn-secondary">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <h1 class="page-title">Add New Health Tip</h1>
        
        <div class="card">
            <form action="" method="POST" enctype="multipart/form-data" id="healthTipForm">
                <div class="form-group">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Enter a compelling title" required>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" class="form-control" placeholder="Provide helpful health information and tips..." required></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Featured Image</label>
                    <div class="file-upload">
                        <label class="file-upload-label" for="image">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>Click to upload an image or drag and drop</span>
                            <span class="hint">PNG, JPG, GIF up to 5MB</span>
                        </label>
                        <input type="file" id="image" name="image" class="file-upload-input" accept="image/*">
                    </div>
                    <div id="imagePreview" class="image-preview"></div>
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-plus-circle"></i> Add Health Tip
                </button>
            </form>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2023 HealthPlus Admin Portal. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Image preview functionality
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                
                reader.addEventListener('load', function() {
                    imagePreview.style.display = 'block';
                    imagePreview.innerHTML = `<img src="${this.result}" alt="Preview">`;
                });
                
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
                imagePreview.innerHTML = '';
            }
        });

        // Form validation
        document.getElementById('healthTipForm').addEventListener('submit', function(e) {
            const title = document.getElementById('title').value.trim();
            const description = document.getElementById('description').value.trim();
            
            if (!title || !description) {
                e.preventDefault();
                alert('Please fill in all required fields');
                return false;
            }
        });
    </script>
</body>
</html>