<?php
include ('../../config/config.php');

$order_id = 0;
$userID = 0;
$promotionID = 0;
if (isset($_GET['oid']) AND $_GET['oid'] != '') {
  $order_id = base64_decode($_GET['oid']);
}


$product_title = '';
$inventory_title = '';
$supplier_name = '';
$quantity = 0;
$unit_tax = 0;
$unit_price = 0;
$unit_discount = 0;
$total_price = 0;
$total_discount = 0;
$inventory_id = 0;
$product_quantity = 0;
$product_id = 0;
$product_unit_price = 0;
$product_unit_discount = 0;
$product_tax = 0;
$supplier = 0;
$checkCompleteOrderCount = 0;
$couponDiscountType = '';
$couponDiscountAmount = 0;


//getting order details from database
$sqlGetOrder = "SELECT * FROM orders WHERE order_id=$order_id";
$resultGetOrder = mysqli_query($con,$sqlGetOrder);
if($resultGetOrder){
  $resultGetOrderObj = mysqli_fetch_object($resultGetOrder);
  if(isset($resultGetOrderObj->order_id)){
    $userID = $resultGetOrderObj->order_user_id;
    $promotionID = $resultGetOrderObj->order_promotion_codes_id;
  }
} else {
  if(DEBUG){
    echo "resultGetOrder error: " . mysqli_error($con);
  } else {
    echo "resultGetOrder query failed.";
  }
}


if($promotionID > 0){ 
  $sqlCheckCoupon = "SELECT * FROM promotion_codes 
                  LEFT JOIN promotion_discount_range ON PDR_promotion_id=PC_promotion_id
                  WHERE PC_id='$promotionCode'";
  $resultCheckCoupon = mysqli_query($con, $sqlCheckCoupon);
  if($resultCheckCoupon){
    $resultCheckCouponObj = mysqli_fetch_object($resultCheckCoupon);
    if(isset($resultCheckCouponObj->PC_id)){
      $couponDiscountType = $resultCheckCouponObj->PDR_discount_type;
      $couponDiscountAmount = $resultCheckCouponObj->PDR_discount_quantity;
    }
  } else {
    if(DEBUG){
    echo "resultCheckCoupon error: " . mysqli_error($con);
  } else {
    echo "resultCheckCoupon query failed.";
  }
  }
}


//getting paid or delivered order count from database
$sqlGetOrderCount = "SELECT * FROM orders WHERE order_user_id=$userID AND (order_status='delivered' OR order_status='paid' OR order_status='approved')";
$resultGetOrderCount = mysqli_query($con, $sqlGetOrderCount);
if($resultGetOrderCount){
  $checkCompleteOrderCount = mysqli_num_rows($resultGetOrderCount);
} else {
  if(DEBUG){
    echo "resultGetOrderCount error: " . mysqli_error($con);
  } else {
    echo "resultGetOrderCount query failed.";
  }
}



$aid = getSession('admin_id');

if (isset($_GET['delid']) AND $_GET['delid'] > 0) {
  $DeleteID = intval($_GET['delid']);
  $sqlDelete = "UPDATE order_products SET OP_is_deleted='yes', OP_updated_by=$aid WHERE OP_id=$DeleteID";
  $resultDelete = mysqli_query($con, $sqlDelete);
  if ($resultDelete) {
    $msg = "Product deleted successfully";
    $link = baseUrl() . "admin/order/edit-order.php?oid=" . $_GET['oid'] . "&msg=" . base64_encode($msg);
    redirect($link);
  }
}



//saving products outside bajaree
if (isset($_POST['fromBajaree'])) {

  extract($_POST);

  if ($inventory_id == 0) {
    $err = "Inventory ID is required.";
  } elseif ($product_quantity == 0) {
    $err = "Product Quantity is required.";
  } else {

    $total_price = $product_unit_price * $product_quantity;
    $total_discount = $product_unit_discount * $product_quantity;

    $AddProductInside = '';
    $AddProductInside .= ' OP_order_id = "' . intval($order_id) . '"';
    $AddProductInside .= ', OP_user_id = "' . intval($userID) . '"';
    $AddProductInside .= ', OP_product_id = "' . intval($product_id) . '"';
    $AddProductInside .= ', OP_product_inventory_id = "' . intval($inventory_id) . '"';
    $AddProductInside .= ', OP_supplier_id = "' . intval($supplier) . '"';
    $AddProductInside .= ', OP_price = "' . floatval($product_unit_price) . '"';
    $AddProductInside .= ', OP_discount = "' . floatval($product_unit_discount) . '"';
    $AddProductInside .= ', OP_product_quantity = "' . floatval($product_quantity) . '"';
    $AddProductInside .= ', OP_product_tax = "' . floatval($product_tax) . '"';
    $AddProductInside .= ', OP_product_total_discount = "' . floatval($total_discount) . '"';
    $AddProductInside .= ', OP_product_total_price = "' . floatval($total_price) . '"';
    $AddProductInside .= ', OP_updated_by = "' . intval($aid) . '"';


    $sqlAddProductInside = "INSERT INTO order_products SET $AddProductInside";
    $resultAddProductInside = mysqli_query($con, $sqlAddProductInside);
    if ($resultAddProductInside) {
      $msg = "Product added successfully.";
    } else {
      if (DEBUG) {
        echo "resultAddProductInside error: " . mysqli_error($con);
      } else {
        echo "resultAddProductInside query failed.";
      }
    }
  }
}




//saving products outside bajaree
if (isset($_POST['outsidebajaree'])) {

  extract($_POST);

  if ($product_title == "") {
    $err = "Product Name is required.";
  } elseif ($inventory_title == "") {
    $err = "Product Inventory Name is required.";
  } elseif ($supplier_name == "") {
    $err = "Supplier Name is required.";
  } elseif ($quantity == "") {
    $err = "Product Quantity is required.";
  } elseif ($unit_tax == "") {
    $err = "Product Unit Tax is required.";
  } elseif ($unit_price == "") {
    $err = "Product Unit Price is required.";
  } elseif ($unit_discount == "") {
    $err = "Product Unit Discount is required.";
  } else {

    $total_price = $unit_price * $quantity;
    $total_discount = $total_discount * $quantity;

    $AddProductOutside = '';
    $AddProductOutside .= ' OPE_order_id = "' . intval($order_id) . '"';
    $AddProductOutside .= ', OPE_user_id = "' . intval($userID) . '"';
    $AddProductOutside .= ', OPE_product_name = "' . mysqli_real_escape_string($con, $product_title) . '"';
    $AddProductOutside .= ', OPE_product_inventory_name = "' . mysqli_real_escape_string($con, $inventory_title) . '"';
    $AddProductOutside .= ', OPE_supplier_name = "' . mysqli_real_escape_string($con, $supplier_name) . '"';
    $AddProductOutside .= ', OPE_price = "' . floatval($unit_price) . '"';
    $AddProductOutside .= ', OPE_discount = "' . floatval($unit_discount) . '"';
    $AddProductOutside .= ', OPE_quantity = "' . floatval($quantity) . '"';
    $AddProductOutside .= ', OPE_tax = "' . floatval($unit_tax) . '"';
    $AddProductOutside .= ', OPE_total_discount = "' . floatval($total_discount) . '"';
    $AddProductOutside .= ', OPE_total_price = "' . floatval($total_price) . '"';
    $AddProductOutside .= ', OPE_updated_by = "' . intval($aid) . '"';


    $sqlAddProductOutside = "INSERT INTO order_products_external SET $AddProductOutside";
    $resultAddProductOutside = mysqli_query($con, $sqlAddProductOutside);
    if ($resultAddProductOutside) {
      $msg = "Product added successfully.";
    } else {
      if (DEBUG) {
        echo "resultAddProductOutside error: " . mysqli_error($con);
      } else {
        echo "resultAddProductOutside query failed.";
      }
    }
  }
}



//getting order product list from database
$arrayOrderProduct = array();
$sqlOrderProduct = "SELECT * 
  
                          FROM order_products
                          
                          LEFT JOIN product_inventories ON PI_id=OP_product_inventory_id
                          LEFT JOIN products ON product_id=OP_product_id
                          WHERE OP_order_id=$order_id";
$ExecuteOrderProduct = mysqli_query($con, $sqlOrderProduct);
if ($ExecuteOrderProduct) {
  while ($ExecuteOrderProductObj = mysqli_fetch_object($ExecuteOrderProduct)) {
    $arrayOrderProduct[] = $ExecuteOrderProductObj;
  }
} else {
  if (DEBUG) {
    $err = "ExecuteOrderProduct error: " . mysqli_error($con);
  } else {
    $err = "ExecuteOrderProduct query failed.";
  }
}




//getting order product list from database which were not deleted
$inProductTotalPrice = 0;
$inProductTotalDiscount = 0;
$inProductTotalTax = 0;
$inProductTotalQuantity = 0;

$arrayOrderProductExist = array();
$sqlOrderProductExist = "SELECT * 
  
                          FROM order_products
                          
                          LEFT JOIN product_inventories ON PI_id=OP_product_inventory_id
                          LEFT JOIN products ON product_id=OP_product_id
                          WHERE OP_order_id=$order_id
                          AND OP_is_deleted='no'";
$ExecuteOrderProductExist = mysqli_query($con, $sqlOrderProductExist);
if ($ExecuteOrderProductExist) {
  while ($ExecuteOrderProductExistObj = mysqli_fetch_object($ExecuteOrderProductExist)) {
    $arrayOrderProductExist[] = $ExecuteOrderProductExistObj;
    $inProductTotalPrice = $inProductTotalPrice + $ExecuteOrderProductExistObj->OP_product_total_price;
    $inProductTotalDiscount = $inProductTotalDiscount + $ExecuteOrderProductExistObj->OP_product_total_discount;
    $inProductTotalTax = $inProductTotalTax + (($ExecuteOrderProductExistObj->OP_product_tax * $ExecuteOrderProductExistObj->OP_product_total_price) / 100);
    $inProductTotalQuantity = $inProductTotalQuantity + $ExecuteOrderProductExistObj->OP_product_quantity;
  }
} else {
  if (DEBUG) {
    $err = "ExecuteOrderProduct error: " . mysqli_error($con);
  } else {
    $err = "ExecuteOrderProduct query failed.";
  }
}



//getting external order product list from database
$outProductTotalPrice = 0;
$outProductTotalDiscount = 0;
$outProductTotalTax = 0;
$outProductTotalQuantity = 0;

$arrayOrderProductExternal = array();
$sqlOrderProductExternal = "SELECT * 
  
                          FROM order_products_external
                          
                          WHERE OPE_order_id=$order_id";
$ExecuteOrderProductExternal = mysqli_query($con, $sqlOrderProductExternal);
if ($ExecuteOrderProductExternal) {
  while ($ExecuteOrderProductExternalObj = mysqli_fetch_object($ExecuteOrderProductExternal)) {
    $arrayOrderProductExternal[] = $ExecuteOrderProductExternalObj;
    $outProductTotalPrice = $outProductTotalPrice + $ExecuteOrderProductExternalObj->OPE_total_price;
    $outProductTotalDiscount = $outProductTotalDiscount + $ExecuteOrderProductExternalObj->OPE_total_discount;
    $outProductTotalTax = $outProductTotalTax + (($ExecuteOrderProductExternalObj->OPE_tax * $ExecuteOrderProductExternalObj->OPE_total_price) / 100);
    $outProductTotalQuantity = $outProductTotalQuantity + $ExecuteOrderProductExternalObj->OPE_quantity;
  }
} else {
  if (DEBUG) {
    $err = "ExecuteOrderProductExternal error: " . mysqli_error($con);
  } else {
    $err = "ExecuteOrderProductExternal query failed.";
  }
}




//getting product list from database
$arrayProducts = array();
$sqlProducts = "SELECT * FROM products WHERE product_status='active'";
$resultProducts = mysqli_query($con, $sqlProducts);
if ($resultProducts) {
  while ($resultProductsObj = mysqli_fetch_object($resultProducts)) {
    $arrayProducts[] = $resultProductsObj;
  }
} else {
  if (DEBUG) {
    echo "resultProducts error: " . mysqli_error($con);
  }
}




//updating whole order calculation for the order
$totalOrderPrice = 0;
$totalOrderDiscount = 0;
$totalOrderTax = 0;
$totalOrderQuantity = 0;
$promoDiscountAmount = 0;
if(isset($_POST['submit'])){
  
  
  $totalOrderPrice = $inProductTotalPrice + $outProductTotalPrice;
  $totalOrderDiscount += $inProductTotalDiscount + $outProductTotalDiscount;
  $totalOrderTax = $inProductTotalTax + $outProductTotalTax;
  $totalOrderQuantity = $inProductTotalQuantity + $outProductTotalQuantity;
  
  
  //checking if first order then give 10% discount
  if($checkCompleteOrderCount == 0 OR $checkCompleteOrderCount == ''){
    $totalOrderDiscount += ($totalOrderPrice * 10) / 100;
  }
  

  //checking promo code type and applying discount
  if($couponDiscountType == "percentage"){
    $promoDiscountAmount = ($totalOrderPrice * $couponDiscountAmount) / 100;
  } else {
    $promoDiscountAmount = $couponDiscountAmount;
  }
  
  $updateOrder = '';
  $updateOrder .= ' order_total_item = "' . floatval($totalOrderQuantity) . '"';
  $updateOrder .= ', order_total_amount = "' . floatval($totalOrderPrice) . '"';
  $updateOrder .= ', order_discount_amount = "' . floatval($totalOrderDiscount) . '"';
  $updateOrder .= ', order_vat_amount = "' . floatval($totalOrderTax) . '"';
  $updateOrder .= ', order_promotion_discount_amount = "' . floatval($promoDiscountAmount) . '"';
  $updateOrder .= ', order_updated_by = "' . intval($aid) . '"';
  
  $sqlUpdateOrder = "UPDATE orders SET $updateOrder WHERE order_id=$order_id";
  $resultUpdateOrder = mysqli_query($con, $sqlUpdateOrder);
  if($resultUpdateOrder){
    $msg = "Order updated successfully.";
    $link = 'order_details.php?oid=' . $_GET['oid'] . '&msg=' . base64_encode($msg);
    redirect($link);
  } else {
    if(DEBUG){
      echo "resultUpdateOrder error: " . mysqli_error($con);
    }
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
    <title>Admin Panel | Product Module</title>

    <link href="<?php echo baseUrl('admin/css/main.css'); ?>" rel="stylesheet" type="text/css" /> 
    <script src="<?php echo baseUrl('admin/js/jquery.min.js'); ?>" type="text/javascript"></script>  
    <!--Start admin panel js/css --> 
    <?php include basePath('admin/header.php'); ?>   
    <!--End admin panel js/css -->    


    <script type="text/javascript" src="<?php echo baseUrl(); ?>admin/order/main.js"></script>

    <!--Effect on left error menu, top message menu, body-->
    <!--delete tags-->
    <script type="text/javascript">
      function del(pin_id) {
        jConfirm('You want to DELETE this?', 'Confirmation Dialog', function(r) {
          if (r) {
            /*alert(r);*/
            window.location.href = 'edit-order.php?<?php echo $_SERVER['QUERY_STRING']; ?>&delid=' + pin_id;
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
      <?php include ('order_left_navigation.php'); ?>

      <!-- Content Start -->
      <div class="content">

        <div class="title"><h5>Edit Order Product Lists</h5></div>


        <!-- Notification messages -->
        <?php include basePath('admin/message.php'); ?>

        <!-- Charts -->



        <div class="widget">    
          <div class="rowElem">
<!--            <label>Add New Product :</label>-->
            <input id='btnFromBajaree' style="float: left !important" type="button" name="submit" value="Add Product from Bajaree" class="greyishBtn submitForm" />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input id='btnOutsideBajaree' style="float: left !important" type="button" name="submit" value="Add Product outside Bajaree" class="greyishBtn submitForm" />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <form action="edit-order.php?oid=<?php echo $_GET['oid']; ?>" method="post">
              <input style="float: right !important; background-color: tomato; bottom: 20px !important; position: relative;" type="submit" name="submit" value="UPDATE WHOLE ORDER"  />
            </form>
          </div>
        </div>


        <div class="widget first"<?php
        if (isset($_POST['fromBajaree'])) {
          echo 'style="display: block;"';
        } else {
          echo 'style="display: none;"';
        }
        ?> id='addFromBajaree'>
          <div class="head">
            <h5 class="iGraph">Add Product</h5></div>
          <div class="body">
            <div class="charts" style="width: 700px; height: auto;">
              <form action="edit-order.php?oid=<?php echo $_GET['oid']; ?>" method="post" class="mainForm">

                <!-- Input text fields -->
                <fieldset>
                  <div class="widget first">
                    <div class="head">
                      <h5 class="iList">Add Product from Bajaree</h5></div>

                    <div class="rowElem noborder"><label>Inventory ID:</label><div class="formRight">                                        
                        <input type="text" name="inventory_id" onkeyup="showProductInfo(this.value);" value="<?php echo $inventory_id; ?>" required="required"></input>
                      </div><div class="fix"></div></div>

                    <div class="rowElem noborder"><label>Product Title:</label><div class="formRight">                                        
                        <span style="font-weight: bolder" id="productTitle">Provide Inventory ID</span>
                      </div><div class="fix"></div></div> 

                    <div class="rowElem noborder"><label>Inventory Title:</label><div class="formRight">                                        
                        <span style="font-weight: bolder" id="inventoryTitle">Provide Inventory ID</span>
                      </div><div class="fix"></div></div> 

                    <div class="rowElem noborder"><label>Supplier Name:</label><div class="formRight">                                        
                        <span style="font-weight: bolder" id="supplier">Provide Inventory ID</span>
                      </div><div class="fix"></div></div>    

                    <div class="rowElem noborder"><label>Product Quantity:</label><div class="formRight">                                        
                        <input type="text" name="product_quantity" value="<?php echo $product_quantity; ?>" required="required"></input>
                      </div><div class="fix"></div></div>

                    <input type="hidden" name="product_id" id="product_id" value="<?php echo $product_id; ?>"></input>  
                    <input type="hidden" name="product_unit_price" id="unit_price" value="<?php echo $product_unit_price; ?>"></input>  
                    <input type="hidden" name="product_unit_discount" id="unit_discount" value="<?php echo $product_unit_discount; ?>"></input>  
                    <input type="hidden" name="product_tax" id="tax" value="<?php echo $product_tax; ?>"></input>  

                    <input type="submit" name="fromBajaree" value="Add Product from Bajaree" class="greyishBtn submitForm" />
                    <div class="fix"></div>

                  </div>
                </fieldset>

              </form>		


            </div>
          </div>
        </div>



        <div class="widget first" <?php
        if (isset($_POST['outsidebajaree'])) {
          echo 'style="display: block;"';
        } else {
          echo 'style="display: none;"';
        }
        ?> id='addOutsideBajaree'>
          <div class="head">
            <h5 class="iGraph">Add Product</h5></div>
          <div class="body">
            <div class="charts" style="width: 700px; height: auto;">
              <form action="edit-order.php?oid=<?php echo $_GET['oid']; ?>" method="post" class="mainForm">

                <!-- Input text fields -->
                <fieldset>
                  <div class="widget first">
                    <div class="head">
                      <h5 class="iList">Add Product outside Bajaree</h5></div>

                    <div class="rowElem noborder"><label>Product Title:</label><div class="formRight">                                        
                        <input type="text" name="product_title" value="<?php echo $product_title; ?>"></input>
                      </div><div class="fix"></div></div>    

                    <div class="rowElem noborder"><label>Product Inventory Title:</label><div class="formRight">                                        
                        <input type="text" name="inventory_title" value="<?php echo $inventory_title; ?>"></input>
                      </div><div class="fix"></div></div>    

                    <div class="rowElem noborder"><label>Supplier Name:</label><div class="formRight">                                        
                        <input type="text" name="supplier_name" value="<?php echo $supplier_name; ?>"></input>
                      </div><div class="fix"></div></div>    

                    <div class="rowElem noborder"><label>Product Quantity:</label><div class="formRight">                                        
                        <input type="text" name="quantity" value="<?php echo $quantity; ?>"></input>
                      </div><div class="fix"></div></div>

                    <div class="rowElem noborder"><label>Product Unit Vat (%):</label><div class="formRight">                                        
                        <input type="text" name="unit_tax" value="<?php echo $unit_tax; ?>"></input>
                      </div><div class="fix"></div></div>

                    <div class="rowElem noborder"><label>Product Unit Price:</label><div class="formRight">                                        
                        <input type="text" name="unit_price" value="<?php echo $unit_price; ?>"></input>
                      </div><div class="fix"></div></div>  

                    <div class="rowElem noborder"><label>Product Unit Discount:</label><div class="formRight">                                        
                        <input type="text" name="unit_discount" value="<?php echo $unit_discount; ?>"></input>
                      </div><div class="fix"></div></div>    


                    <input type="submit" name="outsidebajaree" value="Add Product outside Bajaree" class="greyishBtn submitForm" />
                    <div class="fix"></div>

                  </div>
                </fieldset>

              </form>		


            </div>
          </div>
        </div>




        <div class="table">
          <div class="head">
            <h5 class="iFrames">Order List</h5></div>


          <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
            <thead>
              <tr>
                <th>Product</th>
                <th>Inventory</th>
                <th>Quantity</th>
                <th>Total Tax</th>
                <th>Total Discount</th>
                <th>Total Price</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $status = '';
              $countArrayProduct = count($arrayOrderProduct);
              if ($countArrayProduct > 0):
                for ($i = 0; $i < $countArrayProduct; $i++):

                  $status = $arrayOrderProduct[$i]->OP_is_deleted;
                  ?>
                  <tr>
                    <td><?php if ($status == "yes") {
                    echo "<strike>";
                  } ?> <?php echo $arrayOrderProduct[$i]->product_title; ?> <?php if ($status == "yes") {
                    echo "</strike>";
                  } ?> </td>
                    <td><?php if ($status == "yes") {
                    echo "<strike>";
                  } ?> <?php echo $arrayOrderProduct[$i]->PI_inventory_title; ?> <?php if ($status == "yes") {
                    echo "</strike>";
                  } ?> </td>
                    <td id="quantity_data_<?php echo $arrayOrderProduct[$i]->OP_id; ?>"><?php if ($status == "yes") {
                echo "</strike>";
              } ?>
                      <a href="javascript:resetPriority(<?php echo $arrayOrderProduct[$i]->OP_id; ?>,<?php echo $arrayOrderProduct[$i]->OP_product_quantity; ?>);" ><?php echo $arrayOrderProduct[$i]->OP_product_quantity; ?></a>
    <?php if ($status == "yes") {
      echo "</strike>";
    } ?> </td>
                    <td id="tax_data_<?php echo $arrayOrderProduct[$i]->OP_id; ?>"> <?php if ($status == "yes") {
      echo "<strike>";
    } ?> <?php echo number_format((($arrayOrderProduct[$i]->OP_product_tax * $arrayOrderProduct[$i]->OP_product_total_price) / 100), 2); ?> <?php if ($status == "yes") {
      echo "</strike>";
    } ?> </td>
                    <td id="discount_data_<?php echo $arrayOrderProduct[$i]->OP_id; ?>"> <?php if ($status == "yes") {
      echo "<strike>";
    } ?> <?php echo number_format($arrayOrderProduct[$i]->OP_product_total_discount, 2); ?> <?php if ($status == "yes") {
      echo "</strike>";
    } ?> </td>
                    <td id="price_data_<?php echo $arrayOrderProduct[$i]->OP_id; ?>"> <?php if ($status == "yes") {
      echo "<strike>";
    } ?> <?php echo number_format($arrayOrderProduct[$i]->OP_product_total_price, 2); ?> <?php if ($status == "yes") {
      echo "</strike>";
    } ?> </td>
                    <td class="center"> <?php if ($status == "yes") {
      echo "<strike>";
    } ?> <a href="javascript:del(<?php echo $arrayOrderProduct[$i]->OP_id; ?>)"><img src="<?php echo baseUrl('admin/images/deleteFile.png'); ?>" height="10" width="10" alt="Delete" /></a> <?php if ($status == "yes") {
      echo "</strike>";
    } ?> </td>
                  </tr>
    <?php
  endfor;
endif;
?>
              
              <?php
              $countArrayProductExternal = count($arrayOrderProductExternal);
              if ($countArrayProductExternal > 0):
                for ($a = 0; $a < $countArrayProductExternal; $a++):
                  ?>
                  <tr>
                    <td><?php echo $arrayOrderProductExternal[$a]->OPE_product_name; ?> [Ex]</td>
                    <td><?php echo $arrayOrderProductExternal[$a]->OPE_product_inventory_name; ?> </td>
                    <td><?php echo $arrayOrderProductExternal[$a]->OPE_quantity; ?></td>
                    <td> <?php echo number_format((($arrayOrderProductExternal[$a]->OPE_tax * $arrayOrderProductExternal[$a]->OPE_total_price) / 100), 2); ?> </td>
                    <td> <?php echo number_format($arrayOrderProductExternal[$a]->OPE_total_discount, 2); ?>  </td>
                    <td>  <?php echo number_format($arrayOrderProductExternal[$a]->OPE_total_price, 2); ?>  </td>
                    <td class="center"> 
                      <!--<img src="<?php // echo baseUrl('admin/images/deleteFile.png'); ?>" height="10" width="10" alt="Delete" />--> 
                    </td>
                  </tr>
    <?php
  endfor;
endif;
?>
              
            </tbody>

          </table>



        </div>






      </div>
      <!-- Content End -->











    </div>
    </div>

    </div>
    <!-- Content End -->

    <div class="fix"></div>
    </div>

<?php include basePath('admin/footer.php'); ?>


    <script type="text/javascript">
      $("#btnFromBajaree").click(function() {
        $("#addFromBajaree").slideToggle();
        $("input[name=inventory_title]").focus();
        $("#addOutsideBajaree").slideUp();
      });

      $("#btnOutsideBajaree").click(function() {
        $("#addFromBajaree").slideUp();
        $("#addOutsideBajaree").slideToggle();
      });

    </script>

    <script type="text/javascript">

      function resetPriority(OP_id, product_quantity) {


        var new_product_quantity = prompt("Product Quantity ", product_quantity);
        var table_name = 'order_products';
        var update_field = 'OP_product_quantity';
        var where_condition = 'OP_id=' + OP_id;
        if (new_product_quantity == product_quantity)
        {
          //do nothing 
          //  $.jGrowl('Status could not update  ');
        } else if (new_product_quantity > 0) {
          //call ajax 

          $.ajax({url: "../ajax/quantity_update_order_product.php",
            data: {id: OP_id, new_product_quantity: new_product_quantity, table_name: table_name, update_field: update_field, where_condition: where_condition}, //Modify this
            type: 'post',
            success: function(output) {
              var result = $.parseJSON(output);
              if (result.error == 0) {
                //Query failed
                $.jGrowl(result.error_text);

                $("td#quantity_data_" + OP_id).html('<a href="javascript:resetPriority(' + OP_id + ',' + new_product_quantity + ');">' + new_product_quantity + '</a>');
                $("td#price_data_" + OP_id).text(result.new_total_price);
                $("td#discount_data_" + OP_id).text(result.new_total_discount);
                $("td#tax_data_" + OP_id).text(result.new_total_tax);

              } else if (result.error > 0) {
                //Query failed
                $.jGrowl(result.error_text);

              }

            }
          });
        } else {
          // do nothink 
          $.jGrowl('Quantity can not be 0.');
        }
      }


    </script>

