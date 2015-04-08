<?php
include 'config/config.php';

$CartID = '';
$username = '';
$userID = 0;
$pass1 = '';
$pass2 = '';
$editID = 0;
$redirectType = '';

if(isset($_GET['type']) AND $_GET['type'] != ""){
  $redirectType = mysqli_real_escape_string($con,$_GET['type']);
}

if(!checkUserLogin()){
  $err = "You need to login first.";
  $link = baseUrl() . 'index.php?err=' . base64_encode($err);
  redirect($link);
} else {
  $userID = getSession('UserID');
}

if(isset($_GET['edit_id'])){
  $editID = mysqli_real_escape_string($con,$_GET['edit_id']);
} else {
  $err = "Wrong parameter.";
  $link = baseUrl() . 'my-address-list?err=' . base64_encode($err);
  redirect($link);
}

$page_title = get_option('SITE_DEFAULT_META_TITLE');
$page_description = get_option('SITE_DEFAULT_META_DESCRIPTION');
$page_keywords = get_option('SITE_DEFAULT_META_KEYWORDS');
$site_author = $config['CONFIG_SETTINGS']['SITE_AUTHOR'];


$title = '';
$firstname = '';
$middlename = '';
$lastname = '';
$phone = '';
$address = '';
$zip = '';
$area = '';

//getting address info from database
if($editID > 0){
  $sqlGetAddress = "SELECT * FROM user_addresses WHERE UA_id=$editID";
  $executeGetAddress = mysqli_query($con,$sqlGetAddress);
  if($executeGetAddress){
    $executeGetAddressObj = mysqli_fetch_object($executeGetAddress);
    if(isset($executeGetAddressObj->UA_id)){
      $title = $executeGetAddressObj->UA_title;
      $firstname = $executeGetAddressObj->UA_first_name;
      $middlename = $executeGetAddressObj->UA_middle_name;
      $lastname = $executeGetAddressObj->UA_last_name;
      $phone = $executeGetAddressObj->UA_phone;
      $address = $executeGetAddressObj->UA_address;
      $zip = $executeGetAddressObj->UA_zip;
      $area = $executeGetAddressObj->UA_area_id;
    }
  } else {
    
  }
}

//getting area information from database
$arrayArea = array();
$default_city_id = 1;
$sqlArea = "SELECT * FROM areas WHERE  area_status='allow' AND  area_city_id=$default_city_id";
$executeArea = mysqli_query($con,$sqlArea);
if($executeArea){
  while($executeAreaObj = mysqli_fetch_object($executeArea)){
    $arrayArea[] = $executeAreaObj;
  }
} else {
  if(DEBUG){
    echo "executeArea error: " . mysqli_error($con);
  } else {
    echo "executeArea query failed.";
  }
}


//saving address info into database
if(isset($_POST['update'])){
  extract($_POST);
  
  if($title == ''){
    $err = "Address Name is required.";
  } elseif($phone == ''){
    $err = "Phone No. is required.";
  } elseif($address == ''){
    $err = "Address is required.";
  }  elseif($area == ''){
    $err = "Area is required.";
  } else {
    
    //checking if user is editing an existing address or adding new one
    if($editID > 0){
      $updateAddress = '';
      $updateAddress .=' UA_title ="' . mysqli_real_escape_string($con, $title) . '"';
      $updateAddress .=', UA_first_name ="' . mysqli_real_escape_string($con, $firstname) . '"';
      $updateAddress .=', UA_middle_name ="' . mysqli_real_escape_string($con, $middlename) . '"';
      $updateAddress .=', UA_last_name ="' . mysqli_real_escape_string($con, $lastname) . '"';
      $updateAddress .=', UA_phone ="' . mysqli_real_escape_string($con, $phone) . '"';
      $updateAddress .=', UA_country_id ="' . mysqli_real_escape_string($con, $country) . '"';
      $updateAddress .=', UA_city_id ="' . mysqli_real_escape_string($con, $city) . '"';
      $updateAddress .=', UA_area_id ="' . mysqli_real_escape_string($con, $area) . '"';
      $updateAddress .=', UA_zip ="' . mysqli_real_escape_string($con, $zip) . '"';
      $updateAddress .=', UA_address ="' . mysqli_real_escape_string($con, $address) . '"';
      
      $sqlUpdateAddress = "UPDATE user_addresses SET $updateAddress WHERE UA_id=$editID";
      $executeUpdateAddress = mysqli_query($con,$sqlUpdateAddress);
      if($executeUpdateAddress){
        if($redirectType == "checkout"){
          $msg = "Your address updated successfully.";
          $link = baseUrl() . "checkout-step-1?msg=" . base64_encode($msg);
          redirect($link);
        } else {
          $msg = "Your address updated successfully.";
          $link = baseUrl() . "my-address-list?msg=" . base64_encode($msg);
          redirect($link);
        }
      } else {
        if(DEBUG){
          $err = "executeUpdateAddress error: " . mysqli_error($con);
        } else {
          $err = "executeUpdateAddress query failed.";
        }
      }
    } else {
      $addAddress = '';
      $addAddress .=' UA_user_id = "' . mysqli_real_escape_string($con, $userID) . '"';
      $addAddress .=', UA_title ="' . mysqli_real_escape_string($con, $title) . '"';
      $addAddress .=', UA_first_name ="' . mysqli_real_escape_string($con, $firstname) . '"';
      $addAddress .=', UA_middle_name ="' . mysqli_real_escape_string($con, $middlename) . '"';
      $addAddress .=', UA_last_name ="' . mysqli_real_escape_string($con, $lastname) . '"';
      $addAddress .=', UA_phone ="' . mysqli_real_escape_string($con, $phone) . '"';
      $addAddress .=', UA_country_id ="' . mysqli_real_escape_string($con, $country) . '"';
      $addAddress .=', UA_city_id ="' . mysqli_real_escape_string($con, $city) . '"';
      $addAddress .=', UA_area_id ="' . mysqli_real_escape_string($con, $area) . '"';
      $addAddress .=', UA_zip ="' . mysqli_real_escape_string($con, $zip) . '"';
      $addAddress .=', UA_address ="' . mysqli_real_escape_string($con, $address) . '"';
      
      $sqlAddAddress = "INSERT INTO user_addresses SET $addAddress";
      $executeAddAddress = mysqli_query($con,$sqlAddAddress);
      if($executeAddAddress){
        $msg = "Your address added successfully.";
        $link = baseUrl() . "my-address-list?msg=" . base64_encode($msg);
        redirect($link);
      } else {
        if(DEBUG){
          $err = "executeAddAddress error: " . mysqli_error($con);
        } else {
          $err = "executeAddAddress query failed.";
        }
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
    
      
      <div class="row " style="padding-top:10px;">
           <?php include basePath('alert.php'); ?>
         </div>
      
      <div class="row">
      <div class="col-md-12"><h2 class="reviewHeadingBig"> <span class="glyphicon glyphicon-user"></span> My Account</h2> </div>
      
      <div class="col-md-3 col-sm-4 col-xs-12">
             <div class="accountMenu doequel equalheight">
       <ul class="nav nav-pills nav-stacked">
      <li><a href="<?php echo baseUrl(); ?>my-account">Account</a></li>
      <li class="active"><a href="<?php echo baseUrl(); ?>my-address-list">Address</a></li>
      <li><a href="<?php echo baseUrl(); ?>my-orders">Order history</a></li>
      
     
    </ul>
            </div>
      </div>
      
        <div class="col-md-9 col-sm-8 col-xs-12">
             <div class="accountContent doequel equalheight">
             <h3>Edit Address</h3>
             
            <form action="<?php echo baseUrl(); ?>edit-address/<?php echo $_GET['edit_id']; ?><?php if(isset($_GET['type']) AND $_GET['type'] != ""){ echo "/checkout"; } ?> " method="post" enctype="multipart/form-data">
      
      <div class="content">
        <div id="newAddressSuccess" class="success hide text-center padding-bottom-10"> Success ! </div><div id="newAddressError" class="warning hidden text-center padding-bottom-10"> Error ! </div><table class="form">
          <tbody>
            <tr>
          
          
          </tr>
          <tr>
            <td><span class="required">*</span> Name:</td>
            <td id="title"><input type="text" value="<?php echo $title; ?>" class="form-control" name="title" placeholder="Address Name"></td>
          </tr>
          <tr>
            <td><span class="required">*</span> Phone No.:</td>
            <td id="phone"><input type="text" value="<?php echo $phone; ?>" class="form-control" name="phone" placeholder="Phone No."></td>
          </tr>
          <tr>
            <td><span class="required">*</span> Address:</td>
            <td id="address"><input type="text" value="<?php echo $address; ?>" class="form-control" name="address" placeholder="Address"></td>
          </tr>
          <tr>
            <td>Zip/Postal Code:</td>
            <td id="zip"><input type="text" value="<?php echo $zip; ?>" class="form-control" name="zip" placeholder="Zip/Postal Code "></td>
          </tr>
          <tr>
            <td><span class="required">*</span>Area:</td>
            <td id="area">
              <select id="selectArea" class="form-control" name="area">
                <?php
                $countArrayArea = count($arrayArea);
                if ($countArrayArea > 0):
                  for ($j = 0; $j < $countArrayArea; $j++):
                    ?>
                    <option value="<?php echo $arrayArea[$j]->area_id; ?>" <?php if($area == $arrayArea[$j]->area_id){ echo "selected"; } ?>><?php echo $arrayArea[$j]->area_name; ?></option>
                    <?php
                  endfor;
                endif;
                ?>
              </select>  
            </td>
          </tr>
          <tr style="line-height: 30px !important;">
            <td>City:</td>
            <td><input type='hidden' name='city' id='inputCity' value='<?php echo $default_city_id;?>'><strong>Dhaka</strong></td>
          </tr>
          <tr style="line-height: 30px !important;">
            <td>Country:</td>
            <td><input type="hidden" value="1" id="inputCountry" name="country"><strong>Bangladesh</strong></td>
          </tr>
          </tbody>
        </table>
      </div>
      <div class="buttons">
        <div class="left"><a href="<?php echo baseUrl(); ?>my-address-list" class="btn btn-default pull-left"><i class="fa fa-arrow-circle-left"></i>  Back</a></div>
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
