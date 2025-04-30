<?php

include("./includes/header.php");
include("./includes/functions.php");
include("./includes/db_conn.php");
check_user();

?>
<div class="container">
    <form method="GET">
        <div class="row">
           <div class="col-md-12">
            <h2 class="text-center display-5 fw-semibold py-5">Search Expense</h2>
           </div>
            <div class="col-md-5 mb-3">
                <label for="" class="form-label">From</label>
                <input type="date" class="form-control" name="from_date" max="<?php echo date("Y-m-d"); ?>" id="from_date" onchange="get_date()">
            </div>
            <div class="col-md-5 mb-3">
                <label for="" class="form-label">To</label>
                <input type="date" class="form-control" name="to_date" max="<?php echo date("Y-m-d"); ?>" id="to_date">
            </div>
            <div class="col-md-2 mb-3 align-self-end">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
        </div>
    </form>
    <table class="table table-bordered table-striped table-hover">
  <thead>
    <tr class="text-center">
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">Price</th>
      <th scope="col">Date Added</th>
      <th scope="col">Details</th>
      <th scope="col">Operations</th>
    </tr>
  </thead>
  <tbody>
    <?php
     if(isset($_GET['from_date']) && isset($_GET['to_date'])){
        $from_date = $_GET['from_date'];
        $to_date = $_GET['to_date'];



        $search_expense = "SELECT * FROM expense_info WHERE item_date BETWEEN '$from_date' AND '$to_date'";
        
        $run_search_expense = mysqli_query($conn, $search_expense);

        // Debugging: Check if the query runs successfully
        if (!$run_search_expense) {
            die("Query Failed: " . mysqli_error($conn));
        }

        $expense_counter = 1;
        $total = 0;

        if(mysqli_num_rows($run_search_expense) > 0){
            while($row = mysqli_fetch_assoc($run_search_expense)){
          ?>
          <tr>
          <td><?php echo $expense_counter; ?></td>
          <td><?php echo $row['item_name']; ?></td>
          <td><?php echo $row['item_price']; ?></td>
          <td><?php echo $row['item_date']; ?></td>
          <td><?php echo $row['item_details']; ?></td>
          <td class="d-flex justify-content-evenly">
          <a class href="./edit_expense.php?edit_expense_id=<?php echo $row['item_id'];?>">Edit</a>
    <a href="./delete_expense.php?del_expense_id=<?php echo $row['item_id'];?>">Delete</a>
    </td>
    </tr>
      
          <?php
          $expense_counter++;
          $total += $row['item_price'];
        }
        ?>
        <tr>
          <th colspan="5">Total Amount</th>
          <th><?php echo $total ?></th>
        </tr>
        <?php
       } else {
         ?>
      <tr>
          <td colspan="6">
              <h3 class="text-danger text-center">
                  No Record Found
              </h3>
          </td>
      </tr>
         <?php
       }
     }
    ?>
  </tbody>
</table>

</div>













<?php
include("./includes/footer.php")
?>