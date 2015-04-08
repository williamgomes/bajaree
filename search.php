<?php
include 'config/config.php';
include 'lib/category2.php';
$cat2DD = new Category2($con); /* $cat2DD == category2 library dropdown */

$CartID = '';
$countResult = 0;
$Key = '';

$page_title = get_option('SITE_DEFAULT_META_TITLE');
$page_description = get_option('SITE_DEFAULT_META_DESCRIPTION');
$page_keywords = get_option('SITE_DEFAULT_META_KEYWORDS');
$site_author = $config['CONFIG_SETTINGS']['SITE_AUTHOR'];
$arraySearch = array();
$subCategoryArray = array();
$subCategoryArrayCounter = 0;

$siblingCategorySelected = 0;
$siblingCategoryArray = array();
$siblingCategoryArrayCounter = 0;

if (isset($_GET['key'])) {
    $childStrin = '';
    /* sort by category */
    if (isset($_GET['sortBy'])) {
        $childs = array();
        $sortBy = intval($_GET['sortBy']);
        $childs[] = $sortBy;
        $cat2DD->selected = $sortBy;
        $childsArray = $cat2DD->getChilds($sortBy);
        if (count($childs)) {
            foreach ($childsArray AS $child) {
                $childs[] = $child['category_id'];
            }
        }

        // printDie($childsArray);
        asort($childs);
        $childStrin = implode(',', $childs);
    }
    /* //sort by category */

    if (isset($sortBy)) {
        $siblingCategorySelected = $sortBy;
        /* sibling categories  query */
        $siblingCategorySql = "SELECT category_id,category_name,category_parent_id, category_logo FROM categories WHERE category_parent_id=(SELECT category_parent_id FROM categories WHERE category_id=" . intval($sortBy) . ") ORDER BY category_name ASC";
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



        /* sub categories  query */
        $subCategorySql = "SELECT category_id,category_name,category_parent_id, category_logo FROM categories WHERE category_parent_id=" . intval($sortBy) . " ORDER BY category_name ASC";
        $subCategorySqlResult = mysqli_query($con, $subCategorySql);

        if ($subCategorySqlResult) {
            $subCategoryArrayCounter = mysqli_num_rows($subCategorySqlResult);
            while ($subCategorySqlResultRowObj = mysqli_fetch_object($subCategorySqlResult)) {
                $subCategoryArray[] = $subCategorySqlResultRowObj;
            }
            mysqli_free_result($subCategorySqlResult);
        } else {
            if (DEBUG) {
                die('subCategorySqlResult error : ' . mysqli_error($con));
            } else {
                die('subCategorySqlResult query fail');
            }
        }


        /* //sub categories  query */
    }
    $Key = trim($_GET['key']);

    $KeyArray = explode(' ', $Key);


    $sqlSearch = "";
    $sqlSearch .= "SELECT 
                DISTINCT products.product_id, products.product_title, products.product_default_inventory_id,  products.product_show_as_new_from, products.product_show_as_new_to, products.product_show_as_featured_from, products.product_show_as_featured_to,
                product_inventories.PI_id,product_inventories.PI_inventory_title,product_inventories.PI_size_id,product_inventories.PI_cost,product_inventories.PI_current_price,product_inventories.PI_old_price,product_inventories.PI_quantity,
                product_discounts.PD_start_date,product_discounts.PD_end_date,product_discounts.PD_amount,product_discounts.PD_status,
                (SELECT product_images.PI_file_name FROM product_images WHERE product_images.PI_inventory_id = products.product_default_inventory_id AND product_images.PI_product_id = products.product_id ORDER BY product_images.PI_priority DESC LIMIT 1) as PI_file_name
                
                FROM products

                LEFT JOIN product_inventories ON product_inventories.PI_id = products.product_default_inventory_id
                LEFT JOIN product_discounts ON product_discounts.PD_inventory_id = product_inventories.PI_id
                LEFT JOIN product_categories ON product_categories.PC_product_id = products.product_id 
                ";

    if ($childStrin == '') {
        $sqlSearch .= " WHERE products.product_status ='active' AND product_default_inventory_id >0 AND (";
    } else {
        $sqlSearch .= " WHERE  product_categories.PC_category_id IN ($childStrin) AND products.product_status ='active' AND  product_default_inventory_id >0 AND (";
    }
    $sqlSearch .= " products.product_title LIKE '%" . mysqli_real_escape_string($con, $Key) . "%' ";
    for ($i = 0; $i < count($KeyArray); $i++) {
        $k = $KeyArray[$i];

        $sqlSearch .= " OR products.product_title LIKE '%" . mysqli_real_escape_string($con, $k) . "%' ";
        $sqlSearch .= " OR products.product_tags LIKE '%" . mysqli_real_escape_string($con, $k) . "%'";
        $sqlSearch .= " OR product_inventories.PI_inventory_title LIKE '%" . mysqli_real_escape_string($con, $k) . "%'";
    }


    $sqlSearch .= ") ORDER BY ";
    $sqlSearch .= "	CASE";
    $sqlSearch .= " WHEN products.product_title LIKE '%" . mysqli_real_escape_string($con, $Key) . "%' THEN 1";
    $setp = 1;
    for ($i = 0; $i < count($KeyArray); $i++) {
        $k = $KeyArray[$i];

        $sqlSearch .= " WHEN products.product_title LIKE '%" . mysqli_real_escape_string($con, $k) . "%' THEN " . (($i * $setp) + 2);
        $sqlSearch .= " WHEN products.product_tags LIKE '%" . mysqli_real_escape_string($con, $k) . "%' THEN " . (($i * $setp) + 3);
        $sqlSearch .= " WHEN product_inventories.PI_inventory_title LIKE '%" . mysqli_real_escape_string($con, $k) . "%' THEN " . (($i * $setp) + 4);

        $setp++;
    }


    $sqlSearch .= " ELSE " . (($i * $setp) + 5);
    $sqlSearch .= " END";
    $sqlSearch .= " LIMIT 48";

    $executeSearch = mysqli_query($con, $sqlSearch);
    if ($executeSearch) {
        $countResult = mysqli_num_rows($executeSearch);
        while ($executeSearchObj = mysqli_fetch_object($executeSearch)) {
            $arraySearch[] = $executeSearchObj;
        }
    } else {
        if (DEBUG) {
            echo "executeSearch error: " . mysqli_error($con);
        } else {
            echo "executeSearch query failed.";
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
//
//echo "<pre>";
//print_r($arraySearch);
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
        <link href="<?php echo baseUrl(); ?>css/jquery.minimalect.min.css" rel="stylesheet">


        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <style type="text/css">
            /*            load later*/

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
                        <?php
                        if ($siblingCategoryArrayCounter < 1) {
                            $siblingCategoryArray = $mainProductCategoryArray;
                            $siblingCategoryArrayCounter = count($siblingCategoryArray);
                        }
                        // printDie($siblingCategoryArray);
                        ?>
                    </div>
                </div>

            </div>
            <!-- header end -->

            <div style="clear:both"></div>
            <div class="w100 mainContainer innerPadd">

                <div class="container">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 col-sm-3">
                            <h3 class="categoryName">Categories</h3>
                            <ul class="unstyled catList">
                                <?php if ($siblingCategorySelected == 0): ?>
                                    <li class="active_category"> <a href="<?php echo baseUrl(); ?>search.php?key=<?php echo $Key; ?>" title="<?php echo $Key; ?> ">All</a> </li>
                                <?php else: /* ($siblingCategorySelected == 0) */ ?>
                                    <li> <a href="<?php echo baseUrl(); ?>search.php?key=<?php echo $Key; ?>" title="<?php echo $Key; ?> ">All</a> </li>
                                <?php endif;  /* ($siblingCategorySelected == 0) */ ?>

                                <?php if ($siblingCategoryArrayCounter > 0): ?>
                                    <?php for ($i = 0; $i < $siblingCategoryArrayCounter; $i++): ?>
                                        <?php if ($siblingCategorySelected == $siblingCategoryArray[$i]->category_id): ?>
                                            <li  class="active_category"> <a href="<?php echo baseUrl(); ?>search.php?key=<?php echo $Key; ?>&sortBy=<?php echo $siblingCategoryArray[$i]->category_id; ?>&category=<?php echo $siblingCategoryArray[$i]->category_name; ?>" title="<?php echo $siblingCategoryArray[$i]->category_name; ?> "><?php echo $siblingCategoryArray[$i]->category_name; ?> </a> </li>
                                        <?php else: /* ($sortBy==$siblingCategoryArray[$i]->category_id) */ ?>
                                            <li> <a href="<?php echo baseUrl(); ?>search.php?key=<?php echo $Key; ?>&sortBy=<?php echo $siblingCategoryArray[$i]->category_id; ?>&category=<?php echo $siblingCategoryArray[$i]->category_name; ?>" title="<?php echo $siblingCategoryArray[$i]->category_name; ?> "><?php echo $siblingCategoryArray[$i]->category_name; ?> </a> </li>
                                        <?php endif; /* ($sortBy==$siblingCategoryArray[$i]->category_id) */ ?>

                                    <?php endfor; /* ($i=0; $i< $siblingCategoryArrayCounter; $i++) */ ?>
                                <?php endif; /* ($siblingCategoryArrayCounter > 0) */ ?>


                            </ul>
                            <?php if ($subCategoryArrayCounter > 0): ?>
                                <h3 class="categoryName">Subcategories</h3>
                                <ul class="unstyled catList">
                                    <?php for ($i = 0; $i < $subCategoryArrayCounter; $i++): ?>
                                        <li> <a href="<?php echo baseUrl(); ?>search.php?key=<?php echo $Key; ?>&sortBy=<?php echo $subCategoryArray[$i]->category_id; ?>&category=<?php echo $subCategoryArray[$i]->category_name; ?>" title="<?php echo $subCategoryArray[$i]->category_name; ?> "><?php echo $subCategoryArray[$i]->category_name; ?> </a> </li>
                                    <?php endfor; /* ($i=0; $i< $subCategoryArrayCounter; $i++) */ ?>
                                </ul>
                            <?php endif; /* ($subCategoryArrayCounter > 0) */ ?>

                        </div>
                        <!--                        end Categories -->
                        <div class="col-lg-10 col-md-9 col-sm-9 categoryContainer">
                            <div class="productFilter">
                                <div class="row">
                                    <div class="col-sm-6 col-lg-7 col-md-7 col-xs-12">
                                        <h3><span class="searchFor">Results for</span> <?php echo $Key; ?></h3></div>
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
                            <!--end productFilter-->
                            <div id="prductMainCOntainer" class="productFeatured categoryProduct xsResponse">

                                <?php
                                $countSearchArray = count($arraySearch);
                                if ($countSearchArray > 0):
                                    for ($i = 0; $i < $countSearchArray; $i++):

                                        //declearing variables
                                        $productImage = $arraySearch[$i]->PI_file_name;
                                        $productTitle = $arraySearch[$i]->product_title;
                                        $productID = $arraySearch[$i]->product_id;
                                        $productInventoryTitle = $arraySearch[$i]->PI_inventory_title;
                                        $productCurrentPrice = $arraySearch[$i]->PI_current_price;
                                        $productOldPrice = $arraySearch[$i]->PI_old_price;
                                        $productDiscount = $arraySearch[$i]->PD_amount;
                                        $productInventoryID = $arraySearch[$i]->PI_id;
                                        ?>
                                        <div class="col-lg-3 col-md-3 col-xs-6 col-sm-4 product">
                                            <div class="hiddenData">
                                                <span class="sortProName"><?php echo trim($productTitle); ?></span>
                                                <span class="sortProPrice"><?php echo $productCurrentPrice; ?></span>


                                            </div>
                                            <div class="productBox <?php
                                            if ($i >= 8) {
                                                echo 'hideProduct';
                                            }
                                            ?>"> 
                                                <a target="_blank" href="<?php echo baseUrl(); ?>product/<?php echo $productID; ?>/<?php echo extra_clean(clean($productTitle)); ?>">
                                                    <?php
                                                    $img = 'default.jpg';
                                                    if ($productImage != '') {
                                                        $img = $productImage;
                                                    }
                                                    ?>
                                                    <?php if ($i >= 8): ?>
                                                        <img class="img-responsive lazy2  <?php echo $i; ?>" data-original="<?php echo baseUrl(); ?>upload/product/small/<?php echo $img; ?>" src="<?php echo baseUrl('upload/product/small/default.jpg'); ?>" alt="<?php echo extra_clean(clean($productTitle)); ?>">
                                                    <?php else: /* ($i > 8 ) */ ?>
                                                        <img class="img-responsive" src="<?php echo baseUrl(); ?>upload/product/small/<?php echo $img; ?>" alt="<?php echo extra_clean(clean($productTitle)); ?>">
                                                    <?php endif; /* ($i > 8 ) */ ?>


                                                </a>
                                                <div class="description">
                                                    <h4><a target="_blank" href="<?php echo baseUrl(); ?>product/<?php echo $productID; ?>/<?php echo extra_clean(clean($productTitle)); ?>"><?php echo $productTitle; ?></a></h4>
                                                    <span class="size"><?php echo $productInventoryTitle; ?></span> </div>

                                                <div class="price">

                                                    <!--                    showing product current price based on discount-->
                                                    <?php if ($productDiscount > 0): ?>
                                                        <span class="current-price"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format(($productCurrentPrice - $productDiscount), 2); ?></span>
                                                    <?php else: ?>
                                                        <span><?php echo $config['CURRENCY_SIGN']; ?> <?php echo $productCurrentPrice; ?></span>
                                                    <?php endif; ?>
                                                    <!--                   showing product current price based on discount-->

                                                    <!--                   showing product old price -->
                                                    <?php if ($productDiscount > 0): ?>
                                                        <span class="old-price"> <?php echo $config['CURRENCY_SIGN']; ?> <?php echo $productCurrentPrice; ?></span>
                                                        <?php
                                                    else:
                                                        if ($productOldPrice > 0):
                                                            ?>
                                                            <span class="old-price"> <?php echo $config['CURRENCY_SIGN']; ?> <?php echo $productOldPrice; ?></span>
                                                            <?php
                                                        endif;
                                                    endif;
                                                    ?>
                                                    <!--                   showing product old price -->                                          

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

                                                        if ($productID == $TempCartProductID AND $productInventoryID == $TempCartInventoryID):
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
                                                        <a class="btncart active" id="addToCart_<?php echo $productID; ?>" onClick="AddToCart(<?php echo $productID; ?>,<?php echo $productInventoryID; ?>)" > 
                                                            <span class="counter" id="cartCounter_<?php echo $productID; ?>"> 
                                                                <span><b><?php echo $tempCartQuantity; ?></b></span> 
                                                            </span> 
                                                            <span class="add2cart" id="AddToCartText_<?php echo $productID; ?>">
                                                                Add One More 
                                                            </span> 
                                                        </a> 
                                                    </div>
                                                    <?php
                                                } else {
                                                    ?>

                                                    <div class="cartControll"> 
                                                        <a class="btncart" id="addToCart_<?php echo $productID; ?>" onClick="AddToCart(<?php echo $productID; ?>,<?php echo $productInventoryID; ?>)" > 
                                                            <span class="counter" id="cartCounter_<?php echo $productID; ?>"> 
                                                                <b><span>0</span></b> 
                                                            </span> 
                                                            <span class="add2cart" id="AddToCartText_<?php echo $productID; ?>">
                                                                Add to cart 
                                                            </span> 
                                                        </a> 
                                                    </div>

                                                <?php } ?> 



                                            </div>
                                        </div>
                                        <?php
                                    endfor;
                                endif;
                                ?>

                                <!--product content--> 
                            </div>

                        </div>
                        <!--end categoryContainer-->
                    </div>



                </div>
            </div>

            <!--brandFeatured--> 

        </div>
        <!-- Main hero unit -->
<?php include basePath('footer_delivery.php'); ?>
        <?php include basePath('footer.php'); ?>

    </div>
    <?php include basePath('mini_login.php'); ?>
    <?php include basePath('mini_signup.php'); ?>
    <?php include basePath('mini_cart.php'); ?>

    <?php include basePath('footer_script.php'); ?>

    <script type='text/javascript' src="<?php echo baseUrl(); ?>js/jquery.minimalect.min.js"></script>
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
                                                                            
                                                                              $("html, body").animate({scrollTop: 1}, "slow");

                                                                        }
                                                            });
    </script>
    <script type="text/javascript">



        $(document).ready(function() {
            $("#sortByCat").on('change', function() {
                var sortByCatId = $(this).val();
                var key = getParameterByName('key');
                window.location.href = 'search.php?key=' + key + '&sortBy=' + sortByCatId;
            });
        });

        $(document).ready(function() {
            var key = getParameterByName('key');
            key = key.trim(key);
            var keyArray = key.split(' ');

            /*  word match heighlight diesabled here 
             
             $(".container .description h4 a").html(function(_, html) {
             var re = new RegExp('(' + keyArray.join('|') + ')', "gi");
             return html.replace(re, function($0, $1) {
             return "<span class='match'>" + $1 + "</span>";
             });
             });
             
             **/





        });
    </script>
</body>
</html>