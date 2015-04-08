<?php
include 'config/config.php';
$userID = 0;
$username = '';
$firstname = '';
$middlename = '';
$lastname = '';
$email = '';
$phone = '';
$dateofbirth = '';
$gender = '';

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


//getting all user information from database
$sqlGetUser = "SELECT * FROM users WHERE user_id=$userID";
$executeGetUser = mysqli_query($con,$sqlGetUser);
if($executeGetUser){
  $executeGetUserObj = mysqli_fetch_object($executeGetUser);
  if(isset($executeGetUserObj->user_id)){
    $firstname = $executeGetUserObj->user_first_name;
    $middlename = $executeGetUserObj->user_middle_name;
    $lastname = $executeGetUserObj->user_last_name;
    $email = $executeGetUserObj->user_email;
    $phone = $executeGetUserObj->user_phone;
    $gender = $executeGetUserObj->user_gender;
    if($executeGetUserObj->user_DOB == '0000-00-00'){
     $day = date('d');
     $month = date('m');
     $year = date('Y');
    } else {
     $day = date('d',  strtotime($executeGetUserObj->user_DOB));
     $month = date('m',  strtotime($executeGetUserObj->user_DOB));
     $year = date('Y',  strtotime($executeGetUserObj->user_DOB));
     //$dateofbirth = $executeGetUserObj->user_DOB;
    }
  }
} else {
  if(DEBUG){
    echo "executeGetUser error: " . mysqli_error($con);
  } else {
    echo "executeGetUser query failed.";
  }
}



//updating information
if(isset($_POST['update'])){
  extract($_POST);
  
  if($firstname == ''){
    $err = "First Name is required.";
  } elseif($lastname == ''){
    $err = "Last Name is required.";
  } elseif($email == ''){
    $err = "Email is required.";
  } elseif($phone == ''){
    $err = "Phone is required.";
  } else {
    
    //creating date from given values
    $dateofbirth = $year . '-' . $month . '-' . $day;
    
    $updateUser = '';
    $updateUser .=' user_email = "' . mysqli_real_escape_string($con, $email) . '"';
    $updateUser .=', user_first_name ="' . mysqli_real_escape_string($con, $firstname) . '"';
    $updateUser .=', user_last_name ="' . mysqli_real_escape_string($con, $lastname) . '"';
    $updateUser .=', user_DOB ="' . mysqli_real_escape_string($con, $dateofbirth) . '"';
    $updateUser .=', user_gender ="' . mysqli_real_escape_string($con, $gender) . '"';
    $updateUser .=', user_phone ="' . mysqli_real_escape_string($con, $phone) . '"';
    
    $sqlUpdateUser = "UPDATE users SET $updateUser WHERE user_id=$userID";
    $executeUpdateUser = mysqli_query($con,$sqlUpdateUser);
    if($executeUpdateUser){
      //updating session variables
      setSession('Email', $email);
      setSession('UserFirstName', $firstname);
      
      $msg = "Your information updated successfully.";
      $link = baseUrl() . 'account?msg=' . base64_encode($msg);
      redirect($link);
    } else {
      if(DEBUG){
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
             <h3>Edit Personal Details</h3>
             
             <form action="<?php echo baseUrl(); ?>edit-my-account" method="post" enctype="multipart/form-data">
    <div class="content">
      
      
      
      <table class="form">
        <tbody>
          
          <tr>
            <td><span class="required">*</span> First Name:</td>
            <td><input type="text" class="form-control" name="firstname" value="<?php echo $firstname; ?>" required="required">
            </td>
          </tr>
          
          <tr>
            <td><span class="required">*</span> Last Name:</td>
            <td><input type="text" class="form-control" name="lastname" value="<?php echo $lastname; ?>" required="required">
            </td>
          </tr>
          <tr>
            <td><span class="required">*</span> Email:</td>
            <td><input type="text" class="form-control" name="email" value="<?php echo $email; ?>" required="required">
            </td>
          </tr>
          <tr>
            <td><span class="required">*</span> Phone:</td>
            <td><input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>" required="required">
            </td>
          </tr>
          
          <tr>
            <td> Date of Birth:</td>
            <td>
              <select name="day" class="form-control" style="width:70px !important; float: left !important; margin-right: 10px !important;">
                <option value="">DD</option>
                <?php for($x = 1; $x <= 31; $x++): 
                  $date = str_pad($x, 2, "0", STR_PAD_LEFT); //adding 0 before day if day contains one digit ?>
                <option value="<?php echo $date; ?>" <?php if($day == $date){ echo "selected"; } ?>><?php echo str_pad($x, 2, "0", STR_PAD_LEFT); ?></option>
                <?php endfor; //($x = 1; $x <= 31; $x++): ?>
              </select>
              
              <select name="month" class="form-control" style="width:75px !important; float: left !important; margin-right: 10px !important;">
                <option value="">MM</option>
                <?php for($y = 1; $y <= 12; $y++): 
                  $mnth = str_pad($y, 2, "0", STR_PAD_LEFT); //adding 0 before month if day contains one digit?>
                <option value="<?php echo $mnth; ?>" <?php if($month == $mnth){ echo "selected"; } ?>><?php echo str_pad($y, 2, "0", STR_PAD_LEFT); ?></option>
                <?php endfor; //($y = 1; $y <= 31; $y++): ?>
              </select>
              
              <select name="year" class="form-control" style="width:100px !important; float: left !important; margin-right: 10px !important;">
                <option value="">YYYY</option>
                <?php 
                $curYear = date("Y");
                $startYear = $curYear - 70;
                ?>
                <?php for($z = $curYear; $z >= $startYear; $z--): ?>
                <option value="<?php echo $z; ?>" <?php if($year == $z){ echo "selected"; } ?>><?php echo $z; ?></option>
                <?php endfor; //($y = 1; $y <= 31; $y++): ?>
              </select>
<!--              <input type="text" value="<?php echo $dateofbirth; ?>" readonly="" name="dateofbirth" class="form-control" id="edit_date">
              <span class="add-on"><i class="icon-calendar"></i></span>-->
            </td>
          </tr>
          <tr>
            <td> Gender:</td>
            <td>
              <div class="controls">
                  <label class="radio inline">
                      <input type="radio" class="radio_buttons optional" id="Post_content_type_blog" value="Male" name="gender" <?php if($gender == 'Male'){ echo "checked"; } ?>>
                      <sapn style="font-weight: normal;"> Male</sapn>
                  </label>
                  <label class="radio inline">
                      <input type="radio" class="radio_buttons optional" id="Post_content_type_editorial" value="Female" name="gender" <?php if($gender == 'Female'){ echo "checked"; } ?>>
                      <sapn style="font-weight: normal;">Female </sapn>  
                  </label>

              </div>
            </td>
          </tr>
          
      </tbody></table>
    </div>
    <div class="buttons">
      <div class="left"><a href="<?php echo baseUrl(); ?>/my-account" class="btn btn-default pull-left"><i class="fa fa-arrow-circle-left"></i>  Back</a></div>
    <div class="right"><button class="btn btn-site pull-right" name="update"> <i class="fa fa-check"></i> Update </button></div>
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