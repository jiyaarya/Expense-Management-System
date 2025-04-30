<?php
include("./includes/header.php");
include("./includes/db_conn.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    die("Error: User not logged in.");
}

// **(1) Get First and Last Date of the Current Month**
$first_day_of_month = date("Y-m-01");  // e.g., 2025-04-01
$last_day_of_month = date("Y-m-t");    // e.g., 2025-04-30

// **(2) Fetch Total Expenses for the Current Month**
$expense_query = "SELECT SUM(item_price) AS total_expenses FROM expense_info WHERE item_date BETWEEN ? AND ?";
$stmt = $conn->prepare($expense_query);
$stmt->bind_param("ss", $first_day_of_month, $last_day_of_month);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_expenses = $row['total_expenses'] ?? 0;

// **(3) Fetch User's Budget and Threshold**
$budget_query = "SELECT monthly_budget, threshold FROM budget_info WHERE user_id = ?";
$stmt = $conn->prepare($budget_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$budget_data = $result->fetch_assoc();

$monthly_budget = $budget_data['monthly_budget'] ?? 0;
$threshold = $budget_data['threshold'] ?? 0;

// **(4) Check if Expenses Exceed Threshold**
$notification = "";
if ($total_expenses >= $threshold) {
    $notification = '<div class="alert alert-danger text-center">⚠️ Warning: Your expenses have exceeded the threshold!</div>';
}
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" />

<div class="container py-3">
    <h2 class="text-center display-5 fw-bold py-5">Expense Management System</h2>

    <?= $notification ?>  <!-- Display Notification if Over Budget -->

    <div class="row px-3">

        <!-- Expenses Card -->
        <div class="col-md-6">
            <a href="./all_expense.php">
                <div class="card l-bg-orange-dark">
                    <div class="card-statistic-3 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-dollar-sign"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">Total Expenses (This Month)</h5>
                        </div>
                        <h2 class="d-flex align-items-center mb-0">$<?= number_format($total_expenses, 2) ?></h2>
                    </div>
                </div>
            </a>
        </div>

        <!-- Budget Card -->
        <div class="col-md-6">
            <a href="./budget.php">
                <div class="card l-bg-green-dark">
                    <div class="card-statistic-3 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-ticket-alt"></i></div>
                        <div class="mb-3">
                            <h5 class="card-title mb-0">Budget</h5>
                        </div>
                        <h2 class="d-flex align-items-center mb-0">$<?= number_format($monthly_budget, 2) ?></h2>
                        <p class="text-white">Threshold: $<?= number_format($threshold, 2) ?></p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Loan Request -->
        <div class="col-md-6">
            <a href="./request.php">
                <div class="card l-bg-blue-dark">
                    <div class="card-statistic-3 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">Request</h5>
                        </div>
                        <h2>View Loan Details</h2>
                    </div>
                </div>
            </a>
        </div>

        <!-- Pay Money -->
        <div class="col-md-6">
            <a href="./pay_money.php">
                <div class="card l-bg-cherry">
                    <div class="card-statistic-3 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-shopping-cart"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">Pay</h5>
                        </div>
                        <h2>View Pay Money Details</h2>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>

<?php include("./includes/footer.php"); ?>
