<?php
include 'config/config.php';

$CartID = '';
$UserID = 0;
$shipping = 0;
$billing = 0;
$err = '';


if(!checkUserLogin()){
  $err = "You need to signup/signin first.";
  $link = baseUrl() . "user-signin-signup?err=" . base64_encode($err) . "&checkout=true";
  redirect($link);
} else {
  $UserID = getSession('UserID'); 
}



$page_title = get_option('SITE_DEFAULT_META_TITLE');
$page_description = get_option('SITE_DEFAULT_META_DESCRIPTION');
$page_keywords = get_option('SITE_DEFAULT_META_KEYWORDS');
$site_author = $config['CONFIG_SETTINGS']['SITE_AUTHOR'];





if(isset($_POST['submit'])){
  extract($_POST);
  
  if($shipping == 0){
    $err .= 'You need to choose one Shipping Address from your list. ';
  }
  
  if($billing == 0){
    $err .= 'You need to choose one Billing Address from your list. ';
  }
  
  if($err == ''){
    $link = "checkout-step-2/" . $shipping . "/" . $billing;
    redirect($link);
  }
  
}


$arrayAddress = array();
$sqlAddress = "SELECT 
               user_addresses.UA_id,user_addresses.UA_title,user_addresses.UA_first_name,user_addresses.UA_middle_name,user_addresses.UA_last_name,user_addresses.UA_phone,user_addresses.UA_zip,user_addresses.UA_address,
               cities.city_name,
               countries.country_name,
               areas.area_name
               
               FROM user_addresses
               
               LEFT JOIN areas ON areas.area_id = user_addresses.UA_area_id
               LEFT JOIN cities ON cities.city_id = user_addresses.UA_city_id
               LEFT JOIN countries ON countries.country_id = user_addresses.UA_country_id
               WHERE UA_user_id=$UserID";
$executeAddress = mysqli_query($con,$sqlAddress);
if($executeAddress){
  while($executeAddressObj = mysqli_fetch_object($executeAddress)){
    $arrayAddress[] = $executeAddressObj;
  }
} else {
  if(DEBUG){
    echo "executeAddress error: " . mysqli_error($con);
  } else {
    echo "executeAddress query failed.";
  }
}


//getting area information from database
$default_city_id = 1;
$arrayArea = array();
$sqlArea = "SELECT * FROM areas WHERE area_status='allow' AND area_city_id=$default_city_id ORDER BY area_name ASC";
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

//echo "<pre>";
//print_r($arrayAddress);
//echo "</pre>";

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $page_title; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $page_description; ?>">
    <meta name="keywords" content="<?php echo $page_keywords; ?>">
    <meta name="author" content="<?php echo $site_author; ?>">

        <?php include basePath('header_script.php'); ?>
        <script src="<?php echo baseUrl(); ?>ajax/index/main.js"></script>
        <script src="<?php echo baseUrl(); ?>ajax/checkout1/main.js"></script>

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

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
    
    
    <div class="container" style="padding-top:50px">
      
      
      
      <div class="row ">
        
        <div class="col-lg-12 checkoutBar">
          <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4 "> <a class="checkPoint"> <span> <img src="<?php echo baseUrl(); ?>images/site/step1.png"> </span> </a> <a class="checkPointName arrow_top active" href="#"> Select Address </a> </div>
<!--          <div class="col-lg-3 col-md-3 col-xs-3 col-sm-3 "> <a class="checkPoint"><span> <img src="images/site/step2.png"> </span></a> <a class="checkPointName arrow_top" > Select Delivery </a> </div>-->
          <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4 "> <a class="checkPoint"><span> <img src="<?php echo baseUrl(); ?>images/site/step3.png"> </span></a> <a class="checkPointName arrow_top" >Select Payment</a> </div>
          <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4 "> <a class="checkPoint"><span> <img src="<?php echo baseUrl(); ?>images/site/step4.png"> </span></a> <a class="checkPointName arrow_top" >Review and Confirm</a> </div>
        </div>
      </div>
    </div>
    <div class="container">
      
      <div class="row ">
        <?php include basePath('alert.php'); ?>
      </div>
      
      <div class="addressTitle">
        <h3>Select Delivery &AMP; Billing Address</h3>
<!--        <a class="btn btn-site pull-right" href="step_2_delivery_timing.html">Next &raquo;</a>--> 
      </div>
      
      <form action="<?php echo baseUrl(); ?>checkout-step-1" method="post">
        
        
      <div class="row">
        
        
        
        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12 addressLeft" id="showAllAddresses" style="margin-bottom: 15px;">
 
<?php
$countArrayAddress = count($arrayAddress);
if($countArrayAddress > 0):
  for($i = 0; $i < $countArrayAddress; $i++):
    
    //declearing variables
    $addressID = $arrayAddress[$i]->UA_id;
    $addressTitle = $arrayAddress[$i]->UA_title;
    $addressFirstName = $arrayAddress[$i]->UA_first_name;
    $addressMiddleName = $arrayAddress[$i]->UA_middle_name;
    $addressLastName = $arrayAddress[$i]->UA_last_name;
    $addressPhone = $arrayAddress[$i]->UA_phone;
    $addressAddress = $arrayAddress[$i]->UA_address;
    $addressZip = $arrayAddress[$i]->UA_zip;
    $addressArea = $arrayAddress[$i]->area_name;
    $addressCity = $arrayAddress[$i]->city_name;
    $addressCountry = $arrayAddress[$i]->country_name;
    ?>
          
     <div class="panel panel-default">
              <div class="panel-body">
                <div class="col-md-6 pull-left">
              <h5> <?php echo $addressTitle; ?> <span class="label label-info collapsed" data-toggle="collapse" data-target="#addressDetails_<?php echo $addressID; ?>"> View </span> 
                <a href="<?php echo baseUrl(); ?>edit-address/<?php echo $addressID; ?>/checkout"><span class="label label-danger"> edit </span></a> 
              </h5>		             
              
              
              
                <div id="addressDetails_<?php echo $addressID; ?>" class="collapse hrTop">
                  <p><strong>Name: <?php echo $addressFirstName; ?> <?php echo $addressMiddleName; ?> <?php echo $addressLastName; ?></strong><br>
                    <?php echo $addressAddress; ?>, <?php echo $addressArea; ?><br>
                    <?php echo $addressCity; ?>-<?php echo $addressZip; ?>, <?php echo $addressCountry; ?>.<br>
                    Phone: <?php echo $addressPhone; ?>. </p>
                </div>
                 
                </div>  
               <div class="addressCheckin col-md-6 pull-right text-right">
               <label class="checkbox-inline">
                  <input type="radio" id="inlineCheckbox1" name="shipping" value="<?php echo $addressID; ?>" <?php if($shipping == $addressID){ echo "checked='checked'"; } ?>> Delivery 
                </label>
                <label class="checkbox-inline">
                  <input type="radio" id="inlineCheckbox2" name="billing" value="<?php echo $addressID; ?>" <?php if($billing == $addressID){ echo "checked='checked'"; } ?>> Billing
                </label>
                </div>
              
              
              
              
              </div>
         </div>     
          
    <?php
  endfor;
else:
?>
        
         <div class="panel panel-default">
              <div class="panel-body">
              
              <h5>No Address found. Click 'Add New' to add new address.</h5>		             
              
              
              </div>
         </div>

<?php
endif;
?>
          
        
          
          <div class="row clearfix"> 
            <div class="col-lg-12 clearfix"> 
              <a class="btn btn-site pull-left addNewAdderss" id="AddNewAddressButton" > <i class="fa fa-plus"></i> Add New </a> 
              <button type="submit" class="btn btn-site pull-right" name="submit">Next <i class="fa fa-long-arrow-right"></i></button>
            </div>  
          </div>
        </div>
        
        
        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
          <div class="addNewAddressform" style="display:none" id="newAddressAddForm">
          
            <div class="panel panel-default">
              <div class="panel-heading collapsed" data-target="#collapsed1" data-toggle="collapse" >Add New Address</div>
              <div class="panel-body collapse in" id="collapsed1">
                <table class="form "  style="">
                  <tbody>
                    <tr>
                      <div class="success hide text-center padding-bottom-10" id="newAddressSuccess"> Success ! </div>
                      <div class="warning hidden text-center padding-bottom-10" id="newAddressError"> Error ! </div>
                    </tr>
                    <tr>
                      <td><span class="required">*</span> Name:</td>
                      <td id='title'><input type="text" placeholder="Address Name" name="title" class="form-control" id='inputTitle'></td>
                    </tr>
                    <tr>
                      <td><span class="required">*</span> Phone:</td>
                      <td id='phone'><input type="text" placeholder="Phone No." name="phone" class="form-control" id='inputPhone'></td>
                    </tr>
                    <tr>
                      <td><span class="required">*</span> Address:</td>
                      <td id='address'>
                          <!--<input type="text" placeholder="Address" name="address" class="form-control" id='inputAddress'>-->
                          <textarea placeholder="Address" name="address" class="form-control"  id='inputAddress'></textarea>
                      </td>
                    </tr>
                    <tr>
                      <td>Zip/Postal Code:</td>
                      <td id='zip'><input type="text" placeholder="Zip/Postal Code " name="address_1" class="form-control" id='inputZip'></td>
                    </tr>
                    <tr>
                      <td><span class="required">*</span>Area:</td>
                      <td id='area'>
                        <select name="area_id" class="form-control" id='selectArea'>
                          <option value=""> --- Please Select Area --- </option>
                          
                            <?php
                          $countArrayArea = count($arrayArea);
                          if($countArrayArea > 0):
                            for($j = 0; $j < $countArrayArea; $j++):
                              ?>
                          <option value="<?php echo $arrayArea[$j]->area_id; ?>"><?php echo $arrayArea[$j]->area_name; ?></option>
                              <?php
                            endfor;
                          endif;
                          ?>
                          
                        </select>  
                      </td>
                    </tr>
                    <tr style='line-height: 30px !important;'>
                      <td>City:</td>
                      <td><input type='hidden' name='city' id='inputCity' value='<?php echo $default_city_id; ?>'><strong>Dhaka</strong></td>
                    </tr>
                    <tr style='line-height: 30px !important;'>
                      <td>Country:</td>
                      <td><input type='hidden' name='country' id='inputCountry' value='1'><strong>Bangladesh</strong></td>
                    </tr>
                    
                    
                    
                  </tbody>
                </table>
              </div>
            </div>
            
            
            <div class=" pull-left clearfix"> 
              <a href='javascript:void(0)' class="btn btn-danger pull-right" id="addNewAddressCancel"  style=" margin-left:10px;"> <i class="fa fa-minus-circle"></i> Cancel </a> 
              <a onClick='addNewAdd();' href='javascript:void(0)' class="btn btn-site pull-right "  > <i class="fa fa-plus"></i> Save </a> 
            </div>
          </div>
          
          
        </div>
          
      </div>
        
       </form>
    </div>
    
    <!--brandFeatured--> 
    
  </div>
  <!-- Main hero unit -->
  
  <?php include basePath('footer.php'); ?>
  
  
</div>


        <?php include basePath('mini_login.php'); ?>
        <?php include basePath('mini_signup.php'); ?>
        <?php include basePath('mini_cart.php'); ?>

        <?php include basePath('footer_script.php'); ?>
</body>
</html>
