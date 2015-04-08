<?php
include 'config/config.php';
include ('./lib/email/mail_helper_functions.php');

if (!checkUserLogin()) {
  $err = "You need to signup/signin first.";
  $link = baseUrl() . "user-signin-signup?err=" . base64_encode($err) . "&checkout=true";
  redirect($link);
} else {
  $UserID = getSession('UserID');
}

$promotionCode = '';
$promotionDiscount = 0;
$promotionID = 0;
$codeType = '';
$coupondiscount = 0;
$totaldiscount = 0;
$arrayTimeSlot = array();
$deliveryDate = '';
$deliveryStartTime = '';
$deliveryEndTime = '';
$delStartTime ='';
$delEndTime = '';
$delStartDateTime = '';
$delEndDateTime = '';
$tax = 0;
$emailVerified = getSession('IsEmailVerified');
$countOrderforUser = 0;
$firstOrderDiscount = 0;

//checking if this is user's first order
$sqlCheckOrder = "SELECT * FROM orders WHERE order_user_id=$UserID";
$resultCheckOrder = mysqli_query($con,$sqlCheckOrder);
if($resultCheckOrder){
  $countOrderforUser = mysqli_num_rows($resultCheckOrder);
} else {
  if(DEBUG){
    echo "resultCheckOrder error: " . mysqli_error($con);
  }
}


if($emailVerified == 'no'){
  $err = "To place this order, you need to verify your Email.";
  $link = baseUrl() . "checkout-step-1?err=" . base64_encode($err);
  redirect($link);
}

$minimumShoppingAmountOption = get_option('MINIMUM_SHOPPING_AMOUNT');
$minimumDeliveryChargeOption = 0;

$timeSlot = '';
if(getSession("TimeSloT") != ''){
  $timeSlot = getSession("TimeSloT");
  $arrayTimeSlot = explode("|", $timeSlot);
  $deliveryDate = $arrayTimeSlot[0];
  $deliveryStartTime = $arrayTimeSlot[1];
  $deliveryEndTime = $arrayTimeSlot[2];
}



if(isset($_SESSION['Coupon-No']) AND $_SESSION['Coupon-No'] != ""){
  $promotionCode = $_SESSION['Coupon-No'];
}

if(isset($_SESSION['Coupon-Discount']) AND $_SESSION['Coupon-Discount'] > 0){
  $promotionDiscount = $_SESSION['Coupon-Discount'];
}

$payment = 0;
$billing = 0;
$shipping = 0;
$CartID = '';
$orderDBID = 0;
$orderPublicID = '';
$express = 'no';
$expressCharge = get_option('EXPRESS_DELIVERY_CHARGE');
$shippingChrg = 0;

$page_title = get_option('SITE_DEFAULT_META_TITLE');
$page_description = get_option('SITE_DEFAULT_META_DESCRIPTION');
$page_keywords = get_option('SITE_DEFAULT_META_KEYWORDS');
$site_author = $config['CONFIG_SETTINGS']['SITE_AUTHOR'];

if (!isset($_GET['shipping']) OR !isset($_GET['billing']) OR !isset($_GET['payment'])) {
  $link = baseUrl() . 'checkout-step-1?err=' . base64_encode("Wrong parameter.");
  redirect($link);
} else {
  $payment = mysqli_real_escape_string($con,$_GET['payment']);
  $billing = mysqli_real_escape_string($con,$_GET['billing']);
  $shipping = mysqli_real_escape_string($con,$_GET['shipping']);
  $tmpExp = base64_decode($_GET['express']);
  $express = mysqli_real_escape_string($con, $tmpExp);
}

//getting shipping and billing addresses from database
$arrayShippingAddresses = array();
$sqlShippingAddresses = "SELECT 
               user_addresses.UA_id,user_addresses.UA_title,user_addresses.UA_first_name,user_addresses.UA_middle_name,user_addresses.UA_last_name,user_addresses.UA_phone,user_addresses.UA_zip,user_addresses.UA_address,
               cities.city_name,
               countries.country_name,
               areas.area_name
               
               FROM user_addresses
               
               LEFT JOIN areas ON areas.area_id = user_addresses.UA_area_id
               LEFT JOIN cities ON cities.city_id = user_addresses.UA_city_id
               LEFT JOIN countries ON countries.country_id = user_addresses.UA_country_id
               WHERE user_addresses.UA_id IN ($shipping,$billing)";
$executeShippingAddress = mysqli_query($con, $sqlShippingAddresses);
if ($executeShippingAddress) {
  while ($executeShippingAddressObj = mysqli_fetch_object($executeShippingAddress)) {
    $arrayShippingAddresses[$executeShippingAddressObj->UA_id][] = $executeShippingAddressObj;
  }
} else {
  if (DEBUG) {
    echo "executeShippingAddress error: " . mysqli_error($con);
  } else {
    echo "executeShippingAddress query failed.";
  }
}

//getting shipping and billing address separated
$shippingName = '';
$shippingAddress = '';
$shippingCity = '';
$shippingZip = '';
$shippingCountry = '';
$shippingPhone = '';
$billingName = '';
$billingAddress = '';
$billingCity = '';
$billingZip = '';
$billingCountry = '';
$billingPhone = '';

$countAddressArray = count($arrayShippingAddresses);
if ($countAddressArray > 0):
  for ($i = 0; $i < $countAddressArray; $i++):
    if (isset($arrayShippingAddresses[$shipping][$i]->UA_first_name)) {
      $shippingFName = $arrayShippingAddresses[$shipping][$i]->UA_first_name;
      $shippingMName = $arrayShippingAddresses[$shipping][$i]->UA_middle_name;
      $shippingLName = $arrayShippingAddresses[$shipping][$i]->UA_last_name;
      $shippingName = $shippingFName . ' ' . $shippingMName . ' ' . $shippingLName;
      $shippingAddress = $arrayShippingAddresses[$shipping][$i]->UA_address;
      $shippingCity = $arrayShippingAddresses[$shipping][$i]->city_name;
      $shippingZip = $arrayShippingAddresses[$shipping][$i]->UA_zip;
      $shippingCountry = $arrayShippingAddresses[$shipping][$i]->country_name;
      $shippingPhone = $arrayShippingAddresses[$shipping][$i]->UA_phone;
      $shippingArea = $arrayShippingAddresses[$shipping][$i]->area_name;
    }
    if (isset($arrayShippingAddresses[$billing][$i]->UA_first_name)) {
      $billingFName = $arrayShippingAddresses[$billing][$i]->UA_first_name;
      $billingMName = $arrayShippingAddresses[$shipping][$i]->UA_middle_name;
      $billingLName = $arrayShippingAddresses[$shipping][$i]->UA_last_name;
      $billingName = $billingFName . ' ' . $billingMName . ' ' . $billingLName;
      $billingAddress = $arrayShippingAddresses[$billing][$i]->UA_address;
      $billingCity = $arrayShippingAddresses[$billing][$i]->city_name;
      $billingZip = $arrayShippingAddresses[$billing][$i]->UA_zip;
      $billingCountry = $arrayShippingAddresses[$billing][$i]->country_name;
      $billingPhone = $arrayShippingAddresses[$billing][$i]->UA_phone;
      $billingArea = $arrayShippingAddresses[$billing][$i]->area_name;
    }
  endfor;
endif;




//getting data from temp_carts table
if ($CartID == '') {
  $CartID = session_id();
}
$arrayTempCart = array();
$sqlTempCart = "SELECT 
                products.product_id, products.product_title, products.product_default_inventory_id,  products.product_show_as_new_from, products.product_show_as_new_to, products.product_show_as_featured_from, products.product_show_as_featured_to,
                product_inventories.PI_id,product_inventories.PI_inventory_title,product_inventories.PI_size_id,product_inventories.PI_cost,product_inventories.PI_current_price,product_inventories.PI_old_price,product_inventories.PI_quantity,
                product_discounts.PD_start_date,product_discounts.PD_end_date,product_discounts.PD_amount,product_discounts.PD_status,
                (SELECT product_images.PI_file_name FROM product_images WHERE product_images.PI_inventory_id = products.product_default_inventory_id AND product_images.PI_product_id = products.product_id ORDER BY product_images.PI_priority DESC LIMIT 1) as PI_file_name,
                temp_carts.TC_product_tax,temp_carts.TC_id,temp_carts.TC_unit_price,temp_carts.TC_per_unit_discount,temp_carts.TC_discount_amount,temp_carts.TC_product_quantity,temp_carts.TC_product_total_price

                FROM temp_carts

                LEFT JOIN product_inventories ON product_inventories.PI_id = temp_carts.TC_product_inventory_id
                LEFT JOIN product_discounts ON product_discounts.PD_inventory_id = temp_carts.TC_product_inventory_id
                LEFT JOIN products ON products.product_id = temp_carts.TC_product_id
                WHERE temp_carts.TC_session_id='$CartID'";
$executeTempCart = mysqli_query($con, $sqlTempCart);
if ($executeTempCart) {
  while ($executeTempCartObj = mysqli_fetch_object($executeTempCart)) {
    $arrayTempCart[] = $executeTempCartObj;
  }
} else {
  if (DEBUG) {
    echo "executeTempCart error: " . mysqli_error($con);
  }
}



if(isset($_POST['confirm'])){
  
  //getting Coupon Code ID from database if applied
  if($promotionCode != ''){
    $checkCoupon = "SELECT * FROM promotion_codes 
                    LEFT JOIN promotions ON promotion_id=PC_promotion_id
                    WHERE CONCAT(PC_code_prefix,PC_code_suffix)='$promotionCode'";
    $executeCheckCoupon = mysqli_query($con,$checkCoupon);
    if($executeCheckCoupon){
      $executeCheckCouponObj = mysqli_fetch_object($executeCheckCoupon);
      if(isset($executeCheckCouponObj->PC_code_prefix)){
        $promotionID = $executeCheckCouponObj->PC_id;
        $codeType = $executeCheckCouponObj->promotion_code_use_type;
        
        //updating status of promotion code
        if($codeType == 'single'){
          $sqlUpdateStatus = "UPDATE promotion_codes SET PC_code_status='applied' WHERE PC_id=$promotionID";
          $executeUpdateStatus = mysqli_query($con,$sqlUpdateStatus);
          if(!$executeUpdateStatus){
            if(DEBUG){
              echo "executeUpdateStatus error: " . mysqli_error($con);
            }
          }
        }
      }
    } else {
      if(DEBUG){
        echo "executeCheckCoupon error: " . mysqli_error($con);
      }
    }
  }
  
  
  $checkError = '';
  extract($_POST);
  
  //calculating time slot
  if (count($arrayTimeSlot) > 0){
    $delStartTime = date("H:i:s", strtotime($deliveryStartTime));
    $delEndTime = date("H:i:s", strtotime($deliveryEndTime));
    $delStartDateTime = $deliveryDate . " " . $delStartTime;
    $delEndDateTime = $deliveryDate . " " . $delEndTime;
  }
 
 
  $getLastOrderID = getMaxValue('orders', 'order_id');
  $orderDBID = $getLastOrderID + 1;
  $orderPublicID = '['.date("dmy",  time()) . '-' . $orderDBID.']';
  $OrderPlaced = date("Y-m-d H:i:s", time());
  
  $placeNewOrder = '';
  $placeNewOrder .= ' order_id = "' . intval($orderDBID) . '"';
  $placeNewOrder .= ', order_user_id = "' . intval($UserID) . '"';
  $placeNewOrder .= ', order_created = "' . mysqli_real_escape_string($con,$OrderPlaced) . '"';
  $placeNewOrder .= ', order_number = "' . mysqli_real_escape_string($con,$orderPublicID) . '"';
  $placeNewOrder .= ', order_status = "' . mysqli_real_escape_string($con,'booking') . '"';
  //payment
  if($payment == 1):
    $placeNewOrder .= ', order_payment_type = "' . mysqli_real_escape_string($con,'Bkash') . '"';
  else:
    $placeNewOrder .= ', order_payment_type = "' . mysqli_real_escape_string($con,'COD') . '"';
  endif;
  $placeNewOrder .= ', order_delivery_start_datetime = "' . mysqli_real_escape_string($con,$delStartDateTime) . '"';
  $placeNewOrder .= ', order_delivery_end_datetime = "' . mysqli_real_escape_string($con,$delEndDateTime) . '"';
  $placeNewOrder .= ', order_is_express = "' . mysqli_real_escape_string($con,$express) . '"';
  $placeNewOrder .= ', order_promotion_codes_id = "' . intval($promotionID) . '"';
  $placeNewOrder .= ', order_promotion_discount_amount = "' . intval($promotionDiscount) . '"';
  $placeNewOrder .= ', order_shipment_charge = "' . intval($shippingChrg) . '"';
  $placeNewOrder .= ', order_total_item = "' . intval($totalquantity) . '"';
  $placeNewOrder .= ', order_total_amount = "' . floatval($totalprice) . '"';
  $placeNewOrder .= ', order_vat_amount = "' . floatval($tax) . '"';
  $placeNewOrder .= ', order_discount_amount = "' . floatval($totaldiscount) . '"';
  $placeNewOrder .= ', order_session_id = "' . mysqli_real_escape_string($con,$CartID) . '"';
  $placeNewOrder .= ', order_note = "' . mysqli_real_escape_string($con,$note) . '"';
  
  //Billing Address Insertion
  $placeNewOrder .= ', order_billing_first_name = "' . mysqli_real_escape_string($con,$billingFName) . '"';
  $placeNewOrder .= ', order_billing_middle_name = "' . mysqli_real_escape_string($con,$billingMName) . '"';
  $placeNewOrder .= ', order_billing_last_name = "' . mysqli_real_escape_string($con, $billingLName) . '"';
  $placeNewOrder .= ', order_billing_phone = "' . mysqli_real_escape_string($con, $billingPhone) . '"';
  $placeNewOrder .= ', order_billing_country = "' . mysqli_real_escape_string($con, $billingCountry) . '"';
  $placeNewOrder .= ', order_billing_city = "' . mysqli_real_escape_string($con, $billingCity) . '"';
  $placeNewOrder .= ', order_billing_area = "' . mysqli_real_escape_string($con, $billingArea) . '"';
  $placeNewOrder .= ', order_billing_zip = "' . mysqli_real_escape_string($con, $billingZip) . '"';
  $placeNewOrder .= ', order_billing_address = "' . mysqli_real_escape_string($con, $billingAddress) . '"';
  
  //shipping address
  $placeNewOrder .= ', order_shipping_first_name = "' . mysqli_real_escape_string($con, $shippingFName) . '"';
  $placeNewOrder .= ', order_shipping_middle_name = "' . mysqli_real_escape_string($con, $shippingMName) . '"';
  $placeNewOrder .= ', order_shipping_last_name = "' . mysqli_real_escape_string($con, $shippingLName) . '"';
  $placeNewOrder .= ', order_shipping_phone = "' . mysqli_real_escape_string($con, $shippingPhone) . '"';
  $placeNewOrder .= ', order_shipping_country = "' . mysqli_real_escape_string($con, $shippingCountry) . '"';
  $placeNewOrder .= ', order_shipping_city = "' . mysqli_real_escape_string($con, $shippingCity) . '"';
  $placeNewOrder .= ', order_shipping_area = "' . mysqli_real_escape_string($con, $shippingArea) . '"';
  $placeNewOrder .= ', order_shipping_zip = "' . mysqli_real_escape_string($con, $shippingZip) . '"';
  $placeNewOrder .= ', order_shipping_address = "' . mysqli_real_escape_string($con, $shippingAddress) . '"';
  
  $sqlPlaceOrder = "INSERT INTO orders SET $placeNewOrder";
  $executePlaceOrder = mysqli_query($con,$sqlPlaceOrder);
  if($executePlaceOrder){
    $countTempCartArray = count($arrayTempCart);
    if ($countTempCartArray > 0):
      for ($x = 0; $x < $countTempCartArray; $x++):
        
        $ProductID = $arrayTempCart[$x]->product_id;
        $ProductImage = $arrayTempCart[$x]->PI_file_name;
        $ProductInventoryID = $arrayTempCart[$x]->PI_id;
        $ProductUnitPrice = $arrayTempCart[$x]->TC_unit_price;
        $ProductUnitDiscount = $arrayTempCart[$x]->TC_per_unit_discount;
        $ProductTotalPrice = $arrayTempCart[$x]->TC_product_total_price;
        $ProductTotalDiscount = $arrayTempCart[$x]->TC_discount_amount;
        $ProductCartQuantity = $arrayTempCart[$x]->TC_product_quantity;
        $ProductTax = $arrayTempCart[$x]->TC_product_tax;
        
        
        $addOrderProduct = '';
        $addOrderProduct .= ' OP_order_id = "' . intval($orderDBID) . '"';
        $addOrderProduct .= ', OP_user_id = "' . intval($UserID) . '"';
        $addOrderProduct .= ', OP_product_id = "' . intval($ProductID) . '"';
        $addOrderProduct .= ', OP_product_inventory_id = "' . intval($ProductInventoryID) . '"';
        $addOrderProduct .= ', OP_price = "' . floatval($ProductUnitPrice) . '"';
        $addOrderProduct .= ', OP_discount = "' . floatval($ProductUnitDiscount) . '"';
        $addOrderProduct .= ', OP_product_quantity = "' . intval($ProductCartQuantity) . '"';
        $addOrderProduct .= ', OP_product_tax = "' . floatval($ProductTax) . '"';
        $addOrderProduct .= ', OP_product_total_price = "' . floatval($ProductTotalPrice) . '"';
        $addOrderProduct .= ', OP_product_total_discount = "' . floatval($ProductTotalDiscount) . '"';
        
        $sqlAddOrderProduct = "INSERT INTO order_products SET $addOrderProduct";
        $executeAddOrderProduct = mysqli_query($con,$sqlAddOrderProduct);
        
        if(!$executeAddOrderProduct){
          if(DEBUG){
            $checkError = "executeAddOrderProduct error: " . mysqli_error($con);
          } else {
            $checkError = "executeAddOrderProduct query failed";
          }
        }
      endfor;
    endif;
    
  } else {
    if(DEBUG){
      $checkError = "executePlaceOrder error: " . mysqli_error($con);  
    } else {
      $checkError = "executePlaceOrder query failed.";
    }
  }
  
  if($checkError == ''){
    $_SESSION['Coupon-Discount'] = 0;
    $_SESSION['Coupon-No'] = '';
   
    
    $Subject = "Order Details from Bajaree.com!";
    $EmailBody = file_get_contents(baseUrl('emails/order/order.confirm.php?order_id=' . $orderDBID));
    $sendEmailToApplicant = sendEmailFunction(getSession('Email'),getSession('FirstName'),'noreply@bajaree.com',$Subject,$EmailBody);
    
    $link = baseUrl() . 'thank-you-for-shopping?order_id=' . base64_encode($orderPublicID);
    redirect($link);
  } else {
    echo $checkError;
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

        <div class="container" style="padding-top:50px">
          <div class="row ">
            <div class="col-lg-12 checkoutBar">
              <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4 "> <a class="checkPoint"> <span> <img src="<?php echo baseUrl(); ?>images/site/step1.png"> </span> </a> <a class="checkPointName arrow_top" href="#"> Select Address </a> </div>
    <!--          <div class="col-lg-3 col-md-3 col-xs-3 col-sm-3 "> <a class="checkPoint"><span> <img src="images/site/step2.png"> </span></a> <a class="checkPointName arrow_top" > Select Delivery </a> </div>-->
              <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4 "> <a class="checkPoint"><span> <img src="<?php echo baseUrl(); ?>images/site/step3.png"> </span></a> <a class="checkPointName arrow_top" >Select Payment</a> </div>
              <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4 "> <a class="checkPoint"><span> <img src="<?php echo baseUrl(); ?>images/site/step4.png"> </span></a> <a class="checkPointName arrow_top active" >Review and Confirm</a> </div>
            </div>      
          </div>
        </div>

        <div class="container">
          <div id="content">
            <h1>Order Summary</h1>
            <div class="login-content">
              <div class="row">
                <div class="col-lg-12 col-sm-12 col-xs-12 center-block">
                  
                  <form action="<?php echo baseUrl(); ?>checkout-step-3/<?php echo $shipping; ?>/<?php echo $billing; ?>/<?php echo $payment; ?>/<?php echo $_GET['express']; ?>" method="post">
                  <div style="clear:both;"></div>
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="confirmAddress">
                        <h4>bill to :</h4>
                        <p><strong>Name: <?php echo $billingName; ?></strong><br>
                          <?php echo $billingAddress; ?>,<br>
                          <?php echo $billingCity; ?>-<?php echo $billingZip; ?>, <?php echo $billingCountry; ?>.<br>
                          Phone: <?php echo $billingPhone; ?></p>
                      </div>
                      <div class="confirmAddress">
                        <h4>delivery to :</h4>
                        <p><strong>Name: <?php echo $shippingName; ?></strong><br>
                          <?php echo $shippingAddress; ?>,<br>
                          <?php echo $shippingCity; ?>-<?php echo $shippingZip; ?>, <?php echo $shippingCountry; ?>.<br>
                          Phone: <?php echo $shippingPhone; ?></p>
                      </div>
                      <div class="confirmAddress">
                        <h4>Payment Method :</h4>
                        <p>

                          <?php if ($payment == 1): ?>
                          <h5>
                            <img alt="bkash" src="<?php echo baseUrl(); ?>images/bkash.png">&nbsp;&nbsp;Bkash
                          </h5>
                        <?php else: ?>
                          <h5>
                            <img style="width: 21px;" src="<?php echo baseUrl(); ?>images/cash_on_delivery.png" alt="cash on delivery">&nbsp;&nbsp;Cash on Delivery
                          </h5>
                        <?php endif; ?>

                        </p>
                        <br>
                        
                        <?php if (count($arrayTimeSlot) > 0): ?>
                        <h4>Delivery Time Slot:</h4>
                        <p>

                          <?php if (count($arrayTimeSlot) > 0): ?>
                          <h5><?php echo date("g:i A", strtotime($deliveryStartTime)); ?> &rAarr; <?php echo date("g:i A", strtotime($deliveryEndTime)); ?> on <?php echo date("d M", strtotime($deliveryDate)); ?></h5>
                          <?php endif; ?>

                        </p>
                        <?php endif; ?>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div id="content">
                        <h2 class="order-review">Order Review</h2>
                        <div class="order-review">
                          <table width="100%" border="0">
                            <tbody>
                              <?php
                              $countTempCartArray = count($arrayTempCart);
                              $TotalPrice = 0;
                              $TotalDiscount = 0;
                              $TotalQuantity = 0;
                              $TotalTax = 0;
                              if ($countTempCartArray > 0):
                                for ($x = 0; $x < $countTempCartArray; $x++):

                                  //product information from temp cart
                                  $ProductTitle = $arrayTempCart[$x]->product_title;
                                  $ProductID = $arrayTempCart[$x]->product_id;
                                  $ProductImage = $arrayTempCart[$x]->PI_file_name;
                                  $ProductDefaultInventoryTitle = $arrayTempCart[$x]->PI_inventory_title;
                                  $ProductUnitPrice = $arrayTempCart[$x]->TC_unit_price;
                                  $ProductUnitDiscount = $arrayTempCart[$x]->TC_per_unit_discount;
                                  $ProductTotalPrice = $arrayTempCart[$x]->TC_product_total_price;
                                  $ProductTotalDiscount = $arrayTempCart[$x]->TC_discount_amount;
                                  $ProductCartQuantity = $arrayTempCart[$x]->TC_product_quantity;
                                  $ProductTax = $arrayTempCart[$x]->TC_product_tax;
                                  $productTotalTax = ($ProductTotalPrice * $ProductTax)/100;

                                  //calculating total price and discount
                                  $TotalQuantity += $arrayTempCart[$x]->TC_product_quantity;
                                  $TotalPrice += $ProductTotalPrice;
                                  $TotalDiscount += $ProductTotalDiscount;
                                  $TotalTax += $productTotalTax;
                                  ?>                

                                  <tr class="cartProduct confirmProduct">
                                    <td width="10%" class="confirm">
                                      <?php if ($ProductImage == ''): ?>
                                        <img alt="<?php echo $ProductTitle; ?>" src="<?php echo baseUrl(); ?>upload/product/small/default.jpg" >
                                      <?php else: ?>
                                        <img alt="<?php echo $ProductTitle; ?>" src="<?php echo baseUrl(); ?>upload/product/small/<?php echo $ProductImage; ?>" >
                                      <?php endif; ?>
                                    </td>
                                    <td width="50%" class="cartProductDescription">
                                      <h4>
                                        <a href="<?php echo baseUrl(); ?>product/<?php echo $ProductID; ?>/<?php echo clean($ProductTitle); ?>" target="_blank" title="<?php echo $ProductTitle; ?>"><?php echo $ProductTitle; ?></a> 
                                        <span><?php echo $ProductDefaultInventoryTitle; ?></span>
                                      </h4>
                                    </td>
                                    <td width="6%" align="center"><div class="quantity">

                                        <?php if ($ProductCartQuantity > 0): ?>
                                          <span id="tempCartQuantity_<?php echo $TempCartID; ?>"><span class="cartQuantity"><?php echo $ProductCartQuantity; ?></span></span>
                                        <?php else: ?>
                                          <span id="tempCartQuantity_<?php echo $TempCartID; ?>"><span class="cartQuantity" style="color:red; font-weight: bold;"><?php echo $ProductCartQuantity; ?></span></span>
                                        <?php endif; ?>

                                      </div>
                                    </td>
                                    <td width="40%" align="right" class="subtotal">
                                      <div class="priceglobal confirmPriceglobal">
                                        
                                        <?php if ($ProductTotalDiscount > 0): ?>
                                        <span><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format(($ProductTotalPrice - $ProductTotalDiscount), 2); ?></span>
                                        <?php else: ?>
                                        <span><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($ProductTotalPrice,2); ?></span>
                                        <?php endif; ?>
                                        
                                        <?php if ($ProductTotalDiscount > 0): ?>
                                          <span class="old-price"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo $ProductTotalDiscount; ?></span>
                                        <?php endif; ?>
                                      </div>
                                    </td>

                                  </tr>

                                  <?php
                                endfor;
                              endif;
                              
                              //applying minimum shipping charge
                              if(($TotalPrice) < $minimumShoppingAmountOption AND $express != 'yes'){
                                $minimumDeliveryChargeOption = get_option('MINIMUM_SHOPPING_AMOUNT_CHARGE');
                              }
                              ?>    


                              <tr class="cartProduct">
                                <td class="confirm">
                                  <div class="pull-left">
                                  </div>
                                </td>
<!--                                <td class="cartProductDescription confirm">
                                  <div class=" pull-right">
                                  </div>
                                </td>
                                <td width="6%" align="center">
                                  <div class=" pull-right">
                                  </div>
                                </td>-->
                                <td  colspan="3" align="right">
                                  <h6>
                                    <input name="totalquantity" value="<?php echo $TotalQuantity; ?>" type="hidden">
                                    
                                    Sub Total: <?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($TotalPrice, 2); ?><br>
                                    <input name="totalprice" value="<?php echo $TotalPrice; ?>" type="hidden">
                                    
                                    
                                    <?php if($TotalTax > 0): ?>
                                    <br>Vat: <?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($TotalTax, 2); ?><br>
                                    <input name="tax" value="<?php echo $TotalTax; ?>" type="hidden">
                                    <?php endif; ?>
                                    
                                    
                                    <?php if($countOrderforUser == 0): ?>
                                      <br><?php $firstOrderDiscount = ((10 * $TotalPrice) / 100); ?>
                                      First Order Discount: <?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($firstOrderDiscount, 2); ?><br>
                                      <input name="totaldiscount" value="<?php echo ($TotalDiscount + $firstOrderDiscount); ?>" type="hidden">
                                    <?php endif; ?>
                                    
                                      
                                    <?php if($promotionCode != '' AND $promotionDiscount > 0): ?>
                                      Discount for Coupon (<?php echo $promotionCode; ?>): <?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($TotalDiscount + $promotionDiscount, 2); ?><br>
                                      <input name="coupondiscount" value="<?php echo $promotionDiscount; ?>" type="hidden">
                                    <?php endif; ?>
                                      
                                      <br>
                                      
                                    <?php if($express == 'yes'): ?>
                                    Express Delivery: <?php // echo $config['CURRENCY_SIGN']; ?> <?php // echo number_format(0, 2); ?> <?php echo $config['CURRENCY_SIGN']. ' ' . number_format($expressCharge,2); ?><br>
                                    <input name="shippingChrg" value="<?php echo $expressCharge; ?>" type="hidden">
                                    <input name="express" value="<?php echo $express; ?>" type="hidden">
                                    <?php else: ?>
                                      Delivery: <?php // echo $config['CURRENCY_SIGN']; ?> <?php // echo number_format(0, 2); ?> 

                                      <?php if($minimumDeliveryChargeOption > 0): ?>
                                        <?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($minimumDeliveryChargeOption,2); ?><br>
                                        <input name="shippingChrg" value="<?php echo $minimumDeliveryChargeOption; ?>" type="hidden">  
                                      <?php else: ?>
                                        Free<br>
                                        <input name="shippingChrg" value="<?php echo 0; ?>" type="hidden">
                                      <?php endif; ?>
                                    <input name="express" value="<?php echo $express; ?>" type="hidden">
                                    <?php endif; ?>
                                  </h6>
                                  
                                  <hr>
                                  
                                  <h4>
                                  <?php if($express == 'yes'): ?>
                                    <strong class="totalPrice">Total: <?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format((($TotalPrice + $expressCharge + $TotalTax + $minimumDeliveryChargeOption) - ($TotalDiscount + $promotionDiscount)), 2); ?></strong>
                                    <input name="grandtotal" value="<?php echo (($TotalPrice + $expressCharge + $TotalTax + $minimumDeliveryChargeOption) - ($TotalDiscount + $promotionDiscount + $firstOrderDiscount)); ?>" type="hidden">
                                  <?php else: ?>
                                    <strong class="totalPrice">Total: <?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format((($TotalPrice + $TotalTax + $minimumDeliveryChargeOption) - ($TotalDiscount + $promotionDiscount + $firstOrderDiscount)), 2); ?></strong>
                                    <input name="grandtotal" value="<?php echo (($TotalPrice + $TotalTax + $minimumDeliveryChargeOption) - ($TotalDiscount + $promotionDiscount)); ?>" type="hidden">
                                  <?php endif; ?>
                                  </h4>  
                                </td>

                              </tr>

                            </tbody></table>
                        </div>

                        
                        <div class="instruction">
                          <textarea class="form-control" rows="3" name="note" placeholder="e.g. My flat number is 2C"></textarea>
                          <label for="instruction">special delivery instruction</label>
                        </div>

                      </div>
                    </div>
                  </div>
                  <div style="clear:both;"></div>
                  
                    <button type="submit" name="confirm" class="btn btn-site pull-right confirm-btn btn-lg"><i class="fa fa-check-square-o"></i> CONFIRM</button>
                  </form>  

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
