<?php

include('../config/config.php');

$Action = '';
$CartTotalPrice = 0;
$CartTotalDiscount = 0;
$Total = 0;
$discountAmount = 0;
$CartID = session_id();
$userEmail = getSession('Email');
$data = array();
$data['error'] = 0;
$data['error_text'] = '';
$data['msg_text'] = '';
$data['express_charge'] = 0;
$data['delivery_charge'] = 0;
$data['delivery_charge_with_sign'] = 0;
$data['total_amount'] = 0;
$data['total_amount_before'] = 0;
$data['time_slot'] = '';
$data['time_slot_hidden_val'] = '';
$timeSlot = '';
$expressCharge = 0;
$deliveryCharge = 0;
$minimumShoppingAmountOption = get_option('MINIMUM_SHOPPING_AMOUNT');
$minimumDeliveryChargeOption = 0;
$CouponDiscount = 0;

$START_TIME = get_option('START_TIME');
$END_TIME = get_option('END_TIME');
$TOTAL_SLOT = get_option('TOTAL_SLOT');

if (isset($_SESSION['Coupon-Discount'])) {
  $CouponDiscount = $_SESSION['Coupon-Discount'];
}
extract($_POST);
if ($Action == 'ApplyExpress') {

  //getting sub total amount and total discount amount from database
  $sqlWholeTempCart = "SELECT SUM(TC_product_total_price) AS TotalPrice, SUM(TC_discount_amount) AS TotalDiscount, SUM((TC_product_tax*TC_product_total_price)/100) AS TotalTax FROM temp_carts WHERE TC_session_id='$CartID'";
  $executeWholeCart = mysqli_query($con, $sqlWholeTempCart);
  if ($executeWholeCart) {
    $executeWholeCartObj = mysqli_fetch_object($executeWholeCart);
    $CartTotalPrice = $executeWholeCartObj->TotalPrice;
    $CartTotalDiscount = $executeWholeCartObj->TotalDiscount;
    $TotalTax = $executeWholeCartObj->TotalTax;
    $Total = $CartTotalPrice + $TotalTax - $CartTotalDiscount;
    $data['total_amount'] = $config['CURRENCY_SIGN'] . ' ' . number_format($Total, 2);
  } else {
    $data["error"] = 3;
    if (DEBUG) {
      $data["error_text"] = 'executeWholeCart error: ' . mysqli_error($con);
    } else {
      $data["error_text"] = 'System Error: Cart calculation failed.';
    }
  }

  if (get_option('EXPRESS_DELIVERY_CHARGE') > 0) {
    $expressCharge = get_option('EXPRESS_DELIVERY_CHARGE');
  }

  if ($minimumShoppingAmountOption > $CartTotalPrice) {
    $minimumDeliveryChargeOption = get_option('MINIMUM_SHOPPING_AMOUNT_CHARGE');
  }


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

    if ($curTime <= $rangeEndTime) {
      $timeArray['today'][$i]['start'] = $curTime;
      $timeArray['today'][$i]['end'] = date('H:i', strtotime($curTime)+7200);;
    } else {
      $timeArray['tomorrow'][$i]['start'] = $rangeStartTime;
      $timeArray['tomorrow'][$i]['end'] = $rangeEndTime;
    }
    $rangeStartTime = $rangeEndTime;
  }
  
//  print_r($timeArray);

  $deliveryDateTomorrow = date("Y-m-d", time() + 86400);
  $deliveryDateToday = date("Y-m-d", time());

  $countTodayArray = count($timeArray['today']);
  $firstVal = FALSE;
  if (!empty($timeArray['today'])):
    foreach ($timeArray['today'] AS $todaysTime):
      if (!$firstVal) {
        $data['time_slot'] = date("g:i A", strtotime($todaysTime['start'])) . ' &rArr; ' . date("g:i A", strtotime($todaysTime['end']));
        $data['time_slot_hidden_val'] = $deliveryDateToday . '|' . date("H:i:s", strtotime($todaysTime['start'])) . '|' . date("H:i:s", strtotime($todaysTime['end']));
        $firstVal = TRUE;
      }
    endforeach; //foreach($timeArray['today'] AS $todaysTime) 
  else:

    if (!empty($timeArray['tomorrow'])):
      foreach ($timeArray['tomorrow'] AS $tomoTime):
        if (!$firstVal) {
          $data['time_slot'] = date("g:i A", strtotime($tomoTime['start'])) . ' &rArr; ' . date("g:i A", strtotime($tomoTime['end'])) . '&nbsp; (Tomorrow)';
          $data['time_slot_hidden_val'] = $deliveryDateTomorrow . '|' . date("H:i:s", strtotime($tomoTime['start'])) . '|' . date("H:i:s", strtotime($tomoTime['end']));
          $firstVal = TRUE;
        }
      endforeach; //foreach($timeArray['today'] AS $todaysTime)
    endif;
  endif;


  $data['express_charge'] = $config['CURRENCY_SIGN'] . ' ' . number_format($expressCharge, 2);
  $data['delivery_charge'] = number_format($minimumDeliveryChargeOption, 2);
  $data['delivery_charge_with_sign'] = $config['CURRENCY_SIGN'] . ' ' . number_format($minimumDeliveryChargeOption, 2);
  $data['total_amount'] = $config['CURRENCY_SIGN'] . ' ' . number_format(($Total + $expressCharge + $CouponDiscount), 2);
  $data['total_amount_before'] = $config['CURRENCY_SIGN'] . ' ' . number_format(($Total + $minimumDeliveryChargeOption + $CouponDiscount), 2);
  echo json_encode($data);
}
?>
