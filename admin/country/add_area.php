<?php
include ('../../config/config.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}
$aid = getSession('admin_id');

$city = "";
$areas = "";
//saving tags in database

if (isset($_POST['submit'])) {
    extract($_POST);
    $err = "";
    $msg = "";

    if ($city == "") {
        $err .= "City Name is required.";
    } else if ($areas == "") {
        $err = "Area Name is required.";
    } else {

        $areas_trimmed = trim($areas, ",");
        $myAreas = explode(',', $areas_trimmed);

        if (count($myAreas) == 0) {
            $err = "Please enter correct Area Name.";
        } else {

            $found = "";
            $success = "";
            $failed = "";
            foreach ($myAreas as $area) {

                $CheckArea = "SELECT * FROM areas WHERE area_name='$area' AND area_city_id='$city'";
                $ExecuteCheck = mysqli_query($con, $CheckArea);

                if (mysqli_num_rows($ExecuteCheck) > 0) {
                    $found .= $area . ", ";
                } else {

                    trim($area, ' ');
                    $AddArea = '';
                    $AddArea .= ' area_city_id = "' . mysqli_real_escape_string($con, $city) . '"';
                    $AddArea .= ', area_name = "' . mysqli_real_escape_string($con, $area) . '"';
                    $AddArea .= ', area_status = "' . mysqli_real_escape_string($con, 'notallow') . '"';
                    $AddArea .= ', area_updated_by = "' . mysqli_real_escape_string($con, $aid) . '"';

                    $AddAreaSql = "INSERT INTO areas SET $AddArea";
                    $ExecuteSql = mysqli_query($con, $AddAreaSql);

                    if ($ExecuteSql) {
                        $success = $city . ", ";
                        //$link = baseUrl('admin/country/index.php?msg=' . base64_encode($msg));
                        //redirect($link);
                    } else {
                        if (DEBUG) {
                            echo 'ExecuteSql Error: ' . mysqli_error($con);
                        }
                        $err = "City add failed.";
                    }
                }
            }

            if ($found != "") {
                $found_trimmed = trim($found, ', ');
                $err = $found_trimmed . "already exist in database.";
            }

            if ($success != "") {
                $success_trimmed = trim($success, ', ');
                $msg = $success_trimmed . "added successfully.";
            }
        }
    }
}

$arrayCity = array();
$SelectCity = "SELECT * FROM cities";
$ExecuteSelect = mysqli_query($con, $SelectCity);
if($ExecuteSelect){
  while($ExecuteSelectObj = mysqli_fetch_object($ExecuteSelect)){
    $arrayCity[] = $ExecuteSelectObj;
  }
} else {
  if(DEBUG){
    echo "ExecuteSelect error: " . mysqli_error($con);
  } else {
    echo "ExecuteSelect query failed.";
  }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
        <title>Admin Panel | Create Product </title>

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
        <script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
        <script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>

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


        <link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
        <link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
    </head>

    <body>


        <?php include basePath('admin/top_navigation.php'); ?>

        <?php include basePath('admin/module_link.php'); ?>


        <!-- Content wrapper -->
        <div class="wrapper">

            <!-- Left navigation -->
            <?php include ('country_left_navigation.php'); ?>

            <!-- Content Start -->
            <div class="content">
                <div class="title"><h5>Area Module</h5></div>

                <!-- Notification messages -->
                <?php include basePath('admin/message.php'); ?>

                <!-- Charts -->
                <div class="widget first">
                    <div class="head">
                        <h5 class="iGraph">Area Module</h5></div>
                    <div class="body">
                        <div class="charts" style="width: 700px; height: auto;">
                            <form action="add_area.php" method="post" class="mainForm">

                                <!-- Input text fields -->
                                <fieldset>
                                    <div class="widget first">
                                        <div class="head">
                                            <h5 class="iList">Add Area</h5></div>
                                        <div class="rowElem noborder"><label>City Name:</label><div class="formRight">
                                            <select name="city">
                                                    <option value="">-- Select City --</option>
                                                    <?php
                                                    $countCity = count($arrayCity);
                                                    if($countCity > 0):
                                                      for($i = 0; $i < $countCity; $i++):
                                                    ?>
                                                    <option value="<?php echo $arrayCity[$i]->city_id; ?>" <?php if($arrayCity[$i]->city_id == $city){ echo "selected"; } ?>><?php echo $arrayCity[$i]->city_name; ?></option>
                                                    <?php
                                                      endfor;
                                                    endif;
                                                    ?>
                                                </select>
                                            </div><div class="fix"></div></div>    

                                        <div class="rowElem noborder"><label>Area Name:</label><div class="formRight">                                         
                                            <textarea name="areas" type="text"/><?php echo $areas; ?></textarea>
                                          </div><div class="fix"></div><span style="margin-left:160px; color:#999">Enter multiple Area Name using comma ( <b>,</b> ). <strong>(e.g. Banani, Gulshan-1, Gulshan-2)</strong></span></div>


                                        <input type="submit" name="submit" value="Add City" class="greyishBtn submitForm" />
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
        <script type="text/javascript">
            var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
            var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none");
            var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
            var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "currency", {minValue: 1});
            var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "integer", {minValue: 0, maxValue: 5});
        </script>
