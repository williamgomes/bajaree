<?php

include('../../config/config.php');

$Title = '';
$Phone = '';
$Address = '';
$Zip = '';
$Area = '';
$City = '';
$Country = '';
$Action = '';
$UserID = 0;
$countCheckTitle = 0;
$data = array();
$data['error'] = 0;
$data['error_text'] = '';
$data['AllAddress'] = array();


if(checkUserLogin()){
  $UserID = getSession('UserID');
}

extract($_POST);

if($Action == 'AddAddress'){
  $sqlCheckTitle = "SELECT * FROM user_addresses WHERE UA_title='$Title' AND UA_user_id=$UserID";
  $executeCheckTitle = mysqli_query($con,$sqlCheckTitle);
  if($executeCheckTitle){
    $countCheckTitle = mysqli_num_rows($executeCheckTitle);
  }
  
  if($countCheckTitle > 0){
    $data['error'] = 1;
    $data['error_text'] = 'This Title already exist in record.';
  } else {
    $addAddress = '';
    $addAddress .= ' UA_user_id = "' . intval($UserID) . '"';
    $addAddress .= ', UA_title = "' . mysqli_real_escape_string($con, $Title) . '"';
    $addAddress .= ', UA_phone = "' . mysqli_real_escape_string($con, $Phone) . '"';
    $addAddress .= ', UA_country_id = "' . intval($Country) . '"';
    $addAddress .= ', UA_city_id = "' . intval($City) . '"';
    $addAddress .= ', UA_area_id = "' . intval($Area) . '"';
    $addAddress .= ', UA_zip = "' . mysqli_real_escape_string($con, $Zip) . '"';
    $addAddress .= ', UA_address = "' . mysqli_real_escape_string($con, $Address) . '"';
    
    $sqlAddAddress = "INSERT INTO user_addresses SET $addAddress";
    $executeAddAddress = mysqli_query($con,$sqlAddAddress);
    if($executeAddAddress){
      $data['error'] = 0;
      $data['error_text'] = 'Address added successfully to the record.';
    } else {
      $data['error'] = 2;
      if(DEBUG){
        $data['error_text'] = 'executeAddAddress error: ' . mysqli_error($con);
      } else {
        $data['error_text'] = 'executeAddAddress query failed.';
      }
    }
  }
  //getting all addresses from database
  $sqlAddress = "SELECT 
               user_addresses.UA_id,user_addresses.UA_title,user_addresses.UA_first_name,user_addresses.UA_middle_name,user_addresses.UA_last_name,user_addresses.UA_phone,user_addresses.UA_zip,user_addresses.UA_address,
               cities.city_name,
               countries.country_name,
               areas.area_name
               
               FROM user_addresses
               
               LEFT JOIN areas ON areas.area_id = user_addresses.UA_area_id
               LEFT JOIN cities ON cities.city_id = user_addresses.UA_city_id
               LEFT JOIN countries ON countries.country_id = user_addresses.UA_country_id
               WHERE UA_user_id=$UserID";
  $executeAddress = mysqli_query($con,$sqlAddress);
  if($executeAddress){
    while($executeAddressObj = mysqli_fetch_object($executeAddress)){
      $data['AllAddress'][] = $executeAddressObj;
    }
  } else {
    if(DEBUG){
      echo "executeAddress error: " . mysqli_error($con);
    } else {
      echo "executeAddress query failed.";
    }
  }
  
  echo json_encode($data);
}

?>
