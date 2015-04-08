<?php
include('../config/config.php');
$Action = '';

extract($_POST);

if($Action == 'Logout'){
  if(UserLogout()){
    $data = array("error" => 0);
  } else {
    $data = array("error" => 1);
  }
  echo json_encode($data);
}
?>