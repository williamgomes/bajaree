<?php
include 'config/config.php';

$CartID = '';
$username = '';
$userID = 0;


if(!checkUserLogin()){
  $err = "You need to login first.";
  $link = baseUrl() . 'index.php?err=' . base64_encode($err);
  redirect($link);
} else {
  $userID = getSession('UserID');
  
}

$page_title = get_option('SITE_DEFAULT_META_TITLE');
$page_description = get_option('SITE_DEFAULT_META_DESCRIPTION');
$page_keywords = get_option('SITE_DEFAULT_META_KEYWORDS');
$site_author = $config['CONFIG_SETTINGS']['SITE_AUTHOR'];


$firstName = '';
$lastName = '';
$email = '';
$gender = '';
$dob = '';

//getting all user information from database
$sqlGetUser = "SELECT * FROM users WHERE user_id=$userID";
$executeGetUser = mysqli_query($con,$sqlGetUser);
if($executeGetUser){
  $executeGetUserObj = mysqli_fetch_object($executeGetUser);
  if(isset($executeGetUserObj->user_id)){
    $firstName = $executeGetUserObj->user_first_name;
    $lastName = $executeGetUserObj->user_last_name;
    $email = $executeGetUserObj->user_email;
    $gender = $executeGetUserObj->user_gender;
    $dob = $executeGetUserObj->user_DOB;
  }
} else {
  if(DEBUG){
    echo "executeGetUser error: " . mysqli_error($con);
  } else {
    echo "executeGetUser query failed.";
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

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

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
      
      <div class="row">
      <div class="col-md-12"><h2 class="reviewHeadingBig"> <span class="glyphicon glyphicon-user"></span> My Account</h2> </div>
      
      <div class="col-md-3 col-sm-4 col-xs-12">
             <div class="accountMenu doequel equalheight">
       <ul class="nav nav-pills nav-stacked">
      <li class="active"><a href="<?php echo baseUrl(); ?>my-account">Account</a></li>
      <li><a href="<?php echo baseUrl(); ?>my-address-list">Address</a></li>
      <li><a href="<?php echo baseUrl(); ?>my-orders">Order history</a></li>
      
     
    </ul>
            </div>
      </div>
      
        <div class="col-md-9 col-sm-8 col-xs-12">
             <div class="accountContent doequel equalheight">
             <h3> Basic Information</h3>
             
             <form class="form-horizontal" role="form">
  <div class="form-group">
    <label class="col-sm-2 control-label">Name</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $firstName . " " . $lastName; ?></p>
    </div>
  </div>
  
  <div class="form-group">
    <label class="col-sm-2 control-label">Email</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $email; ?></p>
    </div>
  </div>
  
  <div class="form-group">
    <label class="col-sm-2 control-label">Gender</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $gender; ?></p>
    </div>
  </div>
  
  
  <div class="form-group">
    <label class="col-sm-2 control-label">Date of Birth</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo date("d M, Y", strtotime($dob)); ?></p>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label"></label>
    <div class="col-sm-10">
   
  	<a href="<?php echo baseUrl(); ?>edit-my-account" class="btn btn-default btn-primary pull-right"><i class="fa fa-edit"></i> Edit Profile</a>
   <a href="<?php echo baseUrl(); ?>update-password" style="margin-right:5px;" class="btn btn-default btn-primary pull-right"><i class="fa fa-edit"></i> Change Password</a>
    </div>
  </div>
  
</form>
                     
    			</div>
            </div>
            
            
      </div>

    </div><!-- /.container -->
    
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


