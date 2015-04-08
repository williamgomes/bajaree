<?php
include 'config/config.php';

$CartID = '';
$username = '';
$userID = 0;
$pass1 = '';
$pass2 = '';
$editID = 0;

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


//getting user's order list from database
$arrayOrder = array();
$sqlOrder = "SELECT * FROM orders WHERE order_user_id=$userID";
$executeOrders = mysqli_query($con, $sqlOrder);
if($executeOrders){
  while($executeOrdersObj = mysqli_fetch_object($executeOrders)){
    $arrayOrder[] = $executeOrdersObj;
  }
} else {
  if(DEBUG){
    echo "executeOrders error: " . mysqli_query($con);
  } else {
    echo "executeOrders query failed.";
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
    
      <div class="row" style="padding-top:10px;">
           <?php include basePath('alert.php'); ?>
         </div>
      
      <div class="row">
      <div class="col-md-12"><h2 class="reviewHeadingBig"> <span class="glyphicon glyphicon-user"></span> My Account</h2> </div>
      
      <div class="col-md-3 col-sm-4 col-xs-12">
             <div class="accountMenu doequel equalheight">
       <ul class="nav nav-pills nav-stacked">
      <li><a href="<?php echo baseUrl(); ?>my-account">Account</a></li>
      <li><a href="<?php echo baseUrl(); ?>my-address-list">Address</a></li>
      <li class="active"><a href="<?php echo baseUrl(); ?>my-orders">Order history</a></li>
      
     
    </ul>
            </div>
      </div>
      
        <div class="col-md-9 col-sm-8 col-xs-12">
             <div class="accountContent doequel equalheight">
             <h3>Order History</h3>
             
            <div class="row">
           
<?php
$countOrderArray = count($arrayOrder);
if($countOrderArray > 0):
  for($i = 0; $i < $countOrderArray; $i++):
    ?>              
              
           <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="panel panel-default order-panel doequel equalheight">
              <div class="panel-heading orderheading">
                <h2 class="panel-title"><strong>Order ID : <?php echo '[' . date("dmy",  strtotime($arrayOrder[$i]->order_created)) . '-'. $arrayOrder[$i]->order_id .']'; ?></strong></h2>
              </div>
              <div class="panel-body">
                <ul>
                <li> <span class="address-company"><strong>Purchase Date </strong>: <?php echo date("d M Y H:i A",  strtotime($arrayOrder[$i]->order_created)); ?></span></li>
                  <li> <span class="address-company"><strong>Shipment To </strong>: <?php echo $arrayOrder[$i]->order_shipping_first_name; ?>, </span></li>
                  <li> <span class="address-line1"> <?php echo $arrayOrder[$i]->order_shipping_address; ?>, </span></li>
                  <li> <span class="address-line2"> <?php echo $arrayOrder[$i]->order_shipping_city; ?> - <?php echo $arrayOrder[$i]->order_shipping_zip; ?>, <?php echo $arrayOrder[$i]->order_shipping_country; ?> </span></li>
                  <li> <span> <strong>Phone</strong> : <?php echo $arrayOrder[$i]->order_shipping_phone; ?> </span></li>
                </ul>
              </div>
             <div class="panel-footer panel-footer-address"> <a class="btn btn-default btn-primary" href="<?php echo baseUrl(); ?>order-details/<?php echo $arrayOrder[$i]->order_id; ?>">View Details</a></div>
            </div>
          </div>
          
<?php          
  endfor;
else:
?>   
              <h5 class="text-center">You didn't place any order yet.</h5>
<?php
endif;
?>  
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