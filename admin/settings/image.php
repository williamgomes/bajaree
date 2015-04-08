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
										WHEN 'CATEGORY_BANNER_MIN_WIDTH' THEN '$CATEGORY_BANNER_MIN_WIDTH'
										WHEN 'CATEGORY_BANNER_MAX_WIDTH' THEN '$CATEGORY_BANNER_MAX_WIDTH'
										WHEN 'CATEGORY_PROMOTION_MIN_WIDTH' THEN '$CATEGORY_PROMOTION_MIN_WIDTH'
										WHEN 'CATEGORY_PROMOTION_MAX_WIDTH' THEN '$CATEGORY_PROMOTION_MAX_WIDTH'
										WHEN 'PRODUCT_LARGE_IMAGE_WIDTH' THEN '$PRODUCT_LARGE_IMAGE_WIDTH'
										WHEN 'PRODUCT_MEDIUM_IMAGE_WIDTH' THEN '$PRODUCT_MEDIUM_IMAGE_WIDTH'
										WHEN 'PRODUCT_SMALL_IMAGE_WIDTH' THEN '$PRODUCT_SMALL_IMAGE_WIDTH'
										ELSE `CS_value`
										END");

    if ($setupdate) {
        $msg = "Size updated successfully";
        //echo "<meta http-equiv='refresh' content='5; url=index.php'>";
    } else {
        $err = "Size update failed";
    }
}




$responses['CATEGORY_BANNER_MIN_WIDTH'] = get_option('CATEGORY_BANNER_MIN_WIDTH');
$responses['CATEGORY_BANNER_MAX_WIDTH'] = get_option('CATEGORY_BANNER_MAX_WIDTH');
$responses['CATEGORY_PROMOTION_MIN_WIDTH'] = get_option('CATEGORY_PROMOTION_MIN_WIDTH');
$responses['CATEGORY_PROMOTION_MAX_WIDTH'] = get_option('CATEGORY_PROMOTION_MAX_WIDTH');
$responses['PRODUCT_LARGE_IMAGE_WIDTH'] = get_option('PRODUCT_LARGE_IMAGE_WIDTH');
$responses['PRODUCT_MEDIUM_IMAGE_WIDTH'] = get_option('PRODUCT_MEDIUM_IMAGE_WIDTH');
$responses['PRODUCT_SMALL_IMAGE_WIDTH'] = get_option('PRODUCT_SMALL_IMAGE_WIDTH');
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
                            <form action="image.php" method="post" class="mainForm" enctype="multipart/form-data">

                                <!-- Input text fields -->
                                <fieldset>
                                    <div class="widget first">
                                        <div class="head"><h5 class="iList">Website Settings</h5></div>

                                        <div class="rowElem noborder"><label>Category Banner Min Width:</label><div class="formRight"><input name="CATEGORY_BANNER_MIN_WIDTH" type="text" value="<?php echo ($responses['CATEGORY_BANNER_MIN_WIDTH']); ?>"/></div><div class="fix"></div></div>
                                        <div class="rowElem noborder"><label>Category Banner Max Width:</label><div class="formRight"><input name="CATEGORY_BANNER_MAX_WIDTH" type="text" value="<?php echo ($responses['CATEGORY_BANNER_MAX_WIDTH']); ?>"/></div><div class="fix"></div></div>
                                        <div class="rowElem noborder"><label>Category Promotion Min Width:</label><div class="formRight"><input name="CATEGORY_PROMOTION_MIN_WIDTH" type="text" value="<?php echo ($responses['CATEGORY_PROMOTION_MIN_WIDTH']); ?>"/></div><div class="fix"></div></div>
                                        <div class="rowElem noborder"><label>Category Promotion Max Width:</label><div class="formRight"><input name="CATEGORY_PROMOTION_MAX_WIDTH" type="text" value="<?php echo ($responses['CATEGORY_PROMOTION_MAX_WIDTH']); ?>"/></div><div class="fix"></div></div>
                                        <div class="rowElem noborder"><label>Product Large Image Width:</label><div class="formRight"><input name="PRODUCT_LARGE_IMAGE_WIDTH" type="text" value="<?php echo ($responses['PRODUCT_LARGE_IMAGE_WIDTH']); ?>"/></div><div class="fix"></div></div>
                                        <div class="rowElem noborder"><label>Product Medium Image Width:</label><div class="formRight"><input name="PRODUCT_MEDIUM_IMAGE_WIDTH" type="text" value="<?php echo ($responses['PRODUCT_MEDIUM_IMAGE_WIDTH']); ?>"/></div><div class="fix"></div></div>
                                        <div class="rowElem noborder"><label>Product Small Image Width:</label><div class="formRight"><input name="PRODUCT_SMALL_IMAGE_WIDTH" type="text" value="<?php echo ($responses['PRODUCT_SMALL_IMAGE_WIDTH']); ?>"/></div><div class="fix"></div></div>

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
