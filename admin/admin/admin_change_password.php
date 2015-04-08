<?php
include ('../../config/config.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}

$old_password = '';
$password = '';
$conf_password = '';
if (isset($_POST['change_submit']) AND $_POST['change_submit'] == 'Submit') {

    extract($_POST);

    if ($old_password == '') {
        $err = "Old password is required.";
    } elseif ((strlen($old_password) > $config['ADMIN_PASSWORD_LENGTH_MAX'] OR strlen($old_password) < $config['ADMIN_PASSWORD_LENGTH_MIN'])) {
        $err = 'Old password length should be with in maximum: ' . $config['ADMIN_PASSWORD_LENGTH_MAX'] . ' AND Minimum: ' . $config['ADMIN_PASSWORD_LENGTH_MIN'] . '!! Given password length is :' . strlen($old_password);
    } else if (securedPass($old_password) != getSession('admin_password')) {
        $err = "Old password does not match.";
    } else if ($password == '') {
        $err = "New password is required.";
    } elseif ((strlen($password) > $config['ADMIN_PASSWORD_LENGTH_MAX'] OR strlen($password) < $config['ADMIN_PASSWORD_LENGTH_MIN'])) {
        $err = 'New password length should be with in maximum: ' . $config['ADMIN_PASSWORD_LENGTH_MAX'] . ' AND Minimum: ' . $config['ADMIN_PASSWORD_LENGTH_MIN'] . '!! Given password length is :' . strlen($password);
    } else if ($conf_password == '') {
        $err = "Confirm new password is required.";
    } else if ($password != $conf_password) {
        $err = "Password dose not match.";
    }
    if (!$err) {

        $adminFiled = '';
        $adminFiled .=' admin_password ="' . mysqli_real_escape_string($con, securedPass($password)) . '"';
        $adminUpdateSql = "UPDATE admins SET $adminFiled WHERE admin_email = '" . mysqli_real_escape_string($con, getSession('admin_email')) . "' AND 
		admin_id = " . intval(getSession('admin_id'));
        $adminUpdateSqlResult = mysqli_query($con, $adminUpdateSql);
        if ($adminUpdateSqlResult) {
            if (AdminLogout()) {
                $link = baseUrl('admin/index.php?msg=' . base64_encode('Password Updated successfully'));
                redirect($link);
            }
            $msg = "Password Updated successfully";
        } else {
            if (DEBUG) {
                echo 'adminUpdateSql Error: ' . mysqli_error($con);
            }
        }
    }
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>   
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
        <title>Admin Panel | Change Password</title>   
        <link href="<?php echo baseUrl('admin/css/main.css'); ?>" rel="stylesheet" type="text/css" /> 
        <script src="<?php echo baseUrl('admin/js/jquery.min.js'); ?>" type="text/javascript"></script>  
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
            <?php include ('admin_left_navigation.php'); ?>

            <!-- Content Start -->
            <div class="content">
                <div class="title"><h5>Admin Module</h5></div>

                <!-- Notification messages -->
                <?php include basePath('admin/message.php'); ?>
                <!-- Charts -->
                <div class="widget first">
                    <div class="head">
                        <h5 class="iGraph">Change Admin Password </h5></div>
                    <div class="body">
                        <div class="charts" style="width: 700px; height: auto;">
                            <form action="<?php echo baseUrl('admin/admin/admin_change_password.php'); ?>" method="post" class="mainForm">

                                <!-- Input text fields -->
                                <fieldset>
                                    <div class="widget first">
                                        <div class="head"><h5 class="iList">Admin Information</h5></div>

                                        <div class="rowElem noborder"><label>Admin Email:</label><div class="formRight"><input type="text" readonly="readonly" name="admin_email"  value="<?php echo getSession('admin_email'); ?>"/></div><div class="fix"></div></div>
                                        <div class="rowElem"><label>Old password:</label><div class="formRight"><input type="password" name="old_password" /></div><div class="fix"></div></div>
                                        <div class="rowElem noborder"><label>New password:</label><div class="formRight"><input type="password" name="password"  value=""/></div><div class="fix"></div></div>
                                        <div class="rowElem noborder"><label>Confirm password:</label><div class="formRight"><input type="password" name="conf_password"  value=""/></div><div class="fix"></div></div>


                                        <input type="submit" name="change_submit" value="Submit" class="greyishBtn submitForm" />
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
