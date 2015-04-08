<?php
include ('../../../config/config.php');
include basePath('lib/Zebra_Image.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}
$aid = getSession('admin_id'); //getting admin id
//saving tags in database


//getting predefined image size from database
$getset = mysqli_query($con, "SELECT * FROM config_settings");
if (mysqli_num_rows($getset) > 0) {
    $responses = array();
    while ($row = mysqli_fetch_assoc($getset)) {
        $responses[] = array(
            'Option Name' => $row['CS_option'],
            'Option Value' => $row['CS_value']
        );
    }
}

$smallwidth = get_option('PRODUCT_SMALL_IMAGE_WIDTH'); //getting defined width
$mediumwidth = get_option('PRODUCT_MEDIUM_IMAGE_WIDTH'); //getting defined width
$largewidth = get_option('PRODUCT_LARGE_IMAGE_WIDTH'); //getting defined width

//image declaration

$pid = base64_decode($_GET['pid']); /* prodcut id */
$iid = base64_decode($_GET['iid']); /* prodcut id */


$priority = '';


if (isset($_POST['update'])) {
	
	extract($_POST);
	
	if($priority == ""){
		$err = 'Image Priority is required.';
	} else {
		
		if ($_FILES["img"]["tmp_name"] != "") {
				
				//getting product name
				$GetProduct = mysqli_query($con,"SELECT * FROM products WHERE product_id='$pid'");
				$SetProduct = mysqli_fetch_object($GetProduct);
				$ProductName = myUrlEncode($SetProduct -> product_title);
				
				//getting last id of product_images table
				$NewID = getMaxValue('product_images','PI_id')+1;
				
				$tid = time(); /* use in image name */
				$image = basename($_FILES['img']['name']);
				$info = pathinfo($image, PATHINFO_EXTENSION); /* it will return me like jpeg, gif, pdf, png */
				$image_name = $NewID . '-' . $iid . '.' . $info; /* create custom image name color id will add  */
				$image_source = $_FILES["img"]["tmp_name"];
		
		
				if (!is_dir($config['IMAGE_UPLOAD_PATH'] . '/product/original/')) {
					mkdir($config['IMAGE_UPLOAD_PATH'] . '/product/original/', 0777, TRUE);
				}
				$image_target_path = $config['IMAGE_UPLOAD_PATH'] . '/product/original/' . $image_name;
		
				//saving image into db
				if (move_uploaded_file($image_source, $image_target_path)) {
		
					$UpdateImage = '';
					$UpdateImage .= ' PI_file_name = "' . mysqli_real_escape_string($con, $image_name) . '"';
					$UpdateImage .= ', PI_updated_by = "' . mysqli_real_escape_string($con, $aid) . '"';
					$UpdateImage .= ', PI_priority = "' . mysqli_real_escape_string($con, $priority) . '"';
					
					
					$SqlUpdateImage = "UPDATE product_images SET $UpdateImage WHERE PI_id=$iid";
					$ExecuteUpdateImage = mysqli_query($con, $SqlUpdateImage);
		
					if ($ExecuteUpdateImage) {
						$msg = "Image updated successfully.";
						
						//changing RSS Feed status
						changeFeedStatus('../../../nuvista_feed.xml','latest','NO');
						
						$link = "gallery.php?pid=" . $_GET['pid'] . '&msg=' . base64_encode($msg);
						redirect($link);
						
					} else {
						if (DEBUG) {
							echo "ExecuteUpdateImage mysqli_error: " . mysqli_error($con);
						}
						$err = "Image could not update successfully.";
					}
		
		
					$image_source = $image_target_path; /* iimage uploaded now change the source set to ufrom ariginal path */
					if (file_exists($image_source)) {
						/* now i will resize the image into three folder */
						$zebra = new Zebra_Image();
						$zebra->source_path = $image_source; /* original image path */
						/* Start : large */
		
						if (!is_dir($config['IMAGE_UPLOAD_PATH'] . '/product/large/')) {
							mkdir($config['IMAGE_UPLOAD_PATH'] . '/product/large/', 0777, TRUE);
						}
		
						$zebra->target_path = $config['IMAGE_UPLOAD_PATH'] . '/product/large/' . $image_name;
						$imgpathlar = '/product/large/' . $image_name;
						$width = $largewidth; /* it will come latter from config_settings table */
						if (!$zebra->resize($width)) {
							switch ($zebra->error) {
		
								case 1:
									$err = 'Source file could not be found!';
									break;
								case 2:
									$err = 'Source file is not readable!';
									break;
								case 3:
									$err = 'Could not write target file!';
									break;
								case 4:
									$err = 'Unsupported source file format!';
									break;
								case 5:
									$err = 'Unsupported target file format!';
									break;
								case 6:
									$err = 'GD library version does not support target file format!';
									break;
								case 7:
									$err = 'GD library is not installed!';
									break;
							}
						} else {
		
							// image resized 
						}
						/* End : large */
		
						/* Start : mid */
						if (!is_dir($config['IMAGE_UPLOAD_PATH'] . '/product/mid/')) {
							mkdir($config['IMAGE_UPLOAD_PATH'] . '/product/mid/', 0777, TRUE);
						}
						$zebra->target_path = $config['IMAGE_UPLOAD_PATH'] . '/product/mid/' . $image_name;
						$imgpathmed = '/product/mid/' . $image_name;
						$width = $mediumwidth; /* it will come latter from config_settings table */
						if (!$zebra->resize($width)) {
							switch ($zebra->error) {
		
								case 1:
									$err = 'Source file could not be found!';
									break;
								case 2:
									$err = 'Source file is not readable!';
									break;
								case 3:
									$err = 'Could not write target file!';
									break;
								case 4:
									$err = 'Unsupported source file format!';
									break;
								case 5:
									$err = 'Unsupported target file format!';
									break;
								case 6:
									$err = 'GD library version does not support target file format!';
									break;
								case 7:
									$err = 'GD library is not installed!';
									break;
							}
						} else {
		
							// image resized 
						}
						/* End : mid */
						/* Start : small */
						if (!is_dir($config['IMAGE_UPLOAD_PATH'] . '/product/small/')) {
							mkdir($config['IMAGE_UPLOAD_PATH'] . '/product/small/', 0777, TRUE);
						}
						$zebra->target_path = $config['IMAGE_UPLOAD_PATH'] . '/product/small/' . $image_name;
						$imgpathsma = '/product/small/' . $image_name;
						$width = $smallwidth; /* it will come latter from config_settings table */
						if (!$zebra->resize($width)) {
							switch ($zebra->error) {
		
								case 1:
									$err = 'Source file could not be found!';
									break;
								case 2:
									$err = 'Source file is not readable!';
									break;
								case 3:
									$err = 'Could not write target file!';
									break;
								case 4:
									$err = 'Unsupported source file format!';
									break;
								case 5:
									$err = 'Unsupported target file format!';
									break;
								case 6:
									$err = 'GD library version does not support target file format!';
									break;
								case 7:
									$err = 'GD library is not installed!';
									break;
							}
						} else {
		
							// image resized 
						}
						/* End : small */
					}
				} 
		} else {
					
			$UpdateImage = '';
			$UpdateImage .= ' PI_priority = "' . mysqli_real_escape_string($con, $priority) . '"';
			$UpdateImage .= ', PI_updated_by = "' . mysqli_real_escape_string($con, $aid) . '"';

			$SqlUpdateImage = "UPDATE product_images SET $UpdateImage WHERE PI_id=$iid";
			$ExecuteUpdateImage = mysqli_query($con, $SqlUpdateImage);

			if ($ExecuteUpdateImage) {
				$msg = "Image updated successfully.";
				
				//changing RSS Feed status
				changeFeedStatus('../../../nuvista_feed.xml','latest','NO');
				
				$link = "gallery.php?pid=" . $_GET['pid'] . '&msg=' . base64_encode($msg);
				redirect($link);
				
			} else {
				if (DEBUG) {
					echo "ExecuteUpdateImage mysqli_error: " . mysqli_error($con);
				}
				$err = "Image could not update successfully.";
			}
			
		}
	}
}


$imageSql = "SELECT * FROM product_images WHERE PI_product_id=$pid AND PI_id=$iid";
$imageSqlResult = mysqli_query($con, $imageSql);
if ($imageSqlResult) {
    $imageSqlResultRowObj = mysqli_fetch_object($imageSqlResult);
	if(isset($imageSqlResultRowObj -> PI_id)){
		$priority = $imageSqlResultRowObj ->PI_priority;
	}
    mysqli_free_result($imageSqlResult);
} else {
    if (DEBUG) {
        echo 'imageSqlResult Error : ' . mysqli_errno($con);
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
        <title>Admin Panel | Image Gallery</title>

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


        <script>

            function delid(pin_id)
            {
                //alert(pin_id);
                var pid = <?php echo $pid; ?>;
                if (pin_id == "")
                {
                    document.getElementById("showimg").innerHTML = "";
                    return;
                }
                if (window.XMLHttpRequest)
                {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                }
                else
                {// code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function()
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        document.getElementById("showimg").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET", "gallerydelete.php?id=" + pin_id + "&pid=" + pid, true);
                xmlhttp.send();
            }

            function clr(str)
            {

                if (str == "")
                {
                    document.getElementById("shwClr").innerHTML = "";
                    return;
                }
                if (window.XMLHttpRequest)
                {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                }
                else
                {// code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function()
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        document.getElementById("shwClr").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET", "ajaxcolor.php?c=" + str, true);
                xmlhttp.send();
            }
        </script>



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

        <script type="text/javascript">
            function redirect()
            {
                if (confirm('Do you want to leave Product Editing Module?'))
                {
                    window.location = "../index.php";
                }
            }

        </script>
    </head>

    <body>


        <?php include basePath('admin/top_navigation.php'); ?>

        <?php include basePath('admin/module_link.php'); ?>


        <!-- Content wrapper -->
        <div class="wrapper">

            <!-- Left navigation -->
            <div class="leftNav">
                <?php include('left_navigation.php'); ?>
            </div>

            <!--<div class="leftCol">
                <div class="title">
                    <h5>Note</h5>

                </div>
                <div class="leftColInner">
                    This is admin module you can create , update and see the list of admin here
                </div>
            </div>

        </div>-->

            <!-- Content Start -->
            <div class="content">
                <div class="title"><h5>Product Gallery</h5></div>

                <!-- Notification messages -->
                <?php include basePath('admin/message.php'); ?>

                <!-- Charts -->
                <div class="widget first">
                    <div class="head">
                        <h5 class="iGraph">Gallery</h5></div>
                    <div class="body">
                        <div class="charts" style="width: 700px; height: auto;">
                            <form action="gallery_edit.php?pid=<?php echo base64_encode($pid); ?>&iid=<?php echo $_GET['iid']; ?>" method="post" class="mainForm" enctype="multipart/form-data">

                                <!-- Input text fields -->
                                <fieldset>
                                    <div class="widget first">
                                        <div class="head"><h5 class="iList">Gallery</h5></div>

                                        <div class="rowElem">
                                            <label>Image Priority :</label>
                                            <div class="formRight">
                                                <input name="priority" type="text" value="<?php echo $priority; ?>"/>
                                            </div><div class="fix"></div><span style="margin-left:160px; font-weight:bold;">0 = Low Priority & 5 = High Priority</span>
										</div>


                                        <div class="rowElem noborder"><label>Product Image:</label><div class="formRight">
                                                <input name="img" type="file"/>
                                            </div><div class="fix"></div><span style="margin-left:160px; font-weight:bold; color:#933;">Only select image if want to replace old image.</span></div>


                                        <a class="greyishBtn submitForm" href="gallery.php?pid=<?php echo $_GET['pid']; ?>" style="float:left; position:relative; margin-left:450px; padding:2px 5px;">Go Back</a>
                                        <input type="submit" name="update" value="Update" class="greyishBtn submitForm" />
                                        <div class="fix"></div>

                                    </div>
                                </fieldset>

                            </form>		


                        </div>



                    </div>






                </div>
            </div>

        </div>
        <!-- Content End -->

        <div class="fix"></div>
        </div>

        <?php include basePath('admin/footer.php'); ?>
        <script type="text/javascript">
            var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
            var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
            var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
        </script>
