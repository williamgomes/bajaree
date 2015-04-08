<?php
include 'config/config.php';

$CartID = '';

$page_title = get_option('SITE_DEFAULT_META_TITLE');
$page_description = get_option('SITE_DEFAULT_META_DESCRIPTION');
$page_keywords = get_option('SITE_DEFAULT_META_KEYWORDS');
$site_author = $config['CONFIG_SETTINGS']['SITE_AUTHOR'];



//getting data from temp_carts table
if ($CartID == '') {
  $CartID = session_id();
}
$arrayTempCart = array();
$sqlTempCart = "SELECT 
                products.product_id, products.product_title, products.product_default_inventory_id,  products.product_show_as_new_from, products.product_show_as_new_to, products.product_show_as_featured_from, products.product_show_as_featured_to,
                product_inventories.PI_inventory_title,product_inventories.PI_size_id,product_inventories.PI_cost,product_inventories.PI_current_price,product_inventories.PI_old_price,product_inventories.PI_quantity,
                product_discounts.PD_start_date,product_discounts.PD_end_date,product_discounts.PD_amount,product_discounts.PD_status,
                (SELECT product_images.PI_file_name FROM product_images WHERE product_images.PI_inventory_id = products.product_default_inventory_id AND product_images.PI_product_id = products.product_id ORDER BY product_images.PI_priority DESC LIMIT 1) as PI_file_name,
                temp_carts.TC_product_tax,temp_carts.TC_id,temp_carts.TC_unit_price,temp_carts.TC_per_unit_discount,temp_carts.TC_discount_amount,temp_carts.TC_product_quantity,temp_carts.TC_product_total_price

                FROM temp_carts

                LEFT JOIN product_inventories ON product_inventories.PI_id = temp_carts.TC_product_inventory_id
                LEFT JOIN product_discounts ON product_discounts.PD_inventory_id = temp_carts.TC_product_inventory_id
                LEFT JOIN products ON products.product_id = temp_carts.TC_product_id
                WHERE temp_carts.TC_session_id='$CartID'";
$executeTempCart = mysqli_query($con, $sqlTempCart);
if ($executeTempCart) {
  while ($executeTempCartObj = mysqli_fetch_object($executeTempCart)) {
    $arrayTempCart[] = $executeTempCartObj;
  }
} else {
  if (DEBUG) {
    echo "executeTempCart error: " . mysqli_error($con);
  }
}


//echo "<pre>";
//print_r($arrayTempCart);
//echo "</pre>";
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
    <script src="<?php echo baseUrl(); ?>ajax/index/main.js"></script>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

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





      <div style="clear:both"></div>
      <div class="w100 mainContainer">

        <div class="container">

          <div class="row">
            <?php include basePath('alert.php'); ?>
          </div>

          <div class="container-fluid">
            <h4 align="right"><a class="backshop" href="<?php echo baseUrl(); ?>"><i class="fa fa-chevron-left" style="font-size: 14px;"></i> Back to Shop</a></h4>

            <div class="row-fluid">

              <div class="col-md-8">
                <div class="cartContent">
                  <div class="cartHeading"><h2>my cart</h2></div>
                  <table width="100%" border="0">

                    <?php
                    $countTempCartArray = count($arrayTempCart);
                    $TotalPrice = 0;
                    $TotalPriceWithoutTax = 0;
                    $TotalTax = 0;
                    if ($countTempCartArray > 0):
                      for ($x = 0; $x < $countTempCartArray; $x++):

                        //product information from temp cart
                        $ProductTitle = $arrayTempCart[$x]->product_title;
                        $ProductID = $arrayTempCart[$x]->product_id;
                        $ProductImage = $arrayTempCart[$x]->PI_file_name;
                        $ProductDefaultInventoryTitle = $arrayTempCart[$x]->PI_inventory_title;
                        $ProductUnitPrice = $arrayTempCart[$x]->TC_unit_price;
                        $ProductUnitDiscount = $arrayTempCart[$x]->TC_per_unit_discount;
                        $ProductTotalPrice = $arrayTempCart[$x]->TC_product_total_price;
                        $ProductTotalDiscount = $arrayTempCart[$x]->TC_discount_amount;
                        $ProductCartQuantity = $arrayTempCart[$x]->TC_product_quantity;
                        $ProductTax = $arrayTempCart[$x]->TC_product_tax;
                        $ProductTaxAmount = ($ProductTotalPrice * $ProductTax) / 100;
                        $TempCartID = $arrayTempCart[$x]->TC_id;

                        //calculating total price and discount
                        $TotalPriceWithoutTax += ($ProductTotalPrice - $ProductTotalDiscount);
                        $TotalPrice += (($ProductTotalPrice + $ProductTaxAmount) - $ProductTotalDiscount);
                        $TotalTax += $ProductTaxAmount;
                        ?>
                        <tr class="cartProduct" id="cartItem_<?php echo $arrayTempCart[$x]->TC_id; ?>">
                          <td width="20%" class="cartImg">

                            <?php if ($ProductImage == ''): ?>
                              <img title="<?php echo $ProductTitle; ?>" src="<?php echo baseUrl(); ?>upload/product/small/default.jpg" >
                            <?php else: ?>
                              <img title="<?php echo $ProductTitle; ?>" src="<?php echo baseUrl(); ?>upload/product/small/<?php echo $ProductImage; ?>" >
                            <?php endif; ?>

                          </td>
                          <td width="42%" class="cartProductDescription"><h4><a href="<?php echo baseUrl(); ?>product/<?php echo $ProductID; ?>/<?php echo clean($ProductTitle); ?>"><?php echo $ProductTitle; ?></a>
                              <span><?php echo $ProductDefaultInventoryTitle; ?></span></h4>
                            <div class="priceglobal">

                              <!--                                          showing product current price based on discount-->
                              <?php if ($ProductUnitDiscount > 0): ?>
                                <span class="current-price"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format(($ProductUnitPrice - $ProductUnitDiscount), 2); ?></span>
                                <span class="old-price"> <?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($ProductUnitPrice, 2); ?></span><br/>
                                <span class="save-price"> save <?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($ProductUnitDiscount, 2); ?></span>
                              <?php else: ?>
                                <span><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($ProductUnitPrice, 2); ?></span>                                
                              <?php endif; ?>                                
                              <!--                                              showing product current price based on discount-->

                            </div>
                          </td>
                          <td width="18%" align="center"><div class="quantity">

                              <a href="javascript:void(0)" title="Increase" onClick="tmpCartIncrease(<?php echo $TempCartID; ?>);"><img src="images/increase.png" alt="increase"></a>

                              <?php if ($ProductCartQuantity > 0): ?>
                                <span id="tempCartQuantity_<?php echo $TempCartID; ?>"><span class="cartQuantity"><?php echo $ProductCartQuantity; ?></span></span>
                              <?php else: ?>
                                <span id="tempCartQuantity_<?php echo $TempCartID; ?>"><span class="cartQuantity" style="color:red; font-weight: bold;"><?php echo $ProductCartQuantity; ?></span></span>
                              <?php endif; ?>

                              <a style="padding:0;" href="javascript:void(0)" title="Decrease" onClick="tmpCartDecrease(<?php echo $TempCartID; ?>);"><img src="images/decrease.png" alt="decrease"></a>

                            </div>
                          </td>
                          <td width="12%" align="center" class="subtotal">
                            <div class="priceglobal">
                              <span id="tmpCartTotalPrice_<?php echo $TempCartID; ?>"><strong><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format(($ProductTotalPrice - $ProductTotalDiscount), 2); ?></strong></span>
                            </div>
                          </td>
                          <td width="10%" align="center">
                            <a id="deleteTempCart_<?php echo $arrayTempCart[$x]->TC_id; ?>" class="cartProductDelete" data-toggle="tooltip" title="Delete from Cart"  href="javascript:void(0)" onClick="deleteFromCart(<?php echo $arrayTempCart[$x]->TC_id; ?>,<?php echo $arrayTempCart[$x]->product_id; ?>);">delete</a>
                          </td>
                        </tr>

                        <?php
                      endfor;
                    endif;
                    ?>

                  </table>


                </div>
                <!--product content-->


              </div>

              <div class="col-md-4">
                <h3 style="margin-top: 38px;"><a href="javascript:void(0)" onClick="checkQuantity();" class="checkoutNow btn btn-site">Checkout Now&nbsp;&nbsp;&nbsp;<i class="fa fa-long-arrow-right"></i> </a></h3>
                <div class="cartRight">
                  <table style="border-bottom:1px solid #ddd;" width="100%" border="0">
                    <tr>
                      <td align="left">Subtotal</td>
                      <td align="left" id="cartTotalPrice"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo(number_format($TotalPriceWithoutTax, 2)); ?></td>
                    </tr>
                    <tr id="trTax">
                      <?php if($TotalTax > 0): ?>
                      <td>Tax</td>
                      <td><strong class="free"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo(number_format($TotalTax, 2)); ?></strong></td>
                      <?php endif; ?>
                    </tr>
                  </table>
                </div>
                <div class="totalrow">
                  <div class="text"><h3>Total</h3></div>
                  <div class="total"><h3><span id="cartGrandTotal"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo(number_format($TotalPrice, 2)); ?></span></h3></div>
                </div>
              </div>
            </div>


          </div>
        </div>

      </div>



      <!--brandFeatured-->

    </div>
    <!-- Main hero unit -->
    <?php include basePath('footer_delivery.php'); ?>
    <?php include basePath('footer.php'); ?>

  </div>
  <!-- /container --> 




  <?php include basePath('mini_login.php'); ?>
  <?php include basePath('mini_signup.php'); ?>
  <?php include basePath('mini_cart.php'); ?>

  <?php include basePath('footer_script.php'); ?>


</body>
</html>
