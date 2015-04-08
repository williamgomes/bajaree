<?php
include ('../../config/config.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}
if (isset($_REQUEST['id'])) {
    $image_id = base64_decode($_REQUEST['id']);

    $thumbSql = "SELECT CB_image_name,CB_title, CB_id FROM company_banners WHERE CB_id=" . intval($image_id);

    $thumbSqlResult = mysqli_query($con, $thumbSql);
    if ($thumbSqlResult) {
        $thumbSqlResultRowObj = mysqli_fetch_object($thumbSqlResult);
        if (isset($thumbSqlResultRowObj->CB_id)) {
            $thumbSqlResultRowObj->CB_image_name;
        }
        mysqli_free_result($thumbSqlResult);
    } else {
        if (DEBUG) {
            echo "thumbSqlResultRowObj error" . mysqli_error($con);
        }
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>   
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
        <title>Admin Panel | Banner Image</title>   
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
            <?php include ('company_banner_left_navigation.php'); ?>

            <!-- Content Start -->
            <div class="content">
                <div class="title"><h5>Banner Image Show</h5></div>

                <!-- Notification messages -->
                <?php include basePath('admin/message.php'); ?>
                <!-- Charts -->
                <div class="widget first">
                    <div class="head">
                        <h5 class="iGraph">Image</h5></div>
                    <div class="body">
                        <div class="charts" style="width: 700px; height: auto;">
                            <form action="<?php echo baseUrl('admin/company_banner/banner_full_image.php'); ?>" method="post" enctype="multipart/form-data" class="mainForm">

                                <!-- Input text fields -->
                                <fieldset>
                                    <div class="widget first">
                                        <a href="#"><img style="max-width: 700px;" src="<?php echo $config['IMAGE_UPLOAD_URL'] . '/CB_banner/' . $thumbSqlResultRowObj->CB_image_name; ?>" alt="main image " /></a>
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
