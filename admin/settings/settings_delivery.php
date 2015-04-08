<?php
include ('../../config/config.php');
include basePath('lib/Zebra_Image.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}
//saving tags in database

extract($_POST);
$aid = getSession('admin_id'); //getting loggedin admin id

if (isset($_POST['update'])) {


    $setupdate = mysqli_query($con, "UPDATE `config_settings` SET `CS_value` = CASE `CS_option`
										WHEN 'MINIMUM_SHOPPING_AMOUNT' THEN '$MINIMUM_SHOPPING_AMOUNT'
										WHEN 'MINIMUM_SHOPPING_AMOUNT_CHARGE' THEN '$MINIMUM_SHOPPING_AMOUNT_CHARGE'
										WHEN 'EXPRESS_DELIVERY_CHARGE' THEN '$EXPRESS_DELIVERY_CHARGE'
										ELSE `CS_value`
										END");

    if ($setupdate) {
        $msg = "Delivery option updated successfully";
        //echo "<meta http-equiv='refresh' content='5; url=index.php'>";
    } else {
        $err = "Delivery option update failed";
    }
}




$responses['MINIMUM_SHOPPING_AMOUNT'] = get_option('MINIMUM_SHOPPING_AMOUNT');
$responses['MINIMUM_SHOPPING_AMOUNT_CHARGE'] = get_option('MINIMUM_SHOPPING_AMOUNT_CHARGE');
$responses['EXPRESS_DELIVERY_CHARGE'] = get_option('EXPRESS_DELIVERY_CHARGE');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
        <title>Admin Panel | Settings</title>

        <?php
        include basePath('admin/header.php');
        ?>
        <!--delete tags-->
        <script type="text/javascript">
            /*function del(pin_id1)
             {
             if(confirm('Are you sure to delete this tag!!'))
             {
             window.location='index.php?del='+pin_id1;
             }
             }*/
        </script>
        <!--end delete tags-->


    </head>

    <body>

        <?php include basePath('admin/top_navigation.php'); ?>

        <?php include basePath('admin/module_link.php'); ?>


        <!-- Content wrapper -->
        <div class="wrapper">

            <!-- Left navigation -->
            <?php include basePath('admin/settings/settings_left_navigation.php'); ?>

            <!-- Content Start -->
            <div class="content">
                <div class="title"><h5>Settings Module</h5></div>

                <!-- Notification messages -->
                <?php include basePath('admin/message.php'); ?>

                <!-- Charts -->
                <div class="widget first">
                    <div class="head">
                        <h5 class="iGraph">Website Settings</h5></div>
                    <div class="body">
                        <div class="charts" style="width: 700px; height: auto;">
                            <form action="settings_delivery.php" method="post" class="mainForm" enctype="multipart/form-data">

                                <!-- Input text fields -->
                                <fieldset>
                                    <div class="widget first">
                                        <div class="head"><h5 class="iList">Website Settings</h5></div>

                                        <div class="rowElem noborder"><label>Minimum Shopping Amount:</label><div class="formRight"><input name="MINIMUM_SHOPPING_AMOUNT" type="text" value="<?php echo ($responses['MINIMUM_SHOPPING_AMOUNT']); ?>"/></div><div class="fix"></div></div>
                                        <div class="rowElem noborder"><label>Minimum Shopping Amount Delivery Charge:</label><div class="formRight"><input name="MINIMUM_SHOPPING_AMOUNT_CHARGE" type="text" value="<?php echo ($responses['MINIMUM_SHOPPING_AMOUNT_CHARGE']); ?>"/></div><div class="fix"></div></div>
                                        <div class="rowElem noborder"><label>Express Delivery Charge:</label><div class="formRight"><input name="EXPRESS_DELIVERY_CHARGE" type="text" value="<?php echo ($responses['EXPRESS_DELIVERY_CHARGE']); ?>"/></div><div class="fix"></div></div>
                                        
                                        <input type="submit" name="update" value="Update Settings" class="greyishBtn submitForm" />
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
