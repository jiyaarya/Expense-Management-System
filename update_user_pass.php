<?php
include("./includes/header.php");
include("./includes/functions.php");
include("./includes/db_conn.php");
$update_pass_id=null;
$db_user_name=null;
if(isset($_REQUEST['update_pass_id'])){
    $update_pass_id=$_REQUEST['update_pass_id'];
    $fetch_query="SELECT user_name FROM reg_users WHERE reg_id=$update_pass_id";
    $run_fetch_query=mysqli_query($conn,$fetch_query);
    $row=mysqli_fetch_assoc($run_fetch_query);
    $db_user_name=$row['user_name'];
}
  if(isset($_REQUEST['update_pass'])){
    $update_user_pass=$_REQUEST['update_user_pass'];
    //we are showing all users in navigation if we dont want well remove following kine
    $enc_password=password_hash($update_user_pass,PASSWORD_BCRYPT);
    //IF WE DONR WANT ABOVE SAME WELL CHANGE USER_PASS TO $update_user_pass
    $update_query="UPDATE reg_users SET user_pass='$enc_password'WHERE reg_id=$update_pass_id";
    $run_update_query=mysqli_query($conn,$update_query);
    if($run_update_query){
        my_alert("success","Password updates successfully");
    }else{
        my_alert("danger","Error while updating the password");
    }
}
    
    mysqli_close($conn);


?>
<div class="container">
<div class="card "id="my-card">
  <div class="card-header bg-primary text-white">
    Set New Password
  </div>
  <div class="card-body">
    <div class="row">
    <div class="col-12">
     <form method="POST">
     <div class="mb=3">
    <label for=" " class="form-label">User Name</lable>
    <input type="text" class="form-control" value ='<?php echo $db_user_name?>'disabled>
    </div>
    <div class="mb=3">
    <label for=" " class="form-label">User Password</lable>
    <input type="password" class="form-control" name="update_user_pass">
    </div>
    <div class="mb=3">
     <button type="submit" name="update_pass" class="btn btn-primary">Update Password</button>
    </div>
     </form>
  
    </div>
    </div>
  </div>
</div>

</div>










<?php
include("./includes/footer.php")
?>