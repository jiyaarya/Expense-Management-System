<?php
include("./includes/header.php");
include("./includes/db_conn.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $receiver_name = $_POST['receiver_name'];
    $amount = $_POST['amount'];
    $date_paid = $_POST['date_paid'];
    $details = $_POST['details'];
    $status = $_POST['status'];

    $query = "INSERT INTO pay_money (receiver_name, amount, date_paid, details, status) 
              VALUES ('$receiver_name', '$amount', '$date_paid', '$details', '$status')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: pay_money.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<div class="container mt-5">
    <h2 class="text-center">Add Payment</h2>
    <form method="POST" class="p-4 border rounded bg-light">
        <div class="mb-3">
            <label class="form-label">Receiver Name</label>
            <input type="text" name="receiver_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Amount</label>
            <input type="number" step="0.01" name="amount" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Date Paid</label>
            <input type="date" name="date_paid" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Details</label>
            <textarea name="details" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="Pending">Pending</option>
                <option value="Paid">Paid</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success w-100">Add Payment</button>
    </form>
</div>

<?php include("./includes/footer.php"); ?>
