<?php
include 'config/config.php';

$CartID = '';

$page_title = get_option('SITE_DEFAULT_META_TITLE');
$page_description = get_option('SITE_DEFAULT_META_DESCRIPTION');
$page_keywords = get_option('SITE_DEFAULT_META_KEYWORDS');
$site_author = $config['CONFIG_SETTINGS']['SITE_AUTHOR'];

//Query for getting featured category from database
$arrayFeatCategory = array();
$arrayFeatCategoryID = array();
$countFeatCategoryArray = 0;
$sqlFeatCategory = "SELECT categories.category_name,categories.category_id,category_featured.CF_id,category_featured.CF_category_id 
                    FROM category_featured,categories 
                    WHERE category_featured.CF_featured_from <= NOW() 
                    AND category_featured.CF_featured_to >= NOW() 
                    AND category_featured.CF_category_id=categories.category_id
                    ORDER BY categories.category_name ASC";
$executeFeatCategory = mysqli_query($con, $sqlFeatCategory);
if ($executeFeatCategory) {
    while ($executeFeatCategoryObj = mysqli_fetch_object($executeFeatCategory)) {
        $arrayFeatCategory[] = $executeFeatCategoryObj;
        $arrayFeatCategoryID[] = $executeFeatCategoryObj->CF_category_id;
    }
} else {
    echo "Featured Product query failed.";
    if (DEBUG) {
        echo "executeFeatCategory error: " . mysqli_error($con);
    }
}

$countFeatCategoryArray = count($arrayFeatCategoryID);
$totalProductQuantity = 18 * $countFeatCategoryArray;

//getting all products from database under featured categories
$arrayFeatCatPoduct = array();
$commaseparatedFeatCategoryID = implode(', ', $arrayFeatCategoryID);
if ($commaseparatedFeatCategoryID != '') {
    $sqlFeatCatProduct = "SELECT 
                        products.product_id, products.product_title, products.product_default_inventory_id,  products.product_show_as_new_from, products.product_show_as_new_to, products.product_show_as_featured_from, products.product_show_as_featured_to,
                        product_inventories.PI_inventory_title,product_inventories.PI_size_id,product_inventories.PI_cost,product_inventories.PI_current_price,product_inventories.PI_old_price,product_inventories.PI_quantity,
                        product_discounts.PD_start_date,product_discounts.PD_end_date,product_discounts.PD_amount,product_discounts.PD_status,
                        (SELECT product_images.PI_file_name FROM product_images WHERE product_images.PI_inventory_id = products.product_default_inventory_id AND product_images.PI_product_id = products.product_id ORDER BY product_images.PI_priority DESC LIMIT 1) as PI_file_name,
                        product_categories.PC_category_id,product_categories.PC_id

                        FROM products

                        LEFT JOIN product_inventories ON product_inventories.PI_id = products.product_default_inventory_id
                        LEFT JOIN product_discounts ON product_discounts.PD_inventory_id = product_inventories.PI_id
                        LEFT JOIN product_categories ON product_categories.PC_product_id = products.product_id
                        WHERE product_categories.PC_category_id IN ($commaseparatedFeatCategoryID) 
                          AND products.product_status ='active'
                          AND products.product_default_inventory_id > 0
                        ORDER BY PC_category_id,RAND()";
    $executeFeatCatProduct = mysqli_query($con, $sqlFeatCatProduct);
    if ($executeFeatCatProduct) {
        while ($executeFeatCatProductObj = mysqli_fetch_object($executeFeatCatProduct)) {
            $arrayFeatCatPoduct[$executeFeatCatProductObj->PC_category_id][] = $executeFeatCatProductObj;
        }
    } else {
        if (DEBUG) {
            echo "executeFeatCatProduct error: " . mysqli_error($con);
        }
    }
}



//getting data from temp_carts table
if ($CartID == '') {
    $CartID = session_id();
}
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



//getting category banner data from database
$arrayHomeBanner = array();
$sqlCatBanner = "SELECT * FROM banners WHERE banner_area='HOME' ORDER BY banner_priority DESC";
$executeHomeBanner = mysqli_query($con, $sqlCatBanner);
if ($executeHomeBanner) {
    while ($executeHomeBannerObj = mysqli_fetch_object($executeHomeBanner)) {
        $arrayHomeBanner[] = $executeHomeBannerObj;
    }
} else {
    if (DEBUG) {
        echo "executeCatBanner error: " . mysqli_error($con);
    } else {
        echo "executeCatBanner query failed";
    }
}



//getting brand from database
$arrayBrand = array();
$BRAND_CATEGORY_ID= $config['BRAND_CATEGORY_ID'];
$sqlBrand = "SELECT * FROM categories WHERE category_parent_id= $BRAND_CATEGORY_ID ORDER BY category_priority ASC";
$executeSqlBrand = mysqli_query($con, $sqlBrand);
if ($executeSqlBrand) {
    while ($executeSqlBrandObj = mysqli_fetch_object($executeSqlBrand)) {
        $arrayBrand[] = $executeSqlBrandObj;
    }
} else {
    if (DEBUG) {
        echo "executeSqlBrand error: " . mysqli_error($con);
    } else {
        echo "executeSqlBrand query failed.";
    }
}

//echo "<pre>";
//print_r($arrayHomeBanner);
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

        <script>
            $(document).ready(function() {

                for (var i = 0; i < <?php echo count($arrayFeatCategory); ?>; i++) {

                    $("#homeCarousel_" + i).tnmCarousel({
                        navigation: false,
                        lazyLoad: true,
                        addClassActive: true,
                        items: 6,
                        itemsTablet: [768, 3],
                        itemsTabletSmall: [580, 2]

                    });
                }
            });
        </script>


    </head>

    <body class="home">


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

            <div class="banner">
                <div class="container">
                    <div id="cycleContainer" >


                        <?php
                        $countHomeBanner = count($arrayHomeBanner);
                        if ($countHomeBanner > 0):
                            for ($z = 0; $z < $countHomeBanner; $z++):
                                ?>
                                <div class="item container" data-cycle-pager-template="<a href='#' id='aSlider'> <?php echo $arrayHomeBanner[$z]->banner_title; ?> </a>">
                                    <div class="row">
                                            <?php if ($arrayHomeBanner[$z]->banner_url == ""): ?>
                                            <img width="100%" class="img-responsive"  src="<?php echo baseUrl(); ?>upload/banner/<?php echo $arrayHomeBanner[$z]->banner_image_name; ?>">
                                            <?php else: /*  ($arrayHomeBanner[$z]->banner_url=="") */ ?>
                                            <a href="<?php echo $arrayHomeBanner[$z]->banner_url; ?>" title="<?php echo $arrayHomeBanner[$z]->banner_title; ?> "><img width="100%" class="img-responsive"  src="<?php echo baseUrl(); ?>upload/banner/<?php echo $arrayHomeBanner[$z]->banner_image_name; ?>"></a>
                                            <?php endif; /*  ($arrayHomeBanner[$z]->banner_url=="") */ ?>


                                    </div>
                                </div>
                                <?php
                            endfor;
                        endif;
                        ?>
                    </div>
                </div>
            </div>
            <div style="clear:both"></div>

            <div class="w100 mainContainer">

                <div class="row" style="padding-top:50px; width:80%; margin: 0 auto;">
                <?php include basePath('alert.php'); ?>
                </div>
                <?php
                //featured product slider generation
                $countFeatCategory = count($arrayFeatCategory);
                if ($countFeatCategory > 0):
                    ?>
                    <?php
                    for ($i = 0; $i < $countFeatCategory; $i++):

                        //declearing category variables
                        $CategoryID = $arrayFeatCategory[$i]->category_id;
                        $CategoryTitle = $arrayFeatCategory[$i]->category_name;


                        //checking if the array is empty or not and also checking the count of the array
                        if (!empty($arrayFeatCatPoduct[$CategoryID]) AND count($arrayFeatCatPoduct[$CategoryID]) > 0):
                            $countFeatCatProduct = count($arrayFeatCatPoduct[$CategoryID]);
                            ?>

                            <div class="container padd">



                                <div class="section-title text-center">
                                    <h2><a href="<?php echo baseUrl(); ?>category/<?php echo $CategoryID; ?>/<?php echo extra_clean(clean($CategoryTitle)); ?>"><span><?php echo $CategoryTitle; ?></span></a> <a class="pull-right see-all" href="category/<?php echo $CategoryID; ?>/<?php echo extra_clean(clean($CategoryTitle)); ?>"> See all <i class="fa fa-angle-double-right"></i> </a> </h2>
                                </div>
                                <div id="homeCarousel_<?php echo $i; ?>" class="row productFeatured xsResponse tnm-carousel tnm-theme carousel">


                                    <?php for ($x = 0; $x <= $countFeatCatProduct; $x++): ?>
                                        <?php if (isset($arrayFeatCatPoduct[$CategoryID][$x]->PC_id)) { ?>
                                            <?php
                                            //declearing product variables
                                            $ProductID = $arrayFeatCatPoduct[$CategoryID][$x]->product_id;
                                            $ProductName = $arrayFeatCatPoduct[$CategoryID][$x]->product_title;
                                            $ProductDefaultInventoryID = $arrayFeatCatPoduct[$CategoryID][$x]->product_default_inventory_id;
                                            $ProductInventoryTitle = $arrayFeatCatPoduct[$CategoryID][$x]->PI_inventory_title;
                                            $ProductCurrentPrice = $arrayFeatCatPoduct[$CategoryID][$x]->PI_current_price;
                                            $ProductOldPrice = $arrayFeatCatPoduct[$CategoryID][$x]->PI_old_price;
                                            $ProductDiscount = $arrayFeatCatPoduct[$CategoryID][$x]->PD_amount;
                                            ?>
                                            <div class="product ">
                                                <div class="productBox"> 
                                                    <a class="proImg" href="<?php echo baseUrl(); ?>product/<?php echo $ProductID; ?>/<?php echo extra_clean(clean($ProductName)); ?>" >
                                                      
                                                      <span style="position: absolute; height: 100%; width: 100%; z-index: 100;"></span>
                                                      
                                                        <?php if ($arrayFeatCatPoduct[$CategoryID][$x]->PI_file_name == ''): ?>
                                                            <img src="<?php echo baseUrl(); ?>upload/product/small/default.jpg" >
                                                        <?php else: ?>
                                                            <img src="<?php echo baseUrl(); ?>upload/product/small/<?php echo $arrayFeatCatPoduct[$CategoryID][$x]->PI_file_name; ?>" >
                                                        <?php endif; ?>
                                                    </a>
                                                    <div class="description">

                                                        <!--                                          showing product discount -->                                          
                                                        <?php if ($ProductDiscount > 0): ?>
                                                            <div class="save-price">SAVE <?php echo $config['CURRENCY_SIGN']; ?> <?php echo $ProductDiscount; ?></div>
                                                        <?php endif; ?>
                                                        <!--                                          showing product discount -->                                          

                                                        <h4><a href="<?php echo baseUrl(); ?>product/<?php echo $ProductID; ?>/<?php echo extra_clean(clean($ProductName)); ?>" ><?php echo $ProductName; ?></a></h4>
                                                        <span class="size"><?php echo $ProductInventoryTitle; ?></span> </div>
                                                    <div class="price">

                                                        <!--                                          showing product current price based on discount-->
                                                        <?php if ($ProductDiscount > 0): ?>
                                                            <span class="current-price"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format(($ProductCurrentPrice - $ProductDiscount), 2); ?></span>
                                                        <?php else: ?>
                                                            <span><?php echo $config['CURRENCY_SIGN']; ?> <?php echo $ProductCurrentPrice; ?></span>
                                                        <?php endif; ?>
                                                        <!--                                          showing product current price based on discount-->

                                                        <!--                                          showing product old price -->
                                                        <?php if ($ProductDiscount > 0): ?>
                                                            <span class="old-price"> <?php echo $config['CURRENCY_SIGN']; ?> <?php echo $ProductCurrentPrice; ?></span>
                                                        <?php
                                                        else:
                                                            if ($ProductOldPrice > 0):
                                                                ?>
                                                                <span class="old-price"> <?php echo $config['CURRENCY_SIGN']; ?> <?php echo $ProductOldPrice; ?></span>
                                                                <?php
                                                            endif;
                                                        endif;
                                                        ?>
                                                        <!--                                          showing product old price -->                                          

                                                    </div>
                                                    <?php
                                                    //featured product slider generation
                                                    $countTempCart = count($arrayTempCart);
                                                    $productExistenceIndicator = FALSE;
                                                    $tempCartQuantity = 0;
                                                    if ($countTempCart > 0):
                                                        for ($a = 0; $a < $countTempCart; $a++):

                                                            //declearing temp cart variables
                                                            $TempCartProductID = $arrayTempCart[$a]->TC_product_id;
                                                            $TempCartProductQuantity = $arrayTempCart[$a]->TC_product_quantity;
                                                            $TempCartInventoryID = $arrayTempCart[$a]->TC_product_inventory_id;

                                                            if ($ProductID == $TempCartProductID AND $ProductDefaultInventoryID == $TempCartInventoryID):
                                                                $productExistenceIndicator = TRUE;
                                                                $tempCartQuantity = $TempCartProductQuantity;
                                                            endif;
                                                        endfor;
                                                    endif;
                                                    ?>

                                                    <?php
                                                    if ($productExistenceIndicator) {
                                                        ?>

                                                        <div class="cartControll"> 
                                                            <a class="btncart active" id="addToCart_<?php echo $ProductID; ?>" onClick="AddToCart(<?php echo $ProductID; ?>,<?php echo $ProductDefaultInventoryID; ?>)" > 
                                                                <span class="counter" id="cartCounter_<?php echo $ProductID; ?>"> 
                                                                    <span><b><?php echo $tempCartQuantity; ?></b></span> 
                                                                </span> 
                                                                <span class="add2cart" id="AddToCartText_<?php echo $ProductID; ?>">
                                                                    Add One More 
                                                                </span> 
                                                            </a> 
                                                        </div>
                                                        <?php
                                                    } else {
                                                        ?>

                                                        <div class="cartControll"> 
                                                            <a class="btncart" id="addToCart_<?php echo $ProductID; ?>" onClick="AddToCart(<?php echo $ProductID; ?>,<?php echo $ProductDefaultInventoryID; ?>)" > 
                                                                <span class="counter" id="cartCounter_<?php echo $ProductID; ?>"> 
                                                                    <b><span>0</span></b> 
                                                                </span> 
                                                                <span class="add2cart" id="AddToCartText_<?php echo $ProductID; ?>">
                                                                    Add to cart 
                                                                </span> 
                                                            </a> 
                                                        </div>

                    <?php } ?> 
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php if ($x == 11) {
                                            break;
                                        } //only showing 12 products from the list ?>
            <?php endfor; /* $x=0; $x<$countFeatCatProduct; $x++  */ ?>


                                </div>
                                <!-- end carousel --> 
                            </div>
                        <?php endif; /* $countFeatCategory > 0 */ ?>
                    <?php endfor; /* $i=0; i<$countFeatCategory; $++  */ ?>
                <?php endif; /* $countFeatCategory > 0 */ ?>

                <?php
                $countBrandArray = count($arrayBrand);
                if ($countBrandArray > 0):
                    ?>
                    <!--proDuct Showcase End -->

                    <div class="brandFeatured">
                        <div class="container">
                            <div class="section-title text-center">
                                <p><span>Featured brand </span></p>
                            </div>
                            <div  id="brandCarousel" class="row tnm-carousel tnm-theme carousel"> 

                                <?php
                                for ($a = 0; $a < $countBrandArray; $a++):

                                    //getting all variables from db
                                    $brandName = $arrayBrand[$a]->category_name;
                                    $brandLogo = $arrayBrand[$a]->category_logo;
                                    ?>
                                    <span class="brand-item"><a href="<?php echo baseUrl(); ?>search?key=<?php echo $brandName; ?>" title="<?php echo $brandName; ?>"> <img class="img-responsive" src="<?php echo baseUrl(); ?>upload/category_logo/<?php echo $brandLogo; ?>" alt="<?php echo $brandName; ?>"> </a></span>
                                            <?php
                                        endfor;
                                        ?>                       
                            </div>
                        </div>
                    </div>
                    <!--brandFeatured--> 
                    <?php
                endif;
                ?>
            </div>

<?php include basePath('footer_delivery.php'); ?>
<?php include basePath('footer.php'); ?>



        </div>
        <!-- /wrapper --> 




        <?php include basePath('mini_login.php'); ?>
        <?php include basePath('mini_signup.php'); ?>
        <?php include basePath('mini_cart.php'); ?>

<?php include basePath('footer_script.php'); ?>

        <script src="<?php echo baseUrl(); ?>js/jquery.cycle2.min.js"></script> 
        <script src="<?php echo baseUrl(); ?>js/jquery.cycle2.scrollVert.min.js"></script> 
        <script type="text/javascript">
                                              $(document).ready(function() {
                                                  //Create an array of titles
                                                  var titles = $('#cycleContainer div.item').find("h2").map(function() {
                                                      return $(this).text();
                                                  });

                                                  //Add an unordered list to contain the navigation

                                                  $('#cycleContainer').before('<ul id="pager"></ul>').cycle({
                                                      //Specify options
                                                      fx: 'scrollHorz', //Name of transition effect 
                                                      slides: '.item',
                                                      timeout: 8000,
                                                      speed: 1600,
                                                      easeIn: 'easeInOutExpo',
                                                      easeOut: 'easeInOutExpo',
                                                      pager: '#pager', //Selector for element to use as pager container 
                                                  });


                                              });
        </script> 

        <script>
            $(document).ready(function() {
                var countBanner = <?php echo count($arrayHomeBanner); ?>;
                var aPercentage = 100 / countBanner;
                //alert(aPercentage);

                $("ul#pager").find("a").each(function() {

                    $(this).css({// this is just for style
                        "width": aPercentage + "%"
                    });
                });

        //           $('a#aSlider').css({ // this is just for style
        //                        "width": aPercentage + " !important"
        //                });
            });
        </script>


    </body>
</html>