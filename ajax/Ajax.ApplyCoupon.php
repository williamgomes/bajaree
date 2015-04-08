<?php

include('../config/config.php');

$_SESSION['Coupon-Discount'] = 0;
$_SESSION['Coupon-No'] = '';

$CouponID = '';
$Action = '';
$status = '';
$countCoupon = 0;
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
$data['discount_amount'] = 0;
$data['total_amount'] = 0;

extract($_POST);
if($Action == 'ApplyCoupon' AND $CouponID != ''){
  
  //getting sub total amount and total discount amount from database
  $sqlWholeTempCart = "SELECT SUM(TC_product_total_price) AS TotalPrice, SUM(TC_discount_amount) AS TotalDiscount FROM temp_carts WHERE TC_session_id='$CartID'";
  $executeWholeCart = mysqli_query($con,$sqlWholeTempCart);
  if($executeWholeCart){
    $executeWholeCartObj = mysqli_fetch_object($executeWholeCart);
    $CartTotalPrice = $executeWholeCartObj->TotalPrice;
    $CartTotalDiscount = $executeWholeCartObj->TotalDiscount;
    $Total = $CartTotalPrice - $CartTotalDiscount;
    $data['total_amount'] = $config['CURRENCY_SIGN']. ' ' . number_format($Total,2);
  } else {
    $data["error"] = 3;
    if(DEBUG){
      $data["error_text"]= 'executeWholeCart error: ' . mysqli_error($con);
    } else {
      $data["error_text"]= 'System Error: Cart calculation failed.';
    }
  }
  
  
  $checkCoupon = "SELECT * FROM promotion_codes
                  LEFT JOIN promotions ON promotion_id=PC_promotion_id
                  WHERE CONCAT(PC_code_prefix,PC_code_suffix)='$CouponID'";
  $executeCheckCoupon = mysqli_query($con,$checkCoupon);
  if($executeCheckCoupon){
    $countCoupon = mysqli_num_rows($executeCheckCoupon);
    if($countCoupon > 0){
      $executeCheckCouponObj = mysqli_fetch_object($executeCheckCoupon);
      if(isset($executeCheckCouponObj->PC_code_prefix)){
        
        //getting coupon primary id
        $CouponKeyID = $executeCheckCouponObj->promotion_id;
      
        
        $status = $executeCheckCouponObj->PC_code_status;
        if($status != 'active'){
          $data['error'] = 3;
          $data['error_text'] = 'Coupon is not active';
        } else {
          $dateNow = date("Y-m-d");
          if($dateNow > $executeCheckCouponObj->promotion_expire){
            $data['error'] = 4;
            $data['error_text'] = 'Coupon already expired';
          } else {
            if($executeCheckCouponObj->promotion_code_predefined_user == 'yes'){ //user defined, anyone can not use this coupon
              
              //checking user email with database email
              if($userEmail == $executeCheckCouponObj->PC_code_used_email){ //email address matched
                
                //need to check the range
                //$sqlCheckRange = "SELECT * FROM promotion_discount_range WHERE PDR_promotion_id=$CouponID AND '$CartTotalPrice' BETWEEN PDR_discount_min_range AND PDR_discount_max_range";
                $sqlCheckRange = "SELECT * FROM promotion_discount_range WHERE PDR_promotion_id=$CouponKeyID";
                $executeCheckRange = mysqli_query($con, $sqlCheckRange);
                $valid = FALSE;
                $promotionAmount = 0;
                $promotionType = '';
                if($executeCheckRange){
                  while($executeCheckRangeObj = mysqli_fetch_object($executeCheckRange)){
                    $minRange = $executeCheckRangeObj->PDR_discount_min_range . '-';
                    $maxRange = $executeCheckRangeObj->PDR_discount_max_range;

                    if($minRange == 0 AND $maxRange == 0){ //range 0-0 means no range fixed
                      $valid = TRUE;
                      $promotionAmount = $executeCheckRangeObj->PDR_discount_quantity;
                      $promotionType = $executeCheckRangeObj->PDR_discount_type;
                      break;
                    }

                    if($CartTotalPrice >= $minRange AND $CartTotalPrice <= $maxRange){
                      $valid = TRUE;
                      $promotionAmount = $executeCheckRangeObj->PDR_discount_quantity;
                      $promotionType = $executeCheckRangeObj->PDR_discount_type;
                      break;
                    }
                  }
                } else {
                  $data['error'] = 5;
                  if(DEBUG){
                    $data['error_text'] = 'executeCheckRange error: ' . mysqli_error($con);
                  } else {
                    $data['error_text'] = 'System Error: Price range check failed.';
                  }
                }

                if($valid == TRUE){ //purchase amount of customer is within promotion range
                  if($promotionType = 'percentage'){
                    $data['error'] = 0;
                    $data['msg_text'] = "You will get " . $promotionAmount . "% discount.";
                    $_SESSION['Coupon-Discount'] = $discountAmount = (($Total * $promotionAmount) / 100) + $CartTotalDiscount; //for now as products have no individual discount $CartTotalDiscount=0 always
                    $data['discount_amount'] = $config['CURRENCY_SIGN']. ' ' . number_format($discountAmount,2);
                    $data['total_amount'] = $config['CURRENCY_SIGN']. ' ' . number_format(($Total - $discountAmount),2);
                    $_SESSION['Coupon-No'] = $CouponID;
                  } else {
                    $data['error'] = 0;
                    $data['msg_text'] = "You will get " . $config['CURRENCY_SIGN'] . $promotionAmount . " discount.";
                    $_SESSION['Coupon-Discount'] = $discountAmount = $data['discount_amount'] = ($promotionAmount + $CartTotalDiscount); //for now as products have no individual discount $CartTotalDiscount=0 always
                    $data['discount_amount'] = $config['CURRENCY_SIGN']. ' ' . number_format($discountAmount);
                    $data['total_amount'] = $config['CURRENCY_SIGN']. ' ' . number_format(($Total - $discountAmount),2);
                    $_SESSION['Coupon-No'] = $CouponID;
                  }
                } else { //purchase amount of customer is not within promotion range
                  $data['error'] = 6;
                  $data['error_text'] = 'Your purchase amount is not within range.';
                }
                
              } else { //email address didnt match
                $data['error'] = 6;
                $data['error_text'] = 'This coupon code is not applicable for you.';
              }
            } else { //user not defined, anyone can use this coupon
              //need to check the range
              //$sqlCheckRange = "SELECT * FROM promotion_discount_range WHERE PDR_promotion_id=$CouponID AND '$CartTotalPrice' BETWEEN PDR_discount_min_range AND PDR_discount_max_range";
              $sqlCheckRange = "SELECT * FROM promotion_discount_range WHERE PDR_promotion_id=$CouponKeyID";
              $executeCheckRange = mysqli_query($con, $sqlCheckRange);
              $valid = FALSE;
              $promotionAmount = 0;
              $promotionType = '';
              if($executeCheckRange){
                while($executeCheckRangeObj = mysqli_fetch_object($executeCheckRange)){
                  $minRange = $executeCheckRangeObj->PDR_discount_min_range . '-';
                  $maxRange = $executeCheckRangeObj->PDR_discount_max_range;
                  
                  if($minRange == 0 AND $maxRange == 0){ //range 0-0 means no range fixed
                    $valid = TRUE;
                    $promotionAmount = $executeCheckRangeObj->PDR_discount_quantity;
                    $promotionType = $executeCheckRangeObj->PDR_discount_type;
                    break;
                  }
                  
                  if($CartTotalPrice >= $minRange AND $CartTotalPrice <= $maxRange){
                    $valid = TRUE;
                    $promotionAmount = $executeCheckRangeObj->PDR_discount_quantity;
                    $promotionType = $executeCheckRangeObj->PDR_discount_type;
                    break;
                  }
                }
              } else {
                $data['error'] = 5;
                if(DEBUG){
                  $data['error_text'] = 'executeCheckRange error: ' . mysqli_error($con);
                } else {
                  $data['error_text'] = 'System Error: Price range check failed.';
                }
              }
              
              if($valid == TRUE){ //purchase amount of customer is within promotion range
                if($promotionType = 'percentage'){
                  $data['error'] = 0;
                  $data['msg_text'] = "You will get " . $promotionAmount . "% discount.";
                  $_SESSION['Coupon-Discount'] = $discountAmount = (($Total * $promotionAmount) / 100) + $CartTotalDiscount; //for now as products have no individual discount $CartTotalDiscount=0 always
                  $data['discount_amount'] = $config['CURRENCY_SIGN']. ' ' . number_format($discountAmount,2);
                  $data['total_amount'] = $config['CURRENCY_SIGN']. ' ' . number_format(($Total - $discountAmount),2);
                  $_SESSION['Coupon-No'] = $CouponID;
                } else {
                  $data['error'] = 0;
                  $data['msg_text'] = "You will get " . $config['CURRENCY_SIGN'] . $promotionAmount . " discount.";
                  $_SESSION['Coupon-Discount'] = $discountAmount = $data['discount_amount'] = ($promotionAmount + $CartTotalDiscount); //for now as products have no individual discount $CartTotalDiscount=0 always
                  $data['discount_amount'] = $config['CURRENCY_SIGN']. ' ' . number_format($discountAmount);
                  $data['total_amount'] = $config['CURRENCY_SIGN']. ' ' . number_format(($Total - $discountAmount),2);
                  $_SESSION['Coupon-No'] = $CouponID;
                }
              } else { //purchase amount of customer is not within promotion range
                $data['error'] = 6;
                $data['error_text'] = 'Your purchase amount is not within range.';
              }
            }
          }
        }
      }
    } else {
      $data['error'] = 2;
      $data['error_text'] = 'Invalid Coupon.';
    }
  } else {
    $data['error'] = 1;
    if(DEBUG){
      $data['error_text'] = 'executeCheckCoupon error: ' . mysqli_error($con);
    } else {
      $data['error_text'] = 'System Error: Could not check coupon with system.';
    }
  }
  echo json_encode($data);
}

?>
