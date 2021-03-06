<?php
include 'config/config.php';

$Email = '';
$Hash = '';
$pass1 = '';
$pass2 = '';

$page_title = get_option('SITE_DEFAULT_META_TITLE');
$page_description = get_option('SITE_DEFAULT_META_DESCRIPTION');
$page_keywords = get_option('SITE_DEFAULT_META_KEYWORDS');
$site_author = $config['CONFIG_SETTINGS']['SITE_AUTHOR'];
  $session = session_id();

if (isset($_GET['ac']) AND isset($_GET['e']) AND isset($_GET['h'])) {
    $Email = base64_decode($_GET['e']);
    $Hash = base64_decode($_GET['h']);

    $countUser = 0;
    $sqlRequest = "SELECT * FROM users WHERE user_email='$Email' AND user_hash='$Hash'";
    $executeRequest = mysqli_query($con, $sqlRequest);
    if ($executeRequest) {
        $countUser = mysqli_num_rows($executeRequest);
        if ($countUser <= 0) {
            $err = "This link already changed please send password retrieve link again.";
            $link = baseUrl() . 'forgot-my-password?err=' . base64_encode($err);
            redirect($link);
        }

        if ($countUser > 0) {
          
           // $verification_updateSql = "UPDATE users SET user_hash='" . $session . "',user_verification='yes' WHERE user_email='" . $Email . "'";
            $verification_updateSql = "UPDATE users SET user_verification='yes' WHERE user_email='" . $Email . "'";
            $verification_updateSqlResult = mysqli_query($con, $verification_updateSql);
            if ($verification_updateSqlResult) {
                //updatd 
            } else {
                if (DEBUG) {
                    $err = "verification_updateSqlResult error: " . mysqli_error($con);
                } else {
                    $err = "verification_updateSqlResult query failed.";
                }
            }
        }
    } else {
        if (DEBUG) {
            $err = "executeRequest error: " . mysqli_error($con);
        } else {
            $err = "executeRequest query failed.";
        }
        $link = baseUrl() . 'index?err=' . base64_encode($err);
        redirect($link);
    }
} else {
    $err = "Invalid request.";
    $link = baseUrl() . 'index?err=' . base64_encode($err);
    redirect($link);
}



//updating password
if (isset($_POST['change'])) {
    extract($_POST);

    if ($pass1 == '') {
        $err = "New Password is required.";
    } elseif ($pass2 == '') {
        $err = "Password Confirm is required";
    } elseif ($pass1 != $pass2) {
        $err = "Password Confirm didn't match with Password.";
    } else {

        $securePassword = securedPass($pass1);

        $updateUser = '';
        $updateUser .=' user_password = "' . mysqli_real_escape_string($con, $securePassword) . '"';


        $sqlUpdateUser = "UPDATE users SET $updateUser WHERE user_email='$Email'";
        $executeUpdateUser = mysqli_query($con, $sqlUpdateUser);
        if ($executeUpdateUser) {
            $msg = "Your password updated successfully.";
            $link = baseUrl() . 'index?msg=' . base64_encode($msg);
            redirect($link);
        } else {
            if (DEBUG) {
                echo "executeUpdateUser error: " . mysqli_errno($con);
            } else {
                echo "executeUpdateUser query failed.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $page_title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php echo $page_description; ?>">
        <meta name="keywords" content="<?php echo $page_keywords; ?>">
        <meta name="author" content="<?php echo $site_author; ?>">

        <?php include basePath('header_script.php'); ?>



    </head>

    <body>
        <div id="wrapper">

            <div id="wrapper">
                <div id="header">
                    <div class="navbar navbar-default navbar-fixed-top megamenu">
                        <div class="container-full">
                            <?php include basePath('headertop.php'); ?>
                            <!--/.headertop -->
                            <?php include basePath('header_mid.php'); ?>
                            <!--/.headerBar -->

                            <?php include basePath('header_menu.php'); ?>
                            <!--/.menubar --> 
                        </div>
                    </div>

                </div>
                <!-- header end -->

                <div class="w100 mainContainer">




                    <div class="container">


                        <div class="row" style="padding-top:10px;">
                            <?php include basePath('alert.php'); ?>
                        </div>

                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 main-column userRegistration">
                            <div id="content"> 
                                <h1>Change Password</h1>
                                <form enctype="multipart/form-data" method="post" action="<?php echo baseUrl(); ?>change-password?<?php echo $_SERVER['QUERY_STRING']; ?>">
                                 
                                    <div class="content">
                                        <table class="form">
                                            <tbody><tr>
                                                    <td><span class="required">*</span> New Password:</td>
                                                    <td><input type="password" value="<?php echo $pass1; ?>" name="pass1" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span class="required">*</span> Confirm Password:</td>
                                                    <td><input type="password" value="<?php echo $pass2; ?>" name="pass2" class="form-control">
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                    </div>
                                    <div class="buttons">
                                        <div class="left"><a href="<?php echo baseUrl(); ?>" class="btn btn-default pull-left"><i class="fa fa-arrow-circle-left"></i>  Cancel</a></div>
                                        <div class="right"><button name="change" class="btn btn-site pull-right"> <i class="fa fa-check"></i> Change </button></div>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <aside class="col-lg-3 col-md-3 col-sm-12 col-xs-12 offcanvas-sidebar" id="oc-column-right">	
                            <div class="sidebar" id="column-right">
                                <div class="box">
                                    <div class="box-heading"><span>Account</span></div>
                                    <div class="box-content">
                                        <ul class="list">
                                            <li><a href="?route=account/login">Login</a> </li> 
                                            <li><a href="?route=account/register">Register</a></li>
                                            <li><a href="?route=account/forgotten">Forgotten Password</a></li>
                                            <li><a href="?route=account/account">My Account</a></li>
                                            <li><a href="?route=account/address">Address Books</a></li>
                                            <li><a href="?route=account/wishlist">Wish List</a></li>
                                            <li><a href="?route=account/order">Order History</a></li>
                                            <li><a href="?route=account/download">Downloads</a></li>
                                            <li><a href="?route=account/return">Returns</a></li>
                                            <li><a href="?route=account/transaction">Transactions</a></li>
                                            <li><a href="?route=account/newsletter">Newsletter</a></li>

                                            <li><a href="?route=account/recurring">Recurring payments</a></li>


                                        </ul>
                                    </div>
                                </div>
                            </div></aside>

                    </div>



                    <!--brandFeatured-->

                </div>
                <!-- Main hero unit -->

                <?php include basePath('footer.php'); ?>

            </div>
            <!-- /container --> 

            <?php include basePath('mini_login.php'); ?>
            <?php include basePath('mini_signup.php'); ?>
            <?php include basePath('mini_cart.php'); ?>

            <?php include basePath('footer_script.php'); ?>

    </body>
</html>
