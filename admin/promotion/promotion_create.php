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
$min = 0;
$max = 0;
$expiery = '';
$amount = '';
$type = '';
$PromotionID = '';

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
    } elseif ($amount == '') {
        $err = 'Discount Amount is required!!';
    } elseif ($suffix == '' AND $count == '') {
        $err = '"How many code?" field is required.';
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

        $status = '';
        if (isset($_POST['predefine']) AND $_POST['predefine'] == 'yes') {
            $status = 'inactive';
        } else {
            $status = 'active';
        }

        $addPromotion = '';
        $addPromotion .=' promotion_title = "' . mysqli_real_escape_string($con, $title) . '"';
        $addPromotion .=', promotion_description = "' . mysqli_real_escape_string($con, $desc) . '"';
        $addPromotion .=', promotion_image = "' . mysqli_real_escape_string($con, $UploadedImage) . '"';
        $addPromotion .=', promotion_code_prefix = "' . mysqli_real_escape_string($con, $prefix) . '"';
        if (isset($_POST['predefine']) AND $_POST['predefine'] == 'yes') {
            $addPromotion .=', promotion_code_predefined_user = "' . mysqli_real_escape_string($con, $predefine) . '"';
        }
        $addPromotion .=', promotion_discount_type = "' . mysqli_real_escape_string($con, $type) . '"';
        $addPromotion .=', promotion_expire = "' . mysqli_real_escape_string($con, $expire_date) . '"';
        $addPromotion .=', promotion_status = "' . mysqli_real_escape_string($con, $status) . '"';

        $sqlAddPromotion = "INSERT INTO promotions SET $addPromotion";
        $executeAddPromotion = mysqli_query($con, $sqlAddPromotion);
        if ($executeAddPromotion) {
            $PromotionID = mysqli_insert_id($con);
        } else {
            $errorCheck += 1;
            if (DEBUG) {
                $err = 'executeAddPromotion error: ' . mysqli_error($con);
            }
        }


        if ($suffix == '') {
          if ($count == '') {
            $err = '"How many code?" field is required.';
          } else {
            for ($x = 1; $x <= $count; $x++) {
              $addPromotionCodes = '';
              $addPromotionCodes .=' PC_promotion_id = "' . mysqli_real_escape_string($con, $PromotionID) . '"';
              $addPromotionCodes .=', PC_code_prefix = "' . mysqli_real_escape_string($con, $prefix) . '"';
              $addPromotionCodes .=', PC_code_suffix = "' . mysqli_real_escape_string($con, $x) . '"';
              $addPromotionCodes .=', PC_code_status = "' . mysqli_real_escape_string($con, $status) . '"';

              $sqlAddPromotionCodes = "INSERT INTO promotion_codes SET $addPromotionCodes";
              $executeAddPromotionCodes = mysqli_query($con, $sqlAddPromotionCodes);
              if ($executeAddPromotionCodes) {
                  //$msg = 'Promotion Code Added Successfully';
              } else {
                $errorCheck += 1;
                if (DEBUG) {
                    $err = 'executeAddPromotionCodes error: ' . mysqli_error($con);
                }
              }
            }
          }
        } else if ($suffix != ''){
          $addPromotionCodes = '';
          $addPromotionCodes .=' PC_promotion_id = "' . mysqli_real_escape_string($con, $PromotionID) . '"';
          $addPromotionCodes .=', PC_code_prefix = "' . mysqli_real_escape_string($con, $prefix) . '"';
          $addPromotionCodes .=', PC_code_suffix = "' . mysqli_real_escape_string($con, $suffix) . '"';
          $addPromotionCodes .=', PC_code_status = "' . mysqli_real_escape_string($con, $status) . '"';

          $sqlAddPromotionCodes = "INSERT INTO promotion_codes SET $addPromotionCodes";
          $executeAddPromotionCodes = mysqli_query($con, $sqlAddPromotionCodes);
          if ($executeAddPromotionCodes) {
              //$msg = 'Promotion Code Added Successfully';
          } else {
              $errorCheck += 1;
              if (DEBUG) {
                  $err = 'executeAddPromotionCodes error: ' . mysqli_error($con);
              }
          }
        }


        $addPromotionRange = '';
        $addPromotionRange .=' PDR_promotion_id = "' . mysqli_real_escape_string($con, $PromotionID) . '"';
        $addPromotionRange .=', PDR_discount_type = "' . mysqli_real_escape_string($con, $type) . '"';
        $addPromotionRange .=', PDR_discount_min_range = "' . mysqli_real_escape_string($con, $min) . '"';
        $addPromotionRange .=', PDR_discount_max_range = "' . mysqli_real_escape_string($con, $max) . '"';
        $addPromotionRange .=', PDR_discount_quantity = "' . mysqli_real_escape_string($con, $amount) . '"';
        $addPromotionRange .=', PDR_status = "' . mysqli_real_escape_string($con, $status) . '"';

        $sqlPromotionRange = "INSERT INTO promotion_discount_range SET $addPromotionRange";
        $executePromotionRange = mysqli_query($con, $sqlPromotionRange);
        if ($executePromotionRange) {
            //$msg = 'Promotion Code Added Successfully';
        } else {
            $errorCheck += 1;
            if (DEBUG) {
                $err = 'executeAddPromotionCodes error: ' . mysqli_error($con);
            }
        }

        if ($errorCheck == 0) {
            $msg = 'Promotion information saved successfully.';
            $link = 'index.php';
            redirect($link);
        } else {
            $err = 'Promotion information save failed.';
        }
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
        <title>Admin panel: Promotion Create</title>


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
                        <h5 class="iGraph">Create Promotion </h5></div>
                    <div class="body">
                        <div class="charts" style="width: 700px; height: auto;">
                            <form action="<?php echo baseUrl('admin/promotion/promotion_create.php'); ?>" method="post" class="mainForm" enctype="multipart/form-data">

                                <!-- Input text fields -->
                                <fieldset>
                                    <div class="widget first">
                                        <div class="head"><h5 class="iList">Promotion Code Information</h5></div>

                                        <div class="rowElem noborder"><label>Promotion Title:</label><div class="formRight">
                                                <input type="text" name="title" value="<?php echo $title; ?>"  />
                                            </div><div class="fix"></div></div>

                                        <div class="rowElem noborder"><label>Promotion Image:</label><div class="formRight">
                                                <input type="file" name="image"/>
                                            </div><div class="fix"></div></div>

                                        <div class="head"><h5 class="iPencil">Promotion Description:</h5></div>      
                                        <div><textarea class="tm" rows="5" cols="" name="desc"><?php echo $desc; ?></textarea></div>


                                        <div class="rowElem">
                                            <label>Code Options</label> 
                                            <div class="formRight moreFields">
                                                <ul>
                                                    <li class="sep">Code Prefix &rArr;</li>
                                                    <li><input type="text" name="prefix" value="<?php echo $prefix; ?>" /></li>
                                                    <li class="sep">Code Suffix &rArr;</li>
                                                    <li><input type="text" name="suffix"  value="<?php echo $suffix; ?>" id="codeSuffix" onkeyup="checkSuffix();" onchange="checkSuffix();" /></li>
                                                    <div id="getcount">
                                                        <?php if ($suffix == '') { ?>
                                                            <li class="sep">How many code? &rArr;</li>
                                                            <li><input type="text" name="count" maxlength="4"  value="<?php echo $count; ?>" /></li>
                                                            <br /><br /><br />
                                                            <li class="sep">User Predefined? &rArr;</li>
                                                            <li style="position:relative; left:-15px; bottom:5px;"><input type="checkbox" name="predefine" value="yes" /><p style="bottom:20px; position:relative; left:30px;">Yes</p></li>
                                                        <?php } ?>
                                                    </div>
                                                </ul>  
                                            </div> 
                                            <div class="fix"></div>   
                                        </div>


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
                                                </ul>                                                                                                       
                                            </div> 
                                            <div class="fix"></div>   
                                        </div>


                                        <div class="rowElem noborder">
                                            <label>Expire Date:</label>
                                            <div class="formRight">
                                                <input type="text" name="expiery" value="<?php echo $expiery; ?>" class="datepicker" />
                                            </div>
                                            <div class="fix"></div>
                                        </div>


                                        <input type="submit" name="promotion_create" value="Submit" class="greyishBtn submitForm" />
                                        <div class="fix"></div>

                                    </div>
                                </fieldset>
                            </form>


                        </div>
                    </div>
                </div>

            </div>
            <!-- Content End -->

            <div class="fix"></div>
        </div>

<?php include basePath('admin/footer.php'); ?>
