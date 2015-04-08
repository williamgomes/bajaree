<?php
include 'config/config.php';

if (!checkUserLogin()) {
  $err = "You need to login first.";
  $link = baseUrl() . "cart.php?err=" . base64_encode($err);
  redirect($link);
} else {
  $UserID = getSession('UserID');
}

$billingPhone = '';
$orderID = '';
if (isset($_GET['order_id'])) {
  $orderID = base64_decode($_GET['order_id']);
  $sqlGetBillingPhone = "SELECT order_billing_phone FROM orders WHERE order_number='$orderID'";
  $resultGetBillingPhone = mysqli_query($con,$sqlGetBillingPhone);
  if($resultGetBillingPhone){
    $resultGetBillingPhoneObj = mysqli_fetch_object($resultGetBillingPhone);
    if(isset($resultGetBillingPhoneObj->order_billing_phone)){
      $billingPhone = $resultGetBillingPhoneObj->order_billing_phone;
    }
  } else {
    if(DEBUG){
      echo "resultGetBillingPhone error: " . mysqli_error($con);
    }
  }
} else {
  $err = "Invalid Order ID";
  $link = baseUrl() . "?err=" . base64_encode($err);
  redirect($link);
}
$CartID = session_id();

$page_title = get_option('SITE_DEFAULT_META_TITLE');
$page_description = get_option('SITE_DEFAULT_META_DESCRIPTION');
$page_keywords = get_option('SITE_DEFAULT_META_KEYWORDS');
$site_author = $config['CONFIG_SETTINGS']['SITE_AUTHOR'];


//emptying temp cart
$sqlDeleteTmpCart = "DELETE FROM temp_carts WHERE TC_session_id='$CartID'";
$executeDeleteTmpCart = mysqli_query($con, $sqlDeleteTmpCart);
if (!$executeDeleteTmpCart) {
  if (DEBUG) {
    echo "executeDeleteTmpCart error: " . mysqli_error($con);
  } else {
    echo "executeDeleteTmpCart query failed.";
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
          <div id="content">
            <h1>Thank You !</h1>
            <div class="login-content">
              <div class="row">
                <div class="col-lg-12 col-sm-12 col-xs-12 center-block">
                  <div class="inner userRegistration">
                    <div class="content confirmContent">
                      <p>

                      <h3>Your order has been booked.</h3>
                      <h4 style="text-transform: uppercase; line-height: 30px;">One of our customer care representative will get in touch with you soon to confirm your order & delivery address in the number you provided below:
                        <br>
                        <div class="row" style="margin: 15px 0px;">
                          <div class="col-xs-2">
                            <input maxlength="14" id='billingPhone' type="text" class="form-control" placeholder="Your Phone No" value="<?php echo $billingPhone; ?>">
                          </div>
                          <div class="col-xs-1">
                            <button type="button" class="btn btn-primary" onclick="updatePhoneThanku('<?php echo $orderID; ?>');">Update</button>
                          </div>
                        </div>
                      </h4>
                      <h5 style="text-transform: uppercase; padding-bottom: 200px;">here is your order id <span style="color:blueviolet; font-size: 18px; font-weight: bolder;"><?php echo $orderID; ?></span>. save it for future reference.</h5>

                      </p>
                    </div>
                  </div>

                  <div style="clear:both;"></div>

                </div>
              </div>
            </div>
          </div>

          <!--brandFeatured--> 

        </div>
        <!-- Main hero unit --> 

      </div>
      <!-- /container --> 

      <?php include basePath('footer.php'); ?>

    </div>
    <!--wrapper--> 

    <?php include basePath('mini_login.php'); ?>
    <?php include basePath('mini_signup.php'); ?>
    <?php include basePath('mini_cart.php'); ?>

    <?php include basePath('footer_script.php'); ?>
  </body>
</html>
