<?php
function my_alert($color,$msg){
    ?>
    <div style="position:absolute;right:10px;top:20px;" 
    class="alert alert-<?php echo $color ?>  alert-dismissible fade show" role="alert">
 <?php echo $msg?>
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>
   <?php
}

//check  user
function check_user(){
  if(!isset($_SESSION['is_login'])==true){
    header("Location: login_user.php");
}
}

function customize_data($date){
  $formated_date=date("d-m-Y",strtotime($date));
  echo $formated_date;
}


?>
