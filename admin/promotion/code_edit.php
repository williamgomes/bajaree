<?php
include ('../../config/config.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}

$prefix = '';
$suffix = '';
$email = '';
$order = '';
$status = '';
$discount = '';
$PromotionCode = 0;
$PromotionID = 0;



$promoTitle = '';
$expireDate = '';
$discountType = '';
$status = '';

//getting promotion code id from URL
if (isset($_GET['cid']) AND $_GET['cid'] != '') {
    $PromotionCode = base64_decode($_GET['cid']);
}


if (isset($_POST['update_code'])) {
    extract($_POST);
    if ($email != '' AND !isValidEmail($email)) {
        $err = 'User Email is not valid';
    } else {
        $updateCode = '';
        $updateCode .=' PC_code_used_email = "' . mysqli_real_escape_string($con, $email) . '"';
        $updateCode .=', PC_code_used_order_number = "' . mysqli_real_escape_string($con, $order) . '"';
        $updateCode .=', PC_code_status = "' . mysqli_real_escape_string($con, $status) . '"';

        $updatePromoCode = "UPDATE promotion_codes SET $updateCode WHERE PC_id=$PromotionCode";
        $executeUpdatePromoCode = mysqli_query($con, $updatePromoCode);
        if ($executeUpdatePromoCode) {
            $msg = 'Promotion Code updated successfully.';
            $link = 'code_list.php?pid=' . $_GET['pid'] . '&msg=' . base64_encode($msg);
            redirect($link);
        } else {
            $err = 'Promotion Code update failed.';
            if (DEBUG) {
                echo 'executeUpdatePromoCode error: ' . mysqli_error($con);
            }
        }
    }
}

$sqlPromoCode = "SELECT * FROM promotion_codes WHERE PC_id=$PromotionCode";
$executePromoCode = mysqli_query($con, $sqlPromoCode);
if ($executePromoCode) {
    $getPromoCode = mysqli_fetch_object($executePromoCode);
    if (isset($getPromoCode->PC_id)) {
        $prefix = $getPromoCode->PC_code_prefix;
        $suffix = $getPromoCode->PC_code_suffix;
        $email = $getPromoCode->PC_code_used_email;
        $order = $getPromoCode->PC_code_used_order_number;
        $status = $getPromoCode->PC_code_status;
        $discount = $getPromoCode->PC_code_discount_gain;
        $PromotionID = $getPromoCode->PC_promotion_id;
    }
}

$sqlPromotion = "SELECT * FROM promotions WHERE promotion_id=$PromotionID";
$executePromotion = mysqli_query($con, $sqlPromotion);
if ($executePromotion) {
    $getPromotion = mysqli_fetch_object($executePromotion);
    if (isset($getPromotion->promotion_id)) {
        $promoTitle = $getPromotion->promotion_title;
        $expireDate = $getPromotion->promotion_expire;
        $discountType = $getPromotion->promotion_discount_type;
        $status = $getPromotion->promotion_status;
        $predefine = $getPromotion->promotion_code_predefined_user;
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
        <title>Admin panel: Promotion Code Edit</title>



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
                                //alert(output); 
                                var result2 = $.parseJSON(output2);
                                if (result2.error == 0) {
                                    $.jGrowl('All codes will be updated!');
                                } else if (result2.error == 1) {
                                    $.jGrowl('You can\'t update codes!');
                                    $('#checkBox').prop('checked', true);
                                    /*var defaultValue = $('#defaultCount').val();
                                     $('#countCheck').val(defaultValue);*/
                                } else if (result2.error == 2) {
                                    $.jGrowl('You can\'t update codes!');
                                    $('#checkBox').prop('checked', true);
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
                        <h5 class="iGraph">Edit Promotion Code</h5></div>
                    <div class="body">
                        <div class="charts" style="width: 700px; height: auto;">
                            <form action="<?php echo baseUrl('admin/promotion/code_edit.php?cid=' . $_GET['cid'] . '&pid=' . $_GET['pid']); ?>" method="post" class="mainForm" enctype="multipart/form-data">

                                <!-- Input text fields -->
                                <fieldset>
                                    <div class="widget first">
                                        <div class="head"><h5 class="iList">Edit Promotion Code</h5></div>

                                        <br />

                                        <div class="head"><h5 class="iChart8">Promotion Details</h5></div>

                                        <table cellpadding="0" cellspacing="0" width="100%" class="tableStatic">

                                            <thead>

                                                <tr>

                                                    <td width="25%">Title</td>

                                                    <td width="25%">Value</td>

                                                    <td width="25%">Title</td>

                                                    <td width="25%">Value</td>

                                                </tr>

                                            </thead>

                                            <tbody>

                                                <tr>

                                                    <td>Promotion Title:</td>

                                                    <td><strong><?php echo $promoTitle; ?></strong></td>

                                                    <td>Expire Date:</td>

                                                    <td><strong><?php echo date("d-m-Y", strtotime($expireDate)); ?></strong></td>

                                                </tr>

                                                <tr>

                                                    <td>Discount Type:</td>

                                                    <td><strong><?php echo $discountType; ?></strong></td>

                                                    <td>Status:</td>

                                                    <td><strong><?php echo $status; ?></strong></td>

                                                </tr>

                                            </tbody> 

                                        </table>                    


                                        <br />

                                        <div class="rowElem noborder"><label>Code No.</label><div class="formRight">
                                                <?php echo $prefix; ?><?php echo $suffix; ?>
                                            </div><div class="fix"></div></div>

                                        <?php if ($predefine == 'yes') { ?>
                                            <div class="rowElem noborder"><label>User Email:</label><div class="formRight">
                                                    <input type="text" name="email" value="<?php echo $email; ?>" />
                                                </div><div class="fix"></div></div>
                                        <?php } ?>

                                        <div class="rowElem">
                                            <label>Code Options</label> 
                                            <div class="formRight moreFields">
                                                <ul>
                                                    <li class="sep">Order No. &rArr;</li>
                                                    <li><input type="text" name="order" value="<?php echo $order; ?>" /></li>

                                                    <li class="sep">Discount Gain &rArr;</li>
                                                    <li><?php if ($discount > 0) { ?>
                                                            <?php echo $discount; ?>
                                                        <?php } else { ?>    
                                                            <input type="text" name="title" value="<?php echo $discount; ?>" />
                                                        <?php } ?>
                                                    </li>

                                                    <li class="sep">Code Status &rArr;</li>
                                                    <li>
                                                        <select name="status">
                                                            <option value="inactive" <?php if ($status == 'inactive') {
                                                            echo 'selected';
                                                        } ?>>Inactive</option>
                                                            <option value="active" <?php if ($status == 'active') {
                                                            echo 'selected';
                                                        } ?>>Active</option>
                                                            <option value="applied" <?php if ($status == 'applied') {
                                                            echo 'selected';
                                                        } ?>>Applied</option>
                                                            <option value="used" <?php if ($status == 'used') {
                                                            echo 'selected';
                                                        } ?>>Used</option>
                                                            <option value="archive" <?php if ($status == 'archive') {
                                                            echo 'selected';
                                                        } ?>>Archive</option>
                                                        </select>
                                                    </li>

                                            </div>
                                            </ul>  
                                        </div> 
                                        <div class="fix"></div>   
                                    </div>




                                    <!-- <div class="rowElem noborder"><label>:</label><div class="formRight">
                                     
                                     </div><div class="fix"></div></div>
                                     
                                     <div class="rowElem noborder"><label>:</label><div class="formRight">
                                     
                                     </div><div class="fix"></div></div>
                                     
                                     
                                     <div class="rowElem noborder"><label>Code Status:</label><div class="formRight">
                                     <select name="status">
                                         <option value="inactive" <?php if ($status == 'inactive') {
                                                            echo 'selected';
                                                        } ?>>Inactive</option>
                                         <option value="active" <?php if ($status == 'active') {
                                                            echo 'selected';
                                                        } ?>>Active</option>
                                         <option value="applied" <?php if ($status == 'applied') {
                                                            echo 'selected';
                                                        } ?>>Applied</option>
                                         <option value="used" <?php if ($status == 'used') {
                                                            echo 'selected';
                                                        } ?>>Used</option>
                                         <option value="archive" <?php if ($status == 'archive') {
                                                            echo 'selected';
                                                        } ?>>Archive</option>
                                     </select>
                                     </div><div class="fix"></div></div>-->



                                    <input type="submit" name="update_code" value="Update" class="greyishBtn submitForm" />
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
        <script>
            function test() {
                /*$.jGrowl('Hello world!');*/
                jConfirm('Can you confirm this?', 'Confirmation Dialog', function(r) {
                    jAlert('Confirmed: ' + r, 'Confirmation Results');
                });
            }
        </script>
<?php include basePath('admin/footer.php'); ?>
