<?php
include("./includes/db_conn.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Ensure the status is only "Pending" or "Paid"
    if ($status === "Pending" || $status === "Paid") {
        $query = "UPDATE loan_requests SET status='$status' WHERE id=$id";
        mysqli_query($conn, $query);
    }

    header("Location: request.php");
    exit();
}
?>
