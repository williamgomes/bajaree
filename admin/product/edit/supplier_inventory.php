<?php
include ('../../../config/config.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}

$aid = getSession('admin_id'); //get admin id
$pid = base64_decode($_GET['pid']);

$supplier = 0;
$inventory = 0;
$price = 0;


//checking for activation id
if (isset($_GET['actid'])) {
    $ActID = $_GET['actid'];
    $sqlActivate = "UPDATE supplier_inventories SET SI_status='active' WHERE SI_id=$ActID";
    $executeActivate = mysqli_query($con, $sqlActivate);
    $link = "supplier_inventory.php?pid=" . $_GET['pid'];
    redirect($link);
}

//checking for deactivation id
if (isset($_GET['inactid'])) {
    $InactID = $_GET['inactid'];
    $sqlInactivate = "UPDATE supplier_inventories SET SI_status='inactive' WHERE SI_id=$InactID";
    $executeInactivate = mysqli_query($con, $sqlInactivate);
    $link = "supplier_inventory.php?pid=" . $_GET['pid'];
    redirect($link);
}

//checking for delete id
if (isset($_GET['del'])) {
    $DeleteID = $_GET['del'];
    $sqlDelete = "DELETE FROM supplier_inventories WHERE SI_id=$DeleteID";
    $executeDelete = mysqli_query($con, $sqlDelete);
    $link = "supplier_inventory.php?pid=" . $_GET['pid'];
    redirect($link);
}



if(isset($_POST['submit'])){
  
  extract($_POST);
  if($supplier == ''){
    $err = "Supplier List is required.";
  } elseif($inventory == ''){
    $err = "Inventory List is required.";
  } elseif($price == 0 OR $price == ''){
    $err = "Price is required.";
  } else {
    
    $count = 0;
    //check if record already exist
    $sqlCheckRecord = "SELECT * FROM supplier_inventories 
                      LEFT JOIN product_inventories ON PI_id=SI_product_inventory_id
                      LEFT JOIN suppliers ON supplier_id=SI_supplier_id
                      WHERE SI_supplier_id=$supplier 
                        AND SI_product_inventory_id=$inventory";
    $resultCheckRecord = mysqli_query($con, $sqlCheckRecord);
    if($resultCheckRecord){
      $count = mysqli_num_rows($resultCheckRecord);
    } else {
      if(DEBUG){
        $err = "resultCheckRecord error: " . mysqli_error($con);
      } else {
        $err = "resultCheckRecord query failed.";
      }
    }
    
    if($count > 0){
      $resultCheckRecordObj = mysqli_fetch_object($resultCheckRecord);
      $supplierName = '';
      $supplierPrice = 0;
      $inventoryTitle = '';
      if(isset($resultCheckRecordObj->SI_supplier_id)){
        $supplierName = $resultCheckRecordObj->supplier_name;
        $supplierPrice = $resultCheckRecordObj->SI_product_cost;
        $inventoryTitle = $resultCheckRecordObj->PI_inventory_title;
      }
      $err = '<strong>' . $supplierName . '</strong> already agreed to supply <strong>' . $inventoryTitle . '</strong> for <strong> TK.' . $supplierPrice . '</strong>';
    } else {
      $addSupplierInventory = '';
      $addSupplierInventory .= ' SI_supplier_id = "' . intval($supplier) . '"';
      $addSupplierInventory .= ', SI_product_inventory_id = "' . intval($inventory) . '"';
      $addSupplierInventory .= ', SI_product_cost = "' . mysqli_real_escape_string($con, $price) . '"';

      $sqlAddSupplierInventory = "INSERT INTO supplier_inventories SET $addSupplierInventory";
      $resultAddSupplierInventory = mysqli_query($con, $sqlAddSupplierInventory);
      if($resultAddSupplierInventory){
        $msg = "Inventory Price added successfully.";
      } else {
        if(DEBUG){
          $err = "resultAddSupplierInventory error " . mysqli_error($con);
        } else {
          $err = "resultAddSupplierInventory query failed.";
        }
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



$arraySupplier = array();
$sqlGetSupplier = "SELECT * FROM suppliers WHERE supplier_status='active'";
$resultGetSupplier = mysqli_query($con, $sqlGetSupplier);
if($resultGetSupplier){
  while($resultGetSupplierObj = mysqli_fetch_object($resultGetSupplier)){
    $arraySupplier[] = $resultGetSupplierObj;
  }
} else {
  if(DEBUG){
     $err = "resultGetSupplier error: " . mysqli_errno($con);
  } else {
    $err = "resultGetSupplier query failed.";
  }
}



$arraySupplierInventory = array();
$sqlSupplierInventory = "SELECT * FROM supplier_inventories 
                  LEFT JOIN product_inventories ON PI_id=SI_product_inventory_id
                  LEFT JOIN suppliers ON supplier_id=SI_supplier_id
                  WHERE PI_product_id=" . intval($pid);
$resultSupplierInventory = mysqli_query($con, $sqlSupplierInventory);
if($resultSupplierInventory){
  while($resultSupplierInventoryObj = mysqli_fetch_object($resultSupplierInventory)){
    $arraySupplierInventory[] = $resultSupplierInventoryObj;
  }
} else {
  if(DEBUG){
    $err = "resultAddSupplierInventory error: " . mysqli_error($con);
  } else {
    $err = "resultAddSupplierInventory query failed.";
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
        <title>Admin Panel | Meta</title>

        <?php include basePath('admin/header.php');?>


        <!--Effect on left error menu, top message menu, body-->
        <!-- Activation Script -->
        <script type="text/javascript">
            function active(pin_id) {
                jConfirm('You want to ACTIVATE this?', 'Confirmation Dialog', function(r) {
                    if (r) {
                        /*alert(r);*/
                        window.location.href = 'supplier_inventory.php?<?php echo $_SERVER['QUERY_STRING']; ?>&actid=' + pin_id;
                    }
                });
            }
        </script>
        <!--Activation Script -->
        
        <!-- Deactivation Script -->
        <script type="text/javascript">
            function inactive(pin_id) {
                jConfirm('You want to DEACTIVATE this?', 'Confirmation Dialog', function(r) {
                    if (r) {
                        /*alert(r);*/
                        window.location.href = 'supplier_inventory.php?<?php echo $_SERVER['QUERY_STRING']; ?>&inactid=' + pin_id;
                    }
                });
            }

        </script>
        <!--Deactivation Script -->
        
        
        <!--end delete tags-->
        <script type="text/javascript">
            function del(pin_id) {
                jConfirm('You want to DELETE this?', 'Confirmation Dialog', function(r) {
                    if (r) {
                        /*alert(r);*/
                        window.location.href = 'supplier_inventory.php?<?php echo $_SERVER['QUERY_STRING']; ?>&del=' + pin_id;
                    }
                });
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
                <div class="title"><h5>Supplier &rAarr; Inventory Module</h5></div>

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
                        <h5 class="iGraph">Supplier &rAarr; Inventory Information</h5></div>
                    <div class="body">
                        <div class="charts" style="width: 700px; height: auto;">
                            <form action="supplier_inventory.php?pid=<?php echo base64_encode($pid); ?>" method="post" class="mainForm">

                                <!-- Input text fields -->
                                <fieldset>
                                    <div class="widget first">
                                        <div class="head"><h5 class="iList">Supplier &rAarr; Inventory Information</h5></div>
                                        
                                        <div class="rowElem noborder"><label>Supplier List:</label><div class="formRight">
                                                <select name="supplier" >
                                                  <option value="0">Select Default Inventory</option>
                                                  <?php
                                                  $countSupplier = count($arraySupplier);
                                                  if($countSupplier > 0):
                                                    for($y = 0; $y < $countSupplier; $y++):
                                                      ?>
                                                      <option value="<?php echo $arraySupplier[$y]->supplier_id; ?>" <?php if ($supplier == $arraySupplier[$y]->supplier_id) echo 'selected="selected"'; ?>><?php echo $arraySupplier[$y]->supplier_name; ?></option>
                                                      <?php
                                                    endfor;
                                                  endif;
                                                  ?>
                                                </select>
                                            </div><div class="fix"></div></div>
                                        
                                        <div class="rowElem noborder"><label>Inventory List:</label><div class="formRight">
                                                <select name="inventory" >
                                                  <option value="0">Select Default Inventory</option>
                                                  <?php
                                                  $countInventory = count($arrayInventory);
                                                  if ($countInventory > 0):
                                                    for ($i = 0; $i < $countInventory; $i++):
                                                      ?>
                                                      <option value="<?php echo $arrayInventory[$i]->PI_id; ?>" <?php if ($inventory == $arrayInventory[$i]->PI_id) echo 'selected="selected"'; ?>><?php echo $arrayInventory[$i]->PI_inventory_title; ?></option>
                                                      <?php
                                                    endfor;
                                                  endif;
                                                  ?>
                                                </select>
                                            </div><div class="fix"></div></div>
                                        
                                        <div class="rowElem noborder">
                                            <label>Price:</label>
                                            <div class="formRight">
                                                <input name="price" type="text" value="<?php echo $price; ?>"/>
                                            </div>
                                        </div>
                                        <div class="fix"></div>


                                        <input type="submit" name="submit" value="Add Price" class="greyishBtn submitForm" />
                                        <div class="fix"></div>

                                    </div>
                                </fieldset>

                            </form>		


                        </div>


                      <div class="table">
                            <div class="head">
                                <h5 class="iFrames">Supplier &rAarr; Inventory List</h5></div>
                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                <thead>
                                    <tr>
                                        <th>Supplier Name</th>
                                        <th>Inventory Title</th>
                                        <th>Offered Price</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php
$countSupplierInventory = count($arraySupplierInventory);
if($countSupplierInventory > 0):
  for($y = 0; $y < $countSupplierInventory; $y++):
    ?>
                                  <tr class="gradeA">
                                      <td><?php echo $arraySupplierInventory[$y]->supplier_name; ?></td>
                                      <td><?php echo $arraySupplierInventory[$y]->PI_inventory_title; ?></td>
                                      <td><?php echo $arraySupplierInventory[$y]->SI_product_cost; ?></td>
                                      <td class="center">
                                        <?php
                                        if ($arraySupplierInventory[$y]->SI_status == 'active') {
                                          echo '<a href="javascript:inactive(' . $arraySupplierInventory[$y]->SI_id . ');"><img src="' . baseUrl('admin/images/customButton/on.png') . '" width="60" /></a>';
                                        } else {
                                          echo '<a href="javascript:active(' . $arraySupplierInventory[$y]->SI_id . ');"><img src="' . baseUrl('admin/images/customButton/off.png') . '" width="60" /></a>';
                                        }
                                        ?>
                                      </td>
                                      <td class="center"><a href="javascript:del(<?php echo $arraySupplierInventory[$y]->SI_id; ?>);"><img src="<?php echo baseUrl('admin/images/deleteFile.png');?>" height="14" width="14" /></a></td>
                                  </tr>
    <?php
  endfor;
endif;
?>                        

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
            <!-- Content End -->

            <div class="fix"></div>
        </div>

<?php include basePath('admin/footer.php'); ?>

