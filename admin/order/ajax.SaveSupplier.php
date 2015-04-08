<?php
include ('../../config/config.php');

$supplierID = 0;
$orderProductID = 0;
$data = array();
$data['error'] = 0;
$data['error_text'] = '';

extract($_POST);

if($supplierID > 0 AND $orderProductID > 0 AND $status != ""){
  
  if($status == "TRUE"){
    $sqlUpdateSupplier = "UPDATE order_products SET OP_supplier_id=$supplierID WHERE OP_id=$orderProductID";
  } else {
    $sqlUpdateSupplier = "UPDATE order_products SET OP_supplier_id='' WHERE OP_id=$orderProductID";
  }
  $executeUpdateSupplier = mysqli_query($con,$sqlUpdateSupplier);
  if($executeUpdateSupplier){
    $data['error'] = 0;
    $data['error_text'] = "Updated successfully.";
  } else {
    $data['error'] = 1;
    $data['error_text'] = 'executeUpdateSupplier error: ' . mysqli_error($con);
  }
  
  echo json_encode($data);
}

?>