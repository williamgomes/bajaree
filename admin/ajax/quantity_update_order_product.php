<?php

include ('../../config/config.php');

$admin_id = getSession('admin_id');
$OP_id = 0;
$new_product_quantity = 0;
$table_name = '';
$update_field = '';
$where_condition = '';
$unitPrice = 0;
$unitDiscount = 0;
$unitTax = 0;
$newTotalPrice = 0;
$newTotalDiscount = 0;
$newTaxAmount = 0;
$data = array();
$data['error'] = 0;
$data['error_text'] = '';
$data['new_total_price'] = 0;
$data['new_total_discount'] = 0;
$data['new_total_tax'] = 0;

if (isset($_POST["id"])) {
  $OP_id = $_POST["id"];
}
if (isset($_POST["new_product_quantity"])) {
  $new_product_quantity = $_POST["new_product_quantity"];
}
if (isset($_POST["table_name"])) {
  $table_name = $_POST["table_name"];
}
if (isset($_POST["update_field"])) {
  $update_field = $_POST["update_field"];
}
if (isset($_POST["where_condition"])) {
  $where_condition = $_POST["where_condition"];
}
if (isset($OP_id) && isset($new_product_quantity)) {

  $sqlOrderProduct = "SELECT * FROM order_products WHERE OP_id=$OP_id";
  $resultOrderProduct = mysqli_query($con, $sqlOrderProduct);
  if ($resultOrderProduct) {
    $resultOrderProductObj = mysqli_fetch_object($resultOrderProduct);
    if (isset($resultOrderProductObj->OP_id)) {
      $unitPrice = $resultOrderProductObj->OP_price;
      $unitDiscount = $resultOrderProductObj->OP_discount;
      $unitTax = $resultOrderProductObj->OP_product_tax;
    }
  } else {
    if (DEBUG) {
      $data['error'] = 2;
      $data['error_text'] = "resultOrderProduct error: " . mysqli_error($con); //Mysql query failed
    }
  }

  $newTotalPrice = $unitPrice * $new_product_quantity;
  $newTotalDiscount = $unitDiscount * $new_product_quantity;
  $newTaxAmount = ($newTotalPrice * $unitTax) / 100;

  $quantityUpdateSql = "UPDATE $table_name SET $update_field = $new_product_quantity,OP_product_total_price=$newTotalPrice,OP_product_total_discount=$newTotalDiscount,OP_updated_by=$admin_id WHERE $where_condition";
  $quantityUpdateResult = mysqli_query($con, $quantityUpdateSql);
  if ($quantityUpdateResult) {
    $data['error'] = 0; //NO ERROR
    $data['error_text'] = 'Product Quantity Updated Successfully.';
    $data['new_total_price'] = number_format($newTotalPrice,2);
    $data['new_total_discount'] = number_format($newTotalDiscount,2);
    $data['new_total_tax'] = number_format($newTaxAmount,2);
  } else {
    if (DEBUG) {
      $data['error'] = 1;
      $data['error_text'] = "quantityUpdateResult error: " . mysqli_error($con); //Mysql query failed
    }
  }
  echo json_encode($data);
}
?>
