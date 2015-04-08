<?php


include('../config/config.php');
$ProductID = 0;
$InventoryID = 0;
$Action = '';
$CartID = '';
extract($_POST);
$data = array();
$data["error"] = 0;
$data["error_text"]='';
$userID = 0;

if ($Action == 'AddToWishlist') {
  
  $userID = getSession('UserID');
  if($userID > 0){
    $addToWishlist = '';
    $addToWishlist .= ' WL_product_id = "' . intval($ProductID) . '"';
    $addToWishlist .= ', WL_inventory_id = "' . intval($InventoryID) . '"';
    $addToWishlist .= ', WL_user_id = "' . intval($userID) . '"';
    
    $sqlAddWishlist = "INSERT INTO wishlists SET $addToWishlist";
    $executeAddWishlist = mysqli_query($con,$sqlAddWishlist);
    if($executeAddWishlist){
      $data["error"] = 0;
    } else {
      $data["error"] = 2;
      if(DEBUG){
        $data["error_text"]='executeAddWishlist error: ' . mysqli_error($con);
      } else {
        $data["error_text"]='System Error: Add product to Wishlist failed.';
      }
    }
  } else {
    $data["error"] = 1;
    $data["error_text"] = 'You need to signin first.';
  }
}



echo json_encode($data);
?>
