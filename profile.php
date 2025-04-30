<?php
include("./includes/header.php");
include("./includes/functions.php");
include("./includes/db_conn.php");

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login_user.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';

// Fetch user details
$query = "SELECT * FROM reg_users WHERE reg_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle profile picture upload
if (isset($_POST['submit'])) {
    if (isset($_FILES['user_pic']) && $_FILES['user_pic']['error'] === UPLOAD_ERR_OK) {
        $user_pic = $_FILES['user_pic'];
        $img_name = $user_pic['name'];
        $img_tmp_name = $user_pic['tmp_name'];
        $img_size = $user_pic['size'];
        $img_extension = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
        
        // Validate image
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $max_size = 2 * 1024 * 1024; // 2MB
        
        if (!in_array($img_extension, $allowed_extensions)) {
            $error = "Only JPG, JPEG, PNG & GIF files are allowed!";
        } elseif ($img_size > $max_size) {
            $error = "Image size must be less than 2MB!";
        } else {
            // Generate unique filename
            $new_img_name = uniqid('profile_', true) . '.' . $img_extension;
            $upload_dir = "images/user_image/";
            
            // Create directory if it doesn't exist
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            // Delete old image if exists
            if (!empty($user['user_pic']) && file_exists($upload_dir . $user['user_pic'])) {
                unlink($upload_dir . $user['user_pic']);
            }
            
            // Move uploaded file
            if (move_uploaded_file($img_tmp_name, $upload_dir . $new_img_name)) {
                // Update database
                $update_query = "UPDATE reg_users SET user_pic = ? WHERE reg_id = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("si", $new_img_name, $user_id);
                
                if ($update_stmt->execute()) {
                    $_SESSION['user_pic'] = $new_img_name; // Update session
                    $success = "Profile picture updated successfully!";
                    // Refresh user data
                    $user['user_pic'] = $new_img_name;
                } else {
                    $error = "Error updating profile picture in database!";
                }
                $update_stmt->close();
            } else {
                $error = "Error uploading image to server!";
            }
        }
    } else {
        $error = "Please select a valid image file!";
    }
}

// Handle password update
if (isset($_POST['update_password'])) {
    $new_password = trim($_POST['new_password']);
    
    if (strlen($new_password) < 8) {
        $error = "Password must be at least 8 characters long!";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $update_pass_query = "UPDATE reg_users SET user_pass = ? WHERE reg_id = ?";
        $stmt = $conn->prepare($update_pass_query);
        $stmt->bind_param("si", $hashed_password, $user_id);
        
        if ($stmt->execute()) {
            $success = "Password updated successfully!";
        } else {
            $error = "Error updating password!";
        }
    }
}

// Handle account deletion
if (isset($_POST['delete_account'])) {
    // Delete profile picture if exists
    if (!empty($user['user_pic'])) {
        $upload_dir = "images/user_image/";
        if (file_exists($upload_dir . $user['user_pic'])) {
            unlink($upload_dir . $user['user_pic']);
        }
    }
    
    // Delete user from database
    $delete_query = "DELETE FROM reg_users WHERE reg_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        session_destroy();
        header("Location: login_user.php");
        exit();
    } else {
        $error = "Error deleting account!";
    }
}

// Get profile picture path
$profile_picture = (!empty($user['user_pic']) && file_exists("images/user_image/" . $user['user_pic']))
    ? "images/user_image/" . $user['user_pic']
    : null;

$stmt->close();
$conn->close();
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Profile Settings</h3>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?= $success ?></div>
                    <?php endif; ?>
                    
                    <div class="text-center mb-4">
                        <?php if ($profile_picture): ?>
                            <img src="<?= $profile_picture ?>" class="rounded-circle border" width="150" height="150" alt="Profile Picture">
                        <?php else: ?>
                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center" style="width: 150px; height: 150px;">
                                <i class="bi bi-person-fill" style="font-size: 4rem;"></i>
                            </div>
                        <?php endif; ?>
                        <h4 class="mt-3"><?= htmlspecialchars($user['user_name']) ?></h4>
                    </div>
                    
                    <div class="mb-5">
                        <h5>Update Profile Picture</h5>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <input type="file" class="form-control" name="user_pic" accept="image/jpeg, image/png, image/gif" required>
                                <div class="form-text">Max size: 2MB (JPEG, PNG, GIF)</div>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Upload Picture</button>
                        </form>
                    </div>
                    
                    <div class="mb-5">
                        <h5>Change Password</h5>
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" class="form-control" name="new_password" minlength="8" required>
                            </div>
                            <button type="submit" name="update_password" class="btn btn-primary">Update Password</button>
                        </form>
                    </div>
                    
                    <div class="border-top pt-3">
                        <h5 class="text-danger">Danger Zone</h5>
                        <form method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                            <button type="submit" name="delete_account" class="btn btn-danger">Delete Account</button>
                            <a href="logout.php" class="btn btn-secondary">Logout</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("./includes/footer.php"); ?>