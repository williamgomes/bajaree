<?php
include 'config/config.php';
include 'lib/category2.php';
$catLib2 = new Category2($con);
$catTreeArray = array();
$page_title = get_option('SITE_DEFAULT_META_TITLE');
$page_description = get_option('SITE_DEFAULT_META_DESCRIPTION');
$page_keywords = get_option('SITE_DEFAULT_META_KEYWORDS');
$site_author = $config['CONFIG_SETTINGS']['SITE_AUTHOR'];

$ProductID = 0;
$ProductName = '';
$ProductSize = '';
$ProductCurrentPrice = 0;
$ProductOldPrice = 0;
$ProductDefaultInventory = 0;
$CartID = session_id();
$secureCode = '';
$definedDefaultInventory = 0;

//checking for secure code input
if(isset($_GET['code']) AND $_GET['code'] != ''){
  $secureCode = $_GET['code'];
}


//checking if any defined inventory code provided
if(isset($_GET['defaultInventory']) AND $_GET['defaultInventory'] != ''){
  $definedDefaultInventory = $_GET['defaultInventory'];
}

if (isset($_GET['product_id']) AND isset($_GET['product_name'])) {
    $ProductID = $_GET['product_id'];
    $ProductName = $_GET['product_name'];
} else {
    redirect('index.php');
}



/* category tree */
$PrevCatId = $config['PRODUCT_CATEGORY_ID'];
if (isset($_SERVER['HTTP_REFERER'])) {

    $query = parse_url($_SERVER['HTTP_REFERER']);
    if (isset($query['path'])) {
        $queryArray = explode('/', $query['path']);
        for ($i = 0; $i < count($queryArray); $i++) {
            if ($queryArray[$i] == 'category') {
                if (isset($queryArray[$i + 1])) {
                    $PrevCatId = intval($queryArray[$i + 1]);
                    break;
                }
            }
        }
    }
    $catTreeArray = $catLib2->getParents($config['PRODUCT_CATEGORY_ID'], $PrevCatId);
    asort($catTreeArray);
}


/* //category tree */

//getting product information from database
$ProductTitle = '';
$ProductDetails = '';
$sqlProduct = "SELECT 
              products.product_id, products.product_title, products.product_default_inventory_id,  products.product_show_as_new_from, products.product_show_as_new_to, products.product_show_as_featured_from, products.product_show_as_featured_to,products.product_long_description,
              product_inventories.PI_inventory_title,product_inventories.PI_size_id,product_inventories.PI_cost,product_inventories.PI_current_price,product_inventories.PI_old_price,product_inventories.PI_quantity,
              product_discounts.PD_start_date,product_discounts.PD_end_date,product_discounts.PD_amount,product_discounts.PD_status,
              sizes.size_title
              

              FROM products

              LEFT JOIN product_inventories ON product_inventories.PI_id = products.product_default_inventory_id
              LEFT JOIN product_discounts ON product_discounts.PD_inventory_id = product_inventories.PI_id
              LEFT JOIN sizes ON sizes.size_id = product_inventories.PI_size_id
              WHERE products.product_id = $ProductID AND products.product_status ='active'";
$executeProduct = mysqli_query($con, $sqlProduct);
if ($executeProduct) {
    $executeProductObj = mysqli_fetch_object($executeProduct);
    if (isset($executeProductObj->product_id)) {
        $ProductTitle = $executeProductObj->product_title;
        $ProductDetails = $executeProductObj->product_long_description;
        $ProductSize = $executeProductObj->size_title;
        $ProductCurrentPrice = $executeProductObj->PI_current_price;
        $ProductOldPrice = $executeProductObj->PI_old_price;
        if($definedDefaultInventory > 0){
          $ProductDefaultInventory = $definedDefaultInventory;
        } else {
          $ProductDefaultInventory = $executeProductObj->product_default_inventory_id;
        }
        $ProductDiscount = $executeProductObj->PD_amount;
    }
} else {
    if (DEBUG) {
        echo "executeProduct error: " . mysqli_error($con);
    }
}


//getting pictures from table
$arrayProductImage = array();
$sqlProductImage = "SELECT * FROM product_images WHERE PI_product_id=$ProductID AND PI_inventory_id=$ProductDefaultInventory";
$executeProductImages = mysqli_query($con, $sqlProductImage);
if ($executeProductImages) {
    while ($executeProductImagesObj = mysqli_fetch_object($executeProductImages)) {
        $arrayProductImage[] = $executeProductImagesObj;
    }
} else {
    if (DEBUG) {
        echo "executeProductImages error: " . mysqli_error($con);
    }
}

//getting inventory information from database
$arrayInventory = array();
$sqlInventory = "SELECT * FROM product_inventories WHERE PI_status='active' AND  PI_product_id=" . intval($ProductID);
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


//getting data from temp_carts table
$arrayTempCart = array();
$sqlTempCart = "SELECT * FROM temp_carts WHERE TC_session_id='$CartID'";
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



//getting related products data from database
$arrayRelatedProduct = array();
$sqlRelatedProduct = "SELECT products.product_id,products.product_title,products.product_default_inventory_id,product_inventories.PI_inventory_title,product_inventories.PI_current_price,product_inventories.PI_old_price,(SELECT product_images.PI_file_name FROM product_images WHERE product_images.PI_product_id=products_related.PR_related_product_id LIMIT 1) AS product_image 
                      FROM products_related,products,product_inventories 
                      WHERE products_related.PR_current_product_id=$ProductID
                      AND products.product_id=products_related.PR_related_product_id
                      AND product_inventories.PI_id = products.product_default_inventory_id
                      AND products.product_status='active'";
$executeRelatedProduct = mysqli_query($con, $sqlRelatedProduct);
if ($executeRelatedProduct) {
    while ($executeRelatedProductObj = mysqli_fetch_object($executeRelatedProduct)) {
        $arrayRelatedProduct[] = $executeRelatedProductObj;
    }
} else {
    if (DEBUG) {
        echo "executeRelatedProduct error: " . mysqli_error($con);
    }
}


//getting wish list data from database
$userID = 0;
$arrayWishlist = array();
if (getSession('UserName') != '') {
    $userID = getSession('UserID');
    $sqlWishlist = "SELECT * FROM wishlists WHERE WL_user_id=$userID";
    $executeWishlist = mysqli_query($con, $sqlWishlist);
    if ($executeWishlist) {
        while ($executeWishlistObj = mysqli_fetch_object($executeWishlist)) {
            $arrayWishlist[$executeWishlistObj->WL_user_id][] = $executeWishlistObj;
        }
    } else {
        if (DEBUG) {
            echo "executeWishlist error: " . mysqli_error($con);
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $page_title; ?> | <?php echo $ProductTitle; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php echo $page_description; ?>">
        <meta name="keywords" content="<?php echo $page_keywords; ?>">
        <meta name="author" content="<?php echo $site_author; ?>">

        <?php include basePath('header_script.php'); ?>
        <link href="<?php echo baseUrl(); ?>css/multizoom.css" rel="stylesheet">

        <script>
            $(document).ready(function() {

                $("#homeCarousel_relatedProducts").tnmCarousel({
                    navigation: false,
                    lazyLoad: true,
                    addClassActive: true,
                    items: 6,
                    itemsTablet: [768, 3],
                    itemsTabletSmall: [580, 2]

                });
            });
        </script>
        
        
        
        
        <!-- Open Graph url property -->
    <meta property="og:url" content="<?php echo $_SERVER['REQUEST_URI']; ?>" />
    <!-- Open Graph title property -->
    <meta property="og:title" content="<?php echo $page_title; ?> | <?php echo $ProductTitle; ?>" />
    <!-- Open Graph description property -->
    <meta property="og:description" content="<?php echo $ProductDetails; ?>" />
    <!-- Open Graph image property -->
    <?php if(count($arrayProductImage) > 0): ?>
      <?php if (!file_exists('upload/product/mid/' . $arrayProductImage[0]->PI_file_name)): ?>
           <meta property="og:image" content="<?php echo baseUrl(); ?>upload/product/mid/default.png" />
       <?php else: ?>
           <meta property="og:image" content="<?php echo baseUrl(); ?>upload/product/mid/<?php echo $arrayProductImage[0]->PI_file_name; ?>"/>
       <?php endif; ?>
     <?php else: ?>
       <meta property="og:image" content="<?php echo baseUrl(); ?>upload/product/mid/default.png"/>
     <?php endif; ?>
    <!-- Open Graph type property -->
    <meta property="og:type" content="product" />
    <!-- Open Graph site_name property -->
    <meta property="og:site_name" content="<?php echo $page_title; ?>" />
        
        
        

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



            <div class="w100 mainContainer innerPadd">

                <div class="breadcrumbDiv">
                    <div class="container">
                        <ul class="breadcrumb">
                            <li><a href="<?php echo baseUrl(); ?>">Home</a></li>
                            <?php foreach ($catTreeArray AS $CTA): ?>

                                <li><a href="<?php echo baseUrl('category') . '/' . $CTA['category_id'] . '/' . clean($CTA['category_name']); ?>"><?php echo $CTA['category_name']; ?></a> </li>


                            <?php endforeach; /* foreach ($catTreeArray AS $CTA) */ ?>

                            <li class="active"><?php echo $ProductTitle; ?></li>
                        </ul>
                    </div>

                </div>

                <div class="container">
                    <div class="container-fluid">


                        <div class="row-fluid">
                            <div class="col-lg-5 col-md-5 productImageZoom">

                                <div class="targetarea diffheight" id="singleImageDiv">
                                  
                                  <div style="position: absolute; height: 100%; width: 100%; z-index: 100;"></div>
                                  
                                  <?php if(count($arrayProductImage) > 0): ?>
                                   <?php if (!file_exists(baseUrl() . 'upload/product/large/' . $arrayProductImage[0]->PI_file_name)): ?>
                                        <img id="multizoom2" alt="<?php echo $ProductTitle; ?>" title="" src="<?php echo baseUrl(); ?>upload/product/large/default.jpg"/>
                                    <?php else: ?>
                                        <img id="multizoom2" alt="<?php echo $ProductTitle; ?>" title="" src="<?php echo baseUrl(); ?>upload/product/large/<?php echo $arrayProductImage[0]->PI_file_name; ?>"/>
                                    <?php endif; ?>
                                  <?php else: ?>
                                    <img id="multizoom2" alt="<?php echo $ProductTitle; ?>" title="" src="<?php echo baseUrl(); ?>upload/product/large/<?php echo $arrayProductImage[0]->PI_file_name; ?>"/>
                                  <?php endif; ?>   
                                </div>
                                <div class="multizoom2 thumbs" id="multiImage">
                                    <!--                                  Product Image-->

                                    <?php
                                    $countImageArray = count($arrayProductImage);
                                    if ($countImageArray > 0):
                                        for ($x = 0; $x < $countImageArray; $x++):
                                            ?>
                                            <a href="<?php echo baseUrl(); ?>upload/product/original/<?php echo $arrayProductImage[$x]->PI_file_name; ?>" data-large="<?php echo baseUrl(); ?>upload/product/original/<?php echo $arrayProductImage[$x]->PI_file_name; ?>" data-title="<?php echo $ProductTitle; ?>"><img src="<?php echo baseUrl(); ?>upload/product/small/<?php echo $arrayProductImage[$x]->PI_file_name; ?>" alt="<?php echo $ProductTitle; ?>" title="<?php echo $ProductTitle; ?>"/></a>
                                            <?php
                                        endfor;
                                    else:
                                        ?>
                                        <a href="<?php echo baseUrl(); ?>upload/product/original/default.jpg" data-large="<?php echo baseUrl(); ?>upload/product/original/default.jpg" data-title="<?php echo $ProductTitle; ?>"><img src="<?php echo baseUrl(); ?>upload/product/small/default.jpg" alt="<?php echo $ProductTitle; ?>" title="<?php echo $ProductTitle; ?>"/></a>
                                    <?php endif; ?>  
                                </div>

                                <!--                                  Product Image-->
                            </div>
                            <div class="col-lg-7  col-md-7 categoryContainer">
                                <div class="productDetails">
                                    <div class="description">
                                        <h2><?php echo $ProductTitle; ?></h2>

                                        <span >
                                            <form class="form-inline" role="form">
                                                <div class="form-group has-feedback">
                                                    <select name="inventory" id="inventory_title" onChange="ShowInventoryInfo(<?php echo $ProductID; ?>);" class="form-control">
                                                        <?php
                                                        $countInventory = count($arrayInventory);
                                                        if ($countInventory > 0):
                                                            for ($i = 0; $i < $countInventory; $i++):
                                                                ?>
                                                                <option value="<?php echo $arrayInventory[$i]->PI_id; ?>" <?php
                                                        if ($arrayInventory[$i]->PI_id == $ProductDefaultInventory) {
                                                            echo "selected";
                                                        }
                                                                ?>><?php echo $arrayInventory[$i]->PI_inventory_title; ?></option>
                                                                        <?php
                                                                    endfor;
                                                                endif;
                                                                ?>
                                                    </select>
                                                </div>
                                            </form>
                                        </span><br>
                                        <span class="size" id="productSize"><?php echo $ProductSize; ?></span>

                                        <p><?php echo $ProductDetails; ?></p>

                                    </div>

                                    <div class="price">
                                        <?php if ($ProductDiscount > 0): ?>
                                            <span id="productCurrentPrice" >
                                                <?php echo $config['CURRENCY_SIGN']; ?> <?php echo ($ProductCurrentPrice - $ProductDiscount); ?>
                                            </span>
                                        <?php else: ?>
                                            <span id="productCurrentPrice" >
                                                <?php echo $config['CURRENCY_SIGN']; ?> <?php echo $ProductCurrentPrice; ?>
                                            </span>
                                        <?php endif; ?>

                                        <span class="old-price" id="productOldPrice">
                                            <?php
                                            if ($ProductOldPrice > 0):
                                                ?>  
                                                <?php echo $config['CURRENCY_SIGN']; ?> <?php echo $ProductOldPrice; ?>
                                                <?php
                                            endif;
                                            ?>
                                        </span>

                                        <?php if ($ProductDiscount > 0): ?>
                                            <span class="save">SAVE <?php echo $config['CURRENCY_SIGN']; ?> <?php echo $ProductDiscount; ?></span>
                                        <?php endif; ?>

                                    </div>

                                    <div class="cartControll"> 

                                        <div class="cartControllInner">
                                            <!--                                          Add To Cart Button-->
                                            <?php
                                            //featured product slider generation
                                            $countTempCart = count($arrayTempCart);
                                            $productExistenceIndicator = FALSE;
                                            $tempCartQuantity = 0;
                                            if ($countTempCart > 0):
                                                for ($a = 0; $a < $countTempCart; $a++):
                                                    if (isset($arrayTempCart[$a]->TC_product_id) AND $ProductID == $arrayTempCart[$a]->TC_product_id AND $ProductDefaultInventory == $arrayTempCart[$a]->TC_product_inventory_id):
                                                        $productExistenceIndicator = TRUE;
                                                        $tempCartQuantity = $arrayTempCart[$a]->TC_product_quantity;
                                                    endif;
                                                endfor;
                                            endif;
                                            ?>

                                            <?php
                                            if ($productExistenceIndicator) {
                                                ?>
                                                <a class="btncart active" id="addToCart_<?php echo $ProductID; ?>" onClick="AddToCartProductDetails(<?php echo $ProductID; ?>);"> 
                                                    <span class="counter" id="cartCounter_<?php echo $ProductID; ?>"> 
                                                        <span><?php echo $tempCartQuantity; ?></span> 
                                                    </span> 
                                                    <span class="add2cart" id="AddToCartText_<?php echo $ProductID; ?>">Add One More </span> 
                                                </a> 
                                                <?php
                                            } else {
                                                ?>
                                                <a class="btncart" id="addToCart_<?php echo $ProductID; ?>" onClick="AddToCartProductDetails(<?php echo $ProductID; ?>);"> 
                                                    <span class="counter" id="cartCounter_<?php echo $ProductID; ?>"> 
                                                        <span>0</span> 
                                                    </span> 
                                                    <span class="add2cart" id="AddToCartText_<?php echo $ProductID; ?>">Add to cart </span> 
                                                </a> 
                                                <?php
                                            }
                                            ?>  


                                            <?php
                                            $countWishList = count($arrayWishlist);
                                            $wishlistIndicator = FALSE;
                                            if ($countWishList > 0):
                                                for ($j = 0; $j < $countWishList; $j++):
                                                    if (isset($arrayWishlist[$userID])):
                                                        if ($arrayWishlist[$userID][$j]->WL_inventory_id == $ProductDefaultInventory AND $arrayWishlist[$userID][$j]->WL_product_id == $ProductID):
                                                            $wishlistIndicator = TRUE;
                                                        endif;
                                                    endif;
                                                endfor;
                                            endif;
                                            ?>

                                            <?php
                                            if ($wishlistIndicator):
                                                ?>
                                                <a class="btnwishlist active" id="btnAddToWishlist_<?php echo $ProductID; ?>"> 
                                                    <span class="counter"> <span></span> </span> 
                                                    <span class="add2cart" id="wishlistBtn_<?php echo $ProductID; ?>">Added to list </span> 
                                                </a>
                                                <?php
                                            else:
                                                ?>
                                                <a class="btnwishlist" id="btnAddToWishlist_<?php echo $ProductID; ?>" onClick="AddToWishlist(<?php echo $ProductID; ?>);"> <span class="counter"> 
                                                        <span></span> </span> 
                                                    <span class="add2cart" id="wishlistBtn_<?php echo $ProductID; ?>">Add to my list </span> 
                                                </a> 
                                            <?php
                                            endif;
                                            ?>
                                            <!--                                          Add To Cart Button--> 
                                        </div>                
                                    </div>

                                </div>
                                <!--product content-->
                                
                                
<?php
if($secureCode == get_option('SECRET_CODE_PRODUCT_DETAILS')):
  ?>
                                
                                <table border="1">
                                  <thead>
                                    <tr>
                                      <td>Inventory ID</td>
                                      <td>Inventory Name</td>
                                      <td>Inventory Size</td>
                                      <td>Inventory Quantity</td>
                                      <td>Inventory Cost</td>
                                      <td>Inventory Price</td>
                                    </tr>
                                  </thead>
                                  <tbody>
<?php
$countInventory = count($arrayInventory);
if ($countInventory > 0):
    for ($i = 0; $i < $countInventory; $i++):
?>
                                    <tr>
                                      <td><?php echo $arrayInventory[$i]->PI_id; ?></td>
                                      <td><?php echo $arrayInventory[$i]->PI_inventory_title; ?></td>
                                      <td><?php echo getFieldValue('sizes', 'size_title', 'size_id=' . $arrayInventory[$i]->PI_size_id); ?></td>
                                      <td><?php echo $arrayInventory[$i]->PI_quantity; ?></td>
                                      <td><?php echo $arrayInventory[$i]->PI_cost; ?></td>
                                      <td><?php echo $arrayInventory[$i]->PI_current_price; ?></td>
                                    </tr>
<?php
    endfor;
endif;
?>
                                  </tbody>
                                </table>
<?php
endif;
?>
                                
                                
                                
                                
                            </div>
                        </div>
                        <!--- // end product Details -->

                        <div style="clear:both"></div>

                        <div class="row-fluid relatedProductContainer xsResponse"> 



                            <?php
                            $countRelatedProduct = count($arrayRelatedProduct);
                            if ($countRelatedProduct > 0):
                                ?>
                                <div class="container padd">
                                    <?php include basePath('alert.php'); ?>
                                    <div class="section-title text-center">
                                        <h2><span>RELATED PRODUCT</span> </h2>
                                    </div>
                                    <div id="homeCarousel_relatedProducts" class="row productFeatured xsResponse tnm-carousel tnm-theme carousel">


                                        <?php for ($x = 0; $x < $countRelatedProduct; $x++): ?>
                                            <div class="product ">
                                                <div class="productBox"> <a class="proImg" href="<?php echo baseUrl(); ?>product/<?php echo $arrayRelatedProduct[$x]->product_id; ?>/<?php echo clean($arrayRelatedProduct[$x]->product_title); ?>" ><img src="<?php echo baseUrl(); ?>upload/product/small/<?php echo $arrayRelatedProduct[$x]->product_image; ?>" ></a>
                                                    <div class="description">
                                                        <h4><a href="<?php echo baseUrl(); ?>product/<?php echo $arrayRelatedProduct[$x]->product_id; ?>/<?php echo clean($arrayRelatedProduct[$x]->product_title); ?>" ><?php echo $arrayRelatedProduct[$x]->product_title; ?></a></h4>
                                                        <span class="size"><?php echo $arrayRelatedProduct[$x]->PI_inventory_title; ?></span> </div>
                                                    <div class="price"><span>৳ <?php echo $arrayRelatedProduct[$x]->PI_current_price; ?></span></div>
                                                    <?php
                                                    //featured product slider generation
                                                    $countTempCart = count($arrayTempCart);
                                                    $productExistenceIndicatorRelated = FALSE;
                                                    $tempCartQuantityRelated = 0;
                                                    if ($countTempCart > 0):
                                                        for ($a = 0; $a < $countTempCart; $a++):
                                                            if ($arrayRelatedProduct[$x]->product_id == $arrayTempCart[$a]->TC_product_id AND $arrayRelatedProduct[$x]->product_default_inventory_id == $arrayTempCart[$a]->TC_product_inventory_id):
                                                                $productExistenceIndicatorRelated = TRUE;
                                                                $tempCartQuantityRelated = $arrayTempCart[$a]->TC_product_quantity;
                                                            endif;
                                                        endfor;
                                                    endif;
                                                    ?>

                                                    <?php
                                                    if ($productExistenceIndicatorRelated) {
                                                        ?>

                                                        <div class="cartControll"> 
                                                            <a class="btncart active" id="addToCart_<?php echo $arrayRelatedProduct[$x]->product_id; ?>" onClick="AddToCart(<?php echo $arrayRelatedProduct[$x]->product_id; ?>,<?php echo $arrayRelatedProduct[$x]->product_default_inventory_id; ?>)" > 
                                                                <span class="counter" id="cartCounter_<?php echo $arrayRelatedProduct[$x]->product_id; ?>"> 
                                                                    <span><b><?php echo $tempCartQuantityRelated; ?></b></span> 
                                                                </span> 
                                                                <span class="add2cart" id="AddToCartText_<?php echo $arrayRelatedProduct[$x]->product_id; ?>">
                                                                    Add One More 
                                                                </span> 
                                                            </a> 
                                                        </div>
                                                        <?php
                                                    } else {
                                                        ?>

                                                        <div class="cartControll"> 
                                                            <a class="btncart" id="addToCart_<?php echo $arrayRelatedProduct[$x]->product_id; ?>" onClick="AddToCart(<?php echo $arrayRelatedProduct[$x]->product_id; ?>,<?php echo $arrayRelatedProduct[$x]->product_default_inventory_id; ?>)" > 
                                                                <span class="counter" id="cartCounter_<?php echo $arrayRelatedProduct[$x]->product_id; ?>"> 
                                                                    <b><span>0</span></b> 
                                                                </span> 
                                                                <span class="add2cart" id="AddToCartText_<?php echo $arrayRelatedProduct[$x]->product_id; ?>">
                                                                    Add to cart 
                                                                </span> 
                                                            </a> 
                                                        </div>

                                                    <?php } ?> 
                                                </div>
                                            </div>
                                        <?php endfor; /* $x=0; $x<$countFeatCategory; $x++  */ ?>


                                    </div>
                                    <!-- end carousel --> 
                                </div>

                                <?php
                            endif; //$countRelatedProduct > 0
                            ?>





                        </div>  <!-- // end Related Product -->

                    </div>
                </div>


            </div>
<?php include basePath('footer_delivery.php'); ?>
            <?php include basePath('footer.php'); ?>



        </div>
        <!-- /wrapper --> 




        <?php include basePath('mini_login.php'); ?>
        <?php include basePath('mini_signup.php'); ?>
        <?php include basePath('mini_cart.php'); ?>


        <script type='text/javascript' src="<?php echo baseUrl(); ?>js/multizoom.js"></script>
        <script type='text/javascript' src="<?php echo baseUrl(); ?>js/readmore.min.js"></script> 

        <?php include basePath('footer_script.php'); ?>
        <script type='text/javascript' src="<?php echo baseUrl(); ?>js/productdetails.js"></script>
        <script src="<?php echo baseUrl(); ?>ajax/product_details/main.js"></script>

    </body>
</html>