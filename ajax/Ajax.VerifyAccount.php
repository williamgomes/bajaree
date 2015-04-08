<?php
include('config/config.php');
$HashKey = '';
$Email = '';


if(isset($_GET['ac']) AND base64_decode($_GET['ac'] == 'Verify')){
  $Email = base64_decode($_GET['m']);
  $HashKey = base64_decode($_GET['t']);
  $sqlCheckUser = "SELECT * FROM users WHERE user_email='$Email' AND user_hash='$HashKey'";
  $executeCheckUser = mysqli_query($con,$sqlCheckUser);
  if($executeCheckUser){
    if(mysqli_num_rows($executeCheckUser) > 0){
      $executeCheckUserObj = mysqli_fetch_object($executeCheckUser);
      if(isset($executeCheckUserObj->user_id)){
        $status = $executeCheckUserObj->user_verification;
        if($status == 'yes'){
          $msg = "Your account is already verified.";
          redirect('index.php?msg=' . base64_encode($msg));
        } else {
          $updateUser = '';
          $updateUser .= ' user_verification = "' . mysqli_real_escape_string($con, 'yes') . '"';
          
          $sqlUpdateUser = "UPDATE users SET $updateUser WHERE user_email='$Email' AND user_hash='$HashKey'";
          $executeUpdateUser = mysqli_query($con,$sqlUpdateUser);
          if($executeUpdateUser){
            $msg = "Your account verified successfully.";
            redirect('index.php?msg=' . base64_encode($msg));
          } else {
            $err = "Your account verified failed. Try again.";
            redirect('index.php?msg=' . base64_encode($err));
          }
        }
      }
    } else {
      $err = "Wrong activation link.";
    }
  } else {
    $err = "executeCheckUser query failed. Try again.";
    redirect('index.php?msg=' . base64_encode($err));
  }
}
?>