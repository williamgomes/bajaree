<?php

include('../config/config.php');

$OrderID = '';
$Phone = '';
$count = 0;
$data = array();
$data['error'] = 0;
$data['error_text'] = '';
$data['success_text'] = '';

extract($_POST);

if(isset($OrderID) AND $OrderID != "" AND isset($Phone) AND $Phone != ""){
  $sqlCheckOrder = "SELECT * FROM orders WHERE order_number='" . mysqli_real_escape_string($con, $OrderID) . "'";
  $resultCheckOrder = mysqli_query($con,$sqlCheckOrder);
  if($resultCheckOrder){
    $count = mysqli_num_rows($resultCheckOrder);
    if($count > 0){
      
      $updatePhone = '';
      $updatePhone .= ' order_billing_phone ="' . mysqli_real_escape_string($con, $Phone) . '"';
      
      $sqlUpdatePhone = "UPDATE orders SET $updatePhone WHERE order_number='" . mysqli_real_escape_string($con, $OrderID) . "'";
      $resultUpdatePhone = mysqli_query($con,$sqlUpdatePhone);
      if($resultUpdatePhone){
        $data['error'] = 0;
        $data['success_text'] = 'Phone number updated successfully.';
      } else {
        if(DEBUG){
          $data['error'] = 2;
          $data['error_text'] = 'resultUpdatePhone error: ' . mysqli_error($con);
        }
      }
    } else {
      $data['error'] = 1;
      $data['error_text'] = 'Invalid Order ID.';
    }
  } else {
    if(DEBUG){
      $data['error'] = 3;
      $data['error_text'] = 'resultCheckOrder error: ' . mysqli_error($con);
    }
  }
}

echo json_encode($data);

?>
