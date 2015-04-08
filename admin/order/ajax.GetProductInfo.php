<?php
include ('../../config/config.php');

$inventoryID = 0;
$data = array();
$data['error'] = 0;
$data['error_text'] = '';
$data['product_title'] = '';
$data['product_id'] = '';
$data['unit_price'] = '';
$data['unit_discount'] = '';
$data['tax'] = '';
$data['inventory_title'] = '';
$data['supplier_selectbox'] = '';

extract($_POST);

if($inventoryID > 0){
  
  $sqlGetProduct = "SELECT * 
    
                    FROM product_inventories
                    LEFT JOIN products ON PI_product_id = product_id
                    LEFT JOIN tax_classes ON product_tax_class_id=TC_id
                    WHERE PI_id=$inventoryID";
  $resultGetProduct = mysqli_query($con,$sqlGetProduct);
  if($resultGetProduct){
    $resultGetProductObj = mysqli_fetch_object($resultGetProduct);
    if(isset($resultGetProductObj->PI_id)){
      $data['error'] = 0;
      $data['product_title'] = $resultGetProductObj->product_title;
      $data['inventory_title'] = $resultGetProductObj->PI_inventory_title;
      $data['product_id'] = $resultGetProductObj->product_id;
      $data['unit_price'] = $resultGetProductObj->PI_current_price;
      $data['unit_discount'] = 0;
      $data['tax'] = $resultGetProductObj->TC_percent;
    }
  } else {
    $data['error'] = 1;
    $data['error_text'] = 'executeGetProduct error: ' . mysqli_error($con);
  }
  
  
  
  $selectHtml = '<select name="supplier">';
  $selectHtml .= '<option value="">-- Select Supplier --</option>';
  $sqlGetSupplier = "SELECT * FROM supplier_inventories, suppliers WHERE SI_product_inventory_id=$inventoryID";
  $resultGetSupplier = mysqli_query($con,$sqlGetSupplier);
  if($resultGetSupplier){
    while($resultGetSupplierObj = mysqli_fetch_object($resultGetSupplier)){
     $selectHtml .= '<option value="' . $resultGetSupplierObj->supplier_id . '">' . $resultGetSupplierObj->supplier_name . '</option>'; 
    }
  } else {
    $data['error'] = 2;
    $data['error_text'] = 'resultGetSupplier error: ' . mysqli_error($con);
  }
  $selectHtml .= '</select>';
  
  $data['supplier_selectbox'] = $selectHtml;
  
  echo json_encode($data);
}

?>