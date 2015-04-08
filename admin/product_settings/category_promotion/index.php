<?php
include ('../../../config/config.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}
//saving tags in database

$aid = @getSession('admin_id'); //getting admin id

$definedMaxWidth = (get_option('CATEGORY_PROMOTION_MAX_WIDTH')); //getting defined width
$definedMinWidth = (get_option('CATEGORY_PROMOTION_MIN_WIDTH')); //getting defined height

$title = "";
$desc = "";
$url = "";
$priority = "";
$categories = array();



if (isset($_POST['submit'])) {

    $alphanumeric = "/\w|\s+/"; //regular expression

    extract($_POST);
    if (sizeof($categories) == 0) {
        $err = "Parent category is required.";
    } elseif ($title == "") {
        $err = "Category banner title is required.";
    } elseif ($_FILES['banner']['name'] == "") {
        $err = "Category banner image is required.";
    } else {
        foreach ($categories as $cat) {

            list($width, $height, $type, $attr) = getimagesize($_FILES["banner"]["tmp_name"]); //getting image height, width, type and attribute

            if (!is_dir($config['IMAGE_UPLOAD_PATH'] . '/category_promotion/')) {
                mkdir($config['IMAGE_UPLOAD_PATH'] . '/category_promotion/', 0777, TRUE);
            }
            @$dir = $config['IMAGE_UPLOAD_PATH'] . '/category_promotion/'; //destination folder
            $ext = pathinfo($_FILES["banner"]["name"], PATHINFO_EXTENSION);
            $image_name = "Category-" . $cat . "_Time-" . time() . "." . $ext;
            @$target = $dir . $image_name;


            if ($width > $definedMaxWidth OR $width < $definedMinWidth) {
                $err = "Your image is not in correct shape.";
            } else {
                //setting url type
                if (isset($_POST['type'])) {
                    $urltype = "external";
                } else {
                    $urltype = "internal";
                }
                move_uploaded_file($_FILES['banner']['tmp_name'], $target);

                $AddCatPromotion = '';
                $AddCatPromotion .= ' CP_category_id = "' . mysqli_real_escape_string($con, $cat) . '"';
                $AddCatPromotion .= ', CP_image_name = "' . mysqli_real_escape_string($con, $image_name) . '"';
                $AddCatPromotion .= ', CP_title = "' . mysqli_real_escape_string($con, $title) . '"';
                $AddCatPromotion .= ', CP_description = "' . mysqli_real_escape_string($con, $desc) . '"';
                $AddCatPromotion .= ', CP_url = "' . mysqli_real_escape_string($con, $url) . '"';
                $AddCatPromotion .= ', CP_url_type = "' . mysqli_real_escape_string($con, $urltype) . '"';
                $AddCatPromotion .= ', CP_priority = "' . mysqli_real_escape_string($con, $priority) . '"';
                $AddCatPromotion .= ', CP_updated_by = "' . mysqli_real_escape_string($con, $aid) . '"';

                $SqlCatPromotion = "INSERT INTO category_promotion SET $AddCatPromotion";
                $ExecuteCatPromotion = mysqli_query($con, $SqlCatPromotion);

                if ($ExecuteCatPromotion) {
                    $msg = "Category Promotion added successfully.";
                } else {
                    if (DEBUG) {
                        echo "ExecuteCatPromotion mysqli_error: " . mysqli_error($con);
                    }
                    $err = "Category Promotion could not add successfully.";
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
        <title>Admin Panel | Category Promotion</title>

        <?php
include basePath('admin/header.php');
        ?>

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
        
        <script>
        function delid(str)
        {
        if (str=="")
          {
          document.getElementById("showCat").innerHTML="";
          return;
          } 
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                document.getElementById("showCat").innerHTML=xmlhttp.responseText;
                }
          }
        xmlhttp.open("GET","delete.php?pid="+str,true);
        xmlhttp.send();
        }
        </script>


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
                            <form action="index.php" method="post" class="mainForm" enctype="multipart/form-data" >

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
                                                        <input type="radio" value="<?php echo $config['PRODUCT_CATEGORY_ID']; ?>" name="categories[]" <?php if(in_array($config['PRODUCT_CATEGORY_ID'], $categories)){ echo 'checked="checked"'; } ?> />Root Category
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
                                            <label>Category Promotion Title:</label>
                                            <div class="formRight">
                                                <input name="title" type="text" value="<?php echo $title; ?>"/>
                                            </div>
                                        </div>
                                        <div class="fix"></div>

                                        <div class="head"><h5 class="iPencil">Category Promotion Description:</h5></div>      
                                        <div><textarea class="tm" rows="5" cols="" name="desc"><?php echo $desc; ?></textarea></div>
                                        <div class="fix"></div>

                                        <div class="rowElem noborder">
                                            <label>Category Promotion Priority:</label>
                                            <div class="formRight">
                                                <input name="priority" type="text" value="<?php echo $priority; ?>" maxlength="3"/>
                                            </div>
                                        </div>
                                        <div class="fix"></div>

                                        <div class="rowElem noborder">
                                            <label>Category URL:</label>
                                            <div class="formRight">
                                                <input name="url" type="text" value="http://"/>
                                            </div>
                                        </div>
                                        <div class="fix"></div>

                                        <div class="rowElem noborder">
                                            <label>Category URL Type</label>
                                            <div class="formRight">
                                                <input type="checkbox" name="type" value="External" /><label style="position:relative; bottom:8px; left:95px;">External</label>
                                            </div>
                                        </div> 
                                        <div class="fix"></div>   

                                        <div class="rowElem">
                                            <label>Select Promotion Image:</label>
                                            <div class="formRight">
                                                <input type="file" name="banner"/>
                                            </div>
                                            <div class="fix"></div>
                                            <font color="#666666"><i>Image width should be between <strong><?php echo $definedMinWidth . ' & ' . $definedMaxWidth ?> pixels.</strong></font>
                                        </div>   



                                        <input type="submit" name="submit" value="Add Category Promotion" class="greyishBtn submitForm" />
                                        <div class="fix"></div>


                                    </div>
                                </fieldset>

                            </form>		


                        </div>




                        <div class="table">
                            <div class="head">
                                <h5 class="iFrames">Size List</h5></div>
                            <div id="showCat">
                                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                    <thead>
                                        <tr>
                                            <th>Promotion ID</th>
                                            <th>Promotion Title</th>
                                            <th>Promotion Category</th>
                                            <th>Promotion Image</th>
                                            <th>Promotion Priority</th>
                                            <th>Promotion Last Updated</th>
                                            <th>Promotion Updated By</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $catbansql = mysqli_query($con, "SELECT * FROM category_promotion");
                                        while ($catbanrow = mysqli_fetch_array($catbansql)) {
                                            ?>                        

                                            <tr class="gradeA">
                                                <td><?php echo $catbanrow['CP_id']; ?></td>
                                                <td><?php echo $catbanrow['CP_title']; ?></td>
                                                <td><?php echo $catbanrow['CP_category_id']; ?></td>
                                                <td align="center"><img src="<?php echo baseUrl('upload/category_promotion/') . $catbanrow['CP_image_name']; ?>" width="40px" style="margin:0 auto !important;" /></td>
                                                <td id='priority_data_<?php echo $catbanrow['CP_id']; ?>'><a href='javascript:resetPriority("<?php echo $catbanrow['CP_id']; ?>","<?php echo $catbanrow['CP_priority']; ?>","category_promotion","CP_priority","CP_id")' ><?php echo $catbanrow['CP_priority']; ?></a></td>
                                                <td><?php echo $catbanrow['CP_updated']; ?></td>
                                                <td><?php
                                                    $aid = $catbanrow['CP_updated_by'];
                                                    $adminsql = mysqli_query($con, "SELECT (admin_full_name) FROM admins WHERE admin_id='$aid'");
                                                    $adminrow = mysqli_fetch_array($adminsql);
                                                    echo $adminrow[0];
                                                    ?></td>
                                                <td><a href="edit.php?pid=<?php echo base64_encode($catbanrow['CP_id']); ?>" title="Edit"><img src="<?php echo baseUrl('admin/images/pencil-grey-icon.png') ?>" height="12px" width="12px" /></a>&nbsp;&nbsp;<a href="javascript:delid(<?php echo $catbanrow['CP_id']; ?>);" title="Delete"><img src="<?php echo baseUrl('admin/images/deleteFile.png') ?>" height="12px" width="12px" /></a></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>





                </div>
            </div>

        </div>
        <!-- Content End -->

        <div class="fix"></div>
        </div>

        <?php /* include basePath('admin/footer.php'); */ ?>