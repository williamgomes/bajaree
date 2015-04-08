<?php
include 'config/config.php';
include 'lib/category2.php';
require_once('lib/pagination.class.php');
$catLib2 = new Category2($con);
$catTreeArray = array();
$page_title = get_option('SITE_DEFAULT_META_TITLE');
$page_description = get_option('SITE_DEFAULT_META_DESCRIPTION');
$page_keywords = get_option('SITE_DEFAULT_META_KEYWORDS');
$site_author = $config['CONFIG_SETTINGS']['SITE_AUTHOR'];
$defaultSlideLoad = 1; /* slide dload by default , next slides will load auto by fotter mouse hover */
$categoryId = 0;
$categoryArray = array();
$subCategoryArray = array();
$subCategoryArrayCounter = 0;

$siblingCategoryArray = array();
$siblingCategoryArrayCounter = 0;
$subCategoryArrayIds = '';
$SubCategoryProductArray = array();
$productSubCategorycounter = 0;
$productArray = array();
$total_product = 0;
$CartID = '';

if (isset($_REQUEST['category_id']) AND $_REQUEST['category_id'] > 0) {
    $categoryId = intval($_REQUEST['category_id']);
} else {
    $link = 'index.php?err=' . base64_encode('Url is not correct !!');
    redirect($link);
}

/* category tree */
$catTreeArray = $catLib2->getParents($config['PRODUCT_CATEGORY_ID'], $categoryId);

function aasort($array, $key) {
    $sorter = array();
    $ret = array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii] = $va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii] = $array[$ii];
    }
    return $array = $ret;
}

$catTreeArray = aasort($catTreeArray, "category_parent_id");


//asort($catTreeArray);

/* //category tree */


/* category query */
$categoySql = "SELECT categories.category_id,categories.category_name,categories.category_parent_id, categories.category_logo, 
    category_banners.CB_title,category_banners.CB_image_name  
    FROM categories 
    
    LEFT JOIN category_banners ON category_banners.CB_category_id = categories.category_id
    WHERE category_id=$categoryId LIMIT 1";
$categoySqlResult = mysqli_query($con, $categoySql);

if ($categoySqlResult) {
    $categoryArray = mysqli_fetch_object($categoySqlResult);
    mysqli_free_result($categoySqlResult);
} else {
    if (DEBUG) {
        die('categoySqlResult error : ' . mysqli_error($con));
    } else {
        die('categoySqlResult query fail');
    }
}

if (count($categoryArray) < 1) {
    $link = 'index.php?err=' . base64_encode('Category not found !!');
    redirect($link);
}
/* // category query */



$categoryBannerTitle = $categoryArray->CB_title;
$categoryBannerImage = $categoryArray->CB_image_name;
$currentCategoryRootName =$currentCategoryName = $categoryArray->category_name;
$page_title .=' | ' . $currentCategoryName;

/* sub categories  query */
//$subCategoryArray
$subCategorySql = "SELECT category_id,category_name,category_parent_id, category_logo FROM categories WHERE category_parent_id=$categoryId ORDER BY category_priority DESC";
$subCategorySqlResult = mysqli_query($con, $subCategorySql);

if ($subCategorySqlResult) {
    $subCategoryArrayCounter = mysqli_num_rows($subCategorySqlResult);
    while ($subCategorySqlResultRowObj = mysqli_fetch_object($subCategorySqlResult)) {
        $subCategoryArray[] = $subCategorySqlResultRowObj;
        $subCategoryArrayIds .=$subCategorySqlResultRowObj->category_id . ', ';
    }
    mysqli_free_result($subCategorySqlResult);
    $subCategoryArrayIds = trim($subCategoryArrayIds, ', ');
} else {
    if (DEBUG) {
        die('subCategorySqlResult error : ' . mysqli_error($con));
    } else {
        die('subCategorySqlResult query fail');
    }
}


/* //sub categories  query */
// $subCategoryArrayIds;
/* sub categories product query */
//$config['CATEGORY_CAROUSEL_LIMIT']
if ($subCategoryArrayIds != '') {
    $subCatProductSql = "SELECT 
    
products.product_id, products.product_title, products.product_default_inventory_id,  products.product_show_as_new_from, products.product_show_as_new_to, products.product_show_as_featured_from, products.product_show_as_featured_to,
product_inventories.PI_inventory_title,product_inventories.PI_size_id,product_inventories.PI_cost,product_inventories.PI_current_price,product_inventories.PI_old_price,product_inventories.PI_quantity,
product_discounts.PD_start_date,product_discounts.PD_end_date,product_discounts.PD_amount,product_discounts.PD_status,
(SELECT product_images.PI_file_name FROM product_images WHERE product_images.PI_inventory_id = products.product_default_inventory_id AND product_images.PI_product_id = products.product_id ORDER BY product_images.PI_priority DESC LIMIT 1) as PI_file_name,
product_categories.PC_category_id

FROM products

LEFT JOIN product_inventories ON product_inventories.PI_id = products.product_default_inventory_id
LEFT JOIN product_discounts ON product_discounts.PD_inventory_id = product_inventories.PI_id
LEFT JOIN product_categories ON product_categories.PC_product_id = products.product_id
WHERE product_categories.PC_category_id IN ($subCategoryArrayIds) AND products.product_status ='active'
AND products.product_default_inventory_id > 0 ORDER BY products.product_priority DESC";

    $subCatProductSqlResult = mysqli_query($con, $subCatProductSql);

    if ($subCatProductSqlResult) {
        //$SubCategoryProductArrayCounter = mysqli_num_rows($subCatProductSqlResult);
        while ($subCategorySqlResultRowObj = mysqli_fetch_object($subCatProductSqlResult)) {
            $current_cat_id = $subCategorySqlResultRowObj->PC_category_id;
            $SubCategoryProductArray[$current_cat_id][] = $subCategorySqlResultRowObj;
        }
        mysqli_free_result($subCatProductSqlResult);
    } else {
        if (DEBUG) {
            die('subCatProductSqlResult error : ' . mysqli_error($con));
        } else {
            die('subCatProductSqlResult query fail');
        }
    }
}

/* //sub categories product query */

$SubCategoryProductArrayCounter = count($SubCategoryProductArray);
if ($SubCategoryProductArrayCounter < 1) {
    /* sibling categories  query */
    $siblingCategorySql = "SELECT category_id,category_name,category_parent_id, category_logo FROM categories WHERE category_parent_id=(SELECT category_parent_id FROM categories WHERE category_id=" . intval($categoryId) . ") ORDER BY category_name ASC";
    $siblingCategorySqlResult = mysqli_query($con, $siblingCategorySql);

    if ($siblingCategorySqlResult) {
        $siblingCategoryArrayCounter = mysqli_num_rows($siblingCategorySqlResult);
        while ($siblingCategorySqlResultRowObj = mysqli_fetch_object($siblingCategorySqlResult)) {
            $siblingCategoryArray[] = $siblingCategorySqlResultRowObj;
        }
        mysqli_free_result($siblingCategorySqlResult);
    } else {
        if (DEBUG) {
            die('siblingCategorySqlResult  error : ' . mysqli_error($con));
        } else {
            die('siblingCategorySqlResult query fail');
        }
    }

    /* //sibling categories  query */
}
//printDie($SubCategoryProductArray);

/* current category products */
//$categoryId


$where = " WHERE product_categories.PC_category_id IN ($categoryId) AND products.product_default_inventory_id > 0 AND products.product_status ='active'";

$order_by = " ORDER BY products.product_title ASC";
$productCountSql = "SELECT   
COUNT(products.product_id) AS total_product
FROM products

LEFT JOIN product_categories ON product_categories.PC_product_id = products.product_id
$where
";
$productCountSqlResult = mysqli_query($con, $productCountSql);
if ($productCountSqlResult) {
    $per_page = $config['CATEGORY_ITEMS_PER_PAGE'];
    $pagination = new Pagination($per_page);
    $productCountSqlResultObjectRow = mysqli_fetch_object($productCountSqlResult);
    mysqli_free_result($productCountSqlResult);
    $total_product = $productCountSqlResultObjectRow->total_product;


    $limit = $pagination->getLimit($total_product);


    $productSql = "SELECT 
    
        products.product_id, products.product_title, products.product_default_inventory_id,  products.product_show_as_new_from, products.product_show_as_new_to, products.product_show_as_featured_from, products.product_show_as_featured_to,
        product_inventories.PI_inventory_title,product_inventories.PI_size_id,product_inventories.PI_cost,product_inventories.PI_current_price,product_inventories.PI_old_price,product_inventories.PI_quantity,
        product_discounts.PD_start_date,product_discounts.PD_end_date,product_discounts.PD_amount,product_discounts.PD_status,
        (SELECT product_images.PI_file_name FROM product_images WHERE product_images.PI_inventory_id = products.product_default_inventory_id AND product_images.PI_product_id = products.product_id ORDER BY product_images.PI_priority DESC LIMIT 1) as PI_file_name,
        product_categories.PC_category_id

        FROM products

        LEFT JOIN product_inventories ON product_inventories.PI_id = products.product_default_inventory_id
        LEFT JOIN product_discounts ON product_discounts.PD_inventory_id = product_inventories.PI_id
        LEFT JOIN product_categories ON product_categories.PC_product_id = products.product_id
        $where $order_by LIMIT $limit
";
    $productSqlResult = mysqli_query($con, $productSql);
    if ($productSqlResult) {

        while ($productSqlResultRowObj = mysqli_fetch_object($productSqlResult)) {
            $productArray[] = $productSqlResultRowObj;
        }

        $start_num = $pagination->getStartItem();

        $end_num = $pagination->getEndItem();

        $pagination_add = '?category=' . $categoryId . '&page=';

        $pagination_url = baseUrl('ajax/category/pagination.php') . $pagination_add . '{#PAGE#}';

        $page_link = $pagination->ajaxCategoryPagination($pagination_url, '#prductMainCOntainer');

        mysqli_free_result($productSqlResult);
    } else {
        if (DEBUG) {
            die('productCountSqlResult error : ' . mysqli_error($con));
        } else {
            die('productCountSqlResult query fail');
        }
    }
} else {
    if (DEBUG) {
        die('productCountSqlResult error : ' . mysqli_error($con));
    } else {
        die('productCountSqlResult query fail');
    }
}


/* //current category products */

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
        <script type="text/javascript">
            var SubCategoryProductArrayCounter = '<?php echo $SubCategoryProductArrayCounter; ?>';
        </script>
        <?php include basePath('header_script.php'); ?>
        
        <script src="<?php echo baseUrl(); ?>ajax/index/main.js"></script>


        <script>
            $(document).ready(function() {

                for (var i = 1; i <= SubCategoryProductArrayCounter; i++) {

                    $("#categoryCarousel_" + i).tnmCarousel({
                        navigation: false,
                        lazyLoad: true,
                        items: 4,
                        itemsTablet: [768, 3],
                        itemsTabletSmall: [580, 2]

                    });
                }
            });
        </script>
        <style type="text/css">
            /*            load later*/
            .hide_category{
                display: none;
            }
            .loader{
                text-align: center;
                background: url('<?php echo baseUrl(); ?>images/loader.gif')no-repeat center;
                height:30px;
                width:100%;
                clear:both;
                display: block;
                z-index:999;
                position:relative;
            }
            #prductMainCOntainer .hideProduct{
                display: none;
            }
        </style>
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
            <div class="w100 mainContainer innerPadd">

                <div class="breadcrumbDiv">
                    <div class="container">

                        <ul class="breadcrumb">
                            <li><a href="<?php echo baseUrl(); ?>">Home</a></li>

                            <?php foreach ($catTreeArray AS $CTA): ?>
                            <?php if($CTA['category_parent_id']==$config['PRODUCT_CATEGORY_ID']){
                              $currentCategoryRootName=$CTA['category_name'];
                            }?>
                                <?php if ($CTA['category_id'] == $categoryId): ?>
                                    <li class="active"><?php echo $CTA['category_name']; ?></li>
                                <?php else: /* ($CTA['category_id']==$categoryId ) */ ?>
                                    <li><a href="<?php echo baseUrl('category') . '/' . $CTA['category_id'] . '/' . extra_clean(clean($CTA['category_name'])); ?>"><?php echo $CTA['category_name']; ?></a> </li>
                                <?php endif; /* ($CTA['category_id']==$categoryId ) */ ?>

                            <?php endforeach; /* foreach ($catTreeArray AS $CTA) */ ?>


                        </ul>
                    </div>
                </div>
                <div class="container">
                    <?php include basePath('alert.php'); ?>
                    <div class="row">
                        <div class="col-lg-2 col-md-3 col-sm-3">

                            <?php if ($subCategoryArrayCounter > 0): ?>
                                <h3 class="categoryName"><?php echo $currentCategoryRootName; ?></h3>
                                <ul class="unstyled catList">
                                    <?php for ($i = 0; $i < $subCategoryArrayCounter; $i++): ?>
                                        <?php
                                        $current_cat_name = $subCategoryArray[$i]->category_name;
                                        $current_cat_id = $subCategoryArray[$i]->category_id;
                                        ?>
                                        <li> <a title="<?php echo $current_cat_name; ?>" href="<?php echo baseUrl('category/') . $current_cat_id . '/' . extra_clean(clean($current_cat_name)); ?>"> <?php echo $current_cat_name; ?></a> </li>
                                    <?php endfor; /* ($i=0; $i < $subCategoryArrayCounter; $i++) */ ?>

                                </ul>
                            <?php elseif ($siblingCategoryArrayCounter > 0): /* ($siblingCategoryArrayCounter > 0) */ ?>
                                <h3 class="categoryName"><?php echo $currentCategoryRootName; ?> </h3>
                                <ul class="unstyled catList">
                                    <?php for ($i = 0; $i < $siblingCategoryArrayCounter; $i++): ?>
                                        <?php
                                        $current_cat_name = $siblingCategoryArray[$i]->category_name;
                                        $current_cat_id = $siblingCategoryArray[$i]->category_id;
                                        $class = '';
                                        if ($categoryId == $current_cat_id) {
                                            $class = 'active_category';
                                        }
                                        ?>
                                        <li class="<?php echo $class; ?>"> <a title="<?php echo $current_cat_name; ?>" href="<?php echo baseUrl('category/') . $current_cat_id . '/' . extra_clean(clean($current_cat_name)); ?>"> <?php echo $current_cat_name; ?></a> </li>
                                    <?php endfor; /* ($i=0; $i < $subCategoryArrayCounter; $i++) */ ?>

                                </ul>
                            <?php endif; /* ($subCategoryArrayCounter > 0) */ ?>

                        </div>
                        <div class="col-lg-10 col-md-9 col-sm-9 categoryContainer">

                            <?php if ($SubCategoryProductArrayCounter < 1): ?>
                                <?php $productArrayCounter = count($productArray); ?>
                                <div class="productFilter">
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-7 col-md-7 col-xs-12">
                                            <h3><?php echo $currentCategoryName; ?> <span>( <?php
                                                    if ($productArrayCounter > 0) {
                                                        echo $productArrayCounter . ' Products';
                                                    } else {
                                                        echo 'No Product Found';
                                                    }
                                                    ?>  )</span></h3></div>
                                        <div class="col-sm-6 col-lg-5 col-md-5 col-xs-12 sortBy">
                                            <span>Sort By:</span>
                                            <select id="basic" class="pull-right"> 
                                                <option value="nameAsc" selected>A - Z (Name)</option>
                                                <option value="nameDesc" selected>Z - A (Name)</option>
                                                <option value="priceLow">Price Low to High </option>
                                                <option value="priceHiegh">Price High to Low </option>
                                            </select>

                                        </div>
                                    </div>

                                </div>
                            <?php else: /*  ($SubCategoryProductArrayCounter < 1) */ ?>
                                <?php if ($categoryBannerImage != ''): ?>
                                    <!--last category level will not show any banner instruction by Rameez bhai--> 
                                    <div class="FeaturedImage"> <img alt='<?php echo $categoryBannerImage; ?>' src="<?php echo baseUrl(); ?>upload/category_banner/<?php echo $categoryBannerImage; ?>"> </div>
                                <?php endif; ?>
                            <?php endif; /*  ($SubCategoryProductArrayCounter < 1) */ ?>



                            <!--end productFilter-->
                            <!--                            start showing product information -->
                            <?php if ($SubCategoryProductArrayCounter < 1): ?>
                                <div id="prductMainCOntainer" class="productFeatured categoryProduct xsResponse">

                                    <?php $productArrayCounter = count($productArray); ?>
                                    <?php if ($productArrayCounter > 0): ?>
                                        <?php for ($i = 0; $i < $productArrayCounter; $i++): ?>

                                            <?php
                                            $currentProTitle = $productArray[$i]->product_title;
                                            $currentProTitleClean = extra_clean(clean($productArray[$i]->product_title));
                                            $currentProId = $productArray[$i]->product_id;
                                            $currentProDefaultInventoryId = $productArray[$i]->product_default_inventory_id;
                                            $currentProNewFrom = $productArray[$i]->product_show_as_new_from;
                                            $currentProNewTo = $productArray[$i]->product_show_as_new_to;
                                            $currentProFeaturedFrom = $productArray[$i]->product_show_as_featured_from;
                                            $currentProFeaturedTo = $productArray[$i]->product_show_as_featured_to;
                                            $currentProImage = $productArray[$i]->PI_file_name;


                                            $currentProInventoryTitle = $productArray[$i]->PI_inventory_title;
                                            $currentProInventoryPrice = $productArray[$i]->PI_current_price;
                                            $oldProInventoryPrice = $productArray[$i]->PI_old_price;
                                            $currentProInventoryId = $productArray[$i]->PI_size_id;
                                            $currentProInventoryQty = $productArray[$i]->PI_quantity;


                                            $currentProInventoryDiscountAmount = $productArray[$i]->PD_amount;
                                            $currentProInventoryDiscountStart = $productArray[$i]->PD_start_date;
                                            $currentProInventoryDiscountEnd = $productArray[$i]->PD_end_date;
                                            $discountAmount = 0;
                                            if (($currentProInventoryDiscountStart <= date("Y-m-d")) AND ( $currentProInventoryDiscountEnd >= date("Y-m-d"))) {
                                                $discountAmount = $currentProInventoryDiscountAmount;
                                            }
                                            ?>

                                            <div class="col-sm-4 col-lg-3 col-md-3 col-xs-6 product">
                                                <div class="hiddenData">
                                                    <span class="sortProName"><?php echo trim($currentProTitle); ?></span>
                                                    <span class="sortProPrice"><?php echo $currentProInventoryPrice; ?></span>


                                                </div>
                                                <div class="productBox <?php
                                                if ($i >= 8) {
                                                    echo 'hideProduct';
                                                }
                                                ?>"> 

                                                    <?php if ($currentProImage != '' AND file_exists(basePath('upload/product/small/' . $currentProImage))): ?>
                                                        <a class="proImg" title="<?php echo $currentProTitle; ?>" href="<?php echo baseUrl('product/' . $currentProId . '/' . $currentProTitleClean); ?>">  
                                                            <?php if ($i >= 8): ?>
                                                                <img class="lazy2  <?php echo $i; ?>" data-original="<?php echo baseUrl('upload/product/small/' . $currentProImage); ?>"  src="<?php echo baseUrl('upload/product/small/default.jpg'); ?>" alt="<?php echo $currentProTitle; ?>" />
                                                            <?php else: /* ($i > 8 ) */ ?>
                                                                <img  src="<?php echo baseUrl('upload/product/small/' . $currentProImage); ?>" alt="<?php echo $currentProTitle; ?>" />
                                                            <?php endif; /* ($i > 8 ) */ ?>


                                                        </a>
                                                    <?php else: /* ($currentProImage !='' OR file_exists(basePath('upload/product/small/'.$currentProImage))): */ ?>
                                                        <a title="<?php echo $currentProTitle; ?>" href="<?php echo baseUrl('product/' . $currentProId . '/' . $currentProTitleClean); ?>">  
                                                            <?php if ($i >= 8): ?>
                                                                <img class="lazy2  <?php echo $i; ?>" data-original="<?php echo baseUrl('upload/product/small/default.jpg'); ?>"  src="<?php echo baseUrl('upload/product/small/default.jpg'); ?>" alt="<?php echo $currentProTitle; ?>" />
                                                            <?php else: /* ($i > 8 ) */ ?>
                                                                <img src="<?php echo baseUrl('upload/product/small/default.jpg'); ?>" alt="<?php echo $currentProTitle; ?>" />
                                                            <?php endif; /* ($i > 8 ) */ ?>

                                                        </a>
                                                    <?php endif; /* ($currentProImage !='' OR file_exists(basePath('upload/product/small/'.$currentProImage))): */ ?>




                                                    <div class="description">

                                                        <!--                                          showing product discount -->                                          
                                                        <?php if ($discountAmount > 0): ?>
                                                            <div class="save-price">SAVE <?php echo $config['CURRENCY_SIGN']; ?> <?php echo $discountAmount; ?></div>
                                                        <?php endif; ?>
                                                        <!--                                          showing product discount -->                                                      

                                                        <h4><a title="<?php echo $currentProTitle; ?>" href="<?php echo baseUrl('product/' . $currentProId . '/' . $currentProTitleClean); ?>"><?php echo $currentProTitle; ?></a></h4>
                                                        <span class="size"><?php echo $currentProInventoryTitle; ?></span> </div>

                                                    <div class="price">
                                                        <!--                                          showing product current price based on discount-->
                                                        <?php if ($discountAmount > 0): ?>
                                                            <span class="current-price"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format(($currentProInventoryPrice - $discountAmount), 2); ?></span>
                                                            <span class="old-price"> <?php echo $config['CURRENCY_SIGN']; ?> <?php echo $currentProInventoryPrice; ?></span>
                                                        <?php else: ?>
                                                            <span><?php echo $config['CURRENCY_SIGN']; ?> <?php echo $currentProInventoryPrice; ?></span>
                                                        <?php endif; ?>
                                                        <!--                                          showing product current price based on discount-->

                                                        <!--                                          showing product old price -->
                                                        <?php if ($oldProInventoryPrice > 0): ?>
                                                            <span class="old-price"> <?php echo $config['CURRENCY_SIGN']; ?> <?php echo $oldProInventoryPrice; ?></span>
                                                        <?php endif; ?>
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

                                                            if ($currentProId == $TempCartProductID AND $currentProDefaultInventoryId == $TempCartInventoryID):
                                                                $productExistenceIndicator = TRUE;
                                                                $tempCartQuantity = $TempCartProductQuantity;
                                                            endif;
                                                        endfor;
                                                    endif;
                                                    ?>


                                                    <?php
                                                    if ($productExistenceIndicator):
                                                        ?>
                                                        <div class="cartControll"> 
                                                            <a class="btncart active" id="addToCart_<?php echo $currentProId; ?>" onClick="AddToCart(<?php echo $currentProId; ?>,<?php echo $currentProDefaultInventoryId; ?>)" > 
                                                                <span class="counter" id="cartCounter_<?php echo $currentProId; ?>"> 
                                                                    <span><b><?php echo $tempCartQuantity; ?></b></span> 
                                                                </span> 
                                                                <span class="add2cart" id="AddToCartText_<?php echo $ProductID; ?>">
                                                                    Add One More 
                                                                </span> 
                                                            </a> 
                                                        </div>
                                                        <?php
                                                    else:
                                                        ?>
                                                        <div class="cartControll"> 
                                                            <a class="btncart" id="addToCart_<?php echo $currentProId; ?>" onClick="AddToCart(<?php echo $currentProId; ?>,<?php echo $currentProDefaultInventoryId; ?>)" > 
                                                                <span class="counter" id="cartCounter_<?php echo $currentProId; ?>"> 
                                                                    <b><span>0</span></b> 
                                                                </span> 
                                                                <span class="add2cart" id="AddToCartText_<?php echo $currentProId; ?>">
                                                                    Add to cart 
                                                                </span> 
                                                            </a> 
                                                        </div>
                                                    <?php
                                                    endif;
                                                    ?>

                                                </div>
                                            </div>

                                        <?php endfor; /* ($i=0;$i < $productArrayCounter ;$i++) */ ?>

                                    <?php else: /*  ($productArrayCounter > 0) */ ?>
                                        <p> Product Not available </p>
                                    <?php endif; /*  ($productArrayCounter > 0) */ ?>

                                    <?php if ($total_product > $per_page): ?>

                                        <div class="w100-inline">
                                            <div class="pagination pull-left no-margin-top">

                                                <ul class="pagination no-margin-top">
                                                    <?php echo $page_link; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php endif; /* ($total_product > $per_page): */ ?>


                                </div>
                                <!--product content-->

                            <?php endif; /* ($productArrayCounter < 1 ) */ ?>

                            <!--   //                         start showing product information -->


                            <?php $slideCounter = 0; ?>
                            <?php if ($SubCategoryProductArrayCounter > 0): ?>

                                <?php for ($i = 0; $i < $subCategoryArrayCounter; $i++): ?>
                                    <?php
                                    $currentCatId = $subCategoryArray[$i]->category_id;
                                    $currentCatName = $subCategoryArray[$i]->category_name;
                                    ?>

                                    <?php if (isset($SubCategoryProductArray[$currentCatId])): ?>
                                        <?php $slideCounter++; ?>
                                        <div class="productFeatured categoryProduct <?php
                                        if ($slideCounter > $defaultSlideLoad) {
                                            echo 'hide_category';
                                        }
                                        ?>">
                                          
                                          <?php
                                            /* checking total product , if product exceed max lavel then force to config limit */

                                            $originalProductCounter = $limit = count($SubCategoryProductArray[$currentCatId]);
                                            if ($limit > $config['CATEGORY_CAROUSEL_LIMIT']) {
                                                $limit = $config['CATEGORY_CAROUSEL_LIMIT'];
                                            }
                                            ?>
                                          
                                          
                                            <div class="section-title text-center">
                                                <h2>
                                                  
                                                    <a title="<?php echo $currentCatName; ?>" href="<?php echo baseUrl('category/') . $currentCatId . '/' . extra_clean(clean($currentCatName)); ?>"><span><?php echo $currentCatName; ?>  </span> </a>
                                                    <?php if($originalProductCounter > $config['CATEGORY_CAROUSEL_LIMIT']): ?>
                                                      <a class="pull-right see-all" title="<?php echo $currentCatName; ?>" href="<?php echo baseUrl('category/') . $currentCatId . '/' . extra_clean(clean($currentCatName)); ?>"> See all <i class="fa fa-angle-double-right"></i> </a> 
                                                    <?php endif; ?>  
                                                </h2>
                                            </div>
                                          
                                            


                                            <div id="categoryCarousel_<?php echo $slideCounter; ?>" class="tnm-carousel tnm-theme w100 carousel">

                                                <!--                            show current category's product-->
                                                <?php for ($j = 0; $j < $limit; $j++): ?>
                                                    <?php
                                                    $currentProTitle = $SubCategoryProductArray[$currentCatId][$j]->product_title;
                                                    $currentProTitleClean = extra_clean(clean($SubCategoryProductArray[$currentCatId][$j]->product_title));
                                                    $currentProId = $SubCategoryProductArray[$currentCatId][$j]->product_id;
                                                    $currentProNewFrom = $SubCategoryProductArray[$currentCatId][$j]->product_show_as_new_from;
                                                    $currentProNewTo = $SubCategoryProductArray[$currentCatId][$j]->product_show_as_new_to;
                                                    $currentProFeaturedFrom = $SubCategoryProductArray[$currentCatId][$j]->product_show_as_featured_from;
                                                    $currentProFeaturedTo = $SubCategoryProductArray[$currentCatId][$j]->product_show_as_featured_to;
                                                    $currentProImage = $SubCategoryProductArray[$currentCatId][$j]->PI_file_name;
                                                    $currentProDefaultInventoryId = $SubCategoryProductArray[$currentCatId][$j]->product_default_inventory_id;


                                                    $currentProInventoryTitle = $SubCategoryProductArray[$currentCatId][$j]->PI_inventory_title;
                                                    $currentProInventoryPrice = $SubCategoryProductArray[$currentCatId][$j]->PI_current_price;
                                                    $oldProInventoryPrice = $SubCategoryProductArray[$currentCatId][$j]->PI_old_price;
                                                    $currentProInventoryId = $SubCategoryProductArray[$currentCatId][$j]->PI_size_id;
                                                    $currentProInventoryQty = $SubCategoryProductArray[$currentCatId][$j]->PI_quantity;


                                                    $currentProInventoryDiscountAmount = $SubCategoryProductArray[$currentCatId][$j]->PD_amount;
                                                    $currentProInventoryDiscountStart = $SubCategoryProductArray[$currentCatId][$j]->PD_start_date;
                                                    $currentProInventoryDiscountEnd = $SubCategoryProductArray[$currentCatId][$j]->PD_end_date;
                                                    $discountAmount = 0;
                                                    if (($currentProInventoryDiscountStart <= date("Y-m-d")) AND ( $currentProInventoryDiscountEnd >= date("Y-m-d"))) {
                                                        $discountAmount = $currentProInventoryDiscountAmount;
                                                    }
                                                    ?>


                                                    <div class="product">
                                                        <div  class="productBox">
                                                            <?php if ($currentProImage != '' AND file_exists(basePath('upload/product/small/' . $currentProImage))): ?>
                                                                <a title="<?php echo $currentProTitle; ?>" href="<?php echo baseUrl('product/' . $currentProId . '/' . $currentProTitleClean); ?>">  
                                                                    <!--
                                                                    class="lazy2" data-original="<?php // echo baseUrl('upload/product/large/' . $img);                   ?>"  src="images/grey.gif"
                                                                    --> 
                                                                    <?php if ($slideCounter > $defaultSlideLoad): ?>
                                                                        <img class="lazy2" data-original="<?php echo baseUrl('upload/product/small/' . $currentProImage); ?>" src="<?php echo baseUrl('upload/product/small/default.jpg'); ?>" alt="<?php echo $currentProTitle; ?>" />
                                                                    <?php else: /* ($slideCounter > $defaultSlideLoad) */ ?>
                                                                        <img src="<?php echo baseUrl('upload/product/small/' . $currentProImage); ?>" alt="<?php echo $currentProTitle; ?>" />
                                                                    <?php endif; /* ($slideCounter > $defaultSlideLoad) */ ?>


                                                                </a>
                                                            <?php else: /* ($currentProImage !='' OR file_exists(basePath('upload/product/small/'.$currentProImage))): */ ?>
                                                                <a title="<?php echo $currentProTitle; ?>" href="<?php echo baseUrl('product/' . $currentProId . '/' . $currentProTitleClean); ?>">  
                                                                    <?php if ($slideCounter > $defaultSlideLoad): ?>
                                                                        <img  class="lazy2"  data-original="<?php echo baseUrl('upload/product/small/default.jpg'); ?>" src="<?php echo baseUrl('upload/product/small/default.jpg'); ?>" alt="<?php echo $currentProTitle; ?>" />
                                                                    <?php else: /* ($slideCounter > $defaultSlideLoad) */ ?>
                                                                        <img src="<?php echo baseUrl('upload/product/small/default.jpg'); ?>" alt="<?php echo $currentProTitle; ?>" />
                                                                    <?php endif; /* ($slideCounter > $defaultSlideLoad) */ ?>
                                                                </a>
                                                            <?php endif; /* ($currentProImage !='' OR file_exists(basePath('upload/product/small/'.$currentProImage))): */ ?>


                                                            <div class="description">
                                                                <h4><a title="<?php echo $currentProTitle; ?>" href="<?php echo baseUrl('product/' . $currentProId . '/' . $currentProTitleClean); ?>"><?php echo $currentProTitle; ?></a></h4>
                                                                <span class="size"><?php echo $currentProInventoryTitle; ?></span> </div>

                                                            <!-- Product price div -->


                                                            <div class="price">
                                                                <!--                                          showing product current price based on discount-->
                                                                <?php if ($discountAmount > 0): ?>
                                                                    <span class="current-price"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format(($currentProInventoryPrice - $discountAmount), 2); ?></span>
                                                                    <span class="old-price"> <?php echo $config['CURRENCY_SIGN']; ?> <?php echo $currentProInventoryPrice; ?></span>
                                                                <?php else: ?>
                                                                    <span><?php echo $config['CURRENCY_SIGN']; ?> <?php echo $currentProInventoryPrice; ?></span>
                                                                <?php endif; ?>
                                                                <!--                                          showing product current price based on discount-->

                                                                <!--                                          showing product old price -->
                                                                <?php if ($oldProInventoryPrice > 0): ?>
                                                                    <span class="old-price"> <?php echo $config['CURRENCY_SIGN']; ?> <?php echo $oldProInventoryPrice; ?></span>
                                                                <?php endif; ?>
                                                                <!--                                          showing product old price -->                                                        

                                                            </div>

                                                            <!-- Product price div -->    


                                                            <!-- Add to cart button code -->

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

                                                                    if ($currentProId == $TempCartProductID AND $currentProDefaultInventoryId == $TempCartInventoryID):
                                                                        $productExistenceIndicator = TRUE;
                                                                        $tempCartQuantity = $TempCartProductQuantity;
                                                                    endif;
                                                                endfor;
                                                            endif;
                                                            ?>


                                                            <?php
                                                            if ($productExistenceIndicator):
                                                                ?>
                                                                <div class="cartControll"> 
                                                                    <a class="btncart active" id="addToCart_<?php echo $currentProId; ?>" onClick="AddToCart(<?php echo $currentProId; ?>,<?php echo $currentProDefaultInventoryId; ?>)" > 
                                                                        <span class="counter" id="cartCounter_<?php echo $currentProId; ?>"> 
                                                                            <span><b><?php echo $tempCartQuantity; ?></b></span> 
                                                                        </span> 
                                                                        <span class="add2cart" id="AddToCartText_<?php echo $ProductID; ?>">
                                                                            Add One More 
                                                                        </span> 
                                                                    </a> 
                                                                </div>
                                                                <?php
                                                            else:
                                                                ?>
                                                                <div class="cartControll"> 
                                                                    <a class="btncart" id="addToCart_<?php echo $currentProId; ?>" onClick="AddToCart(<?php echo $currentProId; ?>,<?php echo $currentProDefaultInventoryId; ?>)" > 
                                                                        <span class="counter" id="cartCounter_<?php echo $currentProId; ?>"> 
                                                                            <b><span>0</span></b> 
                                                                        </span> 
                                                                        <span class="add2cart" id="AddToCartText_<?php echo $currentProId; ?>">
                                                                            Add to cart 
                                                                        </span> 
                                                                    </a> 
                                                                </div>
                                                            <?php
                                                            endif;
                                                            ?>


                                                            <!-- Add to cart button code -->

                                                        </div>
                                                    </div>

                                                <?php endfor; /* ($j=0;$j < $limit;$j++) */ ?>





                                            </div>



                                        </div> <!-- slider end-->






                                        <!--                        //    show current category's product-->

                                    <?php endif; /* (isset($SubCategoryProductArray[$currentCatId])) */ ?>

                                <?php endfor; /* ($i=0;$i < $SubCategoryProductArrayCounter; $i++) */ ?>



                            <?php endif; /* ($SubCategoryProductArrayCounter > 0) */ ?>

                        </div>

                    </div>
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

    <?php include basePath('footer_script.php'); ?>


    <script type='text/javascript' src="<?php echo baseUrl(); ?>js/jquery.jsort.0.4.js"></script>
    <style type="text/css">
        .match { color: red;}
        .hiddenData{
            display: none;
        }
    </style>
    <script type="text/javascript">
                                                    $("select").minimalect({
                                                        onchange:
                                                                function(value, text) {
                                                                    //  var select = $(".minict_wrapper.active", content).prev("select");
                                                                    // select.val(value).trigger("change");
                                                                    // alert(value);
                                                                    var sort_by = 'span.sortProName';
                                                                    var order = 'asc';
                                                                    var is_num = false;
                                                                    switch (value)
                                                                    {
                                                                        case 'nameAsc':
                                                                            sort_by = 'span.sortProName';
                                                                            order = 'asc';
                                                                            is_num = false;
                                                                            break;
                                                                        case 'nameDesc':
                                                                            sort_by = 'span.sortProName';
                                                                            order = 'desc';
                                                                            is_num = false;
                                                                            break;
                                                                        case 'priceLow':
                                                                            sort_by = 'span.sortProPrice';
                                                                            order = 'asc';
                                                                            is_num = true;
                                                                            break;
                                                                        case 'priceHiegh':
                                                                            sort_by = 'span.sortProPrice';
                                                                            order = 'desc';
                                                                            is_num = true;
                                                                            break;
                                                                        default:
                                                                            sort_by = 'span.sortProName';
                                                                            order = 'asc';
                                                                    }



                                                                    $("#prductMainCOntainer").jSort({
                                                                        sort_by: sort_by,
                                                                        item: 'div.product',
                                                                        order: order,
                                                                        is_num: is_num
                                                                    });


                                                                    /*$('html, body').animate({
                                                                     scrollTop: $(".breadcrumbDiv").offset().top
                                                                     }, 2000);*/
                                                                    $("html, body").animate({scrollTop: 1}, "slow");
                                                                }
                                                    });
    </script>
    <script type="text/javascript">


        function ajaxCategoryPagination(url, id)
        {
            $.get(url, function(msg) {
                if (msg != 'error')
                {
                    $(id).html(msg);
                }
            });
        }

    </script>
</body>
</html>