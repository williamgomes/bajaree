<?php
include 'config/config.php';

$page_title = get_option('SITE_DEFAULT_META_TITLE');
$page_description = get_option('SITE_DEFAULT_META_DESCRIPTION');
$page_keywords = get_option('SITE_DEFAULT_META_KEYWORDS');
$site_author = $config['CONFIG_SETTINGS']['SITE_AUTHOR'];

$userID = 0;
$countWishlist = 0;

if(checkUserLogin()){
  $userID = getSession('UserID');
}

//getting wishlist data from database
$arrayWishlist = array();
$sqlWishlist = "SELECT
                products.product_id, products.product_title, products.product_default_inventory_id,  products.product_show_as_new_from, products.product_show_as_new_to, products.product_show_as_featured_from, products.product_show_as_featured_to,products.product_long_description,
                product_inventories.PI_inventory_title,product_inventories.PI_size_id,product_inventories.PI_cost,product_inventories.PI_current_price,product_inventories.PI_old_price,product_inventories.PI_quantity,
                product_discounts.PD_start_date,product_discounts.PD_end_date,product_discounts.PD_amount,product_discounts.PD_status,
                sizes.size_title,
                product_images.PI_file_name,
                wishlists.WL_id
              
                FROM wishlists 
                
                LEFT JOIN products ON products.product_id = wishlists.WL_product_id
                LEFT JOIN product_inventories ON product_inventories.PI_id = wishlists.WL_inventory_id
                LEFT JOIN product_discounts ON product_discounts.PD_inventory_id = wishlists.WL_inventory_id
                LEFT JOIN product_images ON product_images.PI_inventory_id = wishlists.WL_inventory_id
                LEFT JOIN sizes ON sizes.size_id = product_inventories.PI_size_id
                WHERE WL_user_id=$userID";

$executeWishlist = mysqli_query($con,$sqlWishlist);
if($executeWishlist){
  while($executeWishlistObj = mysqli_fetch_object($executeWishlist)){
    $arrayWishlist[] = $executeWishlistObj;
  }
} else {
  if(DEBUG){
    echo "executeWishlist error: " . mysqli_error($con);
  } else {
    echo "executeWishlist query failed";
  }
}

//echo "<pre>";
//print_r($arrayWishlist);
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
          <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 main-column userRegistration">
            <div id="content"> 
              <h1>My List</h1>
              <div class="wishlist-info">
                <table width="100%" border="0" id='generateWishList'>
<?php if(checkUserLogin()): ?>                  
  <?php $countWishlist = count($arrayWishlist);
  if($countWishlist > 0):
    for($i = 0; $i < $countWishlist; $i++):

      $ProductTitle = $arrayWishlist[$i]->product_title;
      $ProductID = $arrayWishlist[$i]->product_id;
      $ProductInventoryTitle = $arrayWishlist[$i]->PI_inventory_title;
      $ProductImage = $arrayWishlist[$i]->PI_file_name;
      $ProductCurrentPrice = $arrayWishlist[$i]->PI_current_price;
      $ProductOldPrice = $arrayWishlist[$i]->PI_old_price;
      $ProductDiscount = $arrayWishlist[$i]->PD_amount;
    ?>

                    <tr class="cartProduct" id="wishlistItem_<?php echo $arrayWishlist[$i]->WL_id; ?>">
                      <td width="13%" class="cartImg"><img src="<?php echo baseUrl(); ?>upload/product/small/<?php echo $ProductImage; ?>" alt="<?php echo $arrayWishlist[$i]->product_title; ?>"></td>
                      <td width="40%" class="cartProductDescription">
                        <h4>
                          <a href="#" title="<?php echo $arrayWishlist[$i]->product_title; ?>">
                            <?php echo $arrayWishlist[$i]->product_title; ?>
                          </a>
                          <span><?php echo $arrayWishlist[$i]->PI_inventory_title; ?></span>
                        </h4>
                      </td>
                      <td width="10%" align="center" class="subtotal">
                        <div class="priceglobal">
  <!--                        calculating product real price or discount price-->
                          <?php if($ProductDiscount > 0): ?>
                          <span class="current-price"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo ($ProductCurrentPrice-$ProductDiscount); ?></span>
                          <?php else: ?>
                          <span><?php echo $config['CURRENCY_SIGN']; ?> <?php echo $ProductCurrentPrice; ?></span>
                          <?php endif; ?>

  <!--                        calculating product discount-->
                          <?php if($ProductDiscount > 0): ?>
                          <span class="save"><small> Save <?php echo $config['CURRENCY_SIGN']; ?> <?php echo $ProductDiscount; ?></small></span><br>
                          <?php endif; ?>

  <!--                        getting and validating product old price-->
                          <?php if($ProductOldPrice > 0): ?>
                          <span class="old-price"> <?php echo $config['CURRENCY_SIGN']; ?> <?php echo $ProductOldPrice; ?></span>
                          <?php endif; ?>
                        </div>
                      </td>
                      <td width="25%" align="center">

                        <a class="btncart"> <span class="counter"> <span>1</span> </span> <span class="add2cart">Add to cart </span> </a> 
                      </td>
                      <td align="center"><a data-toggle="tooltip" title="Delete from wishlist"  class="cartProductDelete" href="javascript:void(0)" onClick="deleteWishlist(<?php echo $arrayWishlist[$i]->WL_id; ?>);">delete</a></td>

                    </tr>

    <?php
    endfor;
  else:
  ?>
                    <tr class="cartProduct">
                      <td colspan="5" class="emptyWishlist text-center"><h4>No item found.</h4></td>
                    </tr>
  <?php
  endif;
  else:
  ?>
                    
                    
                    <tr class="cartProduct">
                      <td colspan="5" class="emptyWishlist text-center"><h4>You need to <a data-toggle="modal" data-target="#ModalLogin" id="signinPopup"> Login </a> OR <a data-toggle="modal" data-target="#ModalSignup"> Sign Up </a> first.</h4></td>
                    </tr>
<?php
endif;
?>
                </table>
              </div>
              <div class="buttons">
<!--                <div class="left"><a class="btn btn-default pull-left" href="my_account.html"><i class="fa fa-arrow-circle-left"></i>  Back</a></div>-->
                <div class="right">
                  <a class="btn btn-site pull-right btn-2type" href="<?php echo baseUrl(); ?>"> Continue Shopping  <i class="fa fa-angle-double-right"></i> </a>
                  <a class="btn btn-site pull-right" href="<?php echo baseUrl(); ?>my-cart"> View Cart  <i class="fa fa-shopping-cart"></i> </a>  &nbsp;
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
    <script src="<?php echo baseUrl(); ?>ajax/wishlist/main.js"></script>

  </body>
</html>
