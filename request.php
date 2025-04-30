<?php
include("./includes/header.php");
include("./includes/db_conn.php");

$query = "SELECT * FROM loan_requests";
$result = mysqli_query($conn, $query);
?>

<div class="container">
    <h2 class="text-center">Loan Requests</h2>
    <a href="add_request.php" class="btn btn-primary">Add Request</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Borrower</th>
                <th>Amount</th>
                <th>Date Borrowed</th>
                <th>Details</th>
                <th>Status</th>
                <th>Operations</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['borrower_name'] ?></td>
                    <td><?= $row['amount'] ?></td>
                    <td><?= $row['date_borrowed'] ?></td>
                    <td><?= $row['details'] ?></td>
                    <td>
                        <form method="POST" action="update_status.php">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <select name="status" onchange="this.form.submit()">
                                <option value="Pending" <?= ($row['status'] == 'Pending') ? 'selected' : '' ?>>Pending</option>
                                <option value="Paid" <?= ($row['status'] == 'Paid') ? 'selected' : '' ?>>Paid</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <a href="edit_request.php?id=<?= $row['id'] ?>">Edit</a> |
                        <a href="delete_request.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include("./includes/footer.php"); ?>