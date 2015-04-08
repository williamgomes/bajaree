<?php
include ('../../config/config.php');
include basePath('lib/Zebra_Image.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}
//saving tags in database


$aid = getSession('admin_id'); //getting loggedin admin id

$smtpserver = '';
$smtpport = '';
$hostingid = '';
$hostingpass = '';
$generalemail = '';



if (isset($_POST['update'])) {
    extract($_POST);
    if ($smtpserver == '') {
        $err = "SMTP Server Address is required.";
    } elseif ($smtpport == '') {
        $err = "SMTP Port No. is required.";
    } elseif ($hostingid == '') {
        $err = "Hosting Server ID is required.";
    } elseif ($hostingpass == '') {
        $err = "Hosting Server Pass is required.";
    } elseif ($generalemail == '') {
        $err = "General Email Address is required.";
    } else {

        $setupdate = mysqli_query($con, "UPDATE `config_settings` SET `CS_value` = CASE `CS_option`
										WHEN 'SMTP_SERVER_ADDRESS' THEN '$smtpserver'
										WHEN 'SMTP_PORT_NO' THEN '$smtpport'
										WHEN 'HOSTING_ID' THEN '$hostingid'
										WHEN 'HOSTING_PASS' THEN '$hostingpass'
										WHEN 'EMAIL_ADDRESS_GENERAL' THEN '$generalemail'
										ELSE `CS_value`
										END");

        if ($setupdate) {
            $msg = "Email Settings updated successfully";
        } else {
            $err = "Email Settings update failed";
        }
    }
}



$options = array();
$fields = "'SMTP_SERVER_ADDRESS','SMTP_PORT_NO','HOSTING_ID','HOSTING_PASS','EMAIL_ADDRESS_GENERAL'";
$susFieldsSql = "SELECT CS_option,CS_value FROM config_settings WHERE CS_option IN ($fields)";
$susFieldsResult = mysqli_query($con, $susFieldsSql);
if ($susFieldsResult) {
    while ($susFieldsResultRowObj = mysqli_fetch_object($susFieldsResult)) {
        $options[$susFieldsResultRowObj->CS_option] = $susFieldsResultRowObj->CS_value;
    }
} else {
    if (DEBUG) {
        $err = "susFieldsResult error" . mysqli_error($con);
    } else {
        $err = "susFieldsResult query failed";
    }
}

$smtpserver = $options['SMTP_SERVER_ADDRESS'];
$smtpport = $options['SMTP_PORT_NO'];
$hostingid = $options['HOSTING_ID'];
$hostingpass = $options['HOSTING_PASS'];
$generalemail = $options['EMAIL_ADDRESS_GENERAL'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
        <title>Admin Panel | Settings Phpmailer </title>

        <link href="<?php echo baseUrl('admin/css/main.css'); ?>" rel="stylesheet" type="text/css" />
        <link href='http://fonts.googleapis.com/css?family=Cuprum' rel='stylesheet' type='text/css' />
        <script src="<?php echo baseUrl('admin/js/jquery-1.4.4.js'); ?>" type="text/javascript"></script>
        <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, File upload, editor -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/spinner/ui.spinner.js'); ?>"></script>
        <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/jquery-ui.min.js'); ?>"></script>  
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/fileManager/elfinder.min.js'); ?>"></script>
        <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, File upload -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/wysiwyg/jquery.wysiwyg.js'); ?>"></script>
        <!--Effect on wysiwyg editor -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/wysiwyg/wysiwyg.image.js'); ?>"></script>
        <!--Effect on wysiwyg editor -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/wysiwyg/wysiwyg.link.js'); ?>"></script>
        <!--Effect on wysiwyg editor -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/wysiwyg/wysiwyg.table.js'); ?>"></script>
        <!--Effect on wysiwyg editor -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/dataTables/jquery.dataTables.js'); ?>"></script>
        <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/dataTables/colResizable.min.js'); ?>"></script>
        <!--Effect on left error menu, top message menu -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/forms/forms.js'); ?>"></script>
        <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/forms/autogrowtextarea.js'); ?>"></script>
        <!--Effect on left error menu, top message menu, File upload -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/forms/autotab.js'); ?>"></script>
        <!--Effect on left error menu, top message menu -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/forms/jquery.validationEngine.js'); ?>"></script>
        <!--Effect on left error menu, top message menu-->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/colorPicker/colorpicker.js'); ?>"></script>
        <!--Effect on left error menu, top message menu -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/uploader/plupload.js'); ?>"></script>
        <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, File upload -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/uploader/plupload.html5.js'); ?>"></script>
        <!--Effect on file upload-->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/uploader/plupload.html4.js'); ?>"></script>
        <!--No effect-->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/uploader/jquery.plupload.queue.js'); ?>"></script>
        <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, File upload -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/ui/jquery.tipsy.js'); ?>"></script>
        <!--Effect on left error menu, top message menu,  -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/jBreadCrumb.1.1.js'); ?>"></script>
        <!--Effect on left error menu, File upload -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/cal.min.js'); ?>"></script>
        <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/jquery.collapsible.min.js'); ?>"></script>
        <!--Effect on left error menu, File upload -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/jquery.ToTop.js'); ?>"></script>
        <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/jquery.listnav.js'); ?>"></script>
        <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/jquery.sourcerer.js'); ?>"></script>
        <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/custom.js'); ?>"></script>
        <!--Effect on left error menu, top message menu, body-->
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
                        <h5 class="iGraph">Phpmailer Settings</h5></div>
                    <div class="body">
                        <div class="charts" style="width: 700px; height: auto;">
                            <form action="phpmailer_setting.php" method="post" class="mainForm" enctype="multipart/form-data">


                                <!-- Input text fields -->
                                <fieldset>
                                    <div class="widget first">
                                        <div class="head"><h5 class="iList">Phpmailer  Settings</h5></div>

                                        <div class="rowElem noborder"><label>SMTP Port No.: *</label><div class="formRight"><input name="smtpport" type="text" value="<?php echo $smtpport; ?>"/></div><div class="fix"></div>
                                            <span style="position:relative; left:160px;"><em></em></span>
                                        </div>

                                        <div class="rowElem noborder"><label>SMTP Server Address: *</label><div class="formRight"><input name="smtpserver" type="text" value="<?php echo $smtpserver; ?>"/></div><div class="fix"></div>
                                            <span style="position:relative; left:160px;"><em></em></span>
                                        </div>

                                        <div class="rowElem noborder"><label>Hosting Server ID: *</label><div class="formRight"><input name="hostingid" type="text" value="<?php echo $hostingid; ?>"/></div><div class="fix"></div>
                                            <span style="position:relative; left:160px;"><em></em></span>
                                        </div>

                                        <div class="rowElem noborder"><label>Hosting Server Pass: *</label><div class="formRight"><input name="hostingpass" type="text" value="<?php echo $hostingpass; ?>"/></div><div class="fix"></div>
                                            <span style="position:relative; left:160px;"><em></em></span>
                                        </div>

                                        <div class="rowElem noborder"><label>General Email Address: *</label><div class="formRight"><input name="generalemail" type="text" value="<?php echo $generalemail; ?>"/></div><div class="fix"></div>
                                            <span style="position:relative; left:160px;"><em></em></span>
                                        </div>
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
