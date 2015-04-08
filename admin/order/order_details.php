<?php
include ('../../config/config.php');
include ('../../lib/email/mail_helper_functions.php');


if (!checkAdminLogin()) {

  $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));

  redirect($link);
}




$promotionCodeID = 0;
$product_avg_rating = '';

//saving tags in database

$aid = getSession('admin_id');
$admin_name = getSession('admin_name');
$admin_email = getSession('admin_email');

$order_id = base64_decode($_GET['oid']);

$note = '';





if (isset($_POST['update'])) {

  extract($_POST);

  $GetOrder = mysqli_query($con, "SELECT * FROM orders WHERE order_id='$order_id'");
  $SetOrderStatus = mysqli_fetch_object($GetOrder);

  $errid = '';

  $promotionCodeID = $SetOrderStatus->order_promotion_codes_id;
  $User_ID = $SetOrderStatus->order_user_id;
  $SqlUser = "SELECT * FROM users WHERE user_id='$User_ID'";
  $ExecuteUser = mysqli_query($con, $SqlUser);
  $GetUser = mysqli_fetch_object($ExecuteUser);
  $User_Email = $GetUser->user_email;
  $UserName = $GetUser->user_first_name;

  if ($SetOrderStatus->order_status != 'booking') {
    if ($status == 'booking') {
      $errid = 1;
    }
  }

  if ($status == 'approved' || $status == 'delivered' || $status == 'paid') {
    if ($orderid == '') {
      $errid = 2;
    }
  }

  if ($errid == 1) {

    $err = 'You cannot change order status back to BOOKING.';
  } elseif ($errid == 2) {

    $err = 'Order No. is required';
  } else {

    
    //updating coupon status depending on type
    if ($promotionCodeID != '') {
      $checkCoupon = "SELECT * FROM promotion_codes 
                        LEFT JOIN promotions ON promotion_id=PC_promotion_id
                        WHERE PC_id=$promotionCodeID";
      $executeCheckCoupon = mysqli_query($con, $checkCoupon);
      if ($executeCheckCoupon) {
        $executeCheckCouponObj = mysqli_fetch_object($executeCheckCoupon);
        if (isset($executeCheckCouponObj->PC_code_prefix)) {
          $promotionID = $executeCheckCouponObj->PC_id;
          $codeType = $executeCheckCouponObj->promotion_code_use_type;

          //updating status of promotion code
          if ($codeType == 'single') {
            $sqlUpdateStatus = "UPDATE promotion_codes SET PC_code_status='used' WHERE PC_id=$promotionCodeID";
            $executeUpdateStatus = mysqli_query($con, $sqlUpdateStatus);
            if (!$executeUpdateStatus) {
              if (DEBUG) {
                echo "executeUpdateStatus error: " . mysqli_error($con);
              } else {
                echo "executeUpdateStatus query failed.";
              }
            }
          }
        }
      } else {
        if (DEBUG) {
          echo "executeCheckCoupon error: " . mysqli_error($con);
        }
      }
    }


    $UpdateOrder = '';
    $UpdateOrder .= ' order_status ="' . mysqli_real_escape_string($con, $status) . '"';
    $UpdateOrder .= ', order_number ="' . mysqli_real_escape_string($con, $orderid) . '"';
    $UpdateOrder .= ', order_note ="' . mysqli_real_escape_string($con, $note) . '"';
    $UpdateOrder .= ', order_updated_by ="' . mysqli_real_escape_string($con, $aid) . '"';

    $SqlUpdateOrder = "UPDATE orders SET $UpdateOrder WHERE order_id='$order_id'";
    $ExecuteUpdateOrder = mysqli_query($con, $SqlUpdateOrder);

    if ($ExecuteUpdateOrder) {


      //entering updated status and time in order_status_log table
      $addOrderLog = '';
      $addOrderLog .= ' OSL_order_id ="' . intval($order_id) . '"';
      $addOrderLog .= ', OSL_order_status ="' . mysqli_real_escape_string($con, $status) . '"';
      $addOrderLog .= ', OSL_updated_by ="' . intval($aid) . '"';

      $sqlOrderLog = "INSERT INTO order_status_log SET $addOrderLog";
      $resultOrderLog = mysqli_query($con, $sqlOrderLog);
      if ($resultOrderLog) {


        if ($status == "booking") {
          $emails = explode(',', $config['CONFIG_SETTINGS']['SEND_EMAIL_BOOKING']);
          foreach ($emails as $email) {
            $Subject = "Order Status Confirmation from Bajaree.com!";
            $EmailBody = file_get_contents(baseUrl('emails/order/order.status.confirm.php?order_id=' . $order_id));
            $sendEmailToApplicant = sendEmailFunction($admin_email, $admin_name, 'no-reply@bajaree.com', $Subject, $EmailBody);
          }
        } elseif ($status == "approved") {
          $emails = explode(',', $config['CONFIG_SETTINGS']['SEND_EMAIL_APPROVED']);
          foreach ($emails as $email) {
            $Subject = "Order Status Confirmation from Bajaree.com";
            $EmailBody = file_get_contents(baseUrl('emails/order/order.status.confirm.php?order_id=' . $order_id));
            $sendEmailToApplicant = sendEmailFunction($admin_email, $admin_name, 'no-reply@bajaree.com', $Subject, $EmailBody);
          }
        } elseif ($status == "delivered") {
          $emails = explode(',', $config['CONFIG_SETTINGS']['SEND_EMAIL_DELIVERED']);
          foreach ($emails as $email) {
            $Subject = "Order Status Confirmation from Bajaree.com";
            $EmailBody = file_get_contents(baseUrl('emails/order/order.status.confirm.php?order_id=' . $order_id));
            $sendEmailToApplicant = sendEmailFunction($admin_email, $admin_name, 'no-reply@bajaree.com', $Subject, $EmailBody);
          }
        } else {

//                $emails = explode(',', $config['CONFIG_SETTINGS']['SEND_EMAIL_PAID']);
//                foreach ($emails as $email) {
//
//                    $Subject = "Order Status Confirmation from Bajaree.com";
//                    $EmailBody = file_get_contents(baseUrl('emails/order/order.status.confirm.php?order_id=' . $order_id));
//                    $sendEmailToApplicant = sendEmailFunction($admin_email,$admin_name,'no-reply@bajaree.com',$Subject,$EmailBody);
//                }
        }
      }





      if ($status == "approved") {
        $Subject = "Order Status Confirmation from Bajaree.com";
        $EmailBody = file_get_contents(baseUrl('emails/order/order.status.confirm.php?order_id=' . $order_id));
        $sendEmailToApplicant = sendEmailFunction($User_Email, $UserName, 'no-reply@bajaree.com', $Subject, $EmailBody);
      } elseif ($status == "delivered") {

        $Subject = "Order Status Confirmation from Bajaree.com";
        $EmailBody = file_get_contents(baseUrl('emails/order/order.status.confirm.php?order_id=' . $order_id));
        $sendEmailToApplicant = sendEmailFunction($User_Email, $UserName, 'no-reply@bajaree.com', $Subject, $EmailBody);
      } else {

        $Subject = "Order Status Confirmation from Bajaree.com";
        $EmailBody = file_get_contents(baseUrl('emails/order/order.status.confirm.php?order_id=' . $order_id));
        $sendEmailToApplicant = sendEmailFunction($User_Email, $UserName, 'no-reply@bajaree.com', $Subject, $EmailBody);
      }

      if ($sendEmailToApplicant != true) {
        $err = "Internal error. Try again later.";
      } else {
        $msg = "Thank you. Please check your email.";
        $link = "index.php?msg=" . base64_encode($msg);
        redirect($link);
      }
    } else {

      $err = "Order information could not update.";
    }
  }
}







$ExecuteOrder = mysqli_query($con, "SELECT * FROM orders WHERE order_id='$order_id'");

$SetOrder = mysqli_fetch_object($ExecuteOrder);
if (isset($SetOrder->order_note)) {
  $note = $SetOrder->order_note;
}

if (isset($SetOrder->order_read) AND $SetOrder->order_read != 'yes') {
  $UpdateReadStatus = mysqli_query($con, "UPDATE orders SET order_read='yes' WHERE order_id='$order_id'");
}



//getting external order product list from database
$arrayOrderProductExternal = array();
$sqlOrderProductExternal = "SELECT * 
  
                          FROM order_products_external
                          
                          WHERE OPE_order_id=$order_id";
$ExecuteOrderProductExternal = mysqli_query($con, $sqlOrderProductExternal);
if ($ExecuteOrderProductExternal) {
  while ($ExecuteOrderProductExternalObj = mysqli_fetch_object($ExecuteOrderProductExternal)) {
    $arrayOrderProductExternal[] = $ExecuteOrderProductExternalObj;
  }
} else {
  if (DEBUG) {
    $err = "ExecuteOrderProductExternal error: " . mysqli_error($con);
  } else {
    $err = "ExecuteOrderProductExternal query failed.";
  }
}



//getting product list from database
$arrayOrderProduct = array();
$sqlOrderProduct = "SELECT * 
  
                    FROM order_products

                    LEFT JOIN product_inventories ON PI_id=OP_product_inventory_id
                    LEFT JOIN products ON product_id=OP_product_id
                    WHERE OP_order_id=$order_id";
$ExecuteOrderProduct = mysqli_query($con, $sqlOrderProduct);
if ($ExecuteOrderProduct) {
  while ($ExecuteOrderProductObj = mysqli_fetch_object($ExecuteOrderProduct)) {
    $arrayOrderProduct[] = $ExecuteOrderProductObj;
  }
} else {
  if (DEBUG) {
    $err = "ExecuteOrderProduct error: " . mysqli_error($con);
  } else {
    $err = "ExecuteOrderProduct query failed.";
  }
}





//getting order status log from database
$arrayStatusLog = array();
$sqlGetStatusLog = "SELECT * FROM order_status_log WHERE OSL_order_id=$order_id";
$resultGetStatusLog = mysqli_query($con,$sqlGetStatusLog);
if($resultGetStatusLog){
  while($resultGetStatusLogObj = mysqli_fetch_object($resultGetStatusLog)){
    $arrayStatusLog[] = $resultGetStatusLogObj;
  }
} else {
  if (DEBUG) {
    $err = "resultGetStatusLogObj error: " . mysqli_error($con);
  } else {
    $err = "resultGetStatusLogObj query failed.";
  }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

  <head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />

    <title>Admin Panel | Order Details</title>



    <link href="<?php echo baseUrl('admin/css/main.css'); ?>" rel="stylesheet" type="text/css" />

    <link href='http://fonts.googleapis.com/css?family=Cuprum' rel='stylesheet' type='text/css' />


    <script type="text/javascript" src="<?php echo baseUrl('admin/js/jquery.min.js'); ?>"></script>

    <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, File upload, editor -->

    <script type="text/javascript" src="<?php echo baseUrl('admin/js/jquery.min.js'); ?>"></script>
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

    <script type="text/javascript" src="main.js"></script>



    <!--Effect on left error menu, top message menu, body-->

    <!--delete tags-->
    <!--        Start script src for fancybox of print preview -->
    <script type="text/javascript" src="<?php echo baseUrl('fancybox/fancybox/jquery.fancybox-1.3.4.pack.js'); ?>"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo baseUrl('fancybox/fancybox/jquery.fancybox-1.3.4.css'); ?>" media="screen" />
    <!--        End script src for fancybox of print preview -->

    <script type="text/javascript">

      function updateCount() {
        var count = $("#count").val();

        $.ajax({url: 'updateCount.php',
          data: {count: count}, //Modify this
          type: 'post',
          success: function(output) {
            var result = $.parseJSON(output);
            if (result.error == 0) {
              alert("Update complete.");
            } else if (result.error > 0) {
              alert(result.error_text);
            }

          }
        });
      }

    </script>

    <!--end delete tags-->



    <!-- SHOW PRODUCT Ajax --> 

    <script>

      function showProduct(product_id, inventory_id, order_id)
      {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
          xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
          {
            document.getElementById("productBody").innerHTML = xmlhttp.responseText;
          }
        }
        xmlhttp.open("GET", "order_details_ajax.php?ProductID=" + product_id + "&InventoryID=" + inventory_id + "&OrderID=" + order_id, true);
        xmlhttp.send();
      }
    </script>       

    <!-- SHOW PRODUCT Ajax --> 


  </head>



  <body>





    <?php include basePath('admin/top_navigation.php'); ?>



    <?php include basePath('admin/module_link.php'); ?>





    <!-- Content wrapper -->

    <div class="wrapper">



      <!-- Left navigation -->

      <div class="leftNav">

        <?php include('order_left_navigation.php'); ?>

      </div>

      <!-- Content Start -->

      <div class="content">

        <div class="title"><h5>Order Details Information</h5></div>



        <!-- Notification messages -->

        <?php include basePath('admin/message.php'); ?>



        <!-- Charts -->

        <div class="widget first">

          <div class="head">

            <h5 class="iGraph">Order Information</h5></div>

          <div class="body">

            <div class="charts" style="width: 700px; height: auto;">

              <form action="order_details.php?oid=<?php echo $_GET['oid']; ?>" method="post" class="mainForm" enctype="multipart/form-data">



                <!-- Input text fields -->

                <fieldset>

                  <div class="widget first">

                    <div class="head"><h5 class="iList">Order Status - <font color="#FF0000" style="text-transform:capitalize;"><?php echo $SetOrder->order_status; ?></font><span style="float: right; margin-left: 400px; font-weight: bolder;"><?php if ($SetOrder->order_status == "booking"): ?><a href="<?php echo baseUrl(); ?>admin/order/edit-order.php?oid=<?php echo $_GET['oid']; ?>">Edit Order</a><?php endif; ?></span></h5></div>







                    <div class="rowElem noborder"><label>Order No.:</label><div class="formRight">

                        <input name="orderid" type="text" maxlength="20" value="<?php echo '[' . date("dmy", strtotime($SetOrder->order_created)) . '-' . $SetOrder->order_id . ']'; ?>" readonly />

                      </div><div class="fix"></div></div>

                    <div class="rowElem noborder"><label>Note(Max Length: 500 chars):</label><div class="formRight">

                        <textarea name="note" maxlength="500" value="<?php echo $SetOrder->order_note; ?>" ></textarea>

                      </div><div class="fix"></div></div>

                    <div class="rowElem noborder"><label>Order Status:</label><div class="formRight">

                        <select name="status">

                          <option value="booking" <?php
                          if ($SetOrder->order_status == 'booking') {

                            echo 'selected';
                          }
                          ?>>Booking</option>

                          <option value="approved" <?php
                          if ($SetOrder->order_status == 'approved') {

                            echo 'selected';
                          }
                          ?>>Approved</option>

                          <option value="delivered" <?php
                          if ($SetOrder->order_status == 'delivered') {

                            echo 'selected';
                          }
                          ?>>Delivered</option>

                          <option value="paid" <?php
                          if ($SetOrder->order_status == 'paid') {

                            echo 'selected';
                          }
                          ?>>Paid</option>

                          <option value="cancel" <?php
                          if ($SetOrder->order_status == 'cancel') {

                            echo 'selected';
                          }
                          ?>>Cancel</option>

                        </select>

                      </div><div class="fix"></div></div>        





                    <input type="submit" name="update" value="Update Order Status" class="greyishBtn submitForm" />

                    <div class="fix"></div>

                  </div>    

                </fieldset>
                
                
                
<?php
$countStatusLog = count($arrayStatusLog);
if($countStatusLog > 0):
  ?>
                <fieldset>
                  <div class="widget">    
                    <div class="head"><h5 class="iGraph">Order Status Change Log</h5></div>

                    <table cellpadding="0" cellspacing="0" width="100%" class="tableStatic">
                      <thead>
                        <tr>
                          <td align="center">Status</td>
                          <td width="21%">Updated</td>
                          <td width="21%">Updated By</td>
                        </tr>
                      </thead>
                      <tbody>
<?php
  for($k = 0; $k < $countStatusLog; $k++):
    ?>
                      <tr>
                        <td width="30%"><?php echo $arrayStatusLog[$k]->OSL_order_status; ?></td>;
                        <td width="40%"><?php echo date("d M, Y h:i:s A", strtotime($arrayStatusLog[$k]->OSL_updated)); ?></td>
                        <td width="30%" align="center"><?php echo getFieldValue('admins', 'admin_full_name', 'admin_id=' . $arrayStatusLog[$k]->OSL_updated_by); ?></td>
                      </tr>
    <?php
  endfor;
?>               
                      </tbody>
                    </table>

                  </div>
                </fieldset>
<?php
endif;
?>  


                <fieldset>
                  <div class="widget">    
                    <div class="head"><h5 class="iPin">Invoice</h5></div>

                    <div class="rowElem">

                      <div class="formRight" style="float: left;">
                        <input id="printCommand" type="button" value="Print" class="blackBtn">
                          <input id="iframe" type="button" value="Print Preview" class="blackBtn">

                            </div>

                            <div style="float: right;">
                              <input id="count" type="text" value="<?php echo intval(get_option("INVOICE_MAXIMUM_PRODUCT_COUNT")); ?>" style="width:80px;"/>
                              <input type="button" value="Update" class="blackBtn" onclick="updateCount();"/>

                            </div>
                            <div class="fix"></div>
                            </div>

                            </div>
                            </fieldset>



                            <fieldset>











                              <!-- Collapsible. Closed by default -->

                              <div class="widget">

                                <div class="head closed"><h5>Order Details <strong>(Click to expand)</strong></h5></div>

                                <!-- Website statistics -->

                                <div class="widget">

                                  <div class="head"><h5 class="iChart8">Order Details</h5></div>

                                  <table cellpadding="0" cellspacing="0" width="100%" class="tableStatic">

                                    <thead>

                                      <tr>

                                        <td width="25%">Title</td>

                                        <td width="25%">Value</td>

                                        <td width="25%">Title</td>

                                        <td width="25%">Value</td>

                                      </tr>

                                    </thead>

                                    <tbody>

                                      <tr>

                                        <td>Ordered By:</td>

                                        <?php
                                        $GetUser = mysqli_query($con, "SELECT * FROM users WHERE user_id='" . $SetOrder->order_user_id . "'");

                                        $SetUser = mysqli_fetch_object($GetUser);
                                        ?>

                                        <?php if (isset($SetUser->user_first_name)): ?>

                                          <td><strong><?php echo $SetUser->user_first_name; ?> <?php echo $SetUser->user_middle_name; ?> <?php echo $SetUser->user_last_name; ?></strong></td>

                                        <?php endif; /* (isset($SetUser -> user_first_name)) */ ?>



                                        <td>Order ID:</td>

                                        <td><strong><?php echo '[' . date("dmy", strtotime($SetOrder->order_created)) . '-' . $SetOrder->order_id . ']'; ?></strong></td>

                                      </tr>

                                      <tr>

                                        <td>User's Phone:</td>

                                        <td><strong><?php echo $SetUser->user_phone; ?></strong></td>

                                        <td>Order Placed on:</td>

                                        <td><?php echo date('d M Y h.i.s A', strtotime($SetOrder->order_created)); ?></td>


                                      </tr>
                                      <tr>

                                        <td>Billing Phone:</td>

                                        <td><strong><?php echo $SetOrder->order_billing_phone; ?></strong></td>

                                        <td>Delivery Phone:</td>

                                        <td><strong><?php echo $SetOrder->order_shipping_phone; ?></strong></td>

<!--                                                        <td>Order Placed on:</td>

                                                        <td><?php // echo date('d M Y h.i.s A', strtotime($SetOrder->order_created));  ?></td>-->

                                      </tr>
                                      <tr>

                                        <td>Billing Address:</td>

                                        <td><strong><?php echo $SetOrder->order_billing_address; ?></strong></td>

                                        <td>Delivery Address:</td>

                                        <td><strong><?php echo $SetOrder->order_shipping_address; ?></strong></td>

                                      </tr>

                                      <tr>

                                        <td>Billing Area:</td>

                                        <td ><strong><?php echo $SetOrder->order_billing_area; ?></strong></td>


                                        <td>Delivery Area:</td>

                                        <td ><strong><?php echo $SetOrder->order_shipping_area; ?></strong></td>

                                      </tr>


                                      <tr>
                                        <?php
                                        $subTotal = $SetOrder->order_total_amount;
                                        $Vat = $SetOrder->order_vat_amount;
                                        $discount = $SetOrder->order_discount_amount;
                                        $promoDiscount = $SetOrder->order_promotion_discount_amount;
                                        $shipment = $SetOrder->order_shipment_charge;
                                        $grandTotal = $subTotal + $Vat + $shipment - $discount - $promoDiscount;
                                        ?>

                                        <td>Total Payable:</td>

                                        <td><strong><?php echo number_format($grandTotal, 2); ?></strong></td>

                                        <td>Order Updated On:</td>

                                        <td><?php echo date('d M Y h.i.s A', strtotime($SetOrder->order_updated_on)); ?></td>
                                      </tr>
                                      <tr>

                                        <td>Delivery Time:</td>

                                        <td> Date: <strong><?php echo date('d M Y', strtotime($SetOrder->order_delivery_start_datetime)); ?> </strong><br>

                                            From <strong><?php echo date('h:i A', strtotime($SetOrder->order_delivery_start_datetime)); ?></strong> To <strong><?php echo date('h:i A', strtotime($SetOrder->order_delivery_end_datetime)); ?></strong></td>

                                        <td>Is Express?:</td>

                                        <td><strong style="color:red; font-size: 16px;"><?php echo $SetOrder->order_is_express; ?></strong></td>
                                      </tr>
                                    </tbody> 
                                  </table>                    
                                </div>
                              </div>
                              <div class="widgets"> 
                                <div class="left"><!-- Left column -->
                                  <!-- Collapsible. Opened by default -->
                                  <div class="widget">

                                    <div class="head opened" id="opened"><h5>Product List</h5></div>

                                    <div class="body">



                                      <?php
                                      $SubTotal = 0;
                                      $TotalDiscount = 0;
                                      $countOrderProductArray = count($arrayOrderProduct);
                                      if ($countOrderProductArray > 0):
                                        for ($i = 0; $i < $countOrderProductArray; $i++):

                                          $deleteStatus = $arrayOrderProduct[$i]->OP_is_deleted;
                                          ?>						                        



                                          <div><!-- Left column -->

                                            <!-- Collapsible. Opened by default -->

                                            <div class="widget">
                                              <div class="head closed normal" id="opened">
                                                <h5><?php if ($deleteStatus == "yes") {
                                        echo '<strike>';
                                      } ?>
                                                  <strong <?php if ($deleteStatus == "yes") {
                                                  echo 'style="color: tomato;"';
                                                } ?>>
    <?php echo $arrayOrderProduct[$i]->product_title; ?>
                                                  </strong>
                                                </h5><?php if ($deleteStatus == "yes") {
      echo '</strike>';
    } ?>
                                              </div>
                                              <div class="body">

    <?php if ($deleteStatus == "yes") {
      echo '<strike>';
    } ?>&rArr; Product Inventory: <strong><a href="javascript:void(0)" onclick="showProduct(<?php echo $arrayOrderProduct[$i]->OP_product_id; ?>,<?php echo $arrayOrderProduct[$i]->OP_product_inventory_id; ?>,<?php echo $order_id; ?>);" style="text-decoration:underline;"><?php echo $arrayOrderProduct[$i]->PI_inventory_title; ?></a></strong><?php if ($deleteStatus == "yes") {
      echo '</strike>';
    } ?><br />

                                          <?php if ($deleteStatus == "yes") {
                                            echo '<strike>';
                                          } ?>&rArr; Product Quantity: <strong><?php echo $arrayOrderProduct[$i]->OP_product_quantity; ?></strong><?php if ($deleteStatus == "yes") {
                                            echo '</strike>';
                                          } ?><br /><br />

                                              </div>  

                                            </div>

                                          </div>
                                          <?php
                                        endfor;
                                      endif;
                                      ?>   




<?php
$SubTotal = 0;
$TotalDiscount = 0;
$countOrderProductExternalArray = count($arrayOrderProductExternal);
if ($countOrderProductExternalArray > 0):
  for ($i = 0; $i < $countOrderProductExternalArray; $i++):
    ?>						                        



                                          <div><!-- Left column -->

                                            <!-- Collapsible. Opened by default -->

                                            <div class="widget">
                                              <div class="head closed normal" id="opened">
                                                <h5>
                                                  <strong>
    <?php echo $arrayOrderProductExternal[$i]->OPE_product_name; ?> [External]
                                                  </strong>
                                                </h5>
                                              </div>
                                              <div class="body">

                                                &rArr; Product Inventory: <strong><?php echo $arrayOrderProductExternal[$i]->OPE_product_inventory_name; ?></strong><br />

                                                &rArr; Product Quantity: <strong><?php echo $arrayOrderProductExternal[$i]->OPE_quantity; ?></strong><br />

                                                &rArr; Product Supplier: <strong><?php echo $arrayOrderProductExternal[$i]->OPE_supplier_name; ?></strong><br />

                                                &rArr; Product Tax (%): <strong><?php echo $arrayOrderProductExternal[$i]->OPE_tax; ?></strong><br />

                                                &rArr; Product Total Discount: <strong><?php echo $arrayOrderProductExternal[$i]->OPE_total_discount; ?></strong><br />

                                                &rArr; Product Total Price: <strong><?php echo $arrayOrderProductExternal[$i]->OPE_total_price; ?></strong><br />

                                              </div>  

                                            </div>

                                          </div>
    <?php
  endfor;
endif;
?>   



                                    </div>




                                  </div>

                                </div> <!--left-->



                                <div class="right"><!-- Left column -->

                                  <!-- Collapsible. Opened by default -->

                                  <div class="widget">

                                    <div class="head opened" id="opened"><h5>Product Details</h5></div>

                                    <div class="body" id="productBody">



                                      <font style="font-size:16px; text-align:center;">Please select a product</font>

                                    </div>

                                  </div>

                                </div>

                              </div>

                            </fieldset>



                            </form>		



                            </div>



                            </div>

                            </div>



                            </div>

                            <!-- Content End -->



                            <div class="fix"></div>

                            </div>

                            <script type="text/javascript">
                              $("#iframe").fancybox({
                                'width': '95%',
                                'height': 700,
                                'autoScale': false,
                                'transitionIn': 'none',
                                'transitionOut': 'none',
                                'type': 'iframe',
                                'href': "print/invoice.php?oid=<?php echo base64_encode($order_id); ?>"
                              });

                              $("#printCommand").click(function() {
                                var tempFrame = document.getElementById("invoiceFrame");
                                var tempFrameWindow = tempFrame.contentWindow ? tempFrame.contentWindow : tempFrame.contentDocument.defaultView;
                                tempFrameWindow.focus();
                                tempFrameWindow.print();

                              });
                            </script>
                            <div id="print" style="display: none;">
                              <div id="invoice">
                                <iframe id="invoiceFrame" src="print/invoice.php?oid=<?php echo base64_encode($order_id); ?>"></iframe>
                              </div>

                            </div>

<?php include basePath('admin/footer.php'); ?>


                            </body>

                            </html>