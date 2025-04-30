<?php
include("./includes/header.php");
include("./includes/functions.php");
include("./includes/db_conn.php");

?>
<div class="container">
    <div class="row">
        <div class="col-12 py-5">
            <h1 class="text-center">Last month Expense</h1>

        </div>
        <div class="col-12 mb-3">
            <a href="./add_expense.php" class="btn btn-primary">Add Expense</a>
        </div>

    </div>

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
$today_date=date("Y-m-d");
$previous_seven_days_date=date("Y-m-d",strtotime($today_date."-1 month"));
 $fetch_expense="SELECT * FROM expense_info WHERE item_date BETWEEN'$previous_seven_days_date' AND '$today_date' ORDER BY item_date DESC";
 $run_fetch_expense=mysqli_query($conn,$fetch_expense);
 $expense_counter=1;
 $total=0;
 if(mysqli_num_rows($run_fetch_expense)>0){
  while($row=mysqli_fetch_assoc($run_fetch_expense)){
    ?>
    <tr>
    <td><?php echo $expense_counter; ?></td>
    <td><?php echo $row['item_name']; ?></td>
    <td><?php echo $row['item_price']; ?></td>
    <td><?php customize_data($row['item_date']); ?></td>
    <td><?php echo $row['item_details']; ?></td>
    <td class="d-flex justify-content-evenly">
    <a class href="./edit_expense.php?edit_expense_id=<?php echo $row['item_id'];?>">Edit</a>
    <a href="./delete_expense.php?del_expense_id=<?php echo $row['item_id'];?>">Delete</a>
    </td>
    </tr>

    <?php

    $expense_counter++;
    $total=$total+$row['item_price'];
  }
  ?>
  <tr>
    <th colspan="5" >Total Amount</th>
    <th><?php echo $total?></th>
  </tr>
  <?php
  
 }else{
   ?>
<tr>
    <td colspan="6">
        <h3 class=text-danger text-center>
            No Record Found
        </h3>

    </td>
</tr>
   <?php
 }
 ?>
 
  </tbody>
</table>
</div>

<?php
include("./includes/footer.php")
?>