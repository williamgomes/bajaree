<?php
include ('../../config/config.php');
if (isset($_POST["id"])) {
    $id = $_POST["id"];
}
if (isset($_POST["new_priority"])) {
    $new_priority = $_POST["new_priority"];
}
if(isset($_POST["table_name"])) {
    $table_name = $_POST["table_name"];
}
if(isset($_POST["update_field"])) {
    $update_field = $_POST["update_field"];
}
if(isset($_POST["where_condition"])) {
    $where_condition = $_POST["where_condition"];
}
if (isset($id) && isset($new_priority)) {
    $priorityUpdateSql = "UPDATE $table_name SET $update_field = $new_priority WHERE $where_condition";
    $priorityUpdateResult = mysqli_query($con, $priorityUpdateSql);
    if ($priorityUpdateResult) {
        $err = 0; //No error
    } else {
        if (DEBUG) {
            $err = "updateRowResult error" . mysqli_error($con); //Mysql query failed
        } else {
            $err = 1; //Mysql query failed
        }
    }
    print $err;
}
?>
