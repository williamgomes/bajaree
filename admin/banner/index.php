<?php
include ('../../config/config.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}
$banner_id = 0;

if (isset($_REQUEST['del']) AND isset($_REQUEST['id'])) {
    $del_banner_id = base64_decode($_REQUEST['id']);
    $img_name = getFieldValue('banners', 'banner_image_name', 'banner_id=' . $del_banner_id);
    $bannerDeleteSql = "DELETE FROM `banners` WHERE banner_id=" . intval($del_banner_id);
    $bannerDeleteSqlResult = mysqli_query($con, $bannerDeleteSql);
    if ($bannerDeleteSqlResult) {

        if (file_exists(basePath('upload/banner/') . $img_name)) {
            unlink(basePath('upload/banner/') . $img_name);
        }
        $msg = "Delete successfully";
    } else {

        if (DEBUG) {
            $err = "bannerDeleteSqlResult ERROR : " . mysqli_error($con);
        } else {
            $err = "Banner information not delete";
        }
    }
}

$bannerArray = array();
$bannerSQL = "SELECT * FROM `banners`";
$bannerSQLResult = mysqli_query($con, $bannerSQL);
if ($bannerSQLResult) {
    while ($bannerSQLResultRowObj = mysqli_fetch_object($bannerSQLResult)) {
        $bannerArray[] = $bannerSQLResultRowObj;
    }
    mysqli_free_result($bannerSQLResult);
} else {
    if (DEBUG) {
        echo "BannerSQLResultRowObj error" . mysqli_error($con);
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>   
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
        <title>Admin Panel | Banner List</title>   
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
            <?php include ('banner_left_navigation.php'); ?>

            <!-- Content Start -->
            <div class="content">




                <div class="title"><h5>Banner Module </h5></div>

                <!-- Notification messages -->
                <?php include basePath('admin/message.php'); ?>
                <!-- Charts -->
                <div class="table">
                    <div class="head"><h5 class="iFrames">Banner List</h5></div>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                        <thead>
                            <tr>
                                <th>Banner Title</th>
                                <th>Banner Image</th>
                                <th>Banner Priority</th>
                                <th>Banner Updated By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $bannerArrayCounter = count($bannerArray);
                            if ($bannerArrayCounter > 0):
                                ?>
                                <?php for ($i = 0; $i < $bannerArrayCounter; $i++): ?>
                                    <tr class="gradeA">
                                        <td><?php echo $bannerArray[$i]->banner_title; ?></td>
                                        <td><a href="<?php echo $config['IMAGE_UPLOAD_URL'] . '/banner/' . $bannerArray[$i]->banner_image_name; ?>"  data-lightbox="roadtrip" >image</a></td>
                                        <td id='priority_data_<?php echo $bannerArray[$i]->banner_id; ?>'><a href='javascript:resetPriority("<?php echo $bannerArray[$i]->banner_id; ?>","<?php echo $bannerArray[$i]->banner_priority; ?>","banners","banner_priority","banner_id")' ><?php echo $bannerArray[$i]->banner_priority; ?></a></td>
                                        <td><?php echo getFieldValue('admins', 'admin_full_name', 'admin_id=' . $bannerArray[$i]->banner_updated_by); ?></td>
                                        <td class="center">
                                            <a href="banner_edit.php?id=<?php echo base64_encode($bannerArray[$i]->banner_id); ?>"><img src="<?php echo baseUrl('admin/images/pencil-grey-icon.png'); ?>" height="14" width="14" alt="Edit" /></a>&nbsp;
                                            <a href="index.php?del=yes&id=<?php echo base64_encode($bannerArray[$i]->banner_id); ?>"  onclick="return confirm('Are you sure want to delete?');"><img src="<?php echo baseUrl('admin/images/deleteFile.png'); ?>" height="14" width="14" alt="delete" /></a>
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
        <?php include basePath('admin/footer.php'); ?>
