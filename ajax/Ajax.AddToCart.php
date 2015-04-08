<?php

include('../config/config.php');
$ProductID = 0;
$InventoryID = 0;
$Action = '';
$CartID = '';
$productTaxID = 0;
$productTax = 0;
extract($_POST);
$data = array();
$data["error"] = 0;
$data["error_text"]='';
$data["quantity"] = 0;
$data["fullTempCart"] = array();

if ($Action == 'AddToCart') {
  if ($CartID == '') {
    $CartID = session_id();
  }
  //checking if the product already exist in order table
  $countCheckProduct = 0;
  $sqlCheckProduct = "SELECT * FROM temp_carts WHERE TC_product_id=$ProductID AND TC_product_inventory_id=$InventoryID AND TC_session_id='$CartID'";
  $executeCheckProduct = mysqli_query($con, $sqlCheckProduct);
  if ($executeCheckProduct) {
    $countCheckProduct = mysqli_num_rows($executeCheckProduct);
  } else {
    $data["error"] = 1; //echo "executeCheckProduct error: " . mysqli_error($con);
    if(DEBUG){
      $data["error_text"] = "executeCheckProduct error: " . mysqli_error($con); //echo "executeCheckProduct error: " . mysqli_error($con);
    } else {
      $data["error_text"] = "System Error: Product check failed."; //echo "executeCheckProduct error: " . mysqli_error($con);
    }
  }

  if ($countCheckProduct > 0) {
    $checkProductQuantity = 0;
    $newProductQuantity = 0;
    $unitPrice = 0;
    $unitDiscount = 0;
    $totalPrice = 0;
    $totalDiscount = 0;
    $executeCheckProductObj = mysqli_fetch_object($executeCheckProduct);
    if (isset($executeCheckProductObj)) {
      //getting added quantity of the product
      $checkProductQuantity = $executeCheckProductObj->TC_product_quantity;
      $newProductQuantity = $checkProductQuantity + 1;
      $unitPrice = $executeCheckProductObj->TC_unit_price;
      $unitDiscount = $executeCheckProductObj->TC_per_unit_discount;
      $totalPrice = $unitPrice * $newProductQuantity;
      $totalDiscount = $unitDiscount * $newProductQuantity;
    }

    //updating product quantity in database
    $updateTempCart = '';
    $updateTempCart .= ' TC_product_quantity = "' . intval($newProductQuantity) . '"';
    $updateTempCart .= ', TC_product_total_price = "' . intval($totalPrice) . '"';
    $updateTempCart .= ', TC_discount_amount = "' . intval($totalDiscount) . '"';

    $sqlUpdateTempCart = "UPDATE temp_carts SET $updateTempCart WHERE TC_product_id=$ProductID AND TC_product_inventory_id=$InventoryID";
    $executeUpdateTempCart = mysqli_query($con, $sqlUpdateTempCart);
    if ($executeUpdateTempCart) {
      $data['quantity'] = $newProductQuantity; // Email address already registered with database
    } else {
      $data["error"] = 2; //echo "executeUpdateTempCart error: " . mysqli_error($con);
      if(DEBUG){
        $data["error_text"] = "executeUpdateTempCart error: " . mysqli_error($con); //echo "executeCheckProduct error: " . mysqli_error($con);
      } else {
        $data["error_text"] = "System Error: Update Product in cart failed."; //echo "executeCheckProduct error: " . mysqli_error($con);
      }
    }
  } else {

    $productPrice = 0;
    $productDiscount = 0;

    //getting product information from database
    $sqlProduct = "SELECT * FROM products,product_inventories
                        WHERE products.product_id=$ProductID 
                        AND product_inventories.PI_product_id=$ProductID
                        AND product_inventories.PI_id=$InventoryID";
    $executeProduct = mysqli_query($con, $sqlProduct);
    if ($executeProduct) {
      $ChkDiscount = "SELECT * FROM product_discounts 
                    WHERE DATE(PD_start_date) <= DATE(CURDATE()) 
                    AND DATE(PD_end_date) >= DATE(CURDATE()) 
                    AND PD_product_id='$ProductID' AND PD_inventory_id='$InventoryID'";
      $executeDiscount = mysqli_query($con, $ChkDiscount);
      if ($executeDiscount) {
        $executeDiscountObj = mysqli_fetch_object($executeDiscount);
        if (isset($executeDiscountObj->PD_product_id)) {
          $productDiscount = $executeDiscountObj->PD_amount;
        }
      }
      $executeProductObj = mysqli_fetch_object($executeProduct);
      if (isset($executeProductObj->product_id)) {
        $productPrice = $executeProductObj->PI_current_price;
        $productTaxID = $executeProductObj->product_tax_class_id;
      }
      
      if($productTaxID > 0){
        $sqlGetTax = "SELECT * FROM tax_classes WHERE TC_id=$productTaxID";
        $resultGetTax = mysqli_query($con,$sqlGetTax);
        if($resultGetTax){
          $resultGetTaxObj = mysqli_fetch_object($resultGetTax);
          if(isset($resultGetTaxObj->TC_id)){
            $productTax = $resultGetTaxObj->TC_percent;
          }
        } else {
          $data["error"] = 2;
          if(DEBUG){
            $data["error_text"] = "resultGetTax error: " . mysqli_error($con); //echo "executeCheckProduct error: " . mysqli_error($con);
          } else {
            $data["error_text"] = "resultGetTax query failed.";
          }
        }
      }
    }

    $AddToTempCart = '';
    $AddToTempCart .= ' TC_session_id = "' . mysqli_real_escape_string($con, $CartID) . '"';
    $AddToTempCart .= ', TC_product_id = "' . intval($ProductID) . '"';
    $AddToTempCart .= ', TC_product_inventory_id = "' . intval($InventoryID) . '"';
    $AddToTempCart .= ', TC_product_tax = "' . floatval($productTax) . '"';
    if (getSession('UserID') != '') {
      $AddToTempCart .= ', TC_user_id = "' . intval(getSession('UserID')) . '"';
    }
    $AddToTempCart .= ', TC_unit_price = "' . floatval($productPrice) . '"';
    $AddToTempCart .= ', TC_per_unit_discount = "' . floatval($productDiscount) . '"';
    $AddToTempCart .= ', TC_discount_amount = "' . floatval($productDiscount) . '"';
    $AddToTempCart .= ', TC_product_quantity = "' . intval(1) . '"';
    $AddToTempCart .= ', TC_product_total_price = "' . floatval($productPrice) . '"';

    $sqlAddToTempCart = "INSERT INTO temp_carts SET $AddToTempCart";
    $executeAddToTempCart = mysqli_query($con, $sqlAddToTempCart);
    if ($executeAddToTempCart) {
      $data["quantity"] = 1; // Email address already registered with database
    } else {
      $data["error"] = 3; // "executeAddToTempCart error: " . mysqli_error($con);
      if (DEBUG) {
        $data["error_text"] = "executeAddToTempCart error: " . mysqli_error($con);
      } else {
        $data["error_text"] = "System Error: Product add failed.";
      }
    }
  }
}


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
    $data["fullTempCart"][] = $executeMiniTempCartObj;
  }
  $data["currencySign"] = $config['CURRENCY_SIGN']; //defining currency sign
} else {
  $data["error"] = 4;  //"executeMiniTempCart error: " . mysqli_error($con)
  if(DEBUG){
    $data["error_text"] = "executeMiniTempCart error: " . mysqli_error($con);
  } else {
    $data["error_text"] = "System Error: Mini cart generation failed.";
  }
}
/* //Full temp cart query */


echo json_encode($data);
?>