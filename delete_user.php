<?php
include("./includes/header.php");
include("./includes/functions.php");
include("./includes/db_conn.php");

if (isset($_REQUEST['delete_id'])) {
    $delete_id = $_REQUEST['delete_id'];
    $del_query = "DELETE FROM reg_users WHERE reg_id=$delete_id";
    $run_del_query = mysqli_query($conn, $del_query);

    if ($run_del_query) {
        session_start();
        session_destroy(); // Destroy the session
        my_alert("success", "User deleted successfully");
        header("Location: ./login.php"); // Redirect to login page
        exit();
    } else {
        my_alert("danger", "Something went wrong while deleting the user");
        header("Location: ./profile.php");
        exit();
    }

    mysqli_close($conn);
}

include("./includes/footer.php");
?>
