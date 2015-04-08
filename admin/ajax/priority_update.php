<?php

include ('../../config/config.php');
$return = array();
$return['error'] = 0;
$return['message'] = 0;
if (isset($_REQUEST["action"]) && $_REQUEST["action"] == 'priority_reset') {
    $id = $_REQUEST["id"];
    $table_name = $_REQUEST["table_name"];
    $update_field = $_REQUEST["update_field"];
    $new_priority = $_REQUEST["new_priority"];
    $where_field = $_REQUEST["where_field"];

    $priorityUpdateSql = "UPDATE $table_name SET $update_field = $new_priority WHERE $where_field=" . intval($id);
    $priorityUpdateResult = mysqli_query($con, $priorityUpdateSql);
    if ($priorityUpdateResult) {
        $return['message'] = 1;
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
