<?php
include("./includes/db_conn.php");
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM loan_requests WHERE id = $id");
header("Location: request.php");
?>

