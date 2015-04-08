<?php
//checking for new order
$countOrder = 0;
$sqlCheckOrder = "SELECT * FROM orders WHERE order_read='no'";
$executeCheckOrder = mysqli_query($con,$sqlCheckOrder);
if($executeCheckOrder){
  $countOrder = mysqli_num_rows($executeCheckOrder);
}
?><!-- Header -->
<div id="header" class="wrapper">
    <div class="logo"><a href="<?php echo baseUrl('admin/dashboard.php'); ?>" title=""><img width="250" src="<?php echo baseUrl('admin/images/loginLogo.png'); ?>" alt="" /></a></div>
    <div class="middleNav">
        <ul>
            <?php if (checkAdminAccess('admin/order/index.php')): ?>
          <li class="iOrder"><a href="<?php echo baseUrl('admin/order/'); ?>" title=""><span>Order</span></a><?php if($countOrder > 0): ?><span class="numberMiddle"><?php echo $countOrder; ?></span><?php endif; ?></li>
            <?php endif; /* (checkAdminAccess('admin/admin/index.php')) */ ?>
            
            <?php if (checkAdminAccess('admin/admin/index.php')): ?>
                <li class="iAdmin"><a href="<?php echo baseUrl('admin/admin/'); ?>" title=""><span>Admin</span></a></li>
            <?php endif; /* (checkAdminAccess('admin/admin/index.php')) */ ?>

            <?php if (checkAdminAccess('admin/product/index.php')): ?>
                <li class="iProduct"><a href="<?php echo baseUrl('admin/product/'); ?>" title=""><span>Product</span></a></li>
            <?php endif; /* (checkAdminAccess('admin/product/index.php')) */ ?>

            <?php if (checkAdminAccess('admin/promotion/index.php')): ?>
                <li class="iPromo"><a href="<?php echo baseUrl('admin/promotion/'); ?>" title=""><span>Promotion</span></a></li>
            <?php endif; /* (checkAdminAccess('admin/product/index.php')) */ ?>  

            <?php if (checkAdminAccess('admin/country/index.php')): ?>
                <li class="iCountry"><a href="<?php echo baseUrl('admin/country/'); ?>" title=""><span>Country</span></a></li>
            <?php endif; /* (checkAdminAccess('admin/country/index.php')) */ ?>

            <?php if (checkAdminAccess('admin/customer_activity/index.php')): ?>
                <li class="iCustomer"><a href="<?php echo baseUrl('admin/customer/'); ?>" title=""><span>Customer</span></a></li>
            <?php endif; /* (checkAdminAccess('admin/customer_activity/index.php')) */ ?>

            <?php if (checkAdminAccess('admin/faq/index.php')): ?>
                <li class="iFaq"><a href="<?php echo baseUrl('admin/faq/'); ?>" title=""><span>FAQ</span></a></li>
            <?php endif; /* (checkAdminAccess('admin/pages/index.php')) */ ?>    

            <?php if (checkAdminAccess('admin/pages/index.php')): ?>
                <li class="iPage"><a href="<?php echo baseUrl('admin/pages/'); ?>" title=""><span>Pages</span></a></li>
            <?php endif; /* (checkAdminAccess('admin/pages/index.php')) */ ?>

            <?php if (checkAdminAccess('admin/admin/index.php')): ?>
            <?php endif; /* (checkAdminAccess('admin/admin/index.php')) */ ?>






        </ul>
    </div>
    <div class="fix"></div>
</div>