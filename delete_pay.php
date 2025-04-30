<?php
include("./includes/db_conn.php");

$id = $_GET['id'];
$query = "DELETE FROM pay_money WHERE id = $id";

if (mysqli_query($conn, $query)) {
    header("Location: pay_money.php");
    exit();
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
?>
