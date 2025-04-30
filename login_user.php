<?php
include("./includes/header.php");
include("./includes/functions.php");

if (isset($_SESSION['message']) && isset($_SESSION['color'])) {
  echo my_alert($_SESSION['color'], $_SESSION['message']);
  unset($_SESSION['message'], $_SESSION['color']);
}

if (isset($_REQUEST['Login'])) {
  include("./includes/db_conn.php");

  $user_name = $_REQUEST['user_name'];
  $user_pass = $_REQUEST['user_pass'];

  $login_query = "SELECT * FROM reg_users WHERE user_name='$user_name'";
  $result_login_query = mysqli_query($conn, $login_query);

  if (mysqli_num_rows($result_login_query) == 1) {
    $row = mysqli_fetch_assoc($result_login_query);
    $db_user_name = $row['user_name'];
    $db_user_pass = $row['user_pass'];
    $db_user_pic = $row['user_pic'];

    if (password_verify($user_pass, $db_user_pass)) {
      $_SESSION['user_id'] = $row['reg_id'];
      $_SESSION['name'] = $db_user_name;
      $_SESSION['picture'] = $db_user_pic;
      $_SESSION['is_login'] = true;
      $_SESSION['role'] = $row['role'];

      $_SESSION['message'] = "Login Successful";
      $_SESSION['color'] = "success";
      header("Location: index.php");
      exit();
    } else {
      echo my_alert("danger", "Incorrect Password");
    }
  } else {
    echo my_alert("danger", "User does not exist");
  }

  mysqli_close($conn);
}
?>

<!-- Glassmorphic Login Style -->
<style>
  body {
    margin: 0;
    padding: 0;
    background: url('./images/8.jpg') no-repeat center center fixed;
    background-size: cover;
    font-family: Arial, sans-serif;
  }

  .login-box {
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

<!-- Login Form -->
<div class="container d-flex justify-content-center align-items-center">
  <div class="login-box">
    <h2 class="text-center mb-4">Login</h2>
    <form method="POST">
      <div class="mb-3">
        <label for="user_name" class="form-label">User Name</label>
        <input type="text" class="form-control" required name="user_name">
      </div>
      <div class="mb-3">
        <label for="user_pass" class="form-label">Password</label>
        <input type="password" class="form-control" required name="user_pass">
      </div>
      <button type="submit" name="Login" class="btn btn-primary w-100 mb-3">Login</button>
      <p class="text-center">Not a member? <a href="register_user.php" class="text-warning">Register</a></p>
    </form>
  </div>
</div>

<?php include("./includes/footer.php"); ?>
