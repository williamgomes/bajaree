<?php
include 'config/config.php';
include ('./lib/email/mail_helper_functions.php');

$CartID = '';
$username = '';
$userID = 0;
$email = '';


$page_title = get_option('SITE_DEFAULT_META_TITLE');
$page_description = get_option('SITE_DEFAULT_META_DESCRIPTION');
$page_keywords = get_option('SITE_DEFAULT_META_KEYWORDS');
$site_author = $config['CONFIG_SETTINGS']['SITE_AUTHOR'];


if(isset($_POST['submit'])){
  extract($_POST);
  
  if($email == ''){
    $err = "Email is required.";
  } else {
    $emailCount = 0;
    $sqlCheck = "SELECT * FROM users WHERE user_email='$email'";
    $executeCheck = mysqli_query($con, $sqlCheck);
    if ($executeCheck) {
      $emailCount = mysqli_num_rows($executeCheck);
      if ($emailCount > 0) {
        //sending email to user
        $Subject = "Forgot password request";
        $EmailBody = file_get_contents(baseUrl('emails/forgot-pass/forgot.pass.php?email=' . $email));
        $sendEmailToApplicant = sendEmailFunction($email,$email,'no-reply@bajaree.com',$Subject,$EmailBody);
          
        $msg = "Please check your inbox. An email has been sent with further instructions.";
      } else {
        $err = "Email did not match.";
      }
    } else {
      if(DEBUG){
        $err = "executeCheck error: " . mysqli_error($con);
      } else {
        $err = "executeCheck query failed.";
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

  <form enctype="multipart/form-data" method="post" action="<?php echo baseUrl(); ?>forgot-my-password">
    <h2>Submit email to retrieve password</h2>
    <div class="content">
      <div class="form-inline row" role="form">
        <div class="form-group col-sm-4">
          <label class="sr-only" for="exampleInputEmail2">Email address</label>
          <input type="text" placeholder="Enter email" class="form-control" name="email" value="">
        </div>
        <div class="form-group col-sm-4">
          <button name="submit" type="submit" class="btn btn-site pull-left"> <i class="fa fa-check"></i> Submit </button>
        </div>
        <div class="checkbox">
        </div>
      </div>
    </div>
  </form>
    
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
