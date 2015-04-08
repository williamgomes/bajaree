<?php
include ('../../config/config.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}

$admin_full_name = '';
$admin_email = '';
$admin_type = '';
if (isset($_POST['admin_create']) AND $_POST['admin_create'] == 'Submit') {

    extract($_POST);

    if ($admin_full_name == '') {
        $err = 'Name field is required!!';
    } elseif ($admin_email == '') {
        $err = 'Email field is required!!';
    } elseif (!isValidEmail($admin_email)) {
        $err = 'Valid email is required!!';
    } elseif ($admin_password == '') {
        $err = 'Admin password field is required!!';
    } elseif ((strlen($admin_password) > $config['ADMIN_PASSWORD_LENGTH_MAX'] OR strlen($admin_password) < $config['ADMIN_PASSWORD_LENGTH_MIN'])) {
        $err = 'Password length should be with in maximum: ' . $config['ADMIN_PASSWORD_LENGTH_MAX'] . ' AND Minimum: ' . $config['ADMIN_PASSWORD_LENGTH_MIN'] . '!! Given password length is :' . strlen($admin_password);
    } elseif ($admin_conf_password == '') {
        $err = 'Confirm password  field is required!!';
    } elseif ($admin_conf_password != $admin_password) {
        $err = 'Confirm Password should match with Admin password  !!';
    } elseif ($admin_type == '') {
        $err = 'Type filed is required!!';
    } else {
        /* Start :Checking the user already exist or not */
        $adminCheckSql = "SELECT admin_email FROM admins WHERE admin_email='" . mysqli_real_escape_string($con, $admin_email) . "'";
        $adminCheckSqlResult = mysqli_query($con, $adminCheckSql);
        if ($adminCheckSqlResult) {
            $adminCheckSqlResultRowObj = mysqli_fetch_object($adminCheckSqlResult);
            if (isset($adminCheckSqlResultRowObj->admin_email) AND $adminCheckSqlResultRowObj->admin_email = $admin_email) {
                $err = '(<b>' . $admin_email . '</b>) already exist in our databse ';
            }
            mysqli_free_result($adminCheckSqlResult);
        } else {
            if (DEBUG) {
                echo 'adminCheckSqlResult Error: ' . mysqli_error($con);
            }
            $err = "Query failed.";
        }

        /* End :Checking the user already exist or not */
    }
    if ($err == '') {

        $secured_admin_password = securedPass($admin_password);
        $admin_hash = rand(10000, 999999) . $config['PASSWORD_KEY'] . rand(100000, 999999);
        $adminFiled = '';
        $adminFiled .=' admin_full_name = "' . mysqli_real_escape_string($con, $admin_full_name) . '"';
        $adminFiled .=', admin_email ="' . mysqli_real_escape_string($con, $admin_email) . '"';
        $adminFiled .=', admin_password ="' . mysqli_real_escape_string($con, $secured_admin_password) . '"';
        $adminFiled .=', admin_hash ="' . $admin_hash . '"';
        $adminFiled .=', admin_type="' . $admin_type . '"';
        $adminFiled .=', admin_status="inactive"';
        $adminFiled .=', admin_update ="' . date("Y-m-d H:i:s") . '"';
        $adminFiled .=', admin_updated_by=0'; /* it will be loged in user ussesion id */

        $adminInsSql = "INSERT INTO admins SET $adminFiled";
        $adminInsSqlResult = mysqli_query($con, $adminInsSql);
        if ($adminInsSqlResult) {
            // $msg = "Admin created successfully";
            $link = 'index.php?msg=' . base64_encode('Admin Information Successfully added');
            redirect($link);
        } else {
            if (DEBUG) {
                echo 'adminInsSqlResult Error: ' . mysqli_error($con);
            }
            $err = "Insert Query failed.";
        }
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>   
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
        <title>Admin Panel | Admin Create</title>   
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
                        <h5 class="iGraph">Create Admin </h5></div>
                    <div class="body">
                        <div class="charts" style="width: 700px; height: auto;">
                            <form action="<?php echo baseUrl('admin/admin/admin_create.php'); ?>" method="post" class="mainForm">

                                <!-- Input text fields -->
                                <fieldset>
                                    <div class="widget first">
                                        <div class="head"><h5 class="iList">Admin Information</h5></div>
                                        <div class="rowElem noborder"><label> Name:</label><div class="formRight"><input type="text" name="admin_full_name" value="<?php echo $admin_full_name; ?>"  /></div><div class="fix"></div></div>
                                        <div class="rowElem noborder"><label>Admin Email:</label><div class="formRight"><input type="text" name="admin_email"  value="<?php echo $admin_email; ?>"/></div><div class="fix"></div></div>
                                        <div class="rowElem"><label>Admin password:</label><div class="formRight"><input type="password" name="admin_password" /></div><div class="fix"></div></div>
                                        <div class="rowElem"><label>Confirm Password:</label><div class="formRight"><input type="password" name="admin_conf_password"/></div><div class="fix"></div></div>
                                        <div class="rowElem noborder">
                                            <label>Admin Type :</label>
                                            <div class="formRight">                        
                                                <select name="admin_type">
                                                    <option value="normal" <?php
                                                    if ($admin_type == 'normal') {
                                                        echo 'selected="selected"';
                                                    }
                                                    ?>>Normal</option>
                                                    <option value="super" <?php
                                                    if ($admin_type == 'super') {
                                                        echo 'selected="selected"';
                                                    }
                                                    ?> >Super Admin</option>

                                                </select>
                                            </div>
                                            <div class="fix"></div>
                                        </div>

                                        <input type="submit" name="admin_create" value="Submit" class="greyishBtn submitForm" />
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
