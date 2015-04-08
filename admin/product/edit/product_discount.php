<?php
include ('../../../config/config.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}


$aid = getSession('admin_id'); //get admin id
//saving tags in database

$pid = base64_decode($_GET['pid']);
$starting_date = '';
$ending_date = '';
$discount_amount = '';
$inventory = '';
$current_price = '';
$default_title = '';
$default_image = '';


//getting inventory information from table
$arrayInventory = array();
$sqlInventory = "SELECT PI_id,PI_inventory_title FROM product_inventories WHERE PI_product_id=" . intval($pid);
$executeInventory = mysqli_query($con,$sqlInventory);
if($executeInventory){
  while($executeInventoryObj = mysqli_fetch_object($executeInventory)){
    $arrayInventory[] = $executeInventoryObj;
  }
} else {
  if(DEBUG){
    echo "executeInventory error: " . mysqli_error($con);
  }
}

if (isset($_POST['discount_add'])) {
    extract($_POST);
    $err = "";
    $msg = "";

    if ($starting_date == "") {
        $err = "Starting date is required.";
    } elseif ($ending_date == "") {
        $err = "Ending date is required.";
    } elseif ($discount_amount == "") {
        $err = "Discount amount is required.";
    } elseif (!is_numeric($discount_amount)) {
        $err = "Discount amount can only be numeric.";
    } elseif($inventory == 0){
      $err = "Select Inventory is required.";
    } else {

        $startDate = substr($starting_date, 6, 4) . "-" . substr($starting_date, 3, 2) . "-" . substr($starting_date, 0, 2);
        $endDate = substr($ending_date, 6, 4) . "-" . substr($ending_date, 3, 2) . "-" . substr($ending_date, 0, 2);

        $DiscountSql = mysqli_query($con, "SELECT * FROM product_discounts WHERE PD_product_id=$pid AND PD_inventory_id=$inventory AND PD_status='1' AND (PD_start_date <= '$startDate' AND PD_end_date >= '$startDate' OR PD_start_date <= '$endDate' AND PD_end_date >= '$endDate')");
        $DiscountSqlRow = mysqli_num_rows($DiscountSql);
        $DiscountSqlFetch = mysqli_fetch_assoc($DiscountSql);

        if ($DiscountSqlRow > 0) {
            $err = "A discount already exist between " . $DiscountSqlFetch['PD_start_date'] . " and " . $DiscountSqlFetch['PD_end_date'] . " date range.";
        } else {

          $AddDiscount = '';
          $AddDiscount .= ' PD_product_id = "' . mysqli_real_escape_string($con, $pid) . '"';
          $AddDiscount .= ', PD_start_date = "' . mysqli_real_escape_string($con, $startDate) . '"';
          $AddDiscount .= ', PD_end_date = "' . mysqli_real_escape_string($con, $endDate) . '"';
          $AddDiscount .= ', PD_amount = "' . mysqli_real_escape_string($con, $discount_amount) . '"';
          $AddDiscount .= ', PD_inventory_id = "' . mysqli_real_escape_string($con, $inventory) . '"';
          $AddDiscount .= ', PD_updated_by = "' . mysqli_real_escape_string($con, $aid) . '"';

            $AddDiscountSQL = "INSERT INTO product_discounts SET $AddDiscount";
            $ExecuteAddDiscountSQL = mysqli_query($con, $AddDiscountSQL);

            if ($ExecuteAddDiscountSQL) {
                $msg = "Product discount add successfully.";
            } else {
                if (DEBUG) {
                    echo "ExecuteAddDiscountSQL error" . mysqli_error($con);
                }
                $err = "Product discount could not added";
            }
        }
    }
}
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
//$pid = base64_decode($_GET['pid']);
//$product = mysqli_query($con, "SELECT * FROM products WHERE product_id='$pid'");
//$rowproduct = mysqli_fetch_array($product);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
        <title>Admin Panel | Discount</title>

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
        <!--delete tags-->
<script type="text/javascript">
function redirect()
{
	if (confirm('Do you want to leave Product Editing Module?'))
	{
		window.location = "../index.php";
	}
}

</script>      
        <!--end delete tags-->
 <script type="text/javascript">
function sgnup(id)
{
	if (confirm('Do you want to delete this?'))
    {
		var xmlhttp;
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
			document.getElementById("mydiv").innerHTML=xmlhttp.responseText;
			}
		  }
		xmlhttp.open("GET","delete_discount.php?id="+id,true);
		xmlhttp.send();
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
                <div class="title"><h5>Product Discount Information</h5></div>

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
                        <h5 class="iGraph">Product Discount Information</h5></div>
                    <div class="body">
                        <div class="charts" style="width: 700px; height: auto;">
                            <form action="product_discount.php?pid=<?php echo base64_encode($pid); ?>" method="post" class="mainForm">

                                <!-- Input text fields -->
                                <fieldset>
                                    <div class="widget first">
                                        <div class="head"><h5 class="iList">Product Discount Information</h5></div>

                                        <div class="rowElem noborder">
                                            <label>Starting Date:</label>
                                            <div class="formRight">
                                                <input type="text"  name="starting_date"  value="<?php echo $starting_date; ?>" class="datepicker" />
                                            </div>
                                            <div class="fix"></div>
                                        </div>

                                        <div class="rowElem noborder">
                                            <label>Ending Date:</label>
                                            <div class="formRight">
                                                <input type="text" name="ending_date" value="<?php echo $ending_date; ?>" class="datepicker" />
                                            </div>
                                            <div class="fix"></div>
                                        </div>

                                        <div class="rowElem noborder"><label>Discount Amount:</label><div class="formRight">
                                                <input name="discount_amount" type="text" maxlength="20" value="<?php echo $discount_amount; ?>"/>
                                            </div><div class="fix"></div></div>
                                            
                                            
                                        <div class="rowElem">
                                          <label>Select Inventory :</label>
                                          <div class="formRight">
                                            <select name="inventory" >
                                              <option value="0">Select Default Inventory</option>
                                              <?php
                                              $countInventory = count($arrayInventory);
                                              if ($countInventory > 0):
                                                for ($i = 0; $i < $countInventory; $i++):
                                                  ?>
                                                  <option value="<?php echo $arrayInventory[$i]->PI_id; ?>" <?php if ($invID == $arrayInventory[$i]->PI_id) echo 'selected="selected"'; ?>><?php echo $arrayInventory[$i]->PI_inventory_title; ?></option>
                                                  <?php
                                                endfor;
                                              endif;
                                              ?>
                                            </select>
                                          </div>

                                        </div>


                                        <input type="submit" name="discount_add" value="Product Discount Add" class="greyishBtn submitForm" />
                                        <div class="fix"></div>

                                    </div>
                                </fieldset>

                            </form>		


                        </div>

                        <?php
                        $getdiscount = mysqli_query($con, "SELECT * FROM product_discounts WHERE PD_product_id=$pid AND PD_status='1'");
                        if($getdiscount){
                          if (mysqli_num_rows($getdiscount) > 0) {
                            ?>                          
                            <div class="table">
                                <div class="head">
                                    <h5 class="iFrames">Discount Amount</span></h5></div>
                                <div id="mydiv">    
                                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                    <thead>
                                        <tr>
                                            <td style="mystyle">Inventory Title</td>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Discount Amount</th>
                                            <th>Added on</th>
                                            <th>Added By</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($showdiscount = mysqli_fetch_array($getdiscount)) {
                                            ?>                        

                                            <tr class="gradeA">
                                              <td><?php echo getFieldValue($tableNmae='product_inventories', $fieldName='PI_inventory_title', $where='PI_id=' . $showdiscount['PD_inventory_id']) ; ?></td>
                                                <td><?php
//                                                   
                                                     echo  $showdiscount['PD_start_date'];
                                                    ?></td>
                                                <td><?php
                                                   echo  $showdiscount['PD_end_date'];
//                                  
                                                    ?></td>
                                                
                                                <td> <?php echo  $showdiscount['PD_amount'];?></td>
                                                
                                                <td> <?php echo  $showdiscount['PD_updated'];?></td>
                                                
                                                <td>
                                                <?php
												$adminid = $showdiscount['PD_updated_by'];
												$adminsql = mysqli_query($con,"SELECT (admin_full_name) FROM admins WHERE admin_id='$adminid'");
												$adminrow = mysqli_fetch_array($adminsql);
												echo $adminrow[0];
												?>
                                                </td>
                                                
                                                <td><a href="javascript:sgnup(<?php echo $showdiscount['PD_id']; ?>);" title="Edit"><img src="<?php echo baseUrl('admin/images/deleteFile.png') ?>" height="14" width="14" alt="Edit" /></a></td>
                                            </tr>
                                            <?php
                                        }
                                      }
                                    } else {
                                        //nothing to do
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

        <?php include basePath('admin/footer.php'); ?>
        <script type="text/javascript">
            var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
            var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
            var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
        </script>
