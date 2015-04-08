<?php
include ('../../config/config.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}

//delete query here
if (isset($_REQUEST['del']) && isset($_REQUEST['option'])) {
    $del_configSettings_option = base64_decode($_REQUEST['option']);
    $configSettingsDeleleteSql = "delete from config_settings where CS_option='$del_configSettings_option'";
    $configSettingsDeleleteSqlResult = mysqli_query($con, $configSettingsDeleleteSql);
    if ($configSettingsDeleleteSqlResult) {
        $msg = "Setting Acount Successfully Deleted";
    } else {
        if (DEBUG) {
            $err = "configSettingsDeleleteSqlResult ERROR : " . mysqli_error($con);
        } else {
            $err = "Setting Information Not Deleted";
        }
    }
}
$configSettingsArray = array();
$configSettingsSql = "SELECT config_settings.CS_option,config_settings.CS_value,config_settings.CS_update_date,admins.admin_full_name FROM config_settings LEFT JOIN admins ON admins.admin_id=config_settings.CS_updated_by";
$configSettingsSqlResult = mysqli_query($con, $configSettingsSql);
if ($configSettingsSqlResult) {
    while ($configSettingsSqlResultRowObj = mysqli_fetch_object($configSettingsSqlResult)) {
        $configSettingsArray[] = $configSettingsSqlResultRowObj;
    }
    mysqli_free_result($configSettingsSqlResult);
} else {
    if (DEBUG) {
        echo 'configSettingsSqlResult Error : ' . mysqli_error($con);
    }
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>   
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
        <title>Admin Panel | Setting List</title>   
        <link href="<?php echo baseUrl('admin/css/main.css'); ?>" rel="stylesheet" type="text/css" /> 
        <script src="<?php echo baseUrl('admin/js/jquery.min.js'); ?>" type="text/javascript"></script>  
        <!--tree view -->  
        <script src="<?php echo baseUrl('admin/js/treeViewJquery.min.js'); ?>"></script> 
        <script src ="<?php echo baseUrl('admin/js/jquery-1.4.4.js'); ?>" type = "text / javascript" ></script>   
        <!--tree view --> 
        <!--Start admin panel js/css --> 
        <?php include basePath('admin/header.php'); ?>   
        <!--End admin panel js/css -->               

    </head>

    <body>

        <?php include basePath('admin/top_navigation.php'); ?>

        <?php include basePath('admin/module_link.php'); ?>


        <!-- Content wrapper -->
        <div class="wrapper">

            <!-- Left navigation -->
            <?php include 'settings_left_navigation.php'; ?>

            <!-- Content Start -->
            <div class="content">




                <div class="title"><h5>Setting Module </h5></div>

                <!-- Notification messages -->
                <?php include basePath('admin/message.php'); ?>
                <!-- Charts -->
                <div class="table">
                    <div class="head"><h5 class="iFrames">Setting List</h5></div>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                        <thead>
                            <tr>
                                <th>Option Name</th>
                                <th>Option Updated By</th>
                                <th>Option Updated Date</th>
                                <?php if (getSession('admin_email') == $config['MASTER_ADMIN_EMAIL']) { ?>
                                    <th>Action</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $configSettingsArrayCounter = count($configSettingsArray);
                            if ($configSettingsArrayCounter > 0):
                                for ($i = 0; $i < $configSettingsArrayCounter; $i++):
                                    ?><tr class="gradeA">
                                        <td><?php echo $configSettingsArray[$i]->CS_option; ?></td>
                                        <td><?php echo $configSettingsArray[$i]->admin_full_name; ?></td>
                                        <td><?php echo date_format(date_create($configSettingsArray[$i]->CS_update_date), 'Y jS M - g:i A'); ?></td>
                                        <?php if (getSession('admin_email') == $config['MASTER_ADMIN_EMAIL']) { ?>
                                            <td class="center">     
                                                <?php if (checkAdminAccess('settings_option_list.php?del=yes')): ?>
                                                    <a href="settings_option_list.php?del=yes && option=<?php echo base64_encode($configSettingsArray[$i]->CS_option); ?>"><img src="<?php echo baseUrl('admin/images/deleteFile.png'); ?>" height="14" width="14" alt="delete" onclick="return confirm('Are you sure want to delete?');" /></a>
                                                <?php endif; /* (checkAdminAccess('settings_option_list.php?del=yes')) */ ?>

                                            </td>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                endfor;
                            endif;
                            ?>

                        </tbody>
                    </table>
                </div>

            </div>


            <!-- Content End -->

            <div class="fix"></div>
        </div>

        <?php include basePath('admin/footer.php'); ?>
