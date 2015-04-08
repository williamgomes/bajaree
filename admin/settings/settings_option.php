<?php
include ('../../config/config.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}
$option_name = '';
$option_name_delete = '';
$option_value = '';
if (isset($_POST['insert'])) {
    extract($_POST);
    if ($option_name == "") {
        $err = "Option Name filed is required.";
    } elseif (!checkOptionName($option_name)) {
        $err = "Option Name should contain only upper case letters [A-Z] and or underscores(_).";
    } elseif ($option_value == "") {
        $err = "Option Value filed is required.";
    } else {
        $optionNameCheckSql = "SELECT * FROM config_settings WHERE CS_option='$option_name'";
        $optionNameCheckResult = mysqli_query($con, $optionNameCheckSql);
        if ($optionNameCheckResult) {
            $optionNameCheckResultRowOObj = mysqli_fetch_object($optionNameCheckResult);
            if (isset($optionNameCheckResultRowOObj->CS_option) && $optionNameCheckResultRowOObj->CS_option == "$option_name") {
                $err = "Option Name<b> $option_name </b>Already Exist.";
            }
        } else {
            if (DEBUG) {
                echo 'optionCheckSqlResult Error: ' . mysqli_error($con);
            }
            $err = "Query failed.";
        }
    }
    if ($err == "") {
        $optionField = '';
        $optionField .= ' CS_option = "' . mysqli_real_escape_string($con, $option_name) . '"';
        $optionField .= ' ,CS_value = "' . mysqli_real_escape_string($con, $option_value) . '"';
        //$optionField .= 'CS_update_date = "' . mysqli_real_escape_string($con, $date) . '"';
        $optionField .= ' ,CS_updated_by = "' . mysqli_real_escape_string($con, getSession('admin_id')) . '"';
        $optionFieldInsSql = "INSERT INTO config_settings SET $optionField";
        $optionFieldInsResult = mysqli_query($con, $optionFieldInsSql);

        if ($optionFieldInsResult) {
            $msg = "Option Inserted successfully";
            //echo "<meta http-equiv='refresh' content='5; url=index.php'>";
        } else {
            if (DEBUG) {
                echo 'option Insert Error' . mysqli_error($con);
            }
        }
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>   
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
        <title>Admin Panel | Option Create</title>   
        <link href="<?php echo baseUrl('admin/css/main.css'); ?>" rel="stylesheet" type="text/css" /> 
        <script src="<?php echo baseUrl('admin/js/jquery.min.js'); ?>" type="text/javascript"></script>  
        <!--tree view -->  
        <script src="<?php echo baseUrl('admin/js/treeViewJquery.min.js'); ?>"></script> 
        <script src ="<?php echo baseUrl('admin/js/jquery-1.4.4.js'); ?>" type = "text / javascript" ></script>   
        <!--tree view --> 
        <!--Start admin panel js/css --> 
        <?php include basePath('admin/header.php'); ?>   
        <!--End admin panel js/css -->               

    </head>

    <body>

        <?php include basePath('admin/top_navigation.php'); ?>

        <?php include basePath('admin/module_link.php'); ?>


        <!-- Content wrapper -->
        <div class="wrapper">

            <!-- Left navigation -->
            <?php include basePath('admin/settings/settings_left_navigation.php'); ?>

            <!-- Content Start -->
            <div class="content">
                <div class="title"><h5>Settings Module</h5></div>

                <!-- Notification messages -->
                <?php include basePath('admin/message.php'); ?>

                <!-- Charts -->
                <div class="widget first">
                    <div class="head">
                        <h5 class="iGraph">Website Settings</h5></div>
                    <div class="body">
                        <div class="charts" style="width: 700px; height: auto;">
                            <form action="<?php echo baseUrl('admin/settings/settings_option.php'); ?>" method="post" class="mainForm" enctype="multipart/form-data">

                                <!-- Input text fields -->
                                <fieldset>
                                    <div class="widget first">
                                        <div class="head"><h5 class="iList">Option Insertion</h5></div>
                                        <div class="rowElem noborder"><label>Option Name (<span class="requiredSpan">*</span>):</label><div class="formRight"><input name="option_name" type="text" value="<?php echo $option_name; ?>"/></div><div class="fix"></div></div>
                                        <div class="rowElem noborder"><label>Option Value (<span class="requiredSpan">*</span>):</label><div class="formRight"><input name="option_value" type="text" value="<?php echo $option_value; ?>"/></div><div class="fix"></div></div>
                                        <input type="submit" name="insert" value="Insert Option" class="greyishBtn submitForm" />
                                        <div class="fix"></div>
                                    </div>
                                </fieldset>
                            </form>		
                        </div>
                    </div>
                </div>


            </div>
            <!-- Content End -->

            <div class="fix"></div>
        </div>

        <?php include basePath('admin/footer.php'); ?>
