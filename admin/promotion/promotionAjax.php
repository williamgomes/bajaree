<?php

include ('../../config/config.php');
$strg = '';
$count = '';
$promotionid = '';
$checkval = '';

extract($_POST);

$getAllCouponCount = 0;
$sqlGetAllCount = "SELECT * FROM promotion_codes WHERE PC_promotion_id=$promotionid";
$executeGetAllCount = mysqli_query($con, $sqlGetAllCount);
if ($executeGetAllCount) {
    $getAllCouponCount = mysqli_num_rows($executeGetAllCount);
}


if ($strg == 1) {
    //echo $promotionid;
    //echo $count;
    $getCount = 0;
    $sqlGetCount = "SELECT * FROM promotion_codes WHERE PC_promotion_id=$promotionid AND (PC_code_status='active' OR PC_code_status='inactive')";
    $executeGetCount = mysqli_query($con, $sqlGetCount);
    if ($executeGetCount) {
        $getCount = mysqli_num_rows($executeGetCount);
    }


    if ($getCount > $count) {
        $canDelete = $getCount - $count;
        if ($canDelete > $getCount OR $canDelete < 0) {
            $data = array("error" => 1, "required" => $getCount); //warning that given coupon amount cant be changed
            echo json_encode($data);
        } else {
            $couponToBeDelete = $getAllCouponCount - $count;
            if ($couponToBeDelete > $canDelete) {
                $data = array("error" => 1, "required" => $getCount); //warning that given coupon amount cant be changed
                echo json_encode($data);
            } else {
                $data = array("error" => 0, "required" => $canDelete); //given coupon amount can be changed
                echo json_encode($data);
            }
        }
    } elseif ($count > $getCount) {
        $canAdd = $count - $getAllCouponCount;
        $data = array("error" => 2, "required" => $canAdd); //warning that given coupon amount cant be changed
        echo json_encode($data);
    }
} else {
    //echo $promotionid;
    //echo $checkval;
    $getCount = 0;


    if ($checkval == 'yes') {

        $sqlGetCount = "SELECT * FROM promotion_codes WHERE PC_promotion_id=$promotionid AND PC_code_used_email='' AND (PC_code_status='archive' OR PC_code_status='applied' OR PC_code_status='used')";
        $executeGetCount = mysqli_query($con, $sqlGetCount);
        if ($executeGetCount) {
            $getCount = mysqli_num_rows($executeGetCount);
        }

        if ($getCount > 0) {
            $data = array("error" => 1); //coupons are already used without email and cant be changed
            echo json_encode($data);
        } else {
            $data = array("error" => 0); //email not assigned and can be changed
            echo json_encode($data);
        }
    } else {

        $sqlGetCount = "SELECT * FROM promotion_codes WHERE PC_promotion_id=$promotionid AND PC_code_used_email IS NOT NULL AND (PC_code_status='archive' OR PC_code_status='applied' OR PC_code_status='used')";
        $executeGetCount = mysqli_query($con, $sqlGetCount);
        if ($executeGetCount) {
            $getCount = mysqli_num_rows($executeGetCount);
        }

        if ($getCount > 0) {
            $data = array("error" => 2); //coupons already used including email and cant be changed
            echo json_encode($data);
        } else {
            $data = array("error" => 3); //email not assigned and can be changed
            echo json_encode($data);
        }
    }
}
?>
