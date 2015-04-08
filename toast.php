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
                        WHERE product_categories.PC_category_id IN ($commaseparatedFeatCategoryID) AND products.product_status ='active'
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
$sqlBrand = "SELECT * FROM categories WHERE category_parent_id=1 ORDER BY category_priority ASC";
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
          
<div class="toast-container toast-position-top-right">
  <div class="toast-item-wrapper">
    <div class="toast-item toast-type-success">
      <div class="toast-item-image toast-item-image-success"></div>
      <div class="toast-item-close"></div>
      <p>Product added.</p>
    </div>
  </div>
</div>
          
          <br><br><br>
          <div class="toast-container toast-position-top-right" style="margin-top: 100px !important">
  <div class="toast-item-wrapper">
    <div class="toast-item toast-type-error">
      <div class="toast-item-image toast-item-image-error"></div>
      <div class="toast-item-close"></div>
      <p>First Name is required.</p>
    </div>
  </div>
</div>



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
                                                      timeout: 5000,
                                                      speed: 1200,
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