<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include('../../config/config.php');


$InventoryID = 0;
$Action = '';
$data['productImage'] = array();
$data['currencySign'] = '';
$wishlistCheck = FALSE;
$InventorySize = '';
$InventoryCurrentPrice = 0;
$inventoryOldPrice = 0;
$CartID = session_id();

extract($_POST);

if($Action == 'GetInventoryInfo'){
  $sqlInventoryInfo = "SELECT * FROM product_inventories,sizes WHERE PI_status='active' AND product_inventories.PI_id=$InventoryID AND sizes.size_id=product_inventories.PI_size_id";
  $executeInventoryInfo = mysqli_query($con, $sqlInventoryInfo);
  if($executeInventoryInfo){
    $executeInventoryInfoObj = mysqli_fetch_object($executeInventoryInfo);
    if(isset($executeInventoryInfoObj->PI_id)){
      $InventorySize = $executeInventoryInfoObj->size_title;
      $InventoryCurrentPrice = $executeInventoryInfoObj->PI_current_price;
      $inventoryOldPrice = $executeInventoryInfoObj->PI_old_price;
      
      //checking if this product is already in temporary cart
      $ProductQuantity = 0;   
      $sqlTempCartProduct = "SELECT * FROM temp_carts WHERE TC_session_id='$CartID' AND TC_product_inventory_id=$InventoryID AND TC_product_id=$ProductID";
      $executeTempCartProduct = mysqli_query($con,$sqlTempCartProduct);
      if($executeTempCartProduct){
        $executeTempCartProductObj = mysqli_fetch_object($executeTempCartProduct);
        if(isset($executeTempCartProductObj->TC_product_id)){
          $ProductQuantity = $executeTempCartProductObj->TC_product_quantity;
        }
      } else {
        if(DEBUG){
          echo "executeTempCartProduct error: " . mysqli_error($con);
        }
      }
      
      
      //getting wish list data from database
      if (!checkUserLogin()) {
        $userID = 0;
      } else {
        $userID = getSession('UserID');
        $arrayWishlist = array();
        if(getSession('UserName') != ''){
          $userID = getSession('UserID');
          $sqlWishlist = "SELECT * FROM wishlists WHERE WL_user_id=$userID AND WL_product_id=$ProductID AND WL_inventory_id=$InventoryID";
          $executeWishlist = mysqli_query($con,$sqlWishlist);
          $countWishlist = 0;
          if($executeWishlist){
            $countWishlist = mysqli_num_rows($executeWishlist);
            if($countWishlist > 0){
              $wishlistCheck = TRUE;
            }
          } else {
            if(DEBUG){
              echo "executeWishlist error: " . mysqli_error($con);
            }
          }
        }
      }
      
      
      //getting pictures from table
      $arrayProductImage = array();
      $sqlProductImage = "SELECT * FROM product_images WHERE PI_product_id=$ProductID AND PI_inventory_id=$InventoryID";
      $executeProductImages = mysqli_query($con,$sqlProductImage);
      if($executeProductImages){
        while($executeProductImagesObj = mysqli_fetch_object($executeProductImages)){
          $arrayProductImage[] = $executeProductImagesObj;
        }
      } else {
        if(DEBUG){
          echo "executeProductImages error: " . mysqli_error($con);
        }
      }
      
      
      //passing data using JSON ENCODE
      $data = array("error" => 0, "size" => $InventorySize, "current_price" => $InventoryCurrentPrice, "old_price" => $inventoryOldPrice, "tempcartquantity" => $ProductQuantity, "wishlistCheck" => $wishlistCheck); // Email address not verified
      $data['productImage'] = $arrayProductImage;
      $data['currencySign'] = $config['CURRENCY_SIGN'];
      echo json_encode($data);
    } else {
      if(DEBUG){
        echo "executeInventoryInfoObj object fetch failed.";
      }
    }
  } else {
    if(DEBUG){
      echo "executeInventoryInfo error: " . mysqli_error($con);
    }
  }
}
?>
