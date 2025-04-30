<?php
include("./includes/header.php");
include("./includes/db_conn.php");

// **(1) Get User ID from Session**
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    die("Error: User not logged in.");
}

// **(2) Fetch Existing Budget**
$query = "SELECT * FROM budget_info WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$monthly_budget = $row['monthly_budget'] ?? 0;
$threshold = $row['threshold'] ?? 0;
?>

<div class="container py-3">
    <h2 class="text-center display-5 fw-bold py-5">Manage Budget</h2>

    <div class="card p-4">
        <div class="card-body">
            <h5 class="card-title">Current Budget</h5>
            <p><strong>Budget:</strong> <?= number_format($monthly_budget, 2) ?></p>
            <p><strong>Threshold:</strong> <?= number_format($threshold, 2) ?></p>

            <form method="POST" action="save_budget.php">
                <label class="form-label">Monthly Budget</label>
                <input type="number" step="0.01" name="monthly_budget" class="form-control" required value="<?= $monthly_budget ?>">

                <label class="form-label mt-3">Threshold Value</label>
                <input type="number" step="0.01" name="threshold" class="form-control" required value="<?= $threshold ?>">

                <button type="submit" class="btn btn-success w-100 mt-3">Save Budget</button>
            </form>
        </div>
    </div>
</div>

<?php include("./includes/footer.php"); ?>
