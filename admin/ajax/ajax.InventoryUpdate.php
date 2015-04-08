<?php

include ('../../config/config.php');
$return = array();
$return['error'] = 0;
$return['message'] = 0;
if (isset($_REQUEST["action"]) && $_REQUEST["action"] == 'costUpdate') {
    $id = $_REQUEST["id"];
    $table_name = $_REQUEST["table_name"];
    $update_field = $_REQUEST["update_field"];
    $new_cost = $_REQUEST["new_cost"];
    $where_condition = $_REQUEST["where_condition"];

    $priorityUpdateSql = "UPDATE $table_name SET $update_field = $new_cost WHERE $where_condition";
    $priorityUpdateResult = mysqli_query($con, $priorityUpdateSql);
    if ($priorityUpdateResult) {
        $return['error'] = 0;
    } else {
        if (DEBUG) {
            $return['message'] = "updateRowResult error" . mysqli_error($con); //Mysql query failed
        } else {
            $return['error'] = 1; //Mysql query failed
        }
    }
    echo json_encode($return);
}





if (isset($_REQUEST["action"]) && $_REQUEST["action"] == 'priceUpdate') {
    $id = $_REQUEST["id"];
    $table_name = $_REQUEST["table_name"];
    $update_field = $_REQUEST["update_field"];
    $new_price = $_REQUEST["new_price"];
    $where_condition = $_REQUEST["where_condition"];

    $priorityUpdateSql = "UPDATE $table_name SET $update_field = $new_price WHERE $where_condition";
    $priorityUpdateResult = mysqli_query($con, $priorityUpdateSql);
    if ($priorityUpdateResult) {
        $return['error'] = 0;
    } else {
        if (DEBUG) {
            $return['error'] = "updateRowResult error" . mysqli_error($con); //Mysql query failed
        } else {
            $return['error'] = 1; //Mysql query failed
        }
    }
    echo json_encode($return);
}
?>
