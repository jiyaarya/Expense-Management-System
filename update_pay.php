<?php
include("./includes/db_conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $receiver_name = $_POST['receiver_name'];
    $amount = $_POST['amount'];
    $date_paid = $_POST['date_paid'];
    $details = $_POST['details'];
    $status = $_POST['status'];

    $query = "UPDATE pay_money SET 
              receiver_name='$receiver_name', 
              amount='$amount', 
              date_paid='$date_paid', 
              details='$details', 
              status='$status' 
              WHERE id=$id";

    if (mysqli_query($conn, $query)) {
        header("Location: pay_money.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>
