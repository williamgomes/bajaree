<?php
include ('../../../config/config.php');
$optionMaxProductCount = get_option("INVOICE_MAXIMUM_PRODUCT_COUNT");
$OrderNum = '';
$PhoneNo = '';
$Email = '';
$OrderDate = '';
$UserFullName = '';
$BillingName = '';
$BillingAddress = '';
$BillingCity = '';
$BillingCountry = '';
$BillingArea = '';
$BillingZip = '';
$SubTotal = 0;
$GrandTotal = 0;
$Discount = 0;
$DeliveryCharge = 0;
$TotalQuantity = 0;
$PaymentMethod = '';

if (isset($_GET['oid']) AND $_GET['oid'] != "") {
  $OrderID = base64_decode($_GET['oid']);

  $orderInfoSql = "SELECT * 
                  FROM orders 
                  
                  LEFT JOIN users ON users.user_id=orders.order_user_id
                  WHERE order_id=$OrderID";
  $resultOrderInfoSql = mysqli_query($con, $orderInfoSql);
  if ($resultOrderInfoSql) {
    $resultOrderInfoSqlObj = mysqli_fetch_object($resultOrderInfoSql);
    if (isset($resultOrderInfoSqlObj->order_id)) {
      $OrderNum = $resultOrderInfoSqlObj->order_number;
      $PhoneNo = $resultOrderInfoSqlObj->order_billing_phone;
      $Email = $resultOrderInfoSqlObj->user_email;
      $OrderDate = $resultOrderInfoSqlObj->order_created;
      $UserFullName = $resultOrderInfoSqlObj->user_first_name . ' ' . $resultOrderInfoSqlObj->user_last_name;
      $BillingName = $resultOrderInfoSqlObj->order_billing_first_name . ' ' . $resultOrderInfoSqlObj->order_billing_last_name;
      $BillingAddress = $resultOrderInfoSqlObj->order_billing_address;
      $BillingCity = $resultOrderInfoSqlObj->order_billing_city;
      $BillingCountry = $resultOrderInfoSqlObj->order_billing_country;
      $BillingArea = $resultOrderInfoSqlObj->order_billing_area;
      $BillingZip = $resultOrderInfoSqlObj->order_billing_zip;
      $SubTotal = $resultOrderInfoSqlObj->order_total_amount;
      $Discount = $resultOrderInfoSqlObj->order_discount_amount;
      $DeliveryCharge = $resultOrderInfoSqlObj->order_discount_amount;
      $tmpGrandTotal = $SubTotal + $DeliveryCharge - $Discount;
      $GrandTotal = number_format($tmpGrandTotal, 2);
      $TotalQuantity = $resultOrderInfoSqlObj->order_total_item;
      $PaymentMethod = $resultOrderInfoSqlObj->order_payment_type;
    }
  } else {
    if (DEBUG) {
      echo "resultOrderInfoSql error: " . mysqli_errno($con);
    } else {
      echo "resultOrderInfoSql query failed.";
    }
  }



  $arrayProduct = array();
  $productSql = "SELECT * 
                FROM order_products 
                
                LEFT JOIN products ON products.product_id=order_products.OP_product_id
                LEFT JOIN product_inventories ON product_inventories.PI_id=order_products.OP_product_inventory_id
                LEFT JOIN sizes ON sizes.size_id=product_inventories.PI_size_id
                WHERE OP_order_id=$OrderID";
  $resultProductSql = mysqli_query($con, $productSql);
  if ($resultProductSql) {
    while ($resultProductSqlObj = mysqli_fetch_object($resultProductSql)) {
      $arrayProduct[] = $resultProductSqlObj;
    }
  } else {
    if (DEBUG) {
      echo "resultProductSql error: " . mysqli_error($con);
    } else {
      echo "resultProductSql query failed.";
    }
  }
}
?>
<!DOCTYPE html>
<!-- saved from url=(0052)file:///E:/Bajaree/invoice/invoice/invoice-back.html -->
<html><head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <link rel='stylesheet' href='css/style.css' media="screen">
    <link rel='stylesheet' href='css/style.css' media="print">
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,300' rel='stylesheet' type='text/css'>

  </head>
  <body>

    <div class="wrapper">
      <div class="left">
        <div class="header">
          <img align="left" src="./Invoice_files/logo.png">
          <h3> INVOICE<br>
            <span>Office Copy</span> </h3>

        </div>


        <div class="container">
          <div class="top">
            <table class="topTable" width="80%" border="0">
              <tbody><tr>
                  <td width="34%">

                    <span class="nofloat">O</span><p class="middle"> Order ID: [030514-153]</p> </td>
                  <td width="28%"><span class="nofloat">P</span><p class="middle"> 01937734578</p> </td>
                  <td width="38%"><span class="nofloat">E</span> <p class="middle"> rushdiahmed@yahoo.com</p> </td>
                </tr>
              </tbody></table>

          </div>

          <div class="invoiceToDetails">
            <div class="invToLeft w50 floatleft">
              <h2>invoice to </h2>
              <p>Kazi Farial Ahmed  <br>
                BAF Base Bangabandhu,Kurmitola,DHK Cant,DHK                                        </p>
            </div>


            <div class="invToLeft w40 floatright">
              <h2>Payment </h2>
              <p>
                Total Payable: <strong>1100.00</strong> 

              </p>
              <p> <em>VAT included</em>   </p>
            </div>
          </div> <!--invoiceToDetails-->

          <div class="itemTable">
            <table width="100%" border="0">
              <tbody><tr class="tableHeader">
                  <td width="10%">ID</td>
                  <td width="40%">Details</td>
                  <td width="15%">Price</td>
                  <td width="15%">Quantity</td>
                  <td width="20%">Sub Total</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td>Hawk<br>
                    <p class="styleDes">(PK Polo 3)</p></td>
                  <td>৳ 1100</td>
                  <td>1</td>
                  <td class="price">৳ 1100</td>
                </tr>

                <tr>
                  <td class="text-right charges" colspan="4"><p>VAT:</p></td>
                  <td class="charges">৳ 100</td>
                </tr>
                <tr>
                  <td class="text-right charges" colspan="4"><p>Delivery Charge:</p></td>
                  <td class="charges"> ৳ 50</td>
                </tr>

              </tbody></table>

          </div>

        </div>

        <div class="Signature">
          <h2>total: ৳ 1200.00</h2>
          <div class="w50 floatleft SignatureLeft">

            <h3> Payment Method </h3>
            <h4 class="cashonDelivery"> <img width="16" src="./Invoice_files/ok.png"> Cash On Delivery  </h4>


          </div>

          <div class="floatright ReceiveBy">
            <h3>Signature</h3>

          </div>

        </div>


        <div class="terms">
          <h2> <em>Thank You for Shopping With Us! </em></h2>
          <p>BAJAREE.COM | Online Grocery Shopping </p>
        </div>


      </div> <!-- left -->
      <div class="hr"></div>
      <div class="right">
        <div class="header">
          <img align="left" src="./Invoice_files/logo.png">

          <h3> INVOICE<br>
            <span style="margin-right:5px;">Customer Copy</span> </h3>
        </div>


        <div class="container">
          <div class="top">
            <table class="topTable" width="80%" border="0">
              <tbody><tr>
                  <td width="34%">

                    <span class="nofloat">O</span><p class="middle"> Order ID: [030514-153]</p> </td>
                  <td width="28%"><span class="nofloat">P</span><p class="middle"> 01937734578</p> </td>
                  <td width="38%"><span class="nofloat">E</span> <p class="middle"> rushdiahmed@yahoo.com</p> </td>
                </tr>
              </tbody></table>

          </div>

          <div class="invoiceToDetails">
            <div class="invToLeft w50 floatleft">
              <h2>invoice to </h2>
              <p> Kazi Farial Ahmed  <br>
                BAF Base Bangabandhu,Kurmitola,DHK Cant,DHK                                        </p>
            </div>


            <div class="invToLeft w40 floatright">
              <h2>Payment </h2>
              <p>
                Total Payable: <strong>1100.00</strong> 

              </p>
              <p><em>VAT included</em></p>
            </div>
          </div> <!--invoiceToDetails-->

          <div class="itemTable">
            <table width="100%" border="0">
              <tbody><tr class="tableHeader">
                  <td width="10%">ID</td>
                  <td width="40%">Details</td>
                  <td width="15%">Price</td>
                  <td width="15%">Quantity</td>
                  <td width="20%">Sub Total</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td>Hawk<br>
                    <p class="styleDes">(PK Polo 3)</p></td>
                  <td>৳ 1100</td>
                  <td>1</td>
                  <td class="price">৳ 1100</td>
                </tr>

                <tr>
                  <td class="text-right charges" colspan="4"><p>VAT:</p></td>
                  <td class="charges">৳ 100</td>
                </tr>
                <tr>
                  <td class="text-right charges" colspan="4"><p>Delivery Charge:</p></td>
                  <td class="charges"> ৳ 50</td>
                </tr>

              </tbody></table>
          </div>
        </div>


        <div class="Signature">
          <h2>total: ৳ 1200.00</h2>
          <div class="w50 floatleft SignatureLeft">

            <h3> Payment Method </h3>
            <h4 class="cashonDelivery"> <img width="16" src="./Invoice_files/ok.png">  
              Cash On Delivery  </h4>


          </div>

          <div class="floatright ReceiveBy">
            <h3>Signature</h3>

          </div>

        </div>


        <div class="terms">
          <h2> <em>Thank You for Shopping With Us! </em></h2>
          <p>BAJAREE.COM | Online Grocery Shopping </p>
        </div>


      </div>


    </div>
    <?php
    $countProductArray = count($arrayProduct);
    ?>
    <?php if ($countProductArray > 0): ?>

     <div class="wrapper">
        <div class="left">
          <div class="header">
            <img align="left" src="./Invoice_files/logo.png">
            <h3> INVOICE<br>
              <span>Office Copy</span> </h3>

          </div>


          <div class="container">

            <div class="itemTable itemTableBack">
              <table width="100%" border="0">
                <tbody><tr class="tableHeader">
                    <td width="10%">No</td>
                    <td width="15%">SKU</td>
                    <td width="15%">Product Name</td>
                    <td width="15%">Size</td>
                    <td width="15%">Quantity</td>
                    <td width="15%">Unit Price</td>
                    <td width="15%">Total Price</td>
                  </tr>

                  <?php for ($i = 0; $i < $countProductArray; $i++): ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td>Juice</td>
                      <td>Shezan Mango Juice</td>
                      <td>250ml</td>
                      <td>1</td>
                      <td>৳ 1200</td>
                      <td class="price">৳ 1500</td>
                    </tr>

                    <?php if ($i % $optionMaxProductCount == 0): ?>
<!--ENDING-->

                </tbody></table>

            </div>

          </div>




        </div> <!-- left -->
         </div><!--wrapper-->
<!--//ENDING-->

<!--STARTING-->
  

 <div class="left">
          <div class="header">
            <img align="left" src="./Invoice_files/logo.png">
            <h3> INVOICE<br>
              <span>Office Copy</span> </h3>

          </div>


          <div class="container">

            <div class="itemTable itemTableBack">
              <table width="100%" border="0">
                <tbody><tr class="tableHeader">
                    <td width="10%">No</td>
                    <td width="15%">SKU</td>
                    <td width="15%">Product Name</td>
                    <td width="15%">Size</td>
                    <td width="15%">Quantity</td>
                    <td width="15%">Unit Price</td>
                    <td width="15%">Total Price</td>
                  </tr>

<!--//STARTING-->
                    <?php endif; /* ($i%$optionMaxProductCount==0) */ ?>
                  <?php endfor; /* ($i=0;$i < $countProductArray;$i++) */ ?>

                </tbody></table>

            </div>

          </div>




        </div> <!-- left -->
        <div class="hr"></div>
        <div class="right">
          <div class="header">
            <img align="left" src="./Invoice_files/logo.png">

            <h3> INVOICE<br>
              <span style="margin-right:5px;">Customer Copy</span> </h3>
          </div>


          <div class="container">
            <!--invoiceToDetails-->

            <div class="itemTable itemTableBack">
              <table width="100%" border="0">
                <tbody><tr class="tableHeader">
                    <td width="10%">No</td>
                    <td width="15%">SKU</td>
                    <td width="15%">Product Name</td>
                    <td width="15%">Size</td>
                    <td width="15%">Quantity</td>
                    <td width="15%">Unit Price</td>
                    <td width="15%">Total Price</td>
                  </tr>
                  <?php for ($j = 0; $j < $countProductArray; $j++): ?>
                    <tr>
                      <td><?php echo $j; ?></td>
                      <td>Juice</td>
                      <td>Shezan Mango Juice</td>
                      <td>250ml</td>
                      <td>1</td>
                      <td>৳ 1200</td>
                      <td class="price">৳ 1500</td>
                    </tr>
                    <?php if ($j % $optionMaxProductCount == 0): ?>
<!--//ENDING--> 


                </tbody></table>

            </div>
          </div>





        </div> <!--right-->

 
<!--ENDING--> 
<!--STARTING-->
 <div class="wrapper">
 <div class="hr"></div>
        <div class="right">
          <div class="header">
            <img align="left" src="./Invoice_files/logo.png">

            <h3> INVOICE<br>
              <span style="margin-right:5px;">Customer Copy</span> </h3>
          </div>


          <div class="container">
            <!--invoiceToDetails-->

            <div class="itemTable itemTableBack">
              <table width="100%" border="0">
                <tbody><tr class="tableHeader">
                    <td width="10%">No</td>
                    <td width="15%">SKU</td>
                    <td width="15%">Product Name</td>
                    <td width="15%">Size</td>
                    <td width="15%">Quantity</td>
                    <td width="15%">Unit Price</td>
                    <td width="15%">Total Price</td>
                  </tr>
<!--//STARTING-->
                    <?php endif; /* ($j%$optionMaxProductCount==0) */ ?>
                    
                    
                  <?php endfor; /* ($j=0;$j < $countProductArray;$j++) */ ?>



                </tbody></table>

            </div>
          </div>





        </div> 
 <!--right-->


      </div> 
<!--wraper-->

    <?php endif; /* ($countProductArray > 0) */ ?>


  </body></html>