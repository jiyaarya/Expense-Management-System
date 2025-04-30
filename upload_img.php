<?php
include("./includes/header.php");
include("./includes/functions.php");
include("./includes/db_conn.php");

if (!isset($_SESSION)) { session_start(); } // Ensure session is started

$user_id = $_SESSION['user_id']; // Get logged-in user ID

// Fetch user details
$query = "SELECT * FROM reg_users WHERE reg_id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Handle profile picture upload
if (isset($_POST['submit'])) {
    $user_pic = $_FILES['user_pic']; 
    $img_name = $user_pic['name']; 
    $img_tmp_name = $user_pic['tmp_name']; 
    $img_extension = pathinfo($img_name, PATHINFO_EXTENSION);
    $new_img_name = round(microtime(true)) . "." . $img_extension;
    $img_path = "images/user_image/" . $new_img_name;

    // Upload image to server
    if (move_uploaded_file($img_tmp_name, $img_path)) {
        $update_query = "UPDATE reg_users SET user_pic='$new_img_name' WHERE reg_id='$user_id'";
        if (mysqli_query($conn, $update_query)) {
            echo "<script>alert('Profile picture updated successfully!');</script>";
            header("Refresh:0");
        } else {
            echo "<script>alert('Error updating image in database');</script>";
        }
    } else {
        echo "<script>alert('Error uploading image to server');</script>";
    }
}

// Check if profile picture exists in database
$profile_picture = (!empty($user['user_pic']) && file_exists("images/user_image/" . $user['user_pic'])) 
    ? "images/user_image/" . $user['user_pic'] 
    : "assets/default-avatar.png"; // Default profile picture

mysqli_close($conn);
?>

<div class="container">
    <h2 class="mt-4">Profile</h2>
    <div class="card p-4">
        <div class="text-center">
            <img src="<?= $profile_picture ?>" class="rounded-circle" width="150" height="150" alt="Profile Picture">
            <h4 class="mt-3"><?= htmlspecialchars($user['user_name']); ?></h4>
        </div>
        <hr>

        <h5>Personal Details</h5>
        <p><strong>Username:</strong> <?= htmlspecialchars($user['user_name']); ?></p>
        
        <!-- Profile Picture Upload -->
        <form method="POST" enctype="multipart/form-data">
            <h5>Upload Profile Picture</h5>
            <input type="file" class="form-control mb-2" name="user_pic" required>
            <button type="submit" name="submit" class="btn btn-primary">Upload</button>
        </form>
        <hr>

        <!-- Password Reset Form -->
        <form method="POST">
            <h5>Set New Password</h5>
            <input type="password" class="form-control mb-2" name="new_password" placeholder="Enter new password" required>
            <button type="submit" name="update_password" class="btn btn-primary">Set New Password</button>
        </form>
        <hr>

        <!-- Logout and Delete Account -->
        <form method="POST">
            <button type="submit" name="delete_account" class="btn btn-danger">Delete Account</button>
            <a href="logout.php" class="btn btn-secondary">Logout</a>
        </form>
    </div>
</div>

<?php include("./includes/footer.php"); ?>
