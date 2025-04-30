<?php
include("./includes/header.php");
include("./includes/db_conn.php");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $receiver_name = $_POST['receiver_name'];
    $amount = $_POST['amount'];
    $date_paid = $_POST['date_paid'];
    $details = $_POST['details'];
    $status = $_POST['status'];

    $update_query = "UPDATE pay_money SET receiver_name=?, amount=?, date_paid=?, details=?, status=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, "sdsssi", $receiver_name, $amount, $date_paid, $details, $status, $id);
    mysqli_stmt_execute($stmt);

    header("Location: pay_money.php");
    exit();
}

// Fetch current data
$id = $_GET['id'];
$query = "SELECT * FROM pay_money WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
?>

<div class="container mt-5">
    <h2 class="text-center">Update Payment</h2>

    <form method="POST" class="p-4 border rounded bg-light">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Receiver Name</label>
                <input type="text" name="receiver_name" class="form-control" value="<?= htmlspecialchars($row['receiver_name']) ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Amount</label>
                <input type="number" step="0.01" name="amount" class="form-control" value="<?= $row['amount'] ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Date Paid</label>
                <input type="date" name="date_paid" class="form-control" value="<?= $row['date_paid'] ?>" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Details</label>
            <textarea name="details" class="form-control" placeholder="Enter Details"><?= htmlspecialchars($row['details']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="Pending" <?= ($row['status'] == 'Pending') ? 'selected' : '' ?>>Pending</option>
                <option value="Paid" <?= ($row['status'] == 'Paid') ? 'selected' : '' ?>>Paid</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Update Payment</button>
    </form>
</div>

<?php include("./includes/footer.php"); ?>
