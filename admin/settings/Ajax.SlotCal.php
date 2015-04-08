<?php
include ('../../config/config.php');
$startTime = '';
$endTime = '';
$totalSlot = 0;
$data = array();
$data['error'] = '';
$data['error_text'] = '';
$data['timeDiff'] = '';

extract($_POST);
if($startTime != '' AND $endTime != '' AND $totalSlot > 0){
  //finding out difference between start time and end time
  $time1 = date('H:i:s',strtotime($endTime));
  $time2 = date('H:i:s',strtotime($startTime));
  $diff = $time1 - $time2;
  if($diff < 0){
    $data['error'] = 1;
    $data['error_text'] = "End Time must be greater than Start Time.";
  } else {
    //getting difference between each slot
    $slot = $diff/$totalSlot;

    //converting decimal output into hour, minute & second
    $data['timeDiff'] = convertTime($slot); 
  }
} else {
  $data['error'] = 1;
  $data['error_text'] = "Incorrect Condition/Parameter";
}

echo json_encode($data);
?>
