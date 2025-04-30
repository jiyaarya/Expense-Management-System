<?php

include("./includes/header.php");
include("./includes/functions.php");
include("./includes/db_conn.php");
check_user();
$edit_expense_id=null;
$db_item_name=null;
$db_item_price=null;
$db_item_date=null;
$db_item_details=null;
if(isset($_REQUEST['edit_expense_id'])){
    $edit_expense_id=$_REQUEST['edit_expense_id'];
    $fetch_query="SELECT * FROM expense_info WHERE item_id=$edit_expense_id";
    $run_fetch_query=mysqli_query($conn,$fetch_query);
    $row=mysqli_fetch_assoc($run_fetch_query);
    $db_item_name=$row['item_name'];
    $db_item_price=$row['item_price'];
    $db_item_date=$row['item_date'];
    $db_item_details=$row['item_details'];
}
  if(isset($_REQUEST['update_item'])){
    $update_item_name=$_REQUEST['update_item_name'];
    $update_item_price=$_REQUEST['update_item_price'];
    $update_item_date=$_REQUEST['update_item_date'];
    $update_item_details=$_REQUEST['update_item_details'];
    
    $update_query="UPDATE `expense_info` SET `item_name`='$update_item_name',`item_price`='$update_item_price',`item_date`='$update_item_date',`item_details`='$update_item_details' WHERE item_id=$edit_expense_id";
    $run_update_query=mysqli_query($conn,$update_query);
    if($run_update_query){
        my_alert("success","Expense Updated successfully");
    }else{
        my_alert("danger","Error while updating the expense");
    }
  
  }

  
    mysqli_close($conn);
  
?>
<div class="container py-3">
    <h2 class="text-center diaplsy-4 py-3 fw-semibold">Update Expense</h2>
<form method="POST">
    <div class="row">
    <div class="col-md-4 mb-3">
        <label for="" class="form-label">Name</label>
        <input type="text" class="form-control" name="update_item_name" placeholder="Item Name" value="<?php echo $db_item_name?>">

    </div>
    <div class="col-md-4 mb-3">
        <label for="" class="form-label">Price</label>
        <input type="number" class="form-control" name="update_item_price" placeholder="Amount" value="<?php echo $db_item_price?>">

    </div>
    <div class="col-md-4 mb-3">
        <label for="" class="form-label">Date</label>
        <input type="date" class="form-control" name="update_item_date"value="<?php echo $db_item_date?>">

    </div>
    <div class="col-md-12 mb-3">
        <label for="" class="form-label">Details</label>
        <input type="text" class="form-control" name="update_item_details" placeholder="Enter Details"value="<?php echo $db_item_details?>">

    </div>
    <div class="col-md-12 mb-3">
       <button type="submit" name="update_item" class="btn btn-primary">Update Expense</button>

    </div>
</div>
    
</form>

</div>








<?php
include("./includes/footer.php")
?>