  
<?php
$minimum_shopping_amount = get_option('MINIMUM_SHOPPING_AMOUNT');
$minimum_shopping_charge = get_option('MINIMUM_SHOPPING_AMOUNT_CHARGE');
$totalShopping = 0;
$percentage = 0;
$session_id = session_id();
$sqlTempCart = "SELECT  SUM(TC_product_total_price) AS totalShopping FROM temp_carts WHERE temp_carts.TC_session_id='$session_id'";
$executeTempCart = mysqli_query($con, $sqlTempCart);
if ($executeTempCart) {
    $executeTempCartObj = mysqli_fetch_object($executeTempCart);
    $totalShopping = $executeTempCartObj->totalShopping;
} else {
    if (DEBUG) {
        echo "executeTempCart error: " . mysqli_error($con);
    } else {
        echo "executeTempCart query fail";
    }
}
if (isset($totalShopping) AND $totalShopping > 0) {
    $percentage = (100 * $totalShopping) / $minimum_shopping_amount;
    if ($percentage > 100) {
        $percentage = 100;
    }
} else {
    $percentage = 0;
}
?>
<div class="bottom-nav ">
    <div id="footerDeliveryHiddenData" style="display: none;">
        <input type="hidden=" class="minimum_shopping_amount" value="<?php echo $minimum_shopping_amount; ?>" />
        <input type="hidden=" class="minimum_shopping_charge" value="<?php echo $minimum_shopping_charge; ?>" />
    </div>
    <div class="fclose btn"><i class="fa fa-angle-down"></i></div>
    <div class="container footerSticky">
        <div class="row">
            <div class="col-xs-9 fleft  relative">

                <div style="width: <?php echo $percentage; ?>%" data-parchent="<?php echo $percentage; ?>" class="abs-car"> 
                    <span class="carBefore">
                        <?php if ($percentage >= 100): ?>
                            <img  class="show" src="<?php echo baseUrl(); ?>images/dok.png">
                        <?php else: /* ($percentage >=100) */ ?>
                            <img  class="hide" src="<?php echo baseUrl(); ?>images/dok.png"> ৳ <?php echo $totalShopping; ?>
                        <?php endif; /* ($percentage >=100) */ ?>

                    </span>

                    <span class="car"><img src="<?php echo baseUrl(); ?>images/car.png"></span></div>

            </div>

            <div class="col-xs-3 fright ">

                <?php if ($totalShopping == 0): ?>
                    <span class="deliveryText">Free Delivery On Order <?php echo $config['CURRENCY_SIGN']; ?> <?php echo ($minimum_shopping_amount - $totalShopping); ?>+ </span>
                <?php elseif ($totalShopping < $minimum_shopping_amount): ?>

                    <span class="deliveryText"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo ($minimum_shopping_amount - $totalShopping); ?>  More To Free Delivery</span>

                <?php else: /* ($totalShopping <= $minimum_shopping_amount) */ ?>
                    <span class="deliveryText"> You unlocked free delivery!</span>

                <?php endif; /* ($totalShopping <= $minimum_shopping_amount) */ ?>
            </div>

        </div>
    </div>
</div>