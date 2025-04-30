<?php
include("./includes/db_conn.php");
session_start();

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    die("Error: User not logged in.");
}

// **(1) Check if the user exists in reg_users**
$check_user_query = "SELECT reg_id FROM reg_users WHERE reg_id = ?";
$stmt = $conn->prepare($check_user_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Error: User does not exist in reg_users.");
}

// **(2) Get Data from Form**
$monthly_budget = $_POST['monthly_budget'] ?? 0;
$threshold = $_POST['threshold'] ?? 0;

// **(3) Check if User Already Has a Budget**
$query = "SELECT * FROM budget_info WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // **(4) Update Budget if Exists**
    $update_query = "UPDATE budget_info SET monthly_budget = ?, threshold = ? WHERE user_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ddi", $monthly_budget, $threshold, $user_id);
} else {
    // **(5) Insert New Budget if Not Exists**
    $insert_query = "INSERT INTO budget_info (user_id, monthly_budget, threshold) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("idd", $user_id, $monthly_budget, $threshold);
}

// **(6) Execute and Redirect to Dashboard**
if ($stmt->execute()) {
    $_SESSION['message'] = "Budget updated successfully!";
    $_SESSION['color'] = "success";
} else {
    $_SESSION['message'] = "Error updating budget.";
    $_SESSION['color'] = "danger";
}

header("Location: index.php");
exit;
?>
