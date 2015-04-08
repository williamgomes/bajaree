<?php
include ('../../config/config.php');

$count = 0;
$data = array();
$data['error'] = 0;
$data['error_text'] = '';

extract($_POST);

if($count > 0){
  
  $countUpdateSql = "UPDATE `config_settings` SET `CS_value` = CASE `CS_option`
                WHEN 'INVOICE_MAXIMUM_PRODUCT_COUNT' THEN $count
                ELSE `CS_value`
                END";
  $resultCountUpdate = mysqli_query($con, $countUpdateSql);
  if($resultCountUpdate){
    $data['error'] = 0;
  } else {
    $data['error'] = 1;
    if(DEBUG){
      $data['error_text'] = 'resultCountUpdate error: ' . mysqli_error($con);
    } else {
      $data['error_text'] = 'resultCountUpdate query failed';
    }
  }
}
echo json_encode($data);
?>