<?php
include 'config/config.php';

if(!checkUserLogin()){
  $err = "You need to login first.";
  $link = baseUrl() . 'index.php?err=' . base64_encode($err);
  redirect($link);
} else {
  $userID = getSession('UserID');
}

$purchaseDate = '';
$addressTitle = '';
$address = '';
$city = '';
$country = '';
$phone = '';
$zip = '';


$orderID = 0;
if(isset($_GET['order_id']) AND $_GET['order_id'] > 0){
  $orderID = $_GET['order_id'];
} else {
  $err = "Invalid Parameter.";
  $link = baseUrl() . 'my-orders?err=' . base64_encode($err);
  redirect($link);
}


$page_title = get_option('SITE_DEFAULT_META_TITLE');
$page_description = get_option('SITE_DEFAULT_META_DESCRIPTION');
$page_keywords = get_option('SITE_DEFAULT_META_KEYWORDS');
$site_author = $config['CONFIG_SETTINGS']['SITE_AUTHOR'];


//getting product information from database
$arrayProduct = array();
$sqlOrderProduct = "SELECT * FROM order_products"
        ." LEFT JOIN products ON products.product_id=order_products.OP_product_id"
        ." LEFT JOIN product_inventories ON product_inventories.PI_id=order_products.OP_product_inventory_id"
        ." LEFT JOIN product_images ON product_images.PI_inventory_id=order_products.OP_product_inventory_id"
        ." WHERE order_products.OP_order_id=$orderID"
        ." ORDER BY  order_products.OP_id ASC";
$executeOrderProducts = mysqli_query($con,$sqlOrderProduct);
if($executeOrderProducts){
  while($executeOrderProductsObj = mysqli_fetch_object($executeOrderProducts)){
    $arrayProduct[] = $executeOrderProductsObj;
  }
} else {
  if(DEBUG){
    echo "executeOrderProducts error: " . mysqli_error($con);
  } else {
    echo "executeOrderProducts query failed.";
  }
}
//echo "<pre>";
//print_r($arrayProduct);
//echo "</pre>";


//getting user's order list from database
$sqlOrder = "SELECT * FROM orders WHERE order_id=$orderID";
$executeOrders = mysqli_query($con, $sqlOrder);
if($executeOrders){
  while($executeOrdersObj = mysqli_fetch_object($executeOrders)){
    $purchaseDate = $executeOrdersObj->order_created;
    $status = $executeOrdersObj->order_status;
    $addressTitle = $executeOrdersObj->order_shipping_first_name;
    $address = $executeOrdersObj->order_shipping_address;
    $city = $executeOrdersObj->order_shipping_city;
    $country = $executeOrdersObj->order_shipping_country;
    $phone = $executeOrdersObj->order_shipping_phone;
    $zip = $executeOrdersObj->order_shipping_zip;
    $discount = $executeOrdersObj->order_discount_amount;
    $delivery = $executeOrdersObj->order_shipment_charge;
    $tax = $executeOrdersObj->order_vat_amount;
    $express = $executeOrdersObj->order_is_express;
    $subtotal = $executeOrdersObj->order_total_amount;
    $Total = ($subtotal - $discount) + $delivery + $tax;
  }
} else {
  if(DEBUG){
    echo "executeOrders error: " . mysqli_query($con);
  } else {
    echo "executeOrders query failed.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $page_title; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?php echo $page_description; ?>">
<meta name="keywords" content="<?php echo $page_keywords; ?>">
<meta name="author" content="<?php echo $site_author; ?>">

<?php include basePath('header_script.php'); ?>
</head>

<body>
<div id="wrapper">
  <div id="header">
                <div class="navbar navbar-default navbar-fixed-top megamenu">
                    <div class="container-full">
                        <?php include basePath('headertop.php'); ?>
                        <!--/.headertop -->
                        <?php include basePath('header_mid.php'); ?>
                        <!--/.headerBar -->

                        <?php include basePath('header_menu.php'); ?>
                        <!--/.menubar --> 
                    </div>
                </div>

            </div>
            <!-- header end -->
  
  <div class="w100 mainContainer">
    <div class="container">
    
      <div class="row" style="padding-top:10px;">
           <?php include basePath('alert.php'); ?>
         </div>
      <div class="row">
      <div class="col-md-12"><h2 class="reviewHeadingBig"> <i class="fa fa-shopping-cart"></i> My Order</h2> </div>
      
      <div class="col-md-3 col-sm-4 col-xs-12">
             <div class="accountMenu doequel equalheight">
       <ul class="nav nav-pills nav-stacked">
      <li><a href="<?php echo baseUrl(); ?>my-account">Account</a></li>
      <li><a href="<?php echo baseUrl(); ?>my-address-list">Address</a></li>
      <li class="active"><a href="<?php echo baseUrl(); ?>my-orders">Order history</a></li>
      
     
    </ul>
            </div>
      </div>
      
        <div class="col-md-9 col-sm-8 col-xs-12">
             <div class="accountContent doequel equalheight">
             <h3>Details Order History</h3>
             
            <div class="row">
            
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="panel panel-default order-panel">
              <div class="panel-heading orderheading">
                <h2 class="panel-title"><strong>Order ID : <?php echo '[' . date("dmy",  strtotime($purchaseDate)) . '-'. $orderID .']'; ?></strong></h2>
              </div>
              <div class="panel-body">
                <ul>
                  <li> <span class="address-company"><strong>Order Status </strong>: <strong><span style="text-transform: capitalize;" class="free"><?php echo $status; ?></span></strong></li>
                  <li> <span class="address-company"><strong>Purchase Date </strong>: <?php echo date("d M Y H:i A", strtotime($purchaseDate)); ?></span></li>
                  <li> <span class="address-company"><strong>Shipment To </strong>: <?php echo $addressTitle; ?>, </span></li>
                  <li> <span class="address-line1"> <?php echo $address; ?>, </span></li>
                  <li> <span class="address-line2"> <?php echo $city; ?> - <?php echo $zip; ?>, <?php echo $country; ?> </span></li>
                  <li> <span> <strong>Phone</strong> : <?php echo $phone; ?> </span></li>
                </ul>
              </div>

            </div>
          </div>
          </div>
      <h3>Your ordered Item</h3>
          <div class="table-responsive">
          	<table class="table order-table" width="100%" border="0">
  <tbody>
 <?php
$countOrderProduct = count($arrayProduct);
if($countOrderProduct > 0):
  for($i = 0; $i < $countOrderProduct; $i++):
    
    $productID = $arrayProduct[$i]->OP_product_id;
    $productName = $arrayProduct[$i]->product_title;
    $productImg = $arrayProduct[$i]->PI_file_name;
    $productInventory = $arrayProduct[$i]->PI_inventory_title;
    $productCurrentPrice = $arrayProduct[$i]->OP_price;
    $productDiscount = $arrayProduct[$i]->OP_discount;
    $productQuantity = $arrayProduct[$i]->OP_product_quantity;
    $productSubTotal = $arrayProduct[$i]->OP_product_total_price;
    $productQuantity = $arrayProduct[$i]->OP_product_total_discount;
    ?>        
    
    <tr id="cartItem_142" class="cartProduct">
      <td width="20%" class="cartImg"><img src="<?php echo baseUrl(); ?>upload/product/small/<?php echo $productImg; ?>" title="Cowhead Strawberry Milk "></td>
      <td width="42%" class="cartProductDescription"><h4><a href="<?php echo baseUrl(); ?>product/<?php echo $productID; ?>/<?php echo clean($productName); ?>"><?php echo $productName; ?> </a> <span><?php echo $productInventory; ?></span></h4>
        <div class="priceglobal"> 
          
          <!--                                          showing product current price based on discount--> 
          <span><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($productCurrentPrice,2); ?></span> 
          
          <!--                                              showing product current price based on discount--> 
          
        </div></td>
      <td width="18%" align="center"> <span class="cartQuantity">1</span></td>
      <td width="12%" align="center" class="subtotal"><div class="priceglobal"> <span id="tmpCartTotalPrice_142"><strong><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($productSubTotal,2); ?></strong></span> </div></td>
      
    </tr>
<?php
    endfor;
    endif;
    ?>
    
  </tbody>
</table>
          
          </div>
         	<h3>Purchase Amount </h3>
         	<table class="cartRight" width="100%" border="0" style="border:none;">
                    <tbody><tr>
                      <td align="left">Subtotal</td>
                      <td align="left" id="cartTotalPrice"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($subtotal,2); ?></td>
                    </tr>
                    
                    <?php if($discount > 0): ?>
                    <tr>
                      <td align="left">Discount</td>
                      
                      <td align="left" id="cartTotalDiscount"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($discount,2); ?></td>
                      
                    </tr>
                    <?php endif; ?>
                    
                    <?php if($tax > 0): ?>
                    <tr>
                      <td align="left">Tax</td>
                      
                      <td align="left" id="cartTotalDiscount"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($tax,2); ?></td>
                      
                    </tr>
                    <?php endif; ?>
                    
                    <tr>
                      <td>Delivery</td>
                      <?php if($delivery > 0): ?>
                      <td><strong><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($delivery,2); ?> <?php if($express == 'yes'){ echo "[Express Delivery]"; } ?></strong></td>
                      <?php else: ?>
                      <td><strong class="free">FREE!</strong></td>
                      <?php endif; ?>
                    </tr>
                    <tr>
                      <td><strong>Total</strong></td>
                      <td><strong><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($Total,2); ?></strong></td>
                    </tr>
                                      </tbody></table>
                     

    			</div>
            </div>
            
            
      </div>

    </div><!-- /.container -->
    
    <!--brandFeatured--> 
    
  </div>
  <!-- Main hero unit -->
  
  <?php include basePath('footer.php'); ?>

</div>
<!-- /container --> 

<?php include basePath('mini_login.php'); ?>
        <?php include basePath('mini_signup.php'); ?>
        <?php include basePath('mini_cart.php'); ?>

        <?php include basePath('footer_script.php'); ?>
</body>
</html>