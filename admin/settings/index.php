<?php
include ('../../config/config.php');
include basePath('lib/Zebra_Image.php');
if (!checkAdminLogin()) {
  $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
  redirect($link);
}
//saving tags in database


$aid = getSession('admin_id'); //getting loggedin admin id
$url = '';
extract($_POST);
if (isset($_POST['update'])) {




  if ($_FILES['logo']['size'] > 0 || !empty($_FILES['logo']['tmp_name'])) {   //uploading logo if given
    /* if image select for logo */
    $image = basename($_FILES['logo']['name']);
    $info = pathinfo($image, PATHINFO_EXTENSION);
    $image_name = "logo." . $info;
    $image_source = $_FILES["logo"]["tmp_name"];


    if (!is_dir($config['IMAGE_PATH'] . '/')) {
      mkdir($config['IMAGE_PATH'] . '/', 0777, TRUE);
    }
    $image_target_path = $config['IMAGE_PATH'] . '/' . $image_name;
    if (move_uploaded_file($image_source, $image_target_path)) {
      $logoupdate = mysqli_query($con, "UPDATE `config_settings` SET `CS_value` = CASE `CS_option`
										WHEN 'SITE_LOGO' THEN '$image_name'
										ELSE `CS_value`
										END");
    }
  }


  if ($_FILES['favicon']['size'] > 0 || !empty($_FILES['favicon']['tmp_name'])) {  //uploading favicon if given
    /* if image select for favicon */
    $image = basename($_FILES['favicon']['name']);
    $info = pathinfo($image, PATHINFO_EXTENSION);
    $image_name = "favicon.ico";
    $image_source = $_FILES["favicon"]["tmp_name"];

    if (!is_dir($config['IMAGE_PATH'] . '/')) {
      mkdir($config['IMAGE_PATH'] . '/', 0777, TRUE);
    }
    $image_target_path = $config['IMAGE_PATH'] . '/' . $image_name;
    if (move_uploaded_file($image_source, $image_target_path)) {
      $logoupdate = mysqli_query($con, "UPDATE `config_settings` SET `CS_value` = CASE `CS_option`
										WHEN 'SITE_FAVICON' THEN '$image_name'
										ELSE `CS_value`
										END");
    }
  }





  $setupdate = mysqli_query($con, "UPDATE `config_settings` SET `CS_value` = CASE `CS_option`
										WHEN 'SITE_NAME' THEN '$name'
										WHEN 'SITE_AUTHOR' THEN '$author'
										WHEN 'SITE_URL' THEN '$url'
										WHEN 'SUPPORT_MOBILE_NO' THEN '$mobile'
										WHEN 'SITE_DEFAULT_META_TITLE' THEN '$title'
										WHEN 'SITE_DEFAULT_META_DESCRIPTION' THEN '$desc'
										WHEN 'SITE_DEFAULT_META_KEYWORDS' THEN '$keyword'
										WHEN 'GOOGLE_ANALYTICS' THEN '" . mysqli_real_escape_string($con,$analytics) . "'
										WHEN 'CHECKOUT_PAGE_BKASH_TEXT' THEN '$bkash'
										WHEN 'CHECKOUT_PAGE_COD_TEXT' THEN '$cod'
										WHEN 'CHECKOUT_PAGE_EXPRESS_DELIVERY_TEXT' THEN '$express'
										ELSE `CS_value`
										END");

  if ($setupdate) {
    $msg = "Updated successfully";
//echo "<meta http-equiv='refresh' content='5; url=index.php'>";
  } else {
    $err = "Update failed";
  }
}




$responses = array();
$getset = mysqli_query($con, "SELECT * FROM config_settings WHERE CS_auto_load='yes'");
if (mysqli_num_rows($getset) > 0) {

  while ($row = mysqli_fetch_object($getset)) {
    $responses[$row->CS_option] = $row->CS_value;
  }
}

$responses['SITE_DEFAULT_META_TITLE'] = get_option('SITE_DEFAULT_META_TITLE');
$responses['SITE_DEFAULT_META_DESCRIPTION'] = get_option('SITE_DEFAULT_META_DESCRIPTION');
$responses['SITE_DEFAULT_META_KEYWORDS'] = get_option('SITE_DEFAULT_META_KEYWORDS');
$responses['SUPPORT_MOBILE_NO'] = get_option('SUPPORT_MOBILE_NO');
$responses['GOOGLE_ANALYTICS'] = get_option('GOOGLE_ANALYTICS');
$responses['CHECKOUT_PAGE_BKASH_TEXT'] = get_option('CHECKOUT_PAGE_BKASH_TEXT');
$responses['CHECKOUT_PAGE_COD_TEXT'] = get_option('CHECKOUT_PAGE_COD_TEXT');
$responses['CHECKOUT_PAGE_EXPRESS_DELIVERY_TEXT'] = get_option('CHECKOUT_PAGE_EXPRESS_DELIVERY_TEXT');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
    <title>Admin Panel | Settings</title>

    <?php include basePath('admin/header.php'); ?>
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
              <form action="index.php" method="post" class="mainForm" enctype="multipart/form-data">

                <!-- Input text fields -->
                <fieldset>
                  <div class="widget first">
                    <div class="head"><h5 class="iList">Website Settings</h5></div>

                    <div class="rowElem noborder"><label>Website Name:</label><div class="formRight"><input name="name" type="text" value="<?php echo $responses['SITE_NAME']; ?>"/></div><div class="fix"></div></div>

                    <div class="rowElem noborder"><label>Website Author:</label><div class="formRight">
                        <textarea name="author"><?php echo $responses['SITE_AUTHOR']; ?></textarea>

                      </div><div class="fix"></div></div>
                    <div class="rowElem noborder"><label>Website URL:</label><div class="formRight"><input name="url" type="text" value="<?php echo $responses['SITE_URL']; ?>"/></div><div class="fix"></div></div>

                    <div class="rowElem noborder"><label>Website Logo:</label><div class="formRight"><input type="file" name="logo" /></div><div class="fix"></div></div>

                    <div class="rowElem noborder"><label>Website Favicon:</label><div class="formRight"><input type="file" name="favicon" /></div><div class="fix"></div></div>

                    <div class="rowElem noborder"><label>Support Mobile No:</label><div class="formRight"><input type="text" name="mobile" value="<?php echo $responses['SUPPORT_MOBILE_NO']; ?>"/></div><div class="fix"></div></div>

                    <div class="rowElem noborder"><label>Meta Title:</label><div class="formRight"><input name="title" type="text" value="<?php echo $responses['SITE_DEFAULT_META_TITLE']; ?>"/></div><div class="fix"></div></div>

                    <div class="rowElem noborder"><label>Meta Description:</label><div class="formRight">
                        <textarea name="desc"><?php echo $responses['SITE_DEFAULT_META_DESCRIPTION']; ?></textarea>

                      </div><div class="fix"></div></div>



                    <div class="rowElem noborder"><label>Meta Keyword:</label><div class="formRight">
                        <textarea name="keyword"><?php echo $responses['SITE_DEFAULT_META_KEYWORDS']; ?></textarea>
                      </div><div class="fix"></div></div>
                      
                    <div class="head"><h5 class="iPencil">Google Analytics:</h5></div>      
                    <div><textarea rows="5" cols="" name="analytics"><?php echo $responses['GOOGLE_ANALYTICS']; ?></textarea></div>
                    
                    <div class="head"><h5 class="iPencil">bKash Text on Checkout Page:</h5></div>      
                    <div><textarea class="tm" rows="5" cols="" name="bkash"><?php echo $responses['CHECKOUT_PAGE_BKASH_TEXT']; ?></textarea></div>
                    
                    <div class="head"><h5 class="iPencil">COD Text on Checkout Page:</h5></div>      
                    <div><textarea class="tm" rows="5" cols="" name="cod"><?php echo $responses['CHECKOUT_PAGE_COD_TEXT']; ?></textarea></div>
                    
                    <div class="head"><h5 class="iPencil">Express Delivery Text on Checkout Page:</h5></div>      
                    <div><textarea class="tm" rows="5" cols="" name="express"><?php echo $responses['CHECKOUT_PAGE_EXPRESS_DELIVERY_TEXT']; ?></textarea></div>

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
