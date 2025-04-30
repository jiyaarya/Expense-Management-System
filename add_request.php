<?php
include("./includes/header.php");
include("./includes/db_conn.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $borrower_name = $_POST['borrower_name'];
    $amount = $_POST['amount'];
    $date_borrowed = $_POST['date_borrowed'];
    $details = $_POST['details'];

    $query = "INSERT INTO loan_requests (borrower_name, amount, date_borrowed, details) 
              VALUES ('$borrower_name', '$amount', '$date_borrowed', '$details')";
    mysqli_query($conn, $query);
    header("Location: request.php");
}
?>

<div class="container">
    <h2>Add Loan Request</h2>
    <form method="POST">
        <label>Borrower Name</label>
        <input type="text" name="borrower_name" required class="form-control">
        <label>Amount</label>
        <input type="number" name="amount" required class="form-control">
        <label>Date Borrowed</label>
        <input type="date" name="date_borrowed" required class="form-control">
        <label>Details</label>
        <textarea name="details" class="form-control"></textarea>
        <button type="submit" class="btn btn-success mt-3">Add Request</button>
    </form>
</div>

<?php include("./includes/footer.php"); ?>
