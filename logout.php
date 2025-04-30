<?php
session_start();

if (isset($_REQUEST['is_login'])) {
    unset($_SESSION['is_login']);
    $_SESSION['message'] = "Logout Successful";
    $_SESSION['color'] = "success";
}

header("Location: login_user.php");
exit(); // Ensure script stops after redirection
?>
