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
										WHEN 'FACEBOOK_LINK' THEN '$FACEBOOK_LINK'
										WHEN 'TWITTER_LINK' THEN '$TWITTER_LINK'
										WHEN 'GOOGLE_PLUS_LINK' THEN '$GOOGLE_PLUS_LINK'
										WHEN 'LINKEDIN_LINK' THEN '$LINKEDIN_LINK'
										WHEN 'PINTEREST_LINK' THEN '$PINTEREST_LINK'
										ELSE `CS_value`
										END");

    if ($setupdate) {
        $msg = "Social Settings updated successfully";
        //echo "<meta http-equiv='refresh' content='5; url=index.php'>";
    } else {
        $err = "Social Settings update failed";
    }
}




$responses['FACEBOOK_LINK'] = get_option('FACEBOOK_LINK');
$responses['TWITTER_LINK'] = get_option('TWITTER_LINK');
$responses['GOOGLE_PLUS_LINK'] = get_option('GOOGLE_PLUS_LINK');
$responses['LINKEDIN_LINK'] = get_option('LINKEDIN_LINK');
$responses['PINTEREST_LINK'] = get_option('PINTEREST_LINK');
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
                            <form action="social_settings.php" method="post" class="mainForm" enctype="multipart/form-data">

                                <!-- Input text fields -->
                                <fieldset>
                                    <div class="widget first">
                                        <div class="head"><h5 class="iList">Website Settings</h5></div>

                                        <div class="rowElem noborder"><label>Facebook Link:</label><div class="formRight"><input name="FACEBOOK_LINK" type="text" value="<?php echo ($responses['FACEBOOK_LINK']); ?>"/></div><div class="fix"></div></div>
                                        <div class="rowElem noborder"><label>Twitter Link:</label><div class="formRight"><input name="TWITTER_LINK" type="text" value="<?php echo ($responses['TWITTER_LINK']); ?>"/></div><div class="fix"></div></div>
                                        <div class="rowElem noborder"><label>Google+ Link:</label><div class="formRight"><input name="GOOGLE_PLUS_LINK" type="text" value="<?php echo ($responses['GOOGLE_PLUS_LINK']); ?>"/></div><div class="fix"></div></div>
                                        <div class="rowElem noborder"><label>Linkedin Link:</label><div class="formRight"><input name="LINKEDIN_LINK" type="text" value="<?php echo ($responses['LINKEDIN_LINK']); ?>"/></div><div class="fix"></div></div>
                                        <div class="rowElem noborder"><label>Pinterest Link:</label><div class="formRight"><input name="PINTEREST_LINK" type="text" value="<?php echo ($responses['PINTEREST_LINK']); ?>"/></div><div class="fix"></div></div>
                                        
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
