<?php
include('../config/config.php');

$TmpCartID = 0;
$CartQuantity = 0;
$TCProductUnitPrice = 0;
$TCProductUnitDiscount = 0;
$NewQuantity = 0;
$CartID = session_id();
$data = array();
$data["error"] = 0;
$data["error_text"]='';
$data["quantity"] = 0;
$data["totalPrice"] = 0;
$data["cartSubTotal"] = 0;
$data["cartTotalDiscount"] = 0;
$data["wholeCartPrice"] = 0;
$data["TotalTax"] = 0;
$data["currencySign"] = "৳";
$Action = '';

extract($_POST);


//PHP function for decreasing temp cart quantity
if($Action == 'Increase' AND $TmpCartID > 0 AND $CartQuantity >= 0){
  $sqlTmpCart = "SELECT * FROM temp_carts WHERE TC_id=$TmpCartID";
  $executeTmpCart = mysqli_query($con,$sqlTmpCart);
  if($executeTmpCart){
    $executeTmpCartObj = mysqli_fetch_object($executeTmpCart);
    if(isset($executeTmpCartObj->TC_id)){
      $TCProductUnitPrice = $executeTmpCartObj->TC_unit_price;
      $TCProductUnitDiscount = $executeTmpCartObj->TC_per_unit_discount;
      $NewQuantity = $CartQuantity + 1;
      $NewTotalPrice = $TCProductUnitPrice * $NewQuantity;
      $NewTotalDiscount = $TCProductUnitDiscount * $NewQuantity;
      
      //updating temp cart record
      $updateTempCart = '';
      $updateTempCart .= ' TC_product_quantity = "' . intval($NewQuantity) . '"';
      $updateTempCart .= ', TC_product_total_price = "' . floatval($NewTotalPrice) . '"';
      $updateTempCart .= ', TC_discount_amount = "' . floatval($NewTotalDiscount) . '"';
      
      $sqlUpdateTempCart = "UPDATE temp_carts SET $updateTempCart WHERE TC_id=$TmpCartID";
      $executeUpdateTempCart = mysqli_query($con, $sqlUpdateTempCart);
      if($executeUpdateTempCart){
        $data["error"] = 0;
        $data["quantity"] = $NewQuantity;
        $data["totalPrice"] = number_format(($NewTotalPrice - $NewTotalDiscount),2);
      } else {
        $data["error"] = 2;
        if(DEBUG){
          $data["error_text"]= 'executeUpdateTempCart error: ' . mysqli_error($con);
        } else {
          $data["error_text"]= 'System Error: Cart update failed.';
        }
      }
    }
  } else {
    $data["error"] = 1;
    if(DEBUG){
      $data["error_text"]= 'executeTmpCart error: ' . mysqli_error($con);
    } else {
      $data["error_text"]= 'System Error: Product checking failed.';
    }
  }
  
  $sqlWholeTempCart = "SELECT SUM(TC_product_total_price) AS TotalPrice, SUM(TC_discount_amount) AS TotalDiscount, SUM((TC_product_tax*TC_product_total_price)/100) AS TotalTax  FROM temp_carts WHERE TC_session_id='$CartID'";
  $executeWholeCart = mysqli_query($con,$sqlWholeTempCart);
  if($executeWholeCart){
    $executeWholeCartObj = mysqli_fetch_object($executeWholeCart);
    $CartTotalPrice = $executeWholeCartObj->TotalPrice;
    $CartTotalDiscount = $executeWholeCartObj->TotalDiscount;
    $data["cartSubTotal"] = number_format($CartTotalPrice, 2);
    $data["cartTotalDiscount"] = number_format($CartTotalDiscount, 2);
    $data["wholeCartPrice"] = number_format(($CartTotalPrice + $executeWholeCartObj->TotalTax - $CartTotalDiscount), 2);
    $data["TotalTax"] = number_format(($executeWholeCartObj->TotalTax), 2);
  } else {
    $data["error"] = 3;
    if(DEBUG){
      $data["error_text"]= 'executeWholeCart error: ' . mysqli_error($con);
    } else {
      $data["error_text"]= 'System Error: Mini cart generation failed.';
    }
  }
  
  echo json_encode($data);
}







//PHP function for decreasing temp cart quantity
if($Action == 'Decrease' AND $TmpCartID > 0 AND $CartQuantity >= 1){
  $sqlTmpCart = "SELECT * FROM temp_carts WHERE TC_id=$TmpCartID";
  $executeTmpCart = mysqli_query($con,$sqlTmpCart);
  if($executeTmpCart){
    $executeTmpCartObj = mysqli_fetch_object($executeTmpCart);
    if(isset($executeTmpCartObj->TC_id)){
      $TCProductUnitPrice = $executeTmpCartObj->TC_unit_price;
      $TCProductUnitDiscount = $executeTmpCartObj->TC_per_unit_discount;
      $NewQuantity = $CartQuantity - 1;
      $NewTotalPrice = $TCProductUnitPrice * $NewQuantity;
      $NewTotalDiscount = $TCProductUnitDiscount * $NewQuantity;
      
      //updating temp cart record
      $updateTempCart = '';
      $updateTempCart .= ' TC_product_quantity = "' . intval($NewQuantity) . '"';
      $updateTempCart .= ', TC_product_total_price = "' . floatval($NewTotalPrice) . '"';
      $updateTempCart .= ', TC_discount_amount = "' . floatval($NewTotalDiscount) . '"';
      
      $sqlUpdateTempCart = "UPDATE temp_carts SET $updateTempCart WHERE TC_id=$TmpCartID";
      $executeUpdateTempCart = mysqli_query($con, $sqlUpdateTempCart);
      if($executeUpdateTempCart){
        $data["error"] = 0;
        $data["quantity"] = $NewQuantity;
        $data["totalPrice"] = number_format(($NewTotalPrice - $NewTotalDiscount),2);
      } else {
        $data["error"] = 2;
        if(DEBUG){
          $data["error_text"]= 'executeUpdateTempCart error: ' . mysqli_error($con);
        } else {
          $data["error_text"]= 'executeUpdateTempCart query failed';
        }
      }
    }
  } else {
    $data["error"] = 1;
    if(DEBUG){
      $data["error_text"]= 'executeTmpCart error: ' . mysqli_error($con);
    } else {
      $data["error_text"]= 'executeTmpCart query failed';
    }
  }
  
  $sqlWholeTempCart = "SELECT SUM(TC_product_total_price) AS TotalPrice, SUM(TC_discount_amount) AS TotalDiscount, SUM((TC_product_tax*TC_product_total_price)/100) AS TotalTax  FROM temp_carts WHERE TC_session_id='$CartID'";
  $executeWholeCart = mysqli_query($con,$sqlWholeTempCart);
  if($executeWholeCart){
    $executeWholeCartObj = mysqli_fetch_object($executeWholeCart);
    $CartTotalPrice = $executeWholeCartObj->TotalPrice;
    $CartTotalDiscount = $executeWholeCartObj->TotalDiscount;
    $data["cartSubTotal"] = number_format($CartTotalPrice, 2);
    $data["cartTotalDiscount"] = $CartTotalDiscount;
    $data["wholeCartPrice"] = number_format(($CartTotalPrice + $executeWholeCartObj->TotalTax - $CartTotalDiscount), 2);
    $data["TotalTax"] = number_format(($executeWholeCartObj->TotalTax), 2);
  } else {
    $data["error"] = 3;
    if(DEBUG){
      $data["error_text"]= 'executeWholeCart error: ' . mysqli_error($con);
    } else {
      $data["error_text"]= 'executeWholeCart query failed';
    }
  }
  
  echo json_encode($data);
}
?>
