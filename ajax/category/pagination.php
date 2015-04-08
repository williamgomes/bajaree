<?php
include('../../config/config.php');
require_once('../../lib/pagination.class.php');
$categoryId = 0;

if (isset($_REQUEST['category']) AND $_REQUEST['category'] > 0) {
    $categoryId = intval($_REQUEST['category']);
}
$productArray = array();
$total_product = 0;


/* current category products */
//$categoryId

$where = " WHERE product_categories.PC_category_id IN ($categoryId) AND products.product_status ='active'";
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

//printDie($productArray);
?>



<?php $productArrayCounter = count($productArray); ?>
<?php if ($productArrayCounter > 0): ?>
    <?php for ($i = 0; $i < $productArrayCounter; $i++): ?>

        <?php
        $currentProTitle = $productArray[$i]->product_title;
        $currentProTitleClean = clean($productArray[$i]->product_title);
        $currentProId = $productArray[$i]->product_id;
        $currentProNewFrom = $productArray[$i]->product_show_as_new_from;
        $currentProNewTo = $productArray[$i]->product_show_as_new_to;
        $currentProFeaturedFrom = $productArray[$i]->product_show_as_featured_from;
        $currentProFeaturedTo = $productArray[$i]->product_show_as_featured_to;
        $currentProImage = $productArray[$i]->PI_file_name;


        $currentProInventoryTitle = $productArray[$i]->PI_inventory_title;
        $currentProInventoryPrice = $productArray[$i]->PI_current_price;
        $currentProInventoryId = $productArray[$i]->PI_size_id;
        $currentProInventoryQty = $productArray[$i]->PI_quantity;


        $currentProInventoryDiscountAmount = $productArray[$i]->PD_amount;
        $currentProInventoryDiscountStart = $productArray[$i]->PD_start_date;
        $currentProInventoryDiscountEnd = $productArray[$i]->PD_end_date;
        $discountAmount = 0;
        if (($currentProInventoryDiscountStart <= date("Y-m-d")) AND ($currentProInventoryDiscountEnd >= date("Y-m-d"))) {
            $discountAmount = $currentProInventoryDiscountAmount;
        }
        ?>

        <div class="col-sm-4 col-lg-3 col-md-3 col-xs-6 product">
            <div class="productBox"> 

                <?php if ($currentProImage != '' AND file_exists(basePath('upload/product/small/' . $currentProImage))): ?>
                    <a class="proImg" title="<?php echo $currentProTitle; ?>" href="<?php echo baseUrl('product/' . $currentProId . '/' . $currentProTitleClean); ?>">  
                        <img src="<?php echo baseUrl('upload/product/small/' . $currentProImage); ?>" alt="<?php echo $currentProTitle; ?>" />

                    </a>
                <?php else: /* ($currentProImage !='' OR file_exists(basePath('upload/product/small/'.$currentProImage))): */ ?>
                    <a class="proImg" title="<?php echo $currentProTitle; ?>" href="<?php echo baseUrl('product/' . $currentProId . '/' . $currentProTitleClean); ?>">  <img src="<?php echo baseUrl('upload/product/small/default.jpg'); ?>" alt="<?php echo $currentProTitle; ?>" /></a>
                <?php endif; /* ($currentProImage !='' OR file_exists(basePath('upload/product/small/'.$currentProImage))): */ ?>




                <div class="description">
                    <h4><a title="<?php echo $currentProTitle; ?>" href="<?php echo baseUrl('product/' . $currentProId . '/' . $currentProTitleClean); ?>"><?php echo $currentProTitle; ?></a></h4>
                    <span class="size"><?php echo $currentProInventoryTitle; ?></span> </div>
                <div class="price"> <span><?php echo $currentProInventoryPrice; ?></span></div>
                <div class="cartControll"> <a class="btncart" > <span class="counter"> <span>0</span> <span>1</span> <span>2</span> <span>3</span> <span>4</span> <span>5</span> <span>6</span> <span>7</span> <span>8</span> <span>9</span> <span>10</span> <span>11</span> <span>12</span> </span> <span class="add2cart">Add to cart </span> </a> </div>
            </div>
        </div>

    <?php endfor; /* ($i=0;$i < $productArrayCounter ;$i++) */ ?>

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


