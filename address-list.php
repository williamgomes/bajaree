<?php
include 'config/config.php';

$CartID = '';
$username = '';
$userID = 0;
$pass1 = '';
$pass2 = '';


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


//getting address information from database
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
               WHERE UA_user_id=$userID";
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
             <h3>Address Book</h3>
             
            <div id="content"> 
    <div class="content">
      <table class="trbar" style="width: 100%;">
        <tbody>
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
          
          
          <tr>
            <td>

              <strong><?php echo $addressTitle; ?></strong>
              <address>
                <?php echo $addressAddress; ?>, <?php echo $addressArea; ?><br>
                <?php echo $addressCity; ?>-<?php echo $addressZip; ?><br>
                <?php echo $addressCountry; ?><br>
                Phone: <?php echo $addressPhone; ?>              </address>
            </td>
            <td style="text-align: right;" class="actions">
              <a href="<?php echo baseUrl(); ?>edit-address/<?php echo $addressID; ?>" class="btn btn-site"><i class="fa fa-edit"></i> Edit</a> &nbsp; 
<!--              <a class="btn btn-danger" href="?route=account/address/delete&amp;address_id=4"><i class="fa fa-minus-circle"></i> Delete</a>-->
            </td>
          </tr>
          
          <?php
  endfor;
else:
?>
          <tr>
            <td colspan="2">
              <h5>No Address found. Click '<strong>+</strong>' to add new address.</h5>
            </td>
          </tr>
<?php
endif; 
?>
      </tbody>
      </table>
  </div>
    <div class="buttons">
    <div class="left"><a href="<?php echo baseUrl(); ?>my-account" class="btn btn-default pull-left"><i class="fa fa-arrow-circle-left"></i>  Back</a></div>
    <div class="right"><a href="<?php echo baseUrl(); ?>edit-address/0" class="btn btn-site pull-right"> <i class="fa fa-plus"></i> Add New</a></div>
  </div>
  </div>
                     
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

<!-- Modal -->
<?php include basePath('mini_login.php'); ?>
        <?php include basePath('mini_signup.php'); ?>
        <?php include basePath('mini_cart.php'); ?>

        <?php include basePath('footer_script.php'); ?>

  
  </body>
</html>
