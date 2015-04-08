<?php
include ('../../config/config.php');

if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>   
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
        <title>Admin Panel | File Manager</title>   
        <link href="<?php echo baseUrl('admin/css/main.css'); ?>" rel="stylesheet" type="text/css" /> 
        <script src="<?php echo baseUrl('admin/js/jquery.min.js'); ?>" type="text/javascript"></script>  
        <!--        Start lightBox -->
        <script src="<?php echo baseUrl('js/lightbox/jquery-1.7.2.min.js'); ?>"></script>
        <script src="<?php echo baseUrl('js/lightbox/jquery-ui-1.8.18.custom.min.js'); ?>"></script>
        <script src="<?php echo baseUrl('js/lightbox/jquery.smooth-scroll.min.js'); ?>"></script>
        <script src="<?php echo baseUrl('js/lightbox/lightbox.js'); ?>"></script>
        <link rel="stylesheet" href="<?php echo baseUrl('css/lightbox/lightbox.css'); ?>" type="text/css" media="screen" />
        <!--        End lightBox --> 
        <!--tree view -->  
        <script src="<?php echo baseUrl('admin/js/treeViewJquery.min.js'); ?>"></script> 
        <script src ="<?php echo baseUrl('admin/js/jquery-1.4.4.js'); ?>" type = "text / javascript" ></script>   
        <!--tree view --> 
        <!--Start admin panel js/css --> 
        <?php include basePath('admin/header.php'); ?>   
        <!--End admin panel js/css -->               
        <style>
        </style>
    </head>

    <body>

        <?php include basePath('admin/top_navigation.php'); ?>

        <?php include basePath('admin/module_link.php'); ?>


        <!-- Content wrapper -->
        <div class="wrapper">

            <!-- Left navigation -->
            <?php include (basePath('admin/file_manager/left_navigation.php')); ?>

            <!-- Content Start -->
            <div class="content">




                <div class="title"><h5>File Manager Module </h5></div>

                <!-- Notification messages -->
                <?php include basePath('admin/message.php'); ?>
                <!-- Charts -->

                <!-- File manager -->        
                <div class="widget first">
                    <div class="head"><h5 class="iFiles">File manager</h5></div>
                    <div id="fileManager"></div>
                </div>

            </div>


            <!-- Content End -->

            <div class="fix"></div>
        </div>
        <?php include basePath('admin/footer.php'); ?>