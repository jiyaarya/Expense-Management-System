<?php
include("./includes/header.php");
include("./includes/functions.php");

if (isset($_POST['register'])) {
    include("./includes/db_conn.php");

    // Enable error reporting for debugging
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Get values from the form
    $user_name = trim($_POST['user_name']);
    $user_pass = $_POST['user_pass'];

    // Encrypt password
    $enc_pass = password_hash($user_pass, PASSWORD_BCRYPT);

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO reg_users (user_name, user_pass) VALUES (?, ?)");
    $stmt->bind_param("ss", $user_name, $enc_pass);

    if ($stmt->execute()) {
        // Redirect to login_user.php after successful registration
        header("Location: login_user.php");
        exit();
    } else {
        echo my_alert("danger", "Error while inserting the record");
    }

    // Close connections
    $stmt->close();
    $conn->close();
}
?>

<!-- Glassmorphic Register Style -->
<style>
  body {
    margin: 0;
    padding: 0;
    background: url('./images/8.jpg') no-repeat center center fixed;
    background-size: cover;
    font-family: Arial, sans-serif;
  }

  .register-box {
    background: rgba(0, 0, 0, 0.5);
    color: #fff;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.5);
    width: 350px;
    backdrop-filter: blur(5px);
  }

  .form-control {
    background: transparent;
    border: 1px solid #ccc;
    color: #fff;
  }

  .form-control:focus {
    background: transparent;
    color: #fff;
    border-color: #fff;
    box-shadow: none;
  }

  .btn-primary {
    background-color: #6a0dad;
    border-color: #6a0dad;
  }

  .btn-primary:hover {
    background-color: #8a2be2;
    border-color: #8a2be2;
  }

  label {
    color: #ddd;
  }

  .container {
    min-height: 100vh;
  }
</style>

<!-- Register Form -->
<div class="container d-flex justify-content-center align-items-center">
  <div class="register-box">
    <h2 class="text-center mb-4">Register</h2>
    <form method="POST">
      <div class="mb-3">
        <label class="form-label">User Name</label>
        <input type="text" class="form-control" required name="user_name">
      </div>
      <div class="mb-3">
        <label class="form-label">User Password</label>
        <input type="password" class="form-control" required name="user_pass">
      </div>
      <button type="submit" name="register" class="btn btn-primary w-100 mb-2">Register</button>
      <p class="text-center">Already a member? <a href="login_user.php" class="text-warning">Login</a></p>
    </form>
  </div>
</div>

<?php include("./includes/footer.php"); ?>
