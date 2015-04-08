<?php
include ('../../../config/config.php');

if (!checkAdminLogin()) {
  $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
  redirect($link);
}

$product_priority = 0;
//saving tags in database

$pid = base64_decode($_GET['pid']);

//declaring variables
$title = '';
$product_priority = '';
$desc = '';
$sdesc = '';
$newfrom = '';
$newto = '';
$featuredfrom = '';
$featuredto = '';
$product_status = '';
$inventory = '';
$current_price = '';
$default_title = '';
$default_image = '';
$product_sku = '';
$is_express = 'no';
$tax = 0;


if (isset($_POST['update'])) {
  extract($_POST);

  $err = "";
  $msg = "";

  if ($title == "") {
    $err = "Product Title is required.";
  } elseif ($desc == "") {
    $err = "Long Description is required.";
  } elseif ($sdesc == "") {
    $err = "Short Description is required.";
  } elseif (!preg_match("/([A-Za-z0-9]+)/", $title)) {
    $err = "Product Title can only be Alphanumeric value.";
  } elseif ($inventory == 0) {
    $err = "Default Inventory is required.";
  } else {
    
    if(isset($_POST['express']) AND $_POST['express'] == 'yes'){
      $is_express = 'yes';
    }
    
    $GeneralInformation = '';
    $GeneralInformation .= ' product_title = "' . mysqli_real_escape_string($con, $title) . '"';
    $GeneralInformation .= ', product_priority = "' . mysqli_real_escape_string($con, $product_priority) . '"';
    $GeneralInformation .= ', product_is_express = "' . mysqli_real_escape_string($con, $is_express) . '"';
    $GeneralInformation .= ', product_sku = "' . mysqli_real_escape_string($con, $product_sku) . '"';
    $GeneralInformation .= ', product_short_description = "' . mysqli_real_escape_string($con, $sdesc) . '"';
    $GeneralInformation .= ', product_long_description = "' . mysqli_real_escape_string($con, $desc) . '"';
    $GeneralInformation .= ', product_default_inventory_id = "' . intval($inventory) . '"';
    $GeneralInformation .= ', product_tax_class_id = "' . intval($tax) . '"';
    $GeneralInformation .= ', product_status = "' . mysqli_real_escape_string($con, $product_status) . '"';
    $GeneralInformation .= ', product_show_as_new_from = "' . mysqli_real_escape_string($con, date('Y-m-d', strtotime($newfrom))) . '"';
    $GeneralInformation .= ', product_show_as_new_to = "' . mysqli_real_escape_string($con, date('Y-m-d', strtotime($newto))) . '"';
    $GeneralInformation .= ', product_show_as_featured_from = "' . mysqli_real_escape_string($con, date('Y-m-d', strtotime($featuredfrom))) . '"';
    $GeneralInformation .= ', product_show_as_featured_to = "' . mysqli_real_escape_string($con, date('Y-m-d', strtotime($featuredto))) . '"';

    $UpdateGeneralInfoSQL = "UPDATE products SET $GeneralInformation WHERE product_id='$pid'";
    $ExecuteGeneralInfo = mysqli_query($con, $UpdateGeneralInfoSQL);

    if ($ExecuteGeneralInfo) {
      $msg = "Product General Information updated successfully.";
    } else {
      if (DEBUG) {
        echo "ExecuteGeneralInfo error" . mysqli_error($con);
      }
      $err = "Product General Information update failed";
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
    $product_priority = $getProduct->product_priority;
    $desc = $getProduct->product_long_description;
    $sdesc = $getProduct->product_short_description;
    $product_status = $getProduct->product_status;
    $newfrom = $getProduct->product_show_as_new_from;
    $newto = $getProduct->product_show_as_new_to;
    $featuredfrom = $getProduct->product_show_as_featured_from;
    $featuredto = $getProduct->product_show_as_featured_to;
    $product_sku = $getProduct->product_sku;
    $is_express = $getProduct->product_is_express;
    $tax = $getProduct->product_tax_class_id;
    

    if ($invID > 0) {
      $inventorySql = "SELECT product_inventories.PI_inventory_title, product_inventories.PI_current_price, 
                      product_images.PI_file_name 

                      FROM product_inventories 

                      LEFT JOIN product_images ON product_images.PI_inventory_id=product_inventories.PI_id 
                      WHERE product_inventories.PI_id = " . intval($invID);
      $inventoryResult = mysqli_query($con, $inventorySql);
      if ($inventoryResult) {
        $inventoryResultRowObj = mysqli_fetch_object($inventoryResult);
        if (isset($inventoryResultRowObj->PI_inventory_title)) {
          $current_price = $inventoryResultRowObj->PI_current_price;
          $default_title = $inventoryResultRowObj->PI_inventory_title;
          $default_image = $inventoryResultRowObj->PI_file_name;
        }
      }
    }
  }
}

//getting inventory information from table
$arrayInventory = array();
$sqlInventory = "SELECT PI_id,PI_inventory_title FROM product_inventories WHERE PI_status = 'active' AND PI_product_id=" . intval($pid);
$executeInventory = mysqli_query($con, $sqlInventory);
if ($executeInventory) {
  while ($executeInventoryObj = mysqli_fetch_object($executeInventory)) {
    $arrayInventory[] = $executeInventoryObj;
  }
} else {
  if (DEBUG) {
    echo "executeInventory error: " . mysqli_error($con);
  }
}



//getting tax information from database
$arrayTax = array();
$sqlGetTax = "SELECT * FROM tax_classes";
$executeGetTax = mysqli_query($con, $sqlGetTax);
if ($executeGetTax) {
  while ($executeGetTaxObj = mysqli_fetch_object($executeGetTax)) {
    $arrayTax[] = $executeGetTaxObj;
  }
} else {
  if (DEBUG) {
    echo "executeGetTax error: " . mysqli_error($con);
  } else {
    echo "executeGetTax query failed.";
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
    <title>Admin Panel | Product</title>

    <?php include basePath('admin/header.php'); ?>

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
        <div class="title"><h5>Product's General Information</h5></div>

        <!-- Statistics -->
        <div class="stats">
          <!--          <ul>
                      <li><a href="#" class="count grey" title="" style="font-size: 15px !important; width: inherit;">Product Name: <strong><?php //echo $title;        ?></strong></a></li>
          
                      <li><a href="#" class="count grey" title="">520</a><span>pending orders</span></li>
                      <li><a href="#" class="count grey" title="">14</a><span>new opened tickets</span></li>
                      <li class="last"><a href="#" class="count grey" title="">48</a><span>new user registrations</span></li>
                    </ul>-->
          <div class="fix"></div>
        </div>
        <!-- Website statistics -->
        <div class="widget">
          <div class="head"><h5 class="iChart8">Product basic information</h5></div>
          <table cellpadding="0" cellspacing="0" width="100%" class="tableStatic"> 
            <tbody>
              <tr>
                <td style="width:30%"><a href="#" title="">Product Title</a></td>
                <td><?php echo $title; ?></td>
              </tr>
              <tr>
                <td ><a href="#" title="" >Product Default Inventory Title</a></td>
                <td><?php
                  if ($default_title == '') {
                    echo '<p style="color: red;"><b>Default Inventory is not set</b></p>';
                  } else {
                    echo $default_title;
                  }
                  ?></td>
              </tr>
              <tr>
                <td ><a href="#" title="">Product Current Price</a></td>
                <td><?php
                  if ($default_title == '') {
                    echo '<p style="color: red;"><b>Default Inventory is not set</b></p>';
                  } else {
                    echo $current_price;
                  }
                  ?></td>
              </tr>
              <tr>
                <td ><a href="#" title="">Product Default Image</a></td>
                <td><?php
                  if ($default_image == '') {
                    echo '<p style="color: red;"><b>Default Image is not set</b></p>';
                  } else {
                    echo '<a target="_blank" href="' . baseUrl('upload/product/mid/' . $default_image) . '">Image Link</a>';
                  }
                  ?></td>
              </tr>
            </tbody>
          </table>                    
        </div>

        <!-- Collapsible. Closed by default -->

        <!-- Notification messages -->
        <?php include basePath('admin/message.php'); ?>

        <!-- Charts -->
        <div class="widget first">
          <div class="head">
            <h5 class="iGraph">General Information</h5></div>
          <div class="body">
            <div class="charts" style="width: 700px; height: auto;">
              <form action="index.php?pid=<?php echo base64_encode($pid); ?>" method="post" class="mainForm">

                <!-- Input text fields -->
                <fieldset>
                  <div class="widget first">
                    <div class="head"><h5 class="iList">General Information</h5></div>
                    <div class="rowElem noborder"><label>Product Title:</label><div class="formRight">
                        <input name="title" type="text"  value="<?php echo $title; ?>"/>
                      </div><div class="fix"></div></div>
                    <div class="rowElem noborder"><label>Product Priority:</label><div class="formRight">
                        <input name="product_priority" type="text" value="<?php echo $product_priority; ?>"/>
                      </div><div class="fix"></div></div>
                    <div class="rowElem noborder"><label>Product SKU:</label><div class="formRight">
                        <input name="product_sku" type="text" value="<?php echo $product_sku; ?>"/>
                      </div><div class="fix"></div></div>
                      
                    <div class="head"><h5 class="iPencil">Long Description:</h5></div>      
                    <div><textarea class="tm" rows="5" cols="" name="desc"><?php echo $desc; ?></textarea></div>
                    
                    <div class="rowElem noborder"><label>Short Description:</label><div class="formRight">
                        <textarea rows="5" cols="" class="auto" name="sdesc"><?php echo $sdesc; ?></textarea></div>
                      <div class="fix"></div></div>


                    <div class="rowElem noborder"><label>Product Status:</label>
                      <div class="formRight">      
                        <select name="product_status">
                          <option value="active" 
                          <?php
                          if ($product_status == 'active') {
                            echo 'selected';
                          }
                          ?>>Active</option>
                          <option value="inactive" 
                          <?php
                          if ($product_status == 'inactive') {
                            echo 'selected';
                          }
                          ?>>Inactive</option>

                        </select>
                      </div>
                      <div class="fix"></div></div>
                      
                      
                      <div class="rowElem noborder"><label>Is Express?:</label>
                      <div class="formRight">      
                        <input type="checkbox" name="express" value="yes" <?php if($is_express == 'yes'){ echo 'checked'; } ?>></input> &nbsp;&nbsp;YES
                      </div>
                      <div class="fix"></div></div>


                    <div class="rowElem">
                      <label>Default Inventory :</label>
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
                    
                     <div class="rowElem">
                      <label>Tax Class :</label>
                      <div class="formRight">
                        <select name="tax" >
                          <option value="0">Select Vat Class</option>
                          <?php
                          $countTax = count($arrayTax);
                          if ($countTax > 0):
                            for ($x = 0; $x < $countTax; $x++):
                              ?>
                              <option value="<?php echo $arrayTax[$x]->TC_id; ?>" <?php if ($tax == $arrayTax[$x]->TC_id) echo 'selected="selected"'; ?>><?php echo $arrayTax[$x]->TC_title; ?></option>
                              <?php
                            endfor;
                          endif;
                          ?>
                        </select>
                      </div>

                    </div>

                    <div class="rowElem">
                      <label>Show as new</label> 
                      <div class="formRight moreFields">
                        <ul>
                          <li class="sep" style="color:#000;">From &rArr;</li>
                          <li style="width: 150px;"><input type="text" name="newfrom" value="<?php echo date('d-m-Y', strtotime($newfrom)); ?>" class="datepicker" /></li>
                          <li class="sep" style="color:#000;">To &rArr;</li>
                          <li style="width: 150px;" ><input type="text" name="newto" value="<?php echo date('d-m-Y', strtotime($newto)); ?>" class="datepicker" /></li>
                        </ul>  
                      </div> 
                      <div class="fix"></div>
                    </div>

                    <div class="rowElem">
                      <label>Show as featured</label> 
                      <div class="formRight moreFields">
                        <ul>
                          <li class="sep" style="color:#000;">From &rArr;</li>
                          <li style="width: 150px;"><input type="text" name="featuredfrom" value="<?php echo date('d-m-Y', strtotime($featuredfrom)); ?>" class="datepicker" /></li>
                          <li class="sep" style="color:#000;">To &rArr;</li>
                          <li style="width: 150px;" ><input type="text" name="featuredto" value="<?php echo date('d-m-Y', strtotime($featuredto)); ?>" class="datepicker" /></li>
                        </ul>  
                      </div> 
                      <div class="fix"></div>
                    </div>   


                    <input type="submit" name="update" value="Update Product Details" class="greyishBtn submitForm" />
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
      var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
      var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
    </script>
  </body>
</html>