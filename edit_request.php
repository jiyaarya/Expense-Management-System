<?php
include("./includes/header.php");
include("./includes/db_conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $borrower_name = $_POST['borrower_name'];
    $amount = $_POST['amount'];
    $date_borrowed = $_POST['date_borrowed'];
    $details = $_POST['details'];
    $status = $_POST['status'];

    $update_query = "UPDATE loan_requests SET borrower_name=?, amount=?, date_borrowed=?, details=?, status=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, "sdsssi", $borrower_name, $amount, $date_borrowed, $details, $status, $id);
    mysqli_stmt_execute($stmt);
    
    header("Location: request.php");
    exit();
}

$id = $_GET['id'];
$query = "SELECT * FROM loan_requests WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
?>

<div class="container mt-5">
    <h2 class="text-center">Update Loan Request</h2>
    
    <form method="POST" class="p-4 border rounded bg-light">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Name</label>
                <input type="text" name="borrower_name" class="form-control" value="<?= htmlspecialchars($row['borrower_name']) ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Amount</label>
                <input type="number" step="0.01" name="amount" class="form-control" value="<?= $row['amount'] ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Date</label>
                <input type="date" name="date_borrowed" class="form-control" value="<?= $row['date_borrowed'] ?>" required>
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

        <button type="submit" class="btn btn-primary w-100">Update Request</button>
    </form>
</div>

<?php include("./includes/footer.php"); ?>

