<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

// Get tip_id from URL
$tip_id = isset($_GET['tip_id']) ? intval($_GET['tip_id']) : 0;
if ($tip_id <= 0) {
    die("Invalid health tip ID.");
}

// Fetch existing health tip
$stmt = $conn->prepare("
    SELECT ht.*, a.full_name 
    FROM health_tips ht
    JOIN admins a ON ht.admin_id = a.admin_id
    WHERE tip_id = ?
");
$stmt->bind_param("i", $tip_id);
$stmt->execute();
$result = $stmt->get_result();
$tip = $result->fetch_assoc();
$stmt->close();

if (!$tip) {
    die("Health tip not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Handle file upload (optional)
    $image_path = $tip['image_url']; // Keep existing if not replaced
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $target_dir = "uploads/";
        $filename = time() . '_' . basename($_FILES['image']['name']);
        $target_file = $target_dir . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = $target_file;
        }
    }

    // Update database
    $stmt = $conn->prepare("UPDATE health_tips SET title = ?, description = ?, image_url = ?, admin_id = ?, created_at = NOW() WHERE tip_id = ?");
    $stmt->bind_param("sssii", $title, $description, $image_path, $admin_id, $tip_id);
    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?msg=Health tip updated successfully");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch admin info for the header
$stmt = $conn->prepare("SELECT * FROM admins WHERE admin_id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$admin = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Health Tip - FitBuddyAI Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3a0ca3;
            --accent: #f72585;
            --success: #4cc9f0;
            --danger: #f72585;
            --warning: #f9c74f;
            --info: #3ecf8e;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --light-gray: #e9ecef;
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fb;
            color: #333;
            line-height: 1.6;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background: var(--primary);
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: var(--transition);
            z-index: 1000;
        }

        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }

        .sidebar-header h2 {
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-header h2 i {
            color: var(--accent);
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 15px;
        }

        .admin-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .admin-info h4 {
            font-size: 0.9rem;
            margin-bottom: 3px;
        }

        .admin-info p {
            font-size: 0.8rem;
            opacity: 0.8;
        }

        .nav-menu {
            list-style: none;
            padding: 0 10px;
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            border-radius: 8px;
            transition: var(--transition);
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .nav-link i {
            margin-right: 10px;
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 25px;
            background: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            margin-bottom: 25px;
        }

        .page-title h1 {
            font-size: 1.8rem;
            color: var(--dark);
            font-weight: 600;
        }

        .page-title p {
            color: var(--gray);
            font-size: 0.9rem;
            margin-top: 5px;
        }

        .logout-btn {
            background: var(--accent);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
            text-decoration: none;
        }

        .logout-btn:hover {
            background: #e51274;
            transform: translateY(-2px);
        }

        /* Edit Form Section */
        .edit-section {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: var(--card-shadow);
            max-width: 900px;
            margin: 0 auto;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--light-gray);
        }

        .section-title {
            font-size: 1.4rem;
            color: var(--dark);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .back-btn {
            background: var(--light-gray);
            color: var(--dark);
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: var(--transition);
        }

        .back-btn:hover {
            background: #dce1e7;
        }

        /* Form Styles */
        .form-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .form-preview {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .image-preview {
            border: 2px dashed var(--light-gray);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            transition: var(--transition);
        }

        .image-preview:hover {
            border-color: var(--primary);
        }

        .current-image {
            max-width: 100%;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .preview-title {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: var(--dark);
        }

        .preview-content {
            background: var(--light);
            padding: 15px;
            border-radius: 8px;
            max-height: 200px;
            overflow-y: auto;
        }

        .form-fields {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-weight: 600;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group label i {
            color: var(--primary);
        }

        .form-control {
            padding: 12px 15px;
            border: 1px solid var(--light-gray);
            border-radius: 8px;
            font-family: inherit;
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }

        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }

        .file-input {
            position: relative;
            overflow: hidden;
        }

        .file-input input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-input-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px 15px;
            background: var(--light);
            border: 1px dashed var(--gray);
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
        }

        .file-input-label:hover {
            background: #e9ecef;
            border-color: var(--primary);
        }

        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: #3251d4;
            transform: translateY(-2px);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
                overflow: visible;
            }
            
            .sidebar .sidebar-header h2 span,
            .sidebar .admin-info,
            .sidebar .nav-link span {
                display: none;
            }
            
            .sidebar .nav-link {
                justify-content: center;
                padding: 15px;
            }
            
            .sidebar .nav-link i {
                margin-right: 0;
            }
            
            .main-content {
                margin-left: 70px;
            }
            
            .form-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .section-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-dumbbell"></i> <span>FitBuddyAI</span></h2>
                <div class="admin-profile">
                    <div class="admin-avatar">
                        <?php echo strtoupper(substr($admin['full_name'], 0, 1)); ?>
                    </div>
                    <div class="admin-info">
                        <h4><?php echo htmlspecialchars($admin['full_name']); ?></h4>
                        <p>Administrator</p>
                    </div>
                </div>
            </div>
            
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="admin_dashboard.php" class="nav-link">
                        <i class="fas fa-th-large"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="admin_dashboard.php#users" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>User Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="admin_dashboard.php#admins" class="nav-link">
                        <i class="fas fa-user-shield"></i>
                        <span>Admin Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="admin_dashboard.php#messages" class="nav-link">
                        <i class="fas fa-envelope"></i>
                        <span>Messages</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="admin_dashboard.php#health-tips" class="nav-link active">
                        <i class="fas fa-heartbeat"></i>
                        <span>Health Tips</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="admin_logout.php" class="nav-link">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <div class="page-title">
                    <h1>Edit Health Tip</h1>
                    <p>Update health tip content and image</p>
                </div>
                <a href="admin_logout.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>

            <div class="edit-section">
                <div class="section-header">
                    <h2 class="section-title"><i class="fas fa-edit"></i> Edit Health Tip</h2>
                    <a href="admin_dashboard.php#health-tips" class="back-btn">
                        <i class="fas fa-arrow-left"></i> Back to Health Tips
                    </a>
                </div>

                <form action="" method="POST" enctype="multipart/form-data" class="form-container">
                    <div class="form-fields">
                        <div class="form-group">
                            <label for="title"><i class="fas fa-heading"></i> Title</label>
                            <input 
                                type="text" 
                                id="title" 
                                name="title" 
                                class="form-control" 
                                value="<?php echo htmlspecialchars($tip['title']); ?>" 
                                required
                                placeholder="Enter health tip title"
                            >
                        </div>

                        <div class="form-group">
                            <label for="description"><i class="fas fa-align-left"></i> Description</label>
                            <textarea 
                                id="description" 
                                name="description" 
                                class="form-control" 
                                required
                                placeholder="Enter health tip description"
                            ><?php echo htmlspecialchars($tip['description']); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-image"></i> Replace Image (Optional)</label>
                            <div class="file-input">
                                <input type="file" id="image" name="image" accept="image/*">
                                <label for="image" class="file-input-label">
                                    <i class="fas fa-upload"></i>
                                    <span>Choose new image file</span>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Health Tip
                        </button>
                    </div>

                    <div class="form-preview">
                        <div class="image-preview">
                            <h3 class="preview-title">Current Image</h3>
                            <?php if ($tip['image_url']): ?>
                                <img src="<?php echo htmlspecialchars($tip['image_url']); ?>" alt="Current Tip Image" class="current-image">
                                <p>Current image will be replaced if you upload a new one.</p>
                            <?php else: ?>
                                <div style="padding: 30px; color: var(--gray);">
                                    <i class="fas fa-image" style="font-size: 3rem; margin-bottom: 15px;"></i>
                                    <p>No image currently set</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div>
                            <h3 class="preview-title">Preview</h3>
                            <div class="preview-content">
                                <h4 id="preview-title"><?php echo htmlspecialchars($tip['title']); ?></h4>
                                <p id="preview-description"><?php echo htmlspecialchars($tip['description']); ?></p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        // Live preview update
        const titleInput = document.getElementById('title');
        const descriptionInput = document.getElementById('description');
        const previewTitle = document.getElementById('preview-title');
        const previewDescription = document.getElementById('preview-description');

        titleInput.addEventListener('input', function() {
            previewTitle.textContent = this.value;
        });

        descriptionInput.addEventListener('input', function() {
            previewDescription.textContent = this.value;
        });

        // Image preview
        const imageInput = document.getElementById('image');
        const currentImage = document.querySelector('.current-image');
        
        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    if (currentImage) {
                        currentImage.src = e.target.result;
                    } else {
                        const imagePreview = document.querySelector('.image-preview');
                        imagePreview.innerHTML = `
                            <h3 class="preview-title">New Image Preview</h3>
                            <img src="${e.target.result}" alt="New Tip Image" class="current-image" style="max-width: 100%;">
                        `;
                    }
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Auto-resize textarea
        descriptionInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        
        // Initialize height
        descriptionInput.dispatchEvent(new Event('input'));
    </script>
</body>
</html>