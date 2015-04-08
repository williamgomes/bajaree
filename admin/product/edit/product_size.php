<?php
//include ('../../../config/config.php');
include '../../../config/config.php';
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}
$aid = getSession('admin_id'); //getting admin id from session
//saving tags in database

$pid = base64_decode($_GET['pid']);
$current_price = '';
$default_title = '';
$default_image = '';


if (isset($_POST['add'])) {
    extract($_POST);
    $err = "";
    $msg = "";

    if (sizeof($sizes) == 0) {
        $err = "Size Selection is required.";
    } else {

        foreach ($sizes as $size) { //getting tag id from array
            $AddSize = '';
            $AddSize .= ' PS_size_id = "' . mysqli_real_escape_string($con, $size) . '"';
            $AddSize .= ' ,PS_size_title = "' . mysqli_real_escape_string($con, getFieldValue('sizes', 'size_title', 'size_id=' . intval($size))) . '"';
            $AddSize .= ' ,PS_product_id = "' . mysqli_real_escape_string($con, $pid) . '"';

            $AddSizeSQL = "INSERT INTO product_sizes SET $AddSize";
            $ExecuteAddSizegSQL = mysqli_query($con, $AddSizeSQL);

            if ($ExecuteAddSizegSQL) {
                $msg = "Sizes added successfully.";
            } else {
                if (DEBUG) {
                    echo "ExecuteAddSizeSQL error" . mysqli_error($con);
                }
                $err = "Size add failed";
            }
        }
    }
}


/* * ********************** Start deletion code********************************* */
if (isset($_REQUEST["delSizeId"])) {
    $product_size = base64_decode($_REQUEST["product_size"]);
    $inventoryExistSql = 'SELECT PI_id FROM product_inventories WHERE PI_product_id=' . intval($pid) . ' && PI_size_id=' . intval($product_size);
    $inventoryExistSql;
    $inventoryExistResult = mysqli_query($con, $inventoryExistSql);
    if ($inventoryExistResult) {
        $inventoryExistResultRowObj = mysqli_fetch_object($inventoryExistResult);
        if (isset($inventoryExistResultRowObj->PI_id)) {
            $err = 'You can not delete this size. It has been already added to inventory';
        } else {
            $delSizeId = base64_decode($_REQUEST["delSizeId"]);
            $sizeDeleteSql = "DELETE FROM product_sizes WHERE PS_id=" . intval($delSizeId);
            $sizeDeleteResult = mysqli_query($con, $sizeDeleteSql);
            if ($sizeDeleteResult) {
                $msg = 'Size successfully removed';
            } else {
                if (DEBUG) {
                    $err = '$sizeDeleteResult error' . mysqli_error($con);
                } else {
                    $err = 'Query failed';
                }
            }
        }
    } else {
        if (DEBUG) {
            $err = '$inventoryExistResultRowObj error' . mysqli_error($con);
        } else {
            $err = 'Query failed';
        }
    }
}
/* * ********************** End deletion code********************************* */



/* * **************************Start Show size from product_sizes table*************************************** */
$showSizeArray = array();
$existingSizeArray = array();
$showSizeSql = "SELECT * FROM product_sizes WHERE PS_product_id=" . intval($pid);
$showSizeResult = mysqli_query($con, $showSizeSql);
if ($showSizeResult) {
    while ($showSizeResultRowObj = mysqli_fetch_object($showSizeResult)) {
        $showSizeArray[] = $showSizeResultRowObj;
        $existingSizeArray[] = $showSizeResultRowObj->PS_size_id;
    }
}
/* * **************************End Show size from product_size table*************************************** */

//fetching product general information from db
$sqlProduct = "SELECT * FROM products WHERE product_id='$pid'";
$executeProduct = mysqli_query($con, $sqlProduct);
if ($executeProduct) {
  $getProduct = mysqli_fetch_object($executeProduct);
  if (isset($getProduct->product_id)) {
    $title = $getProduct->product_title;
    $invID = $getProduct->product_default_inventory_id;
    
    if($invID > 0){
      $inventorySql = "SELECT product_inventories.PI_inventory_title, product_inventories.PI_current_price, 
                      product_images.PI_file_name 

                      FROM product_inventories 

                      LEFT JOIN product_images ON product_images.PI_inventory_id=product_inventories.PI_id 
                      WHERE product_inventories.PI_id = ".  intval($invID);
      $inventoryResult = mysqli_query($con, $inventorySql);
      if($inventoryResult){
          $inventoryResultRowObj = mysqli_fetch_object($inventoryResult);
          if(isset($inventoryResultRowObj->PI_inventory_title)){
            $current_price = $inventoryResultRowObj->PI_current_price;
            $default_title = $inventoryResultRowObj->PI_inventory_title;
            $default_image = $inventoryResultRowObj->PI_file_name;
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
        <title>Admin Panel | Size Module</title>

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


        <!--Effect on left error menu, top message menu, body-->

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

            <!-- Content Start -->
            <div class="content">
                
                <div class="title"><h5>Product's Size Module</h5></div>

                <!-- Notification messages -->
                <?php include basePath('admin/message.php'); ?>
<!-- Website statistics -->
                <div class="widget">
                    <div class="head"><h5 class="iChart8">Product basic information</h5></div>
                    <table cellpadding="0" cellspacing="0" width="100%" class="tableStatic"> 
                        <tbody>
                            <tr>
                                <td style="width:30%"><a href="#" title="">Product Title</a></td>
                                <td><?php echo $title;?></td>
                            </tr>
                            <tr>
                                <td ><a href="#" title="" >Product Default Inventory Title</a></td>
                                <td><?php if($default_title == ''){ echo '<p style="color: red;"><b>Default Inventory is not set</b></p>'; } else { echo $default_title; } ?></td>
                            </tr>
                            <tr>
                                <td ><a href="#" title="">Product Current Price</a></td>
                                <td><?php if($default_title == ''){ echo '<p style="color: red;"><b>Default Inventory is not set</b></p>'; } else { echo $current_price; }?></td>
                            </tr>
                            <tr>
                                <td ><a href="#" title="">Product Default Image</a></td>
                                <td><?php if($default_image == ''){ echo '<p style="color: red;"><b>Default Image is not set</b></p>'; } else { echo '<a target="_blank" href="' . baseUrl('upload/product/mid/' . $default_image) . '">Image Link</a>'; }?></td>
                            </tr>
                        </tbody>
                    </table>                            
                </div>
                <!-- Charts -->
                <div class="widget first">
                    <div class="head">
                        <h5 class="iGraph">Size Module</h5></div>
                    <div class="body">
                        <div class="charts" style="width: 700px; height: auto;">
                            <form action="product_size.php?pid=<?php echo base64_encode($pid); ?>" method="post" class="mainForm">

                                <!-- Input text fields -->
                                <fieldset>
                                    <div class="widget first">
                                        <div class="head"><h5 class="iList">Size Module</h5></div>
                                        <div class="rowElem">
                                            <label>Sizes List :</label>
                                            <div class="formRight">

                                                <select name="sizes[]" multiple="multiple" class="multiple" title="Click to Select a Size" style="height:150px !important">
                                                    <option value="">-- Select Multiple Sizes --</option> 
                                                    <?php
                                                    $selsize = mysqli_query($con, "SELECT * FROM sizes");
                                                    while ($rowsize = mysqli_fetch_assoc($selsize)) {
                                                        if (!in_array($rowsize['size_id'], $existingSizeArray)) {
                                                            ?>     
                                                            <option value="<?php echo $rowsize['size_id']; ?>"><?php echo $rowsize['size_title']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                            <div class="fix"></div>
                                        </div>

                                        <input type="submit" name="add" value="Add Sizes" class="greyishBtn submitForm" />
                                        <div class="fix"></div>

                                    </div>
                                </fieldset>

                            </form>		


                        </div>

                        <?php
                        $showSizeArrayCounter = count($showSizeArray);
                        if ($showSizeArrayCounter > 0) {
                            ?>  

                            <div class="table">
                                <div class="head">
                                    <h5 class="iFrames">Related Product List</span></h5></div>
                                <div id="deltag">       
                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                        <thead>
                                            <tr>
                                                <td style="mystyle">Product ID</td>
                                                <th>Size Title</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            for ($i = 0; $i < $showSizeArrayCounter; $i++) {

                                                /*                                                 * ***************** Start Check for deletion if it is alredy in inventory ********************** */
                                                $inventoryExistSql = 'SELECT PI_id FROM product_inventories WHERE PI_product_id=' . intval($showSizeArray[$i]->PS_product_id) . ' && PI_size_id=' . intval($showSizeArray[$i]->PS_size_id);
                                                $inventoryExistResult = mysqli_query($con, $inventoryExistSql);
                                                if ($inventoryExistResult) {
                                                    $inventoryExistResultRowObj = mysqli_fetch_object($inventoryExistResult);
                                                    if (isset($inventoryExistResultRowObj->PI_id)) {
                                                        $inventoryExist = TRUE;
                                                    } else {
                                                        $inventoryExist = FALSE;
                                                    }
                                                } else {
                                                    if (DEBUG) {
                                                        $err = '$inventoryExistResultRowObj error' . mysqli_error($con);
                                                    } else {
                                                        $err = 'Query failed';
                                                    }
                                                }
                                                /*                                                 * ***************** End Check for deletion if it is alredy in inventory ********************** */
                                                ?>                        

                                                <tr class="gradeA">
                                                    <td><?php echo $showSizeArray[$i]->PS_product_id; ?></td>
                                                    <td><?php
                                                        echo $showSizeArray[$i]->PS_size_title;
                                                        ?>
                                                        <td><a onclick="<?php if (!$inventoryExist) { ?> return confirm('Do you sure want to remove this size?'); <?php } else { ?> alert('You can not delete this size. It has been already added to inventory'); return false;<?php } ?>" href="product_size.php?delSizeId=<?php echo base64_encode($showSizeArray[$i]->PS_id); ?>& pid=<?php echo base64_encode($pid) ?> & product_size=<?php echo base64_encode($showSizeArray[$i]->PS_size_id) ?> " title="Remove"><img src="<?php echo baseUrl('admin/images/deleteFile.png" alt="Delete') ?>" /></a></td>
                                                </tr>
                                                <?php
                                                //nothing to do
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php
                        }
                        ?>

                    </div>








                </div>
            </div>

        </div>
        <!-- Content End -->

        <div class="fix"></div>
        </div>
        <!--delete tags-->
        <script type="text/javascript">

            function delid(pin_id, pro_id)
            {

                if (pin_id == "")
                {
                    document.getElementById("deltag").innerHTML = "";
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
                        document.getElementById("deltag").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET", "tagdelete.php?id=" + pin_id + "&pid=" + pro_id, true);
                xmlhttp.send();
            }
        </script>
        <!--end delete tags-->
        <?php include basePath('admin/footer.php'); ?>
        <script type="text/javascript">
            var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
            var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
            var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
        </script>
