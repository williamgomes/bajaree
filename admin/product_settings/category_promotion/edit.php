<?php
include ('../../../config/config.php');
if (!checkAdminLogin()) {
  $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
  redirect($link);
}
//saving tags in database
$categories = array();

extract($_POST);
$aid = @getSession('admin_id'); //getting admin id

$definedMaxWidth = (get_option('CATEGORY_PROMOTION_MAX_WIDTH')); //getting defined width
$definedMinWidth = (get_option('CATEGORY_PROMOTION_MIN_WIDTH')); //getting defined height

$pid = base64_decode($_GET['pid']);


$imgname = '';

//getting data from db
$getban = mysqli_query($con, "SELECT * FROM category_promotion WHERE CP_id=$pid");
if($getban){
  $rowban = mysqli_fetch_assoc($getban);
  if(isset($rowban['CP_id'])){
    $imgname = $rowban['CP_image_name'];
  }
}

$categories[] = $rowban['CP_category_id'];


if (isset($_POST['submit'])) {

  $alphanumeric = "/\w|\s+/"; //regular expression

  if (sizeof(@$categories) == 0) {
    $err = "Parent category is required.";
  } elseif ($title == "") {
    $err = "Category title is required.";
  } else {
    foreach ($categories as $cat) {
      
      if($_FILES["banner"]["name"] != ""){
        
        list($width, $height, $type, $attr) = getimagesize($_FILES["banner"]["tmp_name"]); //getting image height, width, type and attribute
        
        if ($width > $definedMaxWidth OR $width < $definedMinWidth) {
          
            $err = "Your image is not in correct shape.";
        } else {
          
          if (!is_dir($config['IMAGE_UPLOAD_PATH'] . '/category_promotion/')) {
              mkdir($config['IMAGE_UPLOAD_PATH'] . '/category_promotion/', 0777, TRUE);
          }
          @$dir = $config['IMAGE_UPLOAD_PATH'] . '/category_promotion/'; //destination folder
          //$ext = pathinfo($_FILES["banner"]["name"], PATHINFO_EXTENSION);
          $image_name = $imgname;
          $target = $dir . $image_name;

          move_uploaded_file($_FILES['banner']['tmp_name'], $target);
        }
      }

      
      if($err == ''){
      
        if (isset($_POST['type'])) {
          $urltype = "external";
        } else {
          $urltype = "internal";
        }

        $UpdateCatPromotion = '';
        $UpdateCatPromotion .= ' CP_category_id = "' . mysqli_real_escape_string($con, $cat) . '"';
        $UpdateCatPromotion .= ', CP_title = "' . mysqli_real_escape_string($con, $title) . '"';
        $UpdateCatPromotion .= ', CP_description = "' . mysqli_real_escape_string($con, $desc) . '"';
        $UpdateCatPromotion .= ', CP_url = "' . mysqli_real_escape_string($con, $url) . '"';
        $UpdateCatPromotion .= ', CP_url_type = "' . mysqli_real_escape_string($con, $urltype) . '"';
        $UpdateCatPromotion .= ', CP_priority = "' . mysqli_real_escape_string($con, $priority) . '"';
        $UpdateCatPromotion .= ', CP_updated_by = "' . mysqli_real_escape_string($con, $aid) . '"';

        $SqlUpdateCatPromotion = "UPDATE `category_promotion` SET $UpdateCatPromotion WHERE CP_id='$pid'";
        $ExecuteUpdateCatPromotion = mysqli_query($con, $SqlUpdateCatPromotion);


        if ($ExecuteUpdateCatPromotion) {
          $msg = "Category Promotion updated successfully.";
          $link = 'index.php?msg=' . base64_encode($msg);
          redirect($link);
        } else {
          if (DEBUG) {
            echo "ExecuteUpdateCatPromotion mysqli_error: " . mysqli_error($con);
          }
          $err = "Category Promotion could not update successfully.";
        }
      }
    }
  }
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
    <title>Admin Panel | Category Promotion</title>

    <link href="<?php echo baseUrl('admin/css/main.css'); ?>" rel="stylesheet" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Cuprum' rel='stylesheet' type='text/css' />
    <script src="<?php echo baseUrl('admin/js/jquery-1.4.4.js'); ?>" type="text/javascript"></script>
    <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, File upload, editor -->
    <!--tree view -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
    <script src ="<?php echo baseUrl('admin/js/jquery-1.4.4.js'); ?>" type = "text / javascript" ></script>
    <!--tree view -->
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
      function del(pin_id1)
      {
        if (confirm('Are you sure to delete this size!!'))
        {
          window.location = 'index.php?del=' + pin_id1;
        }
      }
    </script>
    <!--end delete tags-->
    <!--Start: tree view--> 

    <link href="<?php echo baseUrl('admin/css/tree_style.css'); ?>" rel="stylesheet" type="text/css" />

    <script type="text/javascript">
      var leftSpace = 0;
      jQuery(document).ready(function($) {
        $('.tree li').each(function() {

          if ($(this).children('ul').length > 0) {
            $(this).addClass('parent');
            leftSpace += 13;

          }
          if ($(this).find('input').is(':checked')) {
            $(this).addClass(' active');
            $(this).parent().css('display', 'block');
            $('.treeParent').css('width', leftSpace + 700);

          }


        });

        $('.treeParent').css('width', 700);
        $('.treeParent li').removeClass('active');
        $('.tree li.parent > a').click(function() {
          $('.treeParent').css('width', leftSpace + 700);
          $('.tree').css('overflow-x', 'scroll');
          $(this).parent().toggleClass('active');
          $(this).parent().children('ul').slideToggle('fast');
        });
      });
    </script>
    <!--End: tree view-->       

  </head>

  <body>

<?php include basePath('admin/top_navigation.php'); ?>

<?php include basePath('admin/module_link.php'); ?>


    <!-- Content wrapper -->
    <div class="wrapper">

      <!-- Left navigation -->
<?php include basePath('admin/product_settings/product_settings_left_navigation.php'); ?>

      <!-- Content Start -->
      <div class="content">
        <div class="title"><h5>Category Promotion Module</h5></div>

        <!-- Notification messages -->
<?php include basePath('admin/message.php'); ?>

        <!-- Charts -->
        <div class="widget first">
          <div class="head">
            <h5 class="iGraph">Category Promotion</h5></div>
          <div class="body">
            <div class="charts" style="width: 700px; height: auto;">
              <form action="edit.php?pid=<?php echo $_GET['pid']; ?>" method="post" class="mainForm" enctype="multipart/form-data" >

                <!-- Input text fields -->
                <fieldset>
                  <div class="widget first">
                    <div class="head"><h5 class="iList">Add Category Promotion</h5></div>
                    <!--Start category div-->
                    <div class="rowElem"><label>Parent Category:</label><div class="formRight tree">

                    <?php
                    include basePath('lib/category2.php');
                    $c = new Category2($con);
                    ?> 

                        <ul class="treeParent">
                          <li>
                            <a> </a>
                            <input type="radio" value="<?php echo $config['PRODUCT_CATEGORY_ID']; ?>" name="categories[]" <?php if (in_array($config['PRODUCT_CATEGORY_ID'], $categories)) {
                          echo 'checked="checked"';
                        } ?> />Root Category
                            <ul>
                    <?php
                    $c->inputType = 'radio';
                    $c->checked = $categories;
                    echo $c->viewTree($config['PRODUCT_CATEGORY_ID']);
                    ?>
                            </ul>
                          </li>
                        </ul>
                      </div><div class="fix"></div></div>

                    <!--                                         End category div   -->

                    <div class="rowElem noborder">
                      <label>Category Title:</label>
                      <div class="formRight">
                        <input name="title" type="text" value="<?php echo $rowban['CP_title']; ?>"/>
                      </div>
                    </div>
                    <div class="fix"></div>

                    <div class="rowElem noborder">
                      <label>Category Description:</label>
                      <div class="formRight">
                        <textarea rows="5" cols="" class="auto" name="desc"><?php echo $rowban['CP_description']; ?></textarea>
                      </div>
                    </div>
                    <div class="fix"></div>

                    <div class="rowElem noborder">
                      <label>Category URL:</label>
                      <div class="formRight">
                        <input name="url" type="text" maxlength="20" value="<?php echo $rowban['CP_url']; ?>"/>
                      </div>
                    </div>
                    <div class="fix"></div>
                    
                    <div class="rowElem noborder">
                        <label>Select Promotion Image:</label>
                        <div class="formRight">
                            <input type="file" name="banner"/>
                        </div>
                        <div class="fix"></div>
                        <font color="#666666"><i>Image width should be between <strong><?php echo $definedMinWidth . ' & ' . $definedMaxWidth ?> pixels.</strong></font>
                    </div> 
                    
                    <div style="clear: right; width:150px;"></div>
                    <span style="float: right; margin-top: -100px;">
                      <img src="<?php echo baseUrl('upload/category_promotion/') . $rowban['CP_image_name']; ?>" width="120px" style="margin:0 auto !important;" />
                    </span>

                    
                    <div class="rowElem noborder">
                      <label>Category Priority:</label>
                      <div class="formRight">
                        <input name="priority" type="text" maxlength="20" value="<?php echo $rowban['CP_priority']; ?>"/>
                      </div>
                    </div>
                    <div class="fix"></div>

                    <div class="rowElem noborder">
                      <label>Category URL Type</label>
                      <div class="formRight">
<?php
if ($rowban['CP_url_type'] == "external") {
  ?>
                          <input type="checkbox" name="type" value="External" checked="checked" /><label style="position:relative; bottom:8px; left:95px;">External</label>
                          <?php
                        } else {
                          ?>
                          <input type="checkbox" name="type" value="External" /><label style="position:relative; bottom:8px; left:95px;">External</label>
                          <?php
                        }
                        ?>
                      </div>
                    </div> 
                    <div class="fix"></div>   





                    <input type="submit" name="submit" value="Update Category Promotion" class="greyishBtn submitForm" />
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

<?php /* include basePath('admin/footer.php'); */ ?>