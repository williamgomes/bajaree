<?php
include('../config/config.php');
$TempCartID = 0;
$Action = '';
$data = array();
$data["error"] = 0;
$data["error_text"]='';
$data["fullTempCart"] = array();
$CartID = session_id();

extract($_POST);

if($Action == 'DeleteItem'){
  
  $sqlDeleteItem = "DELETE FROM temp_carts WHERE TC_id=$TempCartID";
  $executeDeleteItem = mysqli_query($con,$sqlDeleteItem);
  if($executeDeleteItem){
    
    /* Full temp cart query */
    $arrayMiniTempCart = array();   
    $sqlMiniTempCart = "SELECT 
                products.product_id, products.product_title, products.product_default_inventory_id,  products.product_show_as_new_from, products.product_show_as_new_to, products.product_show_as_featured_from, products.product_show_as_featured_to,
                product_inventories.PI_inventory_title,product_inventories.PI_size_id,product_inventories.PI_cost,product_inventories.PI_current_price,product_inventories.PI_old_price,product_inventories.PI_quantity,
                product_discounts.PD_start_date,product_discounts.PD_end_date,product_discounts.PD_amount,product_discounts.PD_status,
                (SELECT product_images.PI_file_name FROM product_images WHERE product_images.PI_inventory_id = products.product_default_inventory_id AND product_images.PI_product_id = products.product_id ORDER BY product_images.PI_priority DESC LIMIT 1) as PI_file_name,
                temp_carts.TC_id,temp_carts.TC_unit_price,temp_carts.TC_per_unit_discount,temp_carts.TC_discount_amount,temp_carts.TC_product_quantity,temp_carts.TC_product_total_price

                FROM temp_carts

                LEFT JOIN product_inventories ON product_inventories.PI_id = temp_carts.TC_product_inventory_id
                LEFT JOIN product_discounts ON product_discounts.PD_inventory_id = temp_carts.TC_product_inventory_id
                LEFT JOIN products ON products.product_id = temp_carts.TC_product_id
                WHERE temp_carts.TC_session_id='$CartID'";
    $executeMiniTempCart = mysqli_query($con,$sqlMiniTempCart);
    if($executeMiniTempCart){
      while($executeMiniTempCartObj = mysqli_fetch_object($executeMiniTempCart)){
        $data['error'] = 0;
        $data["fullTempCart"][] = $executeMiniTempCartObj;
      }
      $data["currencySign"] = "৳"; //defining currency sign
    } else {
      $data["error"] = 2;  //"executeMiniTempCart error: " . mysqli_error($con)
      if(DEBUG){
        $data["error_text"] = "executeMiniTempCart error: " . mysqli_error($con);
      } else {
        $data["error_text"] = "System Error: Mini cart generation failed.";
      }
    }
    /* //Full temp cart query */
    
    
    
  } else {
    $data['error'] = 1;
    if(DEBUG){
      $data['error_text'] = "executeDeleteItem error: " . mysqli_error($con);
    } else {
      $data['error_text'] = "System Error: Product delete failed.";
    }
  }
  
  
  
  
  
  echo json_encode($data);
}
?>
