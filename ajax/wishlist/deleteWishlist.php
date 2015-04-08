<?php
include('../../config/config.php');

$WishlistID = 0;
$Action = '';
$data = array();
$data['error'] = 0;
$data['error_text'] = '';
$data['quantity'] = 0;

$userID = 0;
$wishlistQuantity = 0;
if(checkUserLogin()){
  $userID = getSession('UserID');
}

extract($_POST);

if($Action == 'DeleteWishlist' AND $WishlistID > 0){
  $sqlDeleteWishlist = "DELETE FROM wishlists WHERE WL_id=$WishlistID";
  $executeDeleteWishlist = mysqli_query($con,$sqlDeleteWishlist);
  if($executeDeleteWishlist){
    $sqlGetQuantity = "SELECT * FROM wishlists WHERE WL_user_id=$userID";
    $executeGetQuantity = mysqli_query($con, $sqlGetQuantity);
    if($executeGetQuantity){
      $wishlistQuantity = mysqli_num_rows($executeGetQuantity);
      $data['error'] = 0;
      $data['quantity'] = $wishlistQuantity;
    } else {
      $data['error'] = 1;
      if(DEBUG){
        $data['error_text'] = "executeGetQuantity error: " . mysqli_error($con);
      } else {
        $data['error_text'] = "executeGetQuantity query failed";
      }
    }
    
  } else {
    $data['error'] = 2;
    if(DEBUG){
      $data['error_text'] = "executeDeleteWishlist error: " . mysqli_error($con);
    } else {
      $data['error_text'] = "executeDeleteWishlist query failed";
    }
  }
  
  echo json_encode($data);
}
?>
