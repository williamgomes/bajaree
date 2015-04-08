<?php
include('../../config/config.php');

$CategoryID = 0;
$SecurityKey = '';
$data = array();
$data['error'] = 0;
$data['error_text'] = '';
$data['Categories'] = array();

extract($_POST);

$CategoryID = intval($CategoryID);

if($CategoryID >= 0 AND $SecurityKey == $config['PASSWORD_KEY']){
  if($CategoryID == 0){ 
    //showing all available category information
    $sqlGetCategory = "SELECT * FROM categories WHERE (`category_parent_id` > 0 AND category_id < 119)";
    $resultGetCategory = mysqli_query($con,$sqlGetCategory);
    if($resultGetCategory){
      while($resultGetCategoryObj = mysqli_fetch_object($resultGetCategory)){
        $data['Categories'][] = $resultGetCategoryObj;
      }
    } else {
      $data['error'] = 1;
      if(DEBUG){
        $data['error_text'] = 'resultGetCategory error: ' . mysqli_error($con);
      } else {
        $data['error_text'] = 'resultGetCategory query error';
      }
    }
  } else {
    //showing specific category information
    $sqlGetCategory = "SELECT * FROM categories WHERE category_parent_id=$CategoryID";
    $resultGetCategory = mysqli_query($con,$sqlGetCategory);
    if($resultGetCategory){
      while($resultGetCategoryObj = mysqli_fetch_object($resultGetCategory)){
        $data['Categories'][] = $resultGetCategoryObj;
      }
    } else {
      $data['error'] = 2;
      if(DEBUG){
        $data['error_text'] = 'resultGetCategory error: ' . mysqli_error($con);
      } else {
        $data['error_text'] = 'resultGetCategory query error';
      }
    }
  }
  
  echo json_encode($data);
} else {
  $data['error'] = 3;
  $data['error_text'] = 'Invalid Category ID or Security Key';
}
?>
