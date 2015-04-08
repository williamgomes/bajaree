<?php
include ('../../config/config.php');

$subTotal = 0; 
$Vat = 0; 
$discount = 0; 
$promoDiscount = 0; 
$shipment = 0;
$grandTotal = 0;


if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}

if (!isset($_GET['order_status'])) {
    $BookingOrderSql = mysqli_query($con, "SELECT * FROM orders ORDER BY order_read DESC ,order_created DESC");
} else {
    $status = $_GET['order_status'];
    $BookingOrderSql = mysqli_query($con, "SELECT * FROM orders WHERE order_status='$status' ORDER BY order_read ASC ,order_created DESC");
}
$count = mysqli_num_rows($BookingOrderSql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
        <title>Admin Panel | Product Module</title>

        <link href="<?php echo baseUrl('admin/css/main.css'); ?>" rel="stylesheet" type="text/css" />
        <link href='http://fonts.googleapis.com/css?family=Cuprum' rel='stylesheet' type='text/css' />
        <script src="<?php echo baseUrl('admin/js/jquery-1.4.4.js'); ?>" type="text/javascript"></script>
        <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, File upload, editor -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/spinner/ui.spinner.js'); ?>"></script>
        <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/jquery-ui.min.js'); ?>"></script>  
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/fileManager/elfinder.min.js'); ?>"></script>
        <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, File upload -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/wysiwyg/jquery.wysiwyg.js'); ?>"></script>
        <!--Effect on wysiwyg editor -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/wysiwyg/wysiwyg.image.js'); ?>"></script>
        <!--Effect on wysiwyg editor -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/wysiwyg/wysiwyg.link.js'); ?>"></script>
        <!--Effect on wysiwyg editor -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/wysiwyg/wysiwyg.table.js'); ?>"></script>
        <!--Effect on wysiwyg editor -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/dataTables/jquery.dataTables.js'); ?>"></script>
        <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/dataTables/colResizable.min.js'); ?>"></script>
        <!--Effect on left error menu, top message menu -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/forms/forms.js'); ?>"></script>
        <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/forms/autogrowtextarea.js'); ?>"></script>
        <!--Effect on left error menu, top message menu, File upload -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/forms/autotab.js'); ?>"></script>
        <!--Effect on left error menu, top message menu -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/forms/jquery.validationEngine.js'); ?>"></script>
        <!--Effect on left error menu, top message menu-->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/colorPicker/colorpicker.js'); ?>"></script>
        <!--Effect on left error menu, top message menu -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/uploader/plupload.js'); ?>"></script>
        <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, File upload -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/uploader/plupload.html5.js'); ?>"></script>
        <!--Effect on file upload-->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/uploader/plupload.html4.js'); ?>"></script>
        <!--No effect-->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/uploader/jquery.plupload.queue.js'); ?>"></script>
        <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, File upload -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/ui/jquery.tipsy.js'); ?>"></script>
        <!--Effect on left error menu, top message menu,  -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/jBreadCrumb.1.1.js'); ?>"></script>
        <!--Effect on left error menu, File upload -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/cal.min.js'); ?>"></script>
        <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/jquery.collapsible.min.js'); ?>"></script>
        <!--Effect on left error menu, File upload -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/jquery.ToTop.js'); ?>"></script>
        <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/jquery.listnav.js'); ?>"></script>
        <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/jquery.sourcerer.js'); ?>"></script>
        <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/custom.js'); ?>"></script>
        <script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
        <script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>

        <!--Effect on left error menu, top message menu, body-->
        <!--delete tags-->
        <script type="text/javascript">
            /*function del(pin_id1)
             {
             if(confirm('Are you sure to delete this tag!!'))
             {
             window.location='index.php?del='+pin_id1;
             }
             }*/
        </script>
        <!--end delete tags-->


        <link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
        <link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
    </head>

    <body>


        <?php include basePath('admin/top_navigation.php'); ?>

        <?php include basePath('admin/module_link.php'); ?>


        <!-- Content wrapper -->
        <div class="wrapper">

            <!-- Left navigation -->
            <?php include ('order_left_navigation.php'); ?>

            <!-- Content Start -->
            <div class="content">
                <div class="title"><h5><?php  if(isset($_GET['order_status'])){ echo '<b>'.  ucfirst($_GET['order_status']).'</b>';}else{ echo '<b>All</b>';} ?> Order Lists</h5></div>

                
                        <!-- Statistics -->
        <div class="stats">
        	<ul>
            	<li><a href="#" class="count grey" title=""><?php echo $count; ?></a><span>Total</span></li>
                
            </ul>
            <div class="fix"></div>
        </div>
                        
                        
                <!-- Notification messages -->
                <?php include basePath('admin/message.php'); ?>

                <!-- Charts -->



                <div class="table">
                    <div class="head">
                        <h5 class="iFrames">Order List</h5></div>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                        <thead>
                            <tr>
                                <th>NO.</th>
                                <th>Order Ref Id.</th>
                                <th>User Name</th>
                                <th>Order Status</th>
<!--                                <th>Order Placed</th>-->
                                <th>Total Payable</th>
                                <th>Updated By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $i=1;
                            while ($GetBookingOrder = mysqli_fetch_array($BookingOrderSql)) {
                                ?>                        

                                <tr class="gradeA">
                                    <td><?php echo $i; ?></td>
                                    <?php $express = "";
                                    if($GetBookingOrder['order_is_express'] == "yes"){ $express = "[XPRESS]"; }
                                    if($GetBookingOrder['order_read'] == "no"): ?>
                                    <td><?php echo '<strong>[' . date("dmy", strtotime($GetBookingOrder['order_created'])) . '-' . $GetBookingOrder['order_id'] . '] [NEW] ' . $express . '<strong>'; ?></td>
                                    <?php else: ?>
                                    <td><?php echo '[' . date("dmy", strtotime($GetBookingOrder['order_created'])) . '-' . $GetBookingOrder['order_id'] . ']'; ?></td>
                                    <?php endif; ?>
                                    <td><?php // echo $GetBookingOrder['order_billing_first_name']; ?> <?php
                                        $userid = $GetBookingOrder['order_user_id'];
                                        $usersql = mysqli_query($con, "SELECT * FROM users WHERE user_id='$userid'");
                                        $userrow = mysqli_fetch_object($usersql);
                                        echo $userrow->user_first_name . ' ' . $userrow->user_last_name;
                                       
                                        ?></td>
                                    <td><?php if($GetBookingOrder['order_status']=='booking' AND  $GetBookingOrder['order_read']=='no'){ echo 'New '.$GetBookingOrder['order_status']; }else{ echo $GetBookingOrder['order_status'];} ?></td>
<!--                                    <td><?php // echo date('Y/m/d', strtotime($GetBookingOrder['order_created'])); ?></td>-->
                                    <?php 
                                    $subTotal = $GetBookingOrder['order_total_amount']; 
                                    $Vat = $GetBookingOrder['order_vat_amount']; 
                                    $discount = $GetBookingOrder['order_discount_amount']; 
                                    $promoDiscount = $GetBookingOrder['order_promotion_discount_amount']; 
                                    $shipment = $GetBookingOrder['order_shipment_charge'];
                                    $grandTotal = $subTotal + $Vat + $shipment - $discount - $promoDiscount;
                                    ?>
                                    <td><?php echo number_format($grandTotal,2); ?></td>
                                    <!--<td><?php
                                    $adminid = $GetBookingOrder['order_updated_by'];
                                    $adminsql = mysqli_query($con, "SELECT (admin_full_name) FROM admins WHERE admin_id='$adminid'");
                                    $adminrow = mysqli_fetch_array($adminsql);
                                    echo $adminrow[0];
                                    ?></td>-->
                                    
                                    <td class="center"><?php echo getFieldValue("admins", "admin_full_name", "admin_id=" . $GetBookingOrder['order_updated_by']); ?></td>
                                    <td class="center"><a title="Details" href="order_details.php?oid=<?php echo base64_encode($GetBookingOrder['order_id']); ?>" title="Edit">More Info</a>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>












        </div>
        </div>

        </div>
        <!-- Content End -->

        <div class="fix"></div>
        </div>

        <?php include basePath('admin/footer.php'); ?>
        <script type="text/javascript">
            var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
            var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "custom", {pattern: "XXXX000000"});
            var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
            var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "currency");
        </script>
