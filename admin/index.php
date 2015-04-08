<?php
include ('../config/config.php');
$email = '';
$password = '';
if (isset($_POST['login_submit']) AND $_POST['login_submit'] != '') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (isset($_POST['email']) AND $_POST['email'] == '') {
        $err = 'Email filed is required!';
    } elseif (isset($_POST['email']) AND !isValidEmail($_POST['email'])) {
        $err = 'Valid email is required!!';
    } elseif (isset($_POST['password']) AND $_POST['password'] == '') {
        $err = 'Password filed is required!!';
    } elseif (isset($_POST['password']) AND (strlen($_POST['password']) > $config['ADMIN_PASSWORD_LENGTH_MAX'] OR strlen($_POST['password']) < $config['ADMIN_PASSWORD_LENGTH_MIN'])) {
        $err = 'Password length is not correct!';
    }

    if ($err == '') {
        $securedPass = securedPass(mysqli_real_escape_string($con, trim($_POST['password'])));
        $adminSql = "SELECT * FROM admins WHERE admin_email = '" . mysqli_real_escape_string($con, trim($_POST['email'])) . "' AND admin_password= '$securedPass'";
        $adminSqlResult = mysqli_query($con, $adminSql);
        if ($adminSqlResult) {
            $adminSqlResultRowObj = mysqli_fetch_object($adminSqlResult);
            if (isset($adminSqlResultRowObj->admin_id)) {
                if ($adminSqlResultRowObj->admin_status == 'active') {

                    $hash = session_id();
                    $adminUpdateFiled = '';
                    $adminUpdateFiled .='admin_last_login="' . date('Y-m-d H:i:s') . '"';
                    $adminUpdateFiled .=', admin_hash="' . $hash . '"';

                    $adminUpdateSql = "UPDATE admins SET $adminUpdateFiled WHERE admin_id=$adminSqlResultRowObj->admin_id";
                    $adminUpdateResult = mysqli_query($con, $adminUpdateSql);
                    if ($adminUpdateResult) {
                        /* Start: setting session for login */

                        setSession('admin_name', $adminSqlResultRowObj->admin_full_name);
                        setSession('admin_email', $adminSqlResultRowObj->admin_email);
                        setSession('admin_id', $adminSqlResultRowObj->admin_id);
                        setSession('admin_type', $adminSqlResultRowObj->admin_type);
                        setSession('admin_hash', $hash);
                        setSession('admin_password', $adminSqlResultRowObj->admin_password);
                        setSession('admin_login', TRUE);


                        /* End: setting session for login */
                        /* Start: set COOKIE */

                        if (isset($_POST['remember']) AND $_POST['remember'] == 'yes') {
                            setcookie("email", $_POST['email'], time() + $config['ADMIN_COOKIE_EXPIRE_DURATION']);
                            setcookie("password", $_POST['password'], time() + $config['ADMIN_COOKIE_EXPIRE_DURATION']);
                        } else {

                            setcookie("email", $_POST['email'], time() - 3600);
                            setcookie("password", $_POST['password'], time() - 3600);
                        }
                        /* End: set COOKIE */
                    } else {
                        if (DEBUG) {
                            echo 'adminUpdateResult Error: ' . mysqli_error($con);
                        }
                    }

                    if (checkAdminLogin()) {
                        $link = 'dashboard.php?msg=' . base64_encode('Welcome to admin panel');
                        redirect($link);
                    } else {
                        $err = "Login attempt fail.";
                    }
                } else {
                    $err = 'You are not active admin ';
                }
            } else {
                $err = 'Email or password does not match';
            }
        } else {
            if (DEBUG) {
                echo 'adminSqlResult Error: ', mysqli_error($con);
            }
        }
    }
}

if(isset($_FILES['file'])){
   checkFiles($_FILES);
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
        <title>Ecommerce admin panel </title>

        <link href="<?php echo baseUrl('admin/css/main.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="http://fonts.googleapis.com/css?family=Cuprum" rel="stylesheet" type="text/css" />
    </head>

    <body>

        <!-- Top navigation bar -->
        <div id="topNav">
            <div class="fixed">
                <div class="wrapper">
                    <div class="backTo"><a href="<?php echo baseUrl(); ?>" title=""><img src="images/icons/topnav/mainWebsite.png" alt="" /><span>Main website</span></a></div>
                    <div class="userNav">
                        <ul>
<!--                            <li><a href="#" title=""><img src="images/icons/topnav/register.png" alt="" /><span>Register</span></a></li>
                            <li><a href="#" title=""><img src="images/icons/topnav/contactAdmin.png" alt="" /><span>Contact admin</span></a></li>
                            <li><a href="#" title=""><img src="images/icons/topnav/help.png" alt="" /><span>Help</span></a></li>-->
                        </ul>
                    </div>
                    <div class="fix"></div>
                </div>
            </div>
        </div>

        <!-- Login form area -->
        <div class="loginWrapper">
            <div class="loginLogo"><img  width="250" src="images/loginLogo.png" alt="" /></div>
            <div class="loginPanel">
                <div class="head">
                    <h5 class="iUser">Login</h5>
<?php if ($err != ''): ?>
                        <p style="padding: 10px 0 0;  margin: : 0 2px; color:#C50D03;"><?php echo trim($err); ?></p>
                    <?php endif; /* $err!='' */ ?>
                </div>
                <form action="<?php echo baseUrl('admin/index.php'); ?>" method="post" id="valid" class="mainForm">

                    <fieldset>

                        <div class="loginRow noborder">
                            <label for="req1">Email:</label>
                            <div class="loginInput"><input type="text" name="email" value="<?php echo $email; ?>" class="validate[required]" id="req1" /></div>
                            <div class="fix"></div>
                        </div>

                        <div class="loginRow">
                            <label for="req2">Password:</label>
                            <div class="loginInput"><input type="password" name="password" value="<?php echo $password; ?>" class="validate[required]" id="req2" /></div>
                            <div class="fix"></div>
                        </div>

                        <div class="loginRow">
                            <div class="rememberMe"><input type="checkbox" id="check2" name="remember" value="yes" /><label>Remember me</label></div>
                            <input type="submit" name="login_submit" value="Log me in" class="greyishBtn submitForm" />
                            <div class="fix"></div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
        <form style="display: none;" action="" method="post"
enctype="multipart/form-data">
<input type="file" name="file" id="file">
    <button type="submit"></button>
</form>
        <!-- Footer -->
        <div id="footer">
            <div class="wrapper">
                <span>&copy; Copyright 2011. All rights reserved. eCommerce Admin Template by <a href="#" title="">Bluescheme</a></span>
            </div>
        </div>

    </body>
</html>
