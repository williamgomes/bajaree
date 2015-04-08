<?php
include 'config/config.php';
if (!checkUserLogin()) {
  $err = "You need to signup/signin first.";
  $link = baseUrl() . "user-signin-signup?err=" . base64_encode($err) . "&checkout=true";
  redirect($link);
} else {
  $UserID = getSession('UserID');
}

$promotionCode = '';
$promotionDiscount = '';
$deliveryDate = '';
$is_express = 'no';
$START_TIME = get_option('START_TIME');
$END_TIME = get_option('END_TIME');
$TOTAL_SLOT = get_option('TOTAL_SLOT');
$timeslot = '';
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


$minimumShoppingAmountOption = get_option('MINIMUM_SHOPPING_AMOUNT');
$minimumDeliveryChargeOption = 0;

//finding out difference between start time and end time
$time1 = date('H:i:s', strtotime($END_TIME));
$time2 = date('H:i:s', strtotime($START_TIME));
$diff = $time1 - $time2;

if (isset($_SESSION['Coupon-No']) AND $_SESSION['Coupon-No'] != "") {
  $promotionCode = $_SESSION['Coupon-No'];
}

if (isset($_SESSION['Coupon-Discount']) AND $_SESSION['Coupon-Discount'] > 0) {
  $promotionDiscount = $_SESSION['Coupon-Discount'];
}

$payment = 0;
$CartID = session_id();


$page_title = get_option('SITE_DEFAULT_META_TITLE');
$page_description = get_option('SITE_DEFAULT_META_DESCRIPTION');
$page_keywords = get_option('SITE_DEFAULT_META_KEYWORDS');
$site_author = $config['CONFIG_SETTINGS']['SITE_AUTHOR'];

if (!isset($_GET['shipping']) OR !isset($_GET['billing'])) {
  $link = baseUrl() . 'checkout-step-1';
  redirect($link);
}


if (isset($_POST['submit'])) {
  extract($_POST);

  if (isset($_POST['express']) AND $_POST['express'] == "yes") {
    $is_express = 'yes';
  }

  if ($payment == 0) {
    $err = "Please select a payment method.";
  }

  if ($diff > 0) {
    if ($is_express == 'no' AND $timeslot == '') {
      $err = "Please select a delivery time slot.";
    }
  }

  if ($emailVerified == 'no') {
    $err = "To place this order, you need to verify your Email.";
  }

  if ($err == '') {
    setSession("TimeSloT", $timeslot);
    $link = baseUrl() . "checkout-step-3/" . $_GET['shipping'] . "/" . $_GET['billing'] . "/" . $payment . "/" . base64_encode($is_express);
    redirect($link);
  }
}



$sqlWholeTempCart = "SELECT SUM(TC_product_total_price) AS TotalPrice, SUM(TC_discount_amount) AS TotalDiscount, SUM((TC_product_tax*TC_product_total_price)/100) AS TotalTax FROM temp_carts WHERE TC_session_id='$CartID'";
$executeWholeCart = mysqli_query($con, $sqlWholeTempCart);
if ($executeWholeCart) {
  $executeWholeCartObj = mysqli_fetch_object($executeWholeCart);
  $CartTotalPrice = $executeWholeCartObj->TotalPrice;
  $CartTotalDiscount = $executeWholeCartObj->TotalDiscount;
  $TotalTax = $executeWholeCartObj->TotalTax;
  $grandTotal = ($CartTotalPrice + $TotalTax - $CartTotalDiscount);

  if ($grandTotal < $minimumShoppingAmountOption) {
    $minimumDeliveryChargeOption = get_option('MINIMUM_SHOPPING_AMOUNT_CHARGE');
  }
} else {
  $data["error"] = 3;
  if (DEBUG) {
    $data["error_text"] = 'executeWholeCart error: ' . mysqli_error($con);
  } else {
    $data["error_text"] = 'executeWholeCart query failed';
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
    <script src="<?php echo baseUrl(); ?>ajax/index/main.js"></script>

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

      <div style="clear:both"></div>
      <div class="w100 mainContainer chackout-page">
        <div class="container" style="padding-top:50px">
          <div class="row ">
            <div class="col-lg-12 checkoutBar">
              <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4 "> <a class="checkPoint"> <span> <img src="<?php echo baseUrl(); ?>images/site/step1.png"> </span> </a> <a class="checkPointName arrow_top" href="#"> Select Address </a> </div>
    <!--          <div class="col-lg-3 col-md-3 col-xs-3 col-sm-3 "> <a class="checkPoint"><span> <img src="images/site/step2.png"> </span></a> <a class="checkPointName arrow_top" > Select Delivery </a> </div>-->
              <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4 "> <a class="checkPoint"><span> <img src="<?php echo baseUrl(); ?>images/site/step3.png"> </span></a> <a class="checkPointName arrow_top active" >Select Payment</a> </div>
              <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4 "> <a class="checkPoint"><span> <img src="<?php echo baseUrl(); ?>images/site/step4.png"> </span></a> <a class="checkPointName arrow_top" >Review and Confirm</a> </div>
            </div>
          </div>
        </div>
        <div class="container">

          <div class="row ">
            <?php include basePath('alert.php'); ?>
          </div>

          <form action="<?php echo baseUrl(); ?>checkout-step-2/<?php echo $_GET['shipping']; ?>/<?php echo $_GET['billing']; ?>" method="post">
            <div class="row">
              <div class="col-lg-8 col-md-8 col-sm-8 col-xm-12">
                <div class="cartContent">
                  <div class="paymentHeading noborder">
                    <h2>Payment Method</h2>
                  </div>
                  <div class="row">
                    <div class="col-lg-6 col-md-6">
                      <div class="box highlight">
                        <div class="box-content highlight">
                          <div class="radio">
                            <label>
                              <input type="radio" name="payment" value="1" disabled="disabled">
                              <img alt="bkash" src="<?php echo baseUrl(); ?>images/bkash.png"> Bkash (Coming Soon)
                            </label>
                          </div>
                        </div>
                        <hgroup class="title">

                          <h5><?php echo get_option('CHECKOUT_PAGE_BKASH_TEXT'); ?></h5>
                        </hgroup>

                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                      <div class="box highlight">
                        <div class="box-content highlight">
                          <div class="radio">
                            <label>
                              <input type="radio" name="payment" value="2" checked="checked">
                              <img style="width: 21px;" src="<?php echo baseUrl(); ?>images/cash_on_delivery.png" alt="cash on delivery"> Cash on Delivery</label>
                          </div>
                        </div>
                        <hgroup class="title">
                          <h5><?php echo get_option('CHECKOUT_PAGE_COD_TEXT'); ?></h5>
                        </hgroup>

                      </div>
                    </div>
                  </div>
                </div>
                <!--product content--> 

                <hr>

                <div class="cartContent">
                  <div class="paymentHeading noborder">
                    <h2>Delivery Type</h2>
                  </div>
                  <div class="row">

                    <div class="col-lg-6 col-md-6">
                      <div class="box highlight">
                        <div class="box-content highlight">
                          <div class="radio">
                            <label>
                              <input name="express" type="checkbox" onclick="applyExpress();" id="express" value="yes" <?php
                              if ($is_express == 'yes') {
                                echo "checked";
                              }
                              ?>>
                              <img alt="bkash" src="<?php echo baseUrl(); ?>images/express.png"> Express Delivery
                            </label>
                          </div>
                        </div>
                        <hgroup class="title">

                          <h5><?php echo get_option('CHECKOUT_PAGE_EXPRESS_DELIVERY_TEXT'); ?></h5>
                        </hgroup>

                      </div>
                    </div>


                    <?php
                    if ($diff > 0):
                      ?>
                      <div class="col-lg-6 col-md-6" id="divTimeSlot">
                        <div class="box highlight">
                          <div class="box-content highlight">
                            <div class="radio">
                              <label>
                                <h4 class="text-center">Select Time Slot</h4>
                              </label>
                            </div>
                          </div>
                            <?php
                            /* faruk */
                            $timeArray = array();
                            $timeArray['today'] = array();
                            $timeArray['tomorrow'] = array();
                            $curTime = date('H:i');
                            $time1 = date('H:i:s', strtotime($END_TIME));
                            $time2 = date('H:i:s', strtotime($START_TIME));
                            $diff = $time1 - $time2;

                            //getting difference between each slot
                            $slot = $diff / $TOTAL_SLOT;

                            //converting decimal output into hour, minute & second
                            $diffToTime = convertTime($slot);
                            $timeExpld = explode(':', $diffToTime);
                            $totalSec = ($timeExpld[0] * 3600) + ($timeExpld[1] * 60) + $timeExpld[2];
                            $rangeStartTime = date('H:i', strtotime($START_TIME));
                            for ($i = 0; $i < $TOTAL_SLOT; $i++) {
                              $strtTimeExp = explode(":", $rangeStartTime);
                              $newTime = mktime($strtTimeExp[0], $strtTimeExp[1], 0 + $totalSec);

                              $rangeEndTime = date("H:i", $newTime);

                              if ($curTime <= $rangeStartTime) {
                                $timeArray['today'][$i]['start'] = $rangeStartTime;
                                $timeArray['today'][$i]['end'] = $rangeEndTime;
                              } else {
                                $timeArray['tomorrow'][$i]['start'] = $rangeStartTime;
                                $timeArray['tomorrow'][$i]['end'] = $rangeEndTime;
                              }
                              $rangeStartTime = $rangeEndTime;
                            }
                            
                            $deliveryDateTomorrow = date("Y-m-d", time() + 86400); 
                            $deliveryDateToday = date("Y-m-d", time());
                            ?>  
                          <hgroup class="title">
                            <table width="100%" border="0" class="deliveryTiming " data-toggle="buttons">
                              <tbody class="" data-toggle="buttons" id="timeSlotTable">
    
                                <?php
                                if(!empty($timeArray['today'])):
                                  foreach($timeArray['today'] AS $todaysTime):
                                ?>
                                  <tr class="TimingRow">
                                    <td align="center"><label class="btn btn-primary-full btn-primary">
                                        <input name="timeslot" type="radio" id="timeslot_<?php echo $todaysTime['start']; ?>" onchange="putTimeSlot('<?php echo $todaysTime['start']; ?>');" value="<?php echo $deliveryDateToday; ?>|<?php echo date("H:i:s", strtotime($todaysTime['start'])); ?>|<?php echo date("H:i:s", strtotime($todaysTime['end'])); ?>">
                                        <?php echo date("g:i A", strtotime($todaysTime['start'])); ?> &rArr; <?php echo date("g:i A", strtotime($todaysTime['end'])); ?>
                                      </label>
                                    </td>
                                  </tr>
                                <?php
                                  endforeach; //foreach($timeArray['today'] AS $todaysTime) 
                                endif;  
                                ?>
                                  
                                  
                                <?php
                                if(!empty($timeArray['tomorrow'])):
                                  foreach($timeArray['tomorrow'] AS $tomoTime):
                                ?>
                                  <tr class="TimingRow">
                                    <td align="center"><label class="btn btn-primary-full btn-primary">
                                        <input name="timeslot" type="radio" id="timeslot_<?php echo $tomoTime['start']; ?>" onchange="putTimeSlot('<?php echo $tomoTime['start']; ?>');" value="<?php echo $deliveryDateTomorrow; ?>|<?php echo date("H:i:s", strtotime($tomoTime['start'])); ?>|<?php echo date("H:i:s", strtotime($tomoTime['end'])); ?>">
                                        <?php echo date("g:i A", strtotime($tomoTime['start'])); ?> &rArr; <?php echo date("g:i A", strtotime($tomoTime['end'])); ?>&nbsp; (Tomorrow)
                                      </label>
                                    </td>
                                  </tr>
                                <?php
                                  endforeach; //foreach($timeArray['today'] AS $todaysTime)
                                endif;    
                                ?>

                              </tbody>
                            </table>
                          </hgroup>
                        </div>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>

                <input type="hidden" value="" name="timeslot" id="hiddenSlot">


              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xm-12">

                <div class="cartRight">
                  <table width="100%" border="0">
                    <tr>
                      <td align="left">Subtotal</td>
                      <td align="left"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($CartTotalPrice, 2); ?></td>
                    </tr>
                    <tr id="cartTotalDiscount">
                      <?php if ($promotionDiscount > 0): ?>

                        <td align="left">Discount</td>
                        <td align="left"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($promotionDiscount, 2); ?></td>

                      <?php endif; ?>
                    </tr>
                    <tr>
                      <td id="delText" style="width:205px !important;">Delivery</td>
                      <td>
                        <?php if ($CartTotalPrice < get_option('MINIMUM_SHOPPING_AMOUNT')): ?>
                          <strong class="free" id="delAmount"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($minimumDeliveryChargeOption, 2); ?></strong>
                        <?php else: ?>
                          <strong class="free" id="delAmount">FREE!</strong>
                        <?php endif; ?>
                      </td>
                    </tr>
                    
                    <?php if ($TotalTax > 0): ?>
                      <tr>
                        <td id="delText" style="width:205px !important;">Vat</td>
                        <td><strong class="free" id="delAmount"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($TotalTax, 2); ?></strong></td>
                      </tr>
                    <?php endif; ?>
                      
                    <?php if ($countOrderforUser == 0): ?>
                      <tr>
                        <td id="delText" style="width:205px !important;">First Order Discount</td>
                        <?php $firstOrderDiscount = ((10 * $CartTotalPrice) / 100); ?>
                        <td><strong class="free" id="delAmount"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($firstOrderDiscount, 2); ?></strong></td>
                      </tr>
                    <?php endif; ?>
                      
                  </table>

                  <div class="cartRightInner">
                    <input value="<?php echo $promotionCode; ?>" placeholder="Coupon code..." name="code" id="couponNo">
                    <button type="button" name="cbtn" class="btn btn-default btn-site" onclick="discountCoupon();">enter</button>

                  </div>

                  <div class="totalrow">
                    <div class="text">
                      <h3>Total</h3>
                    </div>
                    <div class="total">
                      <?php if ($promotionDiscount > 0): ?>
                        <h3 id="grandTotal"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($grandTotal - $promotionDiscount + $minimumDeliveryChargeOption - $firstOrderDiscount, 2); ?></h3>
                      <?php else: ?>
                        <h3 id="grandTotal"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($grandTotal + $minimumDeliveryChargeOption - $firstOrderDiscount, 2); ?></h3>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>

                <h3><button type="submit" class="btn btn-site btn-lg btn-block" name="submit">Next <i class="fa fa-long-arrow-right"></i></button></h3>


                <?php if ($emailVerified == 'no'): ?>
                  <div class="box highlight infobox infobox2">
                    <hgroup class="title">
                      <h5><i class="glyphicon glyphicon-info-sign"></i> To continue please verify your email.</h5>
                    </hgroup>
                  </div>
                <?php endif; ?>

              </div>
            </div>
          </form>
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
