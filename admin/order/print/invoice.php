<?php
include ('../../../config/config.php');

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
$isExpress = '';

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
      $Discount = $resultOrderInfoSqlObj->order_promotion_discount_amount;
      $FirstOrderDiscount = $resultOrderInfoSqlObj->order_discount_amount;
      $DeliveryCharge = $resultOrderInfoSqlObj->order_shipment_charge;
      $vatAmount = $resultOrderInfoSqlObj->order_vat_amount;
      $isExpress = $resultOrderInfoSqlObj->order_is_express;
      $tmpGrandTotal = $SubTotal + $DeliveryCharge - $Discount + $vatAmount - $FirstOrderDiscount;
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
                WHERE OP_order_id=$OrderID AND OP_is_deleted='no'";
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
  
  
  
  //getting external order product list from database
  $arrayOrderProductExternal = array();
  $sqlOrderProductExternal = "SELECT * 

                            FROM order_products_external

                            WHERE OPE_order_id=$OrderID";
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
}





?>

<!doctype html>
<html>
  <head>
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
          <img  align="left" src="images/logo.png">
          <h3> INVOICE<br>
            <span>Office Copy</span> </h3>

        </div>


        <div class="container">
          <div class="top">
            <table class="topTable" width="80%" border="0">
              <tr>
                <td width="34%">

                  <span class="nofloat">O</span><p class="middle"> Order ID: <?php echo $OrderNum; ?></p> </td>
                <td width="28%"><span class="nofloat">P</span><p class="middle"> <?php echo $PhoneNo; ?></p> </td>
                <td width="38%"><span class="nofloat">E</span> <p class="middle"> <?php echo $Email; ?></p> </td>
              </tr>
            </table>

          </div>

          <div class="invoiceToDetails">
            <div class="invToLeft w50 floatleft">
              <h2>invoice to </h2>
              <p><?php echo $BillingName; ?><br>
                <?php echo $BillingAddress; ?>,<?php echo $BillingCity; ?> - <?php echo $BillingZip; ?><br>
                <?php echo $BillingCountry; ?>
              </p>
            </div>


            <div class="invToLeft w40 floatright">
              <h2>Payment </h2>
              <p>
                Total Payable: <strong><?php echo $config['CURRENCY_SIGN']; ?> <?php echo $GrandTotal; ?></strong> 

              </p>
              <p> <em>VAT included</em>   </p>
            </div>
          </div> <!--invoiceToDetails-->

          <div class="itemTable">
            <table width="100%" border="0">
              <tr class="tableHeader">
                <td width="60%">Order Details</td>
                <td width="25%">Total Quantity</td>
                <td width="15%">Sub Total</td>
              </tr>
              <tr>
                <td><br>
                  By: <?php echo $UserFullName; ?><br>
                  Date: <?php echo date("d M, Y H:i:s", strtotime($OrderDate)); ?>

                </td>
                <td><?php echo $TotalQuantity; ?></td>
                <td  class="price"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($SubTotal, 2); ?></td>
              </tr>

              <?php if ($Discount > 0): ?>					
                <tr>
                  <td class="text-right charges" colspan="2"><p>Discount:</p></td>
                  <td class="charges"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($Discount, 2); ?></td>
                </tr>
              <?php endif; ?>
                
              <?php if ($FirstOrderDiscount > 0): ?>					
                <tr>
                  <td class="text-right charges" colspan="2"><p>First Order Discount:</p></td>
                  <td class="charges"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($FirstOrderDiscount, 2); ?></td>
                </tr>
              <?php endif; ?>
                
              <?php if ($vatAmount > 0): ?>					
                <tr>
                  <td class="text-right charges" colspan="2"><p>Vat:</p></td>
                  <td class="charges"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($vatAmount, 2); ?></td>
                </tr>
              <?php endif; ?>

              <?php if ($DeliveryCharge > 0): ?>
                <tr>
                  <td class="text-right charges" colspan="2"><p>Delivery Charge:</p></td>
                  <td class="charges"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($DeliveryCharge, 2); ?></td>
                </tr>
              <?php endif; ?>

            </table>

          </div>

        </div>

        <div class="Signature">
          <h2>total: <?php echo $config['CURRENCY_SIGN']; ?> <?php echo $GrandTotal; ?></h2>
          <div class="w50 floatleft SignatureLeft">

            <h3> Payment Method </h3>
            <?php if ($PaymentMethod == 'COD'): ?>
              <h4 class="cashonDelivery"> <img width="16" src="images/ok.png"> Cash On Delivery  </h4>
            <?php elseif ($PaymentMethod == 'Bkash'): ?>
              <h4 class="cashonDelivery"> <img width="16" src="images/ok.png"> bKash  </h4>
            <?php endif; ?>

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
          <img   align="left" src="images/logo.png">

          <h3> INVOICE<br>
            <span style="margin-right:5px;">Customer Copy</span> </h3>
        </div>


        <div class="container">
          <div class="top">
            <table class="topTable" width="80%" border="0">
              <tr>
                <td width="34%">

                  <span class="nofloat">O</span><p class="middle"> Order ID: <?php echo $OrderNum; ?></p> </td>
                <td width="28%"><span class="nofloat">P</span><p class="middle"> <?php echo $PhoneNo; ?></p> </td>
                <td width="38%"><span class="nofloat">E</span> <p class="middle"> <?php echo $Email; ?></p> </td>
              </tr>
            </table>

          </div>

          <div class="invoiceToDetails">
            <div class="invToLeft w50 floatleft">
              <h2>invoice to </h2>
              <p><?php echo $BillingName; ?><br>
                <?php echo $BillingAddress; ?>,<?php echo $BillingCity; ?> - <?php echo $BillingZip; ?><br>
                <?php echo $BillingCountry; ?>
              </p>
            </div>


            <div class="invToLeft w40 floatright">
              <h2>Payment </h2>
              <p>
                Total Payable: <strong><?php echo $config['CURRENCY_SIGN']; ?> <?php echo $GrandTotal; ?></strong> 

              </p>
              <p> <em>VAT included</em>   </p>
            </div>
          </div> <!--invoiceToDetails-->

          <div class="itemTable">
            <table width="100%" border="0">
              <tr class="tableHeader">
                <td width="60%">Order Details</td>
                <td width="25%">Total Quantity</td>
                <td width="15%">Sub Total</td>
              </tr>
              <tr>
                <td><br>

                  By: <?php echo $UserFullName; ?><br>
                  Date: <?php echo date("d M, Y H:i:s", strtotime($OrderDate)); ?>

                </td>
                <td><?php echo $TotalQuantity; ?></td>
                <td  class="price"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($SubTotal, 2); ?></td>
              </tr>

              <?php if ($Discount > 0): ?>					
                <tr>
                  <td class="text-right charges" colspan="2"><p>Discount:</p></td>
                  <td class="charges"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($Discount, 2); ?></td>
                </tr>
              <?php endif; ?>
                
              <?php if ($FirstOrderDiscount > 0): ?>					
                <tr>
                  <td class="text-right charges" colspan="2"><p>First Order Discount:</p></td>
                  <td class="charges"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($FirstOrderDiscount, 2); ?></td>
                </tr>
              <?php endif; ?>
                
              <?php if ($vatAmount > 0): ?>					
                <tr>
                  <td class="text-right charges" colspan="2"><p>Vat:</p></td>
                  <td class="charges"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($vatAmount, 2); ?></td>
                </tr>
              <?php endif; ?>

              <?php if ($DeliveryCharge > 0): ?>
                <tr>
                  <td class="text-right charges" colspan="2"><p>Delivery Charge:</p></td>
                  <td class="charges"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($DeliveryCharge, 2); ?></td>
                </tr>
              <?php endif; ?>

            </table>

          </div>

        </div>

        <div class="Signature">
          <h2>total: <?php echo $config['CURRENCY_SIGN']; ?> <?php echo $GrandTotal; ?></h2>
          <div class="w50 floatleft SignatureLeft">

            <h3> Payment Method </h3>
            <?php if ($PaymentMethod == 'COD'): ?>
              <h4 class="cashonDelivery"> <img width="16" src="images/ok.png"> Cash On Delivery  </h4>
            <?php elseif ($PaymentMethod == 'Bkash'): ?>
              <h4 class="cashonDelivery"> <img width="16" src="images/ok.png"> bKash  </h4>
            <?php endif; ?>

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
    $optionMaxProductCount = get_option("INVOICE_MAXIMUM_PRODUCT_COUNT");
    $pageCount = ceil($countProductArray / $optionMaxProductCount);
    $productCountEndTo = 0;
    $productCountStartFrom = 0;
    for ($a = 0; $a < $pageCount; $a++):
      $restProductQuantity = $countProductArray - $productCountEndTo;
      $productCountEndTo = $productCountEndTo + $optionMaxProductCount;
      if ($restProductQuantity <= $optionMaxProductCount):
        $productCountEndTo = $countProductArray;
      endif;
      ?>



      <div class="wrapper">
        <div class="left">
          <div class="header">
            <img  align="left" src="images/logo.png">
            <h3> INVOICE<br>
              <span>Office Copy</span> </h3>

          </div>


          <div class="container">

            <div class="itemTable itemTableBack">
              <table width="100%" border="0">
                <tr class="tableHeader">
                  <td width="10%">No</td>
                  <td width="30%">Product Name</td>
                  <td width="15%">Size</td>
                  <td width="15%">Unit Price</td>
                  <td width="15%">Quantity</td>
                  <td width="15%">Total Price</td>
                </tr>
                <?php
                if ($countProductArray > 0):
                  for ($x = $productCountStartFrom; $x < $productCountEndTo; $x++):
                    ?>  
                    <tr>
                      <td><?php echo $x + 1; ?></td>
                      <td><?php echo $arrayProduct[$x]->product_title; ?></td>
                      <td><?php echo $arrayProduct[$x]->size_title; ?></td>
                      <td><?php echo $config['CURRENCY_SIGN']; ?> <?php echo $arrayProduct[$x]->OP_price; ?></td>
                      <td><?php echo $arrayProduct[$x]->OP_product_quantity; ?></td>
                      <td class="price"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo $arrayProduct[$x]->OP_product_total_price; ?></td>
                    </tr>
                    <?php
                  endfor;
                endif;
                ?>
                    
                 <?php
                if (count($arrayOrderProductExternal) > 0):
                  for ($y = 0; $y < count($arrayOrderProductExternal); $y++):
                    ?>  
                    <tr>
                      <td><?php echo $x + 1; ?></td>
                      <td><?php echo $arrayOrderProductExternal[$y]->OPE_product_name; ?></td>
                      <td><?php echo $arrayOrderProductExternal[$y]->OPE_product_inventory_name; ?></td>
                      <td><?php echo $config['CURRENCY_SIGN']; ?> <?php echo $arrayOrderProductExternal[$y]->OPE_price; ?></td>
                      <td><?php echo $arrayOrderProductExternal[$y]->OPE_quantity; ?></td>
                      <td class="price"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo $arrayOrderProductExternal[$y]->OPE_total_price; ?></td>
                    </tr>
                    <?php
                  endfor;
                endif;
                ?>

                <?php if ($restProductQuantity <= $optionMaxProductCount) : ?>        
                  <?php if ($Discount > 0): ?>					
                    <tr>
                      <td class="text-right charges" colspan="2"></td>
                      <td class="text-right charges" colspan="3"><p>Discount:</p></td>
                      <td class="charges"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($Discount, 2); ?></td>
                    </tr>
                  <?php endif; ?>
                  <?php if ($FirstOrderDiscount > 0): ?>					
                    <tr>
                      <td class="text-right charges" colspan="2"></td>
                      <td class="text-right charges" colspan="3"><p>First Order Discount:</p></td>
                      <td class="charges"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($FirstOrderDiscount, 2); ?></td>
                    </tr>
                  <?php endif; ?>
                  <?php if ($vatAmount > 0): ?>					
                    <tr>
                      <td class="text-right charges" colspan="2"></td>
                      <td class="text-right charges" colspan="3"><p>Vat:</p></td>
                      <td class="charges"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($vatAmount, 2); ?></td>
                    </tr>
                  <?php endif; ?>

                  <?php if ($DeliveryCharge > 0): ?>
                    <tr>
                      <td class="text-right charges" colspan="2"></td>
                      <td class="text-right charges" colspan="3"><p><?php if($isExpress == 'yes'){ echo "Express "; } ?>Delivery Charge:</p></td>
                      <td class="charges"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($DeliveryCharge, 2); ?></td>
                    </tr>
                  <?php endif; ?>
                <?php endif; ?>         

              </table>

            </div>

          </div>

          <?php if ($restProductQuantity <= $optionMaxProductCount) : ?>
            <h2 class="back-total">total: <?php echo $config['CURRENCY_SIGN']; ?> <?php echo $GrandTotal; ?></h2>
          <?php endif; ?>


        </div> <!-- left -->
        <div class="hr"></div>
        <div class="right">
          <div class="header">
            <img   align="left" src="images/logo.png">

            <h3> INVOICE<br>
              <span style="margin-right:5px;">Customer Copy</span> </h3>
          </div>


          <div class="container">
            <!--invoiceToDetails-->

            <div class="itemTable itemTableBack">
              <table width="100%" border="0">
                <tr class="tableHeader">
                  <td width="10%">No</td>
                  <td width="30%">Product Name</td>
                  <td width="15%">Size</td>
                  <td width="15%">Unit Price</td>
                  <td width="15%">Quantity</td>
                  <td width="15%">Total Price</td>
                </tr>
                <?php
                if ($countProductArray > 0):
                  for ($x = $productCountStartFrom; $x < $productCountEndTo; $x++):
                    ?>  
                    <tr>
                      <td><?php echo $x + 1; ?></td>
                      <td><?php echo $arrayProduct[$x]->product_title; ?></td>
                      <td><?php echo $arrayProduct[$x]->size_title; ?></td>
                      <td><?php echo $config['CURRENCY_SIGN']; ?> <?php echo $arrayProduct[$x]->OP_price; ?></td>
                      <td><?php echo $arrayProduct[$x]->OP_product_quantity; ?></td>
                      <td class="price"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo $arrayProduct[$x]->OP_product_total_price; ?></td>
                    </tr>
                    <?php
                  endfor;
                endif;
                ?>
                    
                  <?php
                if (count($arrayOrderProductExternal) > 0):
                  for ($y = 0; $y < count($arrayOrderProductExternal); $y++):
                    ?>  
                    <tr>
                      <td><?php echo $x + 1; ?></td>
                      <td><?php echo $arrayOrderProductExternal[$y]->OPE_product_name; ?></td>
                      <td><?php echo $arrayOrderProductExternal[$y]->OPE_product_inventory_name; ?></td>
                      <td><?php echo $config['CURRENCY_SIGN']; ?> <?php echo $arrayOrderProductExternal[$y]->OPE_price; ?></td>
                      <td><?php echo $arrayOrderProductExternal[$y]->OPE_quantity; ?></td>
                      <td class="price"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo $arrayOrderProductExternal[$y]->OPE_total_price; ?></td>
                    </tr>
                    <?php
                  endfor;
                endif;
                ?>    
                    
                    
                <?php if ($restProductQuantity <= $optionMaxProductCount) : ?>        
                  <?php if ($Discount > 0): ?>					
                    <tr>
                      <td class="text-right charges" colspan="2"></td>
                      <td class="text-right charges" colspan="3"><p>Discount:</p></td>
                      <td class="charges"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($Discount, 2); ?></td>
                    </tr>
                  <?php endif; ?>
                  <?php if ($FirstOrderDiscount > 0): ?>					
                    <tr>
                      <td class="text-right charges" colspan="2"></td>
                      <td class="text-right charges" colspan="3"><p>First Order Discount:</p></td>
                      <td class="charges"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($FirstOrderDiscount, 2); ?></td>
                    </tr>
                  <?php endif; ?>
                  <?php if ($vatAmount > 0): ?>					
                    <tr>
                      <td class="text-right charges" colspan="2"></td>
                      <td class="text-right charges" colspan="3"><p>Vat:</p></td>
                      <td class="charges"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($vatAmount, 2); ?></td>
                    </tr>
                  <?php endif; ?>

                  <?php if ($DeliveryCharge > 0): ?>
                    <tr>
                      <td class="text-right charges" colspan="2"></td>
                      <td class="text-right charges" colspan="3"><p><?php if($isExpress == 'yes'){ echo "Express "; } ?>Delivery Charge:</p></td>
                      <td class="charges"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($DeliveryCharge, 2); ?></td>
                    </tr>
                  <?php endif; ?>
                <?php endif; ?>         

              </table>

            </div>

          </div>

          <?php if ($restProductQuantity <= $optionMaxProductCount) : ?>
            <h2 class="back-total">total: <?php echo $config['CURRENCY_SIGN']; ?> <?php echo $GrandTotal; ?></h2>
          <?php endif; ?>


        </div>


      </div>

    </body>
  </html>

  <?php
  $productCountStartFrom = $productCountStartFrom + $optionMaxProductCount;
endfor;
?>