<?php
include ('../../config/config.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}

if (isset($_REQUEST['id'])) {
    $edit_banner_id = base64_decode($_REQUEST['id']);
} else {
    $link = baseUrl('admin/banner/index.php?err=' . base64_encode('Id missing.'));
    redirect($link);
}

$author = getSession('admin_id');
$banner_image_name = '';
$banner_title = '';
$banner_priority = '';
$banner_area = '';
$banner_url = '';
$banner_description = '';
$banner_min_width = get_option('BANNER_MIN_WIDTH');

$bannerSql = "SELECT * FROM `banners` WHERE banner_id=" . intval($edit_banner_id);
$bannerSqlResult = mysqli_query($con, $bannerSql);
if ($bannerSqlResult) {
    $bannerSqlResultRowObj = mysqli_fetch_object($bannerSqlResult);
    if (isset($bannerSqlResultRowObj->banner_id)) {

        $banner_title = $bannerSqlResultRowObj->banner_title;
        $banner_priority = $bannerSqlResultRowObj->banner_priority;
        $banner_area = $bannerSqlResultRowObj->banner_area;
        $banner_url = $bannerSqlResultRowObj->banner_url;
        $banner_description = $bannerSqlResultRowObj->banner_description;
    }
} else {
    if (DEBUG) {
        echo "bannerSqlResult error : " . mysqli_error($con);
    } else {
        $link = baseUrl('admin/banner/index.php?err=' . base64_encode('Edit sql fail.'));
        redirect($link);
    }
}

$bannerArray = array();
$bannerSQL = "SELECT * FROM banners";
$bannerSQLResult = mysqli_query($con, $bannerSQL);
if ($bannerSQLResult) {
    while ($bannerSQLResultRowObj = mysqli_fetch_object($bannerSQLResult)) {
        $bannerArray[] = $bannerSQLResultRowObj;
    }
    mysqli_free_result($bannerSQLResult);
} else {
    if (DEBUG) {
        echo "bannerSQLResultRowObj error" . mysqli_error($con);
    }
}


if (isset($_POST['banner_update']) AND $_POST['banner_update'] == 'Update') {

    extract($_POST);
    $width = 0;

    if ($_FILES["banner_image"]["error"] == 0) {
        list($width) = getimagesize($_FILES["banner_image"]["tmp_name"]);
    }

    //echo $width;
    if ($_FILES["banner_image"]["error"] == 0 && $width < $banner_min_width) {
        $err = "Banner width should be minimum <b>$banner_min_width </b>";
    } else if ($banner_title == '') {
        $err = 'Banner title field is required!!';
    } elseif ($banner_priority == '') {
        $err = 'Banner priority field is required!!';
    } elseif (!is_numeric($banner_priority)) {
        $err = 'Banner priority should be numeric!!';
    } elseif ($banner_url != '' AND filter_var($banner_url, FILTER_VALIDATE_URL) == FALSE) {
        $err = 'Valid Banner url field is required!!';
    } elseif ($banner_description == '') {
        $err = 'Banner description field is required!!';
    }


    if ($err == '') {
        if ($width > 0) {
            $max_Banner_id = getMaxValue('banners', 'banner_id');
            $new_Banner_id = $max_Banner_id + 1;
            /* Srat: image upload */
            $banner_image = basename($_FILES['banner_image']['name']);
            $info = pathinfo($banner_image, PATHINFO_EXTENSION); /* it will return me like jpeg, gif, pdf, png */
            $banner_image_name = str_replace(' ', '_', clean($banner_title)) . '-' . $new_Banner_id . '.' . $info; /* create custom image name color id will add  */

            $banner_image_source = $_FILES["banner_image"]["tmp_name"];

            if (!is_dir($config['IMAGE_UPLOAD_PATH'] . '/banner/')) {
                mkdir($config['IMAGE_UPLOAD_PATH'] . '/banner/', 0777, TRUE);
            }
            $banner_image_target_path = $config['IMAGE_UPLOAD_PATH'] . '/banner/' . $banner_image_name;


            if (!move_uploaded_file($banner_image_source, $banner_image_target_path)) {
                $banner_image_name = '';
            }
        }

        /* End: image upload */
        $bannerField = '';
        $bannerField .= ' banner_title ="' . (mysqli_real_escape_string($con, $banner_title)) . '"';
        if ($banner_image_name != '') {
            $bannerField .= ', banner_image_name ="' . mysqli_real_escape_string($con, $banner_image_name) . '"';
        }
        $bannerField .= ', banner_priority ="' . intval($banner_priority) . '"';
        $bannerField .= ', banner_area ="' .mysqli_real_escape_string($con, $banner_area) . '"';
        $bannerField .= ', banner_url ="' . mysqli_real_escape_string($con, $banner_url) . '"';
        $bannerField .= ', banner_updated_by ="' . $author . '"';
        $bannerField .= ', banner_description ="' . htmlentities(mysqli_real_escape_string($con, $banner_description)) . '"';

        $bannerInsSql = "UPDATE `banners` SET $bannerField WHERE banner_id=" . intval($edit_banner_id);
        $bannerInsSqlResult = mysqli_query($con, $bannerInsSql);
        if ($bannerInsSqlResult) {
            $msg = "Banner information update successfully";
        } else {
            if (DEBUG) {
                echo 'bannerInsSqlResult Error: ' . mysqli_error($con);
            }
            $err = "Update Query failed.";
        }
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>   
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
        <title>Admin Panel | Banner Update</title>   
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
                <div class="title"><h5>Banner Module</h5></div>

                <!-- Notification messages -->
                <?php include basePath('admin/message.php'); ?>
                <!-- Charts -->
                <div class="widget first">
                    <div class="head">
                        <h5 class="iGraph">Update Banner </h5></div>
                    <div class="body">
                        <div class="charts" style="width: 700px; height: auto;">
                            <form action="<?php echo baseUrl('admin/banner/banner_edit.php') . '?id=' . base64_encode($edit_banner_id); ?>" method="post" enctype="multipart/form-data" class="mainForm">

                                <!-- Input text fields -->
                                <fieldset>
                                    <div class="widget first">
                                        <div class="head"><h5 class="iList">Banner</h5></div>
                                        <div class="rowElem noborder"><label>Banner Image:</label><div class="formRight"><input type="file" name="banner_image" value=""  />&nbsp;<?php echo "Minimum width:" . $banner_min_width; ?></div><div class="fix"></div></div>
                                        <div class="rowElem noborder"><label>Banner Title:</label><div class="formRight"><input type="text" name="banner_title" value="<?php echo $banner_title; ?>"  /></div><div class="fix"></div></div>
                                        <div class="rowElem noborder"><label>Banner Priority:</label><div class="formRight"><input type="text" name="banner_priority" value="<?php echo $banner_priority; ?>"  /></div><div class="fix"></div></div>
                                                                                <?php if (isset($config['BANNER_AREA']) AND count($config['BANNER_AREA']) > 0): ?>
                                            <div class="rowElem noborder"><label>Banner Area:</label><div class="formRight">
                                                    <select name="banner_area">
                                                        <?php foreach ($config['BANNER_AREA'] AS $key => $value): ?>
                                                            <option value="<?php echo $key; ?>" <?php
                                                            if ($banner_area == $key) {
                                                                echo 'selected="selected"';
                                                            }
                                                            ?>><?php echo $value; ?></option>
    <?php endforeach; /* ($config['BANNER_AREA'] AS $area) */ ?>


                                                    </select>
                                                </div><div class="fix"></div></div> 

<?php endif; /* (isset($config['BANNER_AREA']) AND count($config['BANNER_AREA']) >0) */ ?>
                                        <div class="rowElem noborder"><label>Banner Url:</label><div class="formRight"><input type="text" value="<?php echo $banner_url; ?>" name="banner_url"/></div><div class="fix"></div></div>
                                        <div class="head"><h5 class="iPencil">Banner Description:</h5></div>      
                                        <div><textarea class="tm" rows="5" cols="" name="banner_description"><?php echo $banner_description; ?></textarea></div>
                                        <input type="submit" name="banner_update" value="Update" class="greyishBtn submitForm" />
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
