<?php

include('../../config/config.php');

$ProductID = 0;
$SecurityKey = '';
$data = array();
$data['error'] = 0;
$data['error_text'] = '';
$data['Inventories'] = array();

extract($_POST);

$CategoryID = intval($CategoryID);

if ($ProductID >= 0 AND $SecurityKey == $config['PASSWORD_KEY']) {
  //showing all available category information
  $sqlGetProduct = "SELECT 
    
    product_inventories.PI_inventory_title,product_inventories.PI_size_id,product_inventories.PI_cost,product_inventories.PI_current_price,product_inventories.PI_old_price,product_inventories.PI_quantity,
    product_discounts.PD_start_date,product_discounts.PD_end_date,product_discounts.PD_amount,product_discounts.PD_status,
    (SELECT product_images.PI_file_name FROM product_images WHERE product_images.PI_inventory_id = products.product_default_inventory_id AND product_images.PI_product_id = products.product_id ORDER BY product_images.PI_priority DESC LIMIT 1) as PI_file_name
    
    FROM product_inventories

    LEFT JOIN product_inventories ON product_inventories.PI_product_id = $ProductID
    LEFT JOIN product_discounts ON product_discounts.PD_inventory_id = product_inventories.PI_id
    ORDER BY products.product_priority DESC";
  $resultGetProduct = mysqli_query($con, $sqlGetProduct);
  if ($resultGetProduct) {
    while ($resultGetProductObj = mysqli_fetch_object($resultGetProduct)) {

      $data['Inventories'][] = $resultGetProductObj;
//        $imageName = $resultGetProductObj->PI_file_name;
//        $smallImagePath = baseUrl() . "upload/product/small/" . $imageName;
//        $extension = pathinfo($smallImagePath, PATHINFO_EXTENSION);
//        $data = file_get_contents($smallImagePath);
//        $smallImageBase64 = 'data:image/' . $extension . ';base64,' . base64_encode($data);
    }
  } else {
    $data['error'] = 1;
    if (DEBUG) {
      $data['error_text'] = 'resultGetProduct error: ' . mysqli_error($con);
    } else {
      $data['error_text'] = 'resultGetProduct query error';
    }
  }

  $data['error'] = 3;
  $data['error_text'] = 'Invalid Product ID or Security Key';
}
?>
