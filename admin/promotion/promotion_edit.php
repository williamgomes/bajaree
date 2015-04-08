<?php
include ('../../config/config.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}

$title = '';
$desc = '';
$prefix = '';
$suffix = '';
$count = '';
$min = '';
$max = '';
$expiery = '';
$amount = '';
$type = '';
$predefine = '';
$image = '';
$status = '';
$disamount = '';
$RangeID = 0;
$predefinedHidden = '';

$PromotionID = '';
if (isset($_GET['pid']) AND $_GET['pid'] != '') {
    $PromotionID = base64_decode($_GET['pid']);
}

$errorCheck = 0;


if (isset($_POST['promotion_create']) AND $_POST['promotion_create'] == 'Submit') {

    extract($_POST);

    if ($title == '') {
        $err = 'Promotion Title is required!!';
    } elseif ($desc == '') {
        $err = 'Promotion Description is required!!';
    } elseif ($prefix == '') {
        $err = 'Code Prefix is required!!';
    } elseif ($expiery == '') {
        $err = 'Expire Date is required!!';
    } else {


        $UploadedImage = '';
        if ($_FILES['image']['tmp_name'] != '') {
            $image = basename($_FILES['image']['name']);
            $info = pathinfo($image, PATHINFO_EXTENSION); /* it will return me like jpeg, gif, pdf, png */
            $image_name = clean($title) . '_' . date('Y-m-d-H-i-s', time()) . '.' . $info; /* create custom image name color id will add  */
            $image_source = $_FILES["image"]["tmp_name"];


            if (!is_dir($config['IMAGE_UPLOAD_PATH'] . '/promotion/')) {
                mkdir($config['IMAGE_UPLOAD_PATH'] . '/promotion/', 0777, TRUE);
            }

            $image_target_path = $config['IMAGE_UPLOAD_PATH'] . '/promotion/' . $image_name;

            if (move_uploaded_file($image_source, $image_target_path)) {
                $UploadedImage = $image_name;
            }
        }


        $expire_date = substr($expiery, 6, 4) . '-' . substr($expiery, 3, 2) . '-' . substr($expiery, 0, 2);

        /* $status = '';
          if(isset($_POST['predefine']) AND $_POST['predefine'] == 'yes'){
          $status = 'inactive';
          } else {
          $status = 'active';
          } */

        if ($predefinedHidden != $predefine) {
            if ($predefine == 'yes') {

                //updating promotions table
                $updatePromotion = '';
                $updatePromotion .=' promotion_code_predefined_user = "' . mysqli_real_escape_string($con, 'yes') . '"';

                $sqlPromotion = "UPDATE promotions SET $updatePromotion WHERE promotion_id=$PromotionID";
                $executePromotion = mysqli_query($con, $sqlPromotion);

                if ($executePromotion) {
                    //no message need to show
                } else {
                    $errorCheck += 1;
                    if (DEBUG) {
                        echo 'executePromotion error: ' . mysqli_error($con);
                    }
                }


                //updating promotion_codes table
                $updatePromotionCodes = '';
                $updatePromotionCodes .=' PC_code_status = "' . mysqli_real_escape_string($con, 'inactive') . '"';

                $sqlPromotionCode = "UPDATE promotion_codes SET $updatePromotionCodes WHERE PC_promotion_id=$PromotionID";
                $executePromotionCode = mysqli_query($con, $sqlPromotionCode);

                if ($executePromotionCode) {
                    //no message need to show
                } else {
                    $errorCheck += 1;
                    if (DEBUG) {
                        echo 'executePromotionCode error: ' . mysqli_error($con);
                    }
                }
            } else {

                //updating promotions table
                $updatePromotion = '';
                $updatePromotion .=' promotion_code_predefined_user = "' . mysqli_real_escape_string($con, 'no') . '"';

                $sqlPromotion = "UPDATE promotions SET $updatePromotion WHERE promotion_id=$PromotionID";
                $executePromotion = mysqli_query($con, $sqlPromotion);

                if ($executePromotion) {
                    //no message need to show
                } else {
                    $errorCheck += 1;
                    if (DEBUG) {
                        echo 'executePromotion error: ' . mysqli_error($con);
                    }
                }


                //updating promotion_codes table
                $updatePromotionCodes = '';
                $updatePromotionCodes .=' PC_code_status = "' . mysqli_real_escape_string($con, 'active') . '"';
                $updatePromotionCodes .=', PC_code_used_email = "' . mysqli_real_escape_string($con, '') . '"';

                $sqlPromotionCode = "UPDATE promotion_codes SET $updatePromotionCodes WHERE PC_promotion_id=$PromotionID";
                $executePromotionCode = mysqli_query($con, $sqlPromotionCode);

                if ($executePromotionCode) {
                    //no message need to show
                } else {
                    $errorCheck += 1;
                    if (DEBUG) {
                        echo 'executePromotionCode error: ' . mysqli_error($con);
                    }
                }
            }
        }

        $updatePromotion = '';
        $updatePromotion .=' promotion_title = "' . mysqli_real_escape_string($con, $title) . '"';
        $updatePromotion .=', promotion_description = "' . mysqli_real_escape_string($con, $desc) . '"';
        if ($_FILES['image']['tmp_name'] != '' AND move_uploaded_file($image_source, $image_target_path)) {
            $updatePromotion .=', promotion_image = "' . mysqli_real_escape_string($con, $UploadedImage) . '"';
        }
        $updatePromotion .=', promotion_code_prefix = "' . mysqli_real_escape_string($con, $prefix) . '"';
        if (isset($_POST['predefine']) AND $_POST['predefine'] == 'yes') {
            $updatePromotion .=', promotion_code_predefined_user = "' . mysqli_real_escape_string($con, $predefine) . '"';
        }
        $updatePromotion .=', promotion_discount_type = "' . mysqli_real_escape_string($con, $type) . '"';
        $updatePromotion .=', promotion_expire = "' . mysqli_real_escape_string($con, $expire_date) . '"';
        $updatePromotion .=', promotion_status = "' . mysqli_real_escape_string($con, $status) . '"';

        $sqlUpdatePromotion = "UPDATE promotions SET $updatePromotion WHERE promotion_id=$PromotionID";
        $executeAddPromotion = mysqli_query($con, $sqlUpdatePromotion);
        if ($executeAddPromotion) {
            $PromotionID = mysqli_insert_id($con);
        } else {
            $errorCheck += 1;
            if (DEBUG) {
                echo 'executeAddPromotion error: ' . mysqli_error($con);
            }
        }


        if ($suffix == '') {
            if ($count == '') {
                $err = '"How many code?" field is required.';
            } else {

                if (isset($_GET['pid']) AND $_GET['pid'] != '') {
                    $PromotionID = base64_decode($_GET['pid']);
                }

                if ($count < $countdefault) { //if admin want to decrease existing promotion codes
                    $getCount = 0;
                    $sqlGetCount = "SELECT * FROM promotion_codes WHERE PC_promotion_id=$PromotionID AND (PC_code_status='active' OR PC_code_status='inactive')";
                    $executeGetCount = mysqli_query($con, $sqlGetCount);
                    if ($executeGetCount) {
                        $getCount = mysqli_num_rows($executeGetCount);
                    }

                    $needToDelete = $getCount - $count;
                    $sqlDeletePromotionCode = "DELETE FROM promotion_codes WHERE PC_promotion_id=$PromotionID AND (PC_code_status='active' OR PC_code_status='inactive') LIMIT " . $needToDelete . "";
                    $executeDeletePromotionCode = mysqli_query($con, $sqlDeletePromotionCode);
                    if ($executeDeletePromotionCode) {
                        //$msg = 'Promotion Code Added Successfully';
                    } else {
                        $errorCheck += 1;
                        if (DEBUG) {
                            echo 'executeDeletePromotionCode error: ' . mysqli_error($con);
                        }
                    }
                } elseif ($count > $countdefault) { //if admin want to increase promotion codes
                    if (isset($_GET['pid']) AND $_GET['pid'] != '') {
                        $PromotionID = base64_decode($_GET['pid']);
                    }

                    $needToAdd = $count - $countdefault;
                    $lastPromoID = 0;
                    $getMaxValue = "SELECT MAX(PC_code_suffix) AS max_value FROM promotion_codes WHERE PC_promotion_id=$PromotionID";
                    $executeMaxValue = mysqli_query($con, $getMaxValue);
                    if ($executeMaxValue) {
                        $getMax = mysqli_fetch_object($executeMaxValue);
                        $lastPromoID = $getMax->max_value;
                        $TotalVouchar = $lastPromoID + $needToAdd;
                    }

                    for ($x = $lastPromoID + 1; $x <= $TotalVouchar; $x++) {
                        $addPromotionCodes = '';
                        $addPromotionCodes .=' PC_promotion_id = "' . mysqli_real_escape_string($con, $PromotionID) . '"';
                        $addPromotionCodes .=', PC_code_prefix = "' . mysqli_real_escape_string($con, $prefix) . '"';
                        $addPromotionCodes .=', PC_code_suffix = "' . mysqli_real_escape_string($con, $x) . '"';
                        $addPromotionCodes .=', PC_code_status = "' . mysqli_real_escape_string($con, $status) . '"';

                        $sqlAddPromotionCodes = "INSERT INTO promotion_codes SET $addPromotionCodes";
                        $executeAddPromotionCodes = mysqli_query($con, $sqlAddPromotionCodes);
                        if ($executeAddPromotionCodes) {
                            //$msg = 'Promotion Code updated Successfully';
                        } else {
                            $errorCheck += 1;
                            if (DEBUG) {
                                echo 'executeAddPromotionCodes error: ' . mysqli_error($con);
                            }
                        }
                    }
                }
            }
        } else if ($suffix != ''){
          $updatePromotionCodes = '';
          $updatePromotionCodes .=' PC_promotion_id = "' . mysqli_real_escape_string($con, $PromotionID) . '"';
          $updatePromotionCodes .=', PC_code_prefix = "' . mysqli_real_escape_string($con, $prefix) . '"';
          $updatePromotionCodes .=', PC_code_suffix = "' . mysqli_real_escape_string($con, $suffix) . '"';
          $updatePromotionCodes .=', PC_code_status = "' . mysqli_real_escape_string($con, $status) . '"';

          $sqlUpdatePromotionCodes = "UPDATE promotion_codes SET $updatePromotionCodes WHERE PC_promotion_id=$PromotionID";
          $executeUpdatePromotionCodes = mysqli_query($con, $sqlUpdatePromotionCodes);
          if ($executeUpdatePromotionCodes) {
              //$msg = 'Promotion Code updated Successfully';
          } else {
              $errorCheck += 1;
              if (DEBUG) {
                  $err = 'executeUpdatePromotionCodes error: ' . mysqli_error($con);
              }
          }
        }

        if ($errorCheck == 0) {
            $msg = 'Promotion information updated successfully.';
            $link = 'index.php?msg=' . base64_encode($msg);
            redirect($link);
        } else {
            $err = 'Promotion information update failed.';
        }
    }
}





$sqlPromotion = "SELECT * FROM promotions,promotion_discount_range 
				WHERE promotions.promotion_id=$PromotionID 
				AND promotion_discount_range.PDR_promotion_id=$PromotionID";
$executePromotion = mysqli_query($con, $sqlPromotion);
if ($executePromotion) {
    $getPromotion = mysqli_fetch_object($executePromotion);
    if (isset($getPromotion->promotion_id)) {
        $getCount = 0;
        $sqlGetCount = "SELECT * FROM promotion_codes WHERE PC_promotion_id=$PromotionID";
        $executeGetCount = mysqli_query($con, $sqlGetCount);
        if ($executeGetCount) {
            $getCount = mysqli_num_rows($executeGetCount);
            $executeGetPromoCodeObj = mysqli_fetch_object($executeGetCount);
        }

        $title = $getPromotion->promotion_title;
        $desc = $getPromotion->promotion_description;
        $prefix = $getPromotion->promotion_code_prefix;
        if($getCount <= 1){
          $suffix = $executeGetPromoCodeObj->PC_code_suffix;
        }
        $predefine = $getPromotion->promotion_code_predefined_user;
        $count = $getCount;
        $expiery = substr($getPromotion->promotion_expire, 8, 2) . '-' . substr($getPromotion->promotion_expire, 5, 2) . '-' . substr($getPromotion->promotion_expire, 0, 4);
        $amount = $getPromotion->PDR_discount_quantity;
        $type = $getPromotion->PDR_discount_type;
        $image = $getPromotion->promotion_image;
        $status = $getPromotion->promotion_status;
    }
}


if (!isset($_GET['range_id'])) {
    if (isset($_POST['range_create'])) {
        extract($_POST);
        if ($min == '') {
            $err = 'Discount Min Range is required.';
        } elseif ($max == '') {
            $err = 'Discount Max Range is required.';
        } elseif ($disamount == '') {
            $err = 'Discount Amount is required.';
        } elseif (!ctype_digit($min)) {
            $err = 'Discount Min Range can only be number.';
        } elseif (!ctype_digit($max)) {
            $err = 'Discount Max Range can only be number.';
        } elseif (!ctype_digit($disamount)) {
            $err = 'Discount Amount can only be number.';
        } elseif ($min >= $max) {
            $err = 'Min Range should be smaller then Max Range.';
        } else {
            $Count = 0;
            $checkRange = "SELECT * FROM `promotion_discount_range` 
						WHERE ($min BETWEEN `PDR_discount_min_range` AND `PDR_discount_max_range` 
						OR $max BETWEEN `PDR_discount_min_range` AND `PDR_discount_max_range`)
						AND PDR_promotion_id=$PromotionID";
            $executeRange = mysqli_query($con, $checkRange);
            if ($executeRange) {
                $Count = mysqli_num_rows($executeRange);
                $getRangeCheck = mysqli_fetch_object($executeRange);
            }

            if ($Count > 0) {
                $err = "Min Range should be greater then " . $getRangeCheck->PDR_discount_max_range;
            } else {

                $addRange = '';
                $addRange .=' PDR_promotion_id = "' . mysqli_real_escape_string($con, $PromotionID) . '"';
                $addRange .=', PDR_discount_type = "' . mysqli_real_escape_string($con, $type) . '"';
                $addRange .=', PDR_discount_min_range = "' . mysqli_real_escape_string($con, $min) . '"';
                $addRange .=', PDR_discount_max_range = "' . mysqli_real_escape_string($con, $max) . '"';
                $addRange .=', PDR_discount_quantity = "' . mysqli_real_escape_string($con, $disamount) . '"';
                $addRange .=', PDR_status = "' . mysqli_real_escape_string($con, 'active') . '"';

                $sqlAddRange = "INSERT INTO promotion_discount_range SET $addRange";
                $executeAddRange = mysqli_query($con, $sqlAddRange);
                if ($executeAddRange) {
                    $msg = 'Discount Range added successfully.';
                } else {
                    $err = 'Discount Range add failed.';
                    if (DEBUG) {
                        echo "executeAddRange error: " . mysqli_error($con);
                    }
                }
            }
        }
    }
}



if (isset($_GET['range_id']) AND $_GET['range_id'] != '') {
    $RangeID = base64_decode($_GET['range_id']);

    if (isset($_POST['range_create'])) {
        extract($_POST);
        if ($min == '') {
            $err = 'Discount Min Range is required.';
        } elseif ($max == '') {
            $err = 'Discount Max Range is required.';
        } elseif ($disamount == '') {
            $err = 'Discount Amount is required.';
        } elseif (!ctype_digit($min)) {
            $err = 'Discount Min Range can only be number.';
        } elseif (!ctype_digit($max)) {
            $err = 'Discount Max Range can only be number.';
        } elseif (!ctype_digit($disamount)) {
            $err = 'Discount Amount can only be number.';
        } elseif ($min >= $max) {
            $err = 'Min Range should be smaller then Max Range.';
        } else {

            $Count = 0;
            $checkRange = "SELECT * FROM `promotion_discount_range` 
						WHERE ($min BETWEEN `PDR_discount_min_range` AND `PDR_discount_max_range` 
						OR $max BETWEEN `PDR_discount_min_range` AND `PDR_discount_max_range`) 
						AND PDR_promotion_id=$PromotionID 
						AND PDR_id NOT IN ($RangeID)";
            $executeRange = mysqli_query($con, $checkRange);
            if ($executeRange) {
                $Count = mysqli_num_rows($executeRange);
                $getRangeCheck = mysqli_fetch_object($executeRange);
            }

            if ($Count > 0) {
                $err = "Min Range should be greater then '" . $getRangeCheck->PDR_discount_max_range;
            } else {
                $updateRange = '';
                $updateRange .=' PDR_discount_min_range = "' . mysqli_real_escape_string($con, $min) . '"';
                $updateRange .=', PDR_discount_max_range = "' . mysqli_real_escape_string($con, $max) . '"';
                $updateRange .=', PDR_discount_quantity = "' . mysqli_real_escape_string($con, $disamount) . '"';
                $updateRange .=', PDR_status = "' . mysqli_real_escape_string($con, $status) . '"';

                $sqlUpdateRange = "UPDATE promotion_discount_range SET $updateRange WHERE PDR_id=$RangeID";
                $executeUpdateRange = mysqli_query($con, $sqlUpdateRange);

                if ($executeUpdateRange) {
                    $msg = 'Discount Range updated successfully.';
                    $link = 'promotion_edit.php?pid=' . $_GET['pid'] . '&msg=' . base64_encode($msg);
                    redirect($link);
                } else {
                    $err = 'Discount Range update failed.';
                    if (DEBUG) {
                        echo "executeUpdateRange error: " . mysqli_error($con);
                    }
                }
            }
        }
    }


    $sqlRange = "SELECT * FROM promotion_discount_range WHERE PDR_id=$RangeID";
    $executeRange = mysqli_query($con, $sqlRange);
    if ($executeRange) {
        $getRange = mysqli_fetch_object($executeRange);
        if (isset($getRange->PDR_id)) {
            $min = $getRange->PDR_discount_min_range;
            $max = $getRange->PDR_discount_max_range;
            $disamount = $getRange->PDR_discount_quantity;
            $status = $getRange->PDR_status;
        }
    }
}



$arrayPromotionRange = array();
$sqlPromotionRange = "SELECT * FROM promotion_discount_range WHERE PDR_promotion_id=$PromotionID";
$executePromotionRange = mysqli_query($con, $sqlPromotionRange);
if ($executePromotionRange) {
    while ($getPromotionRange = mysqli_fetch_object($executePromotionRange)) {
        $arrayPromotionRange[] = $getPromotionRange;
    }
} else {
    if (DEBUG) {
        echo 'executePromotionCode error: ' . mysqli_error($con);
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
        <title>Admin panel: Promotion Edit</title>



<?php include basePath('admin/header.php'); ?>

        <style type="text/css">
            .moreFields ul li.sep {
                color:#2A6788;
            }
        </style>

        <script>
            function checkSuffix() {
                var suffix = $('input#codeSuffix').val();
                //alert(suffix);
                if (suffix == '') {
                    $('#getcount').fadeIn('slow');
                } else {
                    $('#getcount').fadeOut('slow');
                }
            }


        </script>




        <script type="text/javascript">
            function generateResult(strg, pid) {

                if (strg == 1) {  //this is for promotion code

                    var count = $('#countCheck').val(); //getting new coupon counts
                    var defaultValue = $('#defaultCount').val(); //keeping the default value in record
                    var promotionid = pid;
                    if (count != defaultValue) {
                        $.ajax({url: 'promotionAjax.php',
                            data: {promotionid: promotionid, count: count, strg: strg}, //Modify this
                            type: 'post',
                            success: function(output1) {
                                //alert(output); 
                                var result1 = $.parseJSON(output1);
                                if (result1.error == 0) {
                                    $.jGrowl(result1.required + " unused coupon(s) will be removed from system.");
                                } else if (result1.error == 1) {
                                    $.jGrowl("You can only remove " + result1.required + " coupons from system.");
                                    $('#countCheck').val(defaultValue);
                                } else {
                                    $.jGrowl(result1.required + " coupons will be added to system.");
                                }
                            }
                        });
                    }
                } else {  //this is for predefined email

                    checkval = '';
                    if ($('#checkBox').is(":checked")) {
                        var checkval = 'no';
                    } else {
                        var checkval = $('#checkBox').val();
                    }

                    var promotionid = pid;
                    var checkPre = $('#checkPredefine').val(); //getting default value of predefine user email

                    if (checkval != checkPre) {
                        $.ajax({url: 'promotionAjax.php',
                            data: {promotionid: promotionid, checkval: checkval, strg: strg}, //Modify this
                            type: 'post',
                            success: function(output2) {
                                /*alert(output2);*/
                                var result2 = $.parseJSON(output2);
                                if (result2.error == 0) {
                                    $.jGrowl('All codes will be updated!');
                                } else if (result2.error == 1) {
                                    $.jGrowl('You can\'t update codes!');
                                    /*alert(1);*/
                                    /*$('#checkBox').prop('checked');*/
                                    /*alert(checkPre);*/
                                    if (checkPre == 'yes') {
                                        $('#checkBox').prev().addClass('jqTransformChecked');
                                    } else {
                                        $('#checkBox').prev().removeClass('jqTransformChecked');
                                    }
                                    /*var defaultValue = $('#defaultCount').val();
                                     $('#countCheck').val(defaultValue);*/
                                } else if (result2.error == 2) {
                                    $.jGrowl('You can\'t update codes!');
                                    /*alert(2);*/
                                    /*$('#checkBox').prop('checked');*/
                                    /*alert(checkPre);*/
                                    if (checkPre == 'yes') {
                                        $('#checkBox').prev().addClass('jqTransformChecked');
                                    } else {
                                        $('#checkBox').prev().removeClass('jqTransformChecked');
                                    }
                                    /*var defaultValue = $('#defaultCount').val();
                                     $('#countCheck').val(defaultValue);*/
                                } else if (result2.error == 3) {
                                    $.jGrowl('All codes will be updated and assigned emails will be removed!');
                                    /*var defaultValue = $('#defaultCount').val();
                                     $('#countCheck').val(defaultValue);*/
                                }
                            }
                        });
                    }

                }
            }


        </script>  

    </head>

    <body>

<?php include basePath('admin/top_navigation.php'); ?>

<?php include basePath('admin/module_link.php'); ?>


        <!-- Content wrapper -->
        <div class="wrapper">

            <!-- Left navigation -->
<?php include ('promotion_left_navigation.php'); ?>

            <!-- Content Start -->
            <div class="content">
                <div class="title"><h5>Promotion Module</h5></div>

                <!-- Notification messages -->
<?php include basePath('admin/message.php'); ?>
                <!-- Charts -->
                <div class="widget first">
                    <div class="head">
                        <h5 class="iGraph">Edit Promotion </h5></div>
                    <div class="body">
                        <div class="charts" style="width: 700px; height: auto;">
                            <form action="<?php echo baseUrl('admin/promotion/promotion_edit.php?pid=' . $_GET['pid']); ?>" method="post" class="mainForm" enctype="multipart/form-data">

                                <!-- Input text fields -->
                                <fieldset>
                                    <div class="widget first">
                                        <div class="head"><h5 class="iList">Promotion Code Information</h5></div>

                                        <div class="rowElem noborder"><label>Promotion Title:</label><div class="formRight">
                                                <input type="text" name="title" value="<?php echo $title; ?>"  />
                                            </div><div class="fix"></div></div>

                                        <div class="rowElem noborder"><label>Promotion Image:</label><div class="formRight">
                                                <input type="file" name="image"/>&nbsp;&nbsp;
<?php if ($image != '') { ?>
                                                    <a href="<?php echo $config['IMAGE_UPLOAD_URL'] . '/promotion/' . $image; ?>" data-lightbox="<?php echo $config['IMAGE_UPLOAD_URL'] . '/promotion/' . $image; ?>" title="<?php echo $title; ?> Image" >Logo</a>
<?php } ?>
                                            </div><div class="fix"></div></div>

                                        <div class="head"><h5 class="iPencil">Promotion Description:</h5></div>      
                                        <div><textarea class="tm" rows="5" cols="" name="desc"><?php echo $desc; ?></textarea></div>


                                        <div class="rowElem">
                                            <label>Code Options</label> 
                                            <div class="formRight moreFields">
                                                <ul>
                                                    <li class="sep">Code Prefix &rArr;</li>
                                                    <li><input type="text" name="prefix" value="<?php echo $prefix; ?>" /></li>

<?php if ($suffix != '') { ?>
                                                        <li class="sep">Code Suffix &rArr;</li>
                                                        <li><input type="text" name="suffix" maxlength="1"  value="<?php echo $suffix; ?>" readonly="readonly" /></li>
<?php } ?>

                                                    <div id="getcount">
<?php if ($count != 0) { ?>
                                                            <li class="sep">How many code? &rArr;</li>
                                                            <li><input type="text" id="countCheck" name="count" maxlength="4"  value="<?php echo $count; ?>" onchange="generateResult(1,<?php echo $PromotionID; ?>);"  onkeyup="generateResult(1,<?php echo $PromotionID; ?>);"/></li>
                                                            <input type="hidden" name="countdefault" value="<?php echo $count; ?>" id="defaultCount">

                                                                <br /><br /><br />
                                                                <li class="sep">User Predefined? &rArr;</li>
                                                                <li style="position:relative; left:-15px; bottom:5px;"><input type="checkbox" id="checkBox" name="predefine" value="yes" <?php if ($predefine == 'yes') {
                                                        echo 'checked';
                                                    } ?>  onclick="generateResult(2,<?php echo $PromotionID; ?>);"/><p style="bottom:20px; position:relative; left:30px;">Yes</p></li>
                                                                <input type="hidden" name="predefinedHidden" value="<?php echo $predefine; ?>" id="checkPredefine" />
<?php } ?>
                                                    </div>
                                                </ul>  
                                            </div> 
                                            <div class="fix"></div>   
                                        </div>
                                        <p style="position:relative; bottom:30px; left: 340px; color: red;" id="showMessage"></p> 


                                        <div class="rowElem">
                                            <label>Code Settings</label> 
                                            <div class="formRight moreFields onlyNums">
                                                <ul>

                                                    <li class="sep">Discount Type &rArr;</li>
                                                    <li>
                                                        <select name="type">
                                                            <option value="percentage" <?php if ($type == 'percentage') {
    echo 'selected';
} ?>>Percentage</option>
                                                            <option value="fix" <?php if ($type == 'fix') {
    echo 'selected';
} ?>>Fix</option>
                                                        </select>
                                                    </li>
                                                    <li class="sep" style="margin-left:50px;">Promotion Amount &rArr;</li>
                                                    <li><input type="text" name="amount" value="<?php echo $amount; ?>" /></li>
                                                </ul>                                                                                                      </ul>  
                                            </div> 
                                            <div class="fix"></div>   
                                        </div>
                                        <p style="position:relative; bottom:30px; left: 180px; color: red;" id="showMessageChkbox"></p>


                                        <div class="rowElem noborder">
                                            <label>Expire Date:</label>
                                            <div class="formRight">
                                                <input type="text" name="expiery" value="<?php echo $expiery; ?>" class="datepicker" />
                                            </div>
                                            <div class="fix"></div>
                                        </div>


                                        <div class="rowElem noborder"><label>Code Status:</label><div class="formRight">
                                                <select name="status">
                                                    <option value="inactive" <?php if ($status == 'inactive') {
    echo 'selected';
} ?>>Inactive</option>
                                                    <option value="active" <?php if ($status == 'active') {
    echo 'selected';
} ?>>Active</option>
                                                    <option value="archive" <?php if ($status == 'archive') {
    echo 'selected';
} ?>>Archive</option>
                                                </select>
                                            </div><div class="fix"></div></div>



                                        <input type="submit" name="promotion_create" value="Submit" class="greyishBtn submitForm" />
                                        <div class="fix"></div>

                                    </div>
                                </fieldset>
                            </form>






                            <form action="<?php echo baseUrl('admin/promotion/promotion_edit.php?' . $_SERVER['QUERY_STRING']); ?>" method="post" class="mainForm" enctype="multipart/form-data">

                                <!-- Input text fields -->
                                <fieldset>
                                    <div class="widget first">
                                        <div class="head"><h5 class="iList">Add Discount Range</h5></div>

                                        <div class="rowElem">
                                            <label>Discount Option</label> 
                                            <div class="formRight moreFields">
                                                <ul>
                                                    <li class="sep">Min Range &rArr;</li>
                                                    <li><input type="text" name="min" value="<?php echo $min; ?>"  /></li>

                                                    <li class="sep">Max Range &rArr;</li>
                                                    <li><input type="text" name="max" value="<?php echo $max; ?>"  /></li>

                                                    <li class="sep">Amount &rArr;</li>
                                                    <li><input type="text" name="disamount" value="<?php echo $disamount; ?>"  /></li>
                                                </ul>  
                                            </div> 
                                            <div class="fix"></div>   
                                        </div>

                                        <input type="submit" name="range_create" value="Submit" class="greyishBtn submitForm" />
                                        <div class="fix"></div>

                                    </div>
                                </fieldset>
                            </form>


                        </div>
                    </div>
                </div>



                <div class="table">
                    <div class="head"><h5 class="iFrames">Promotion Code Range List</h5></div>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                        <thead>
                            <tr>
                                <th>Min Range</th>
                                <th>Max Range</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
<?php
$countArrayPromotionRange = count($arrayPromotionRange);
if ($countArrayPromotionRange > 0):
    ?>
    <?php for ($i = 0; $i < $countArrayPromotionRange; $i++): ?>
                                    <tr class="gradeA">
                                        <td><?php echo $arrayPromotionRange[$i]->PDR_discount_min_range; ?></td>
                                        <td><?php echo $arrayPromotionRange[$i]->PDR_discount_max_range; ?></td>
                                        <td><?php echo $arrayPromotionRange[$i]->PDR_discount_quantity; ?></td>
                                        <td class="center"><?php echo $arrayPromotionRange[$i]->PDR_status; ?></td>
                                        <td class="center">

                                            <a href="promotion_edit.php?pid=<?php echo $_GET['pid']; ?>&range_id=<?php echo base64_encode($arrayPromotionRange[$i]->PDR_id); ?>"><img src="<?php echo baseUrl('admin/images/pencil-grey-icon.png') ?>" height="14" width="14" alt="Edit" /></a>

                                        </td>
                                    </tr>
    <?php endfor; /* $i=0; i<$adminArrayCounter; $++  */ ?>
<?php endif; /* count($adminArray) > 0 */ ?>    
                        </tbody>
                    </table>
                </div>




            </div>
            <!-- Content End -->

            <div class="fix"></div>
        </div>
        <script>
            function test() {
                /*$.jGrowl('Hello world!');*/
                jConfirm('Can you confirm this?', 'Confirmation Dialog', function(r) {
                    jAlert('Confirmed: ' + r, 'Confirmation Results');
                });
            }
        </script>
<?php include basePath('admin/footer.php'); ?>
