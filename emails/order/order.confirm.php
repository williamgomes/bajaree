<?php
include ('../../config/config.php');


if(isset($_GET['order_id']) AND $_GET['order_id'] > 0){
  
  $OrderID = $_GET['order_id'];
  
  $SqlGetOrder = "SELECT * FROM orders,users WHERE orders.order_id=$OrderID AND orders.order_user_id=users.user_id";
  $ExecuteOrder = mysqli_query($con,$SqlGetOrder);

  if($ExecuteOrder){
          $SetOrder = mysqli_fetch_object($ExecuteOrder);
  } else {
    if(DEBUG){
          echo "ExecuteOrder error: " . mysqli_error($con);
    }
  }
?>

<?php include('../header.php'); ?>
<tr>
                <td style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; color: #505050; font-family: 'Varela Round', sans-serif; font-size: 14px; line-height: 150%; text-align: left; padding-top:9px;padding-bottom:9px;padding-left:18px;padding-right:18px;">
                    <p style="font-family: 'Varela Round', sans-serif;font-size: 14px;">Hello <?php echo $SetOrder -> user_first_name; ?>,
                      <br><br>Thank you for shopping with us. Your order has been received through our system and waiting for approval. The details of your order are given below.</p>
                </td>
            </tr>
            <tr>
                <td style="padding-top:9px;padding-bottom:9px;padding-left:18px;padding-right:18px;">
                    <h3 style="color: #505050; display: block; font-family: 'Varela Round', sans-serif; font-size: 14px; font-style: normal; font-weight: normal; line-height: 110%; letter-spacing: normal; margin: 0; margin-bottom: 9px; text-align: left; text-align: right;">Order Number: <b><?php echo '[' . date("dmy", strtotime($SetOrder->order_created)) . '-' . $SetOrder->order_id . ']'; ?></b></h3>
                    <table style="color: #666;font-size: 14px;border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; margin:0px;width:100%;border:1px solid #3EAE99;font-family: 'Varela Round', sans-serif;font-size:14px;">
                        <tbody>
                            <tr style="background-color: #3EAE99; color: #fff;font-size:14px;font-weight:normal;">
                                <td style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; padding-left: 5px;padding-bottom:5px;padding-top:5px;">#</td>
                                <td style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0">Product</td>
                                <td style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0">Quantity</td>
                                <td style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0">Price</td>
                            </tr>
               <?php
               $SqlOrderProduct = mysqli_query($con,"SELECT * FROM order_products,products WHERE OP_order_id=$OrderID AND order_products.OP_product_id=products.product_id");
               if($SqlOrderProduct){
                       $Total = 0;
                       $x = 0;
                       while($SetOrderProduct = mysqli_fetch_object($SqlOrderProduct)){
                               $TotalPrice = ($SetOrderProduct->OP_price * $SetOrderProduct->OP_product_quantity);
                               $TotalDiscount = ($SetOrderProduct->OP_discount * $SetOrderProduct->OP_product_quantity);
                               $SubTotal = $TotalPrice - $TotalDiscount;
                               $Total += $SubTotal;
                               $x++;
                        ?>
                            <tr>
                                <td style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; padding-left: 5px;padding-bottom:5px;padding-top:5px;"><?php echo $x; ?></td>
                                <td style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0"><?php echo $SetOrderProduct->product_title; ?></td>
                                <td style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0"><?php echo $SetOrderProduct->OP_product_quantity; ?></td>
                                <td style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0"><?php echo number_format($TotalPrice,2,'.',''); ?></td>
                            </tr>
                       <?php
                       }
               }
                       ?>
                            </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="kmTextContent" valign="top" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; color: #505050; font-family: 'Varela Round', sans-serif; font-size: 14px; line-height: 150%; text-align: left; padding-top:3px;padding-bottom:3px;padding-left:18px;padding-right:18px;line-height:100%;">
                    <p style="text-align: right;">Subtotal: <?php echo $config['CURRENCY']; ?> <?php echo $SetOrder -> order_total_amount; ?></p>
                    
                    <?php if($SetOrder -> order_shipment_charge > 0): ?>
                      <p style="text-align: right;"><?php if($SetOrder -> order_is_express == "yes"){ echo "Express"; } ?> Delivery Charge: <?php echo $config['CURRENCY']; ?> <?php echo number_format($SetOrder -> order_shipment_charge,2); ?></p>
                    <?php else: ?>
                      <p style="text-align: right;">Delivery Charge: FREE</p>
                    <?php endif; ?> 
                     
                    <?php if($SetOrder -> order_vat_amount > 0): ?>  
                      <p style="text-align: right;">Tax: <?php echo $config['CURRENCY']; ?> <?php echo number_format($SetOrder -> order_vat_amount,2); ?></p>
                    <?php endif; ?>
                      
                    <?php if($SetOrder -> order_promotion_discount_amount > 0): ?>   
                    <p style="text-align: right;">Discount: <?php echo $config['CURRENCY']; ?> <?php echo number_format($SetOrder -> order_promotion_discount_amount,2); ?></p>
                    <?php endif; ?>
                    
                    <?php if($SetOrder -> order_discount_amount > 0): ?>   
                    <p style="text-align: right;">First Order Discount: <?php echo $config['CURRENCY']; ?> <?php echo number_format($SetOrder -> order_discount_amount,2); ?></p>
                    <?php endif; ?>
                    
                    <?php $totalAmount = ($SetOrder -> order_total_amount + $SetOrder -> order_vat_amount + $SetOrder -> order_shipment_charge) - ($SetOrder -> order_promotion_discount_amount + $SetOrder -> order_discount_amount); ?>
                    <p style="text-align: right; font-size: 18px; font-weight: bold;">Total:  <?php echo $config['CURRENCY']; ?> <?php echo number_format($totalAmount,2); ?></p>
                </td>
            </tr>
            <tr><td class="kmTextContent" valign="top">
                <table style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; margin:0px;">
                    <tr>
                        <td class="kmTextContent" valign="top" style="width:250px;border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; color: #505050; font-family: 'Varela Round', sans-serif; font-size: 14px; line-height: 150%; text-align: left;padding-top:3px;padding-bottom:3px;padding-left:18px;padding-right:18px;">
                            <p>Your order will be send to:</p>
                            <p><?php echo $SetOrder -> order_shipping_address; ?>,<br /><?php echo $SetOrder -> order_shipping_city; ?> - <?php echo $SetOrder -> order_shipping_zip; ?>,<br /><?php echo $SetOrder -> order_shipping_country; ?></p>
                            <?php if($SetOrder -> order_note != ''){ ?>
                            <p><b>Special Notes: <?php echo $SetOrder -> order_note; ?></b></p>
                            <?php } ?>
                        </td>
<!--                        <td class="kmTextContent" valign="top" style="width:250px;border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; color: #505050; font-family: 'Varela Round', sans-serif; font-size: 14px; line-height: 150%; text-align: left;padding-top:3px;padding-bottom:3px;padding-left:18px;padding-right:18px;">
                            <p>Your estimated delivery date:</p>
                            <p>Tuesday, October 1, 2013</p>
                        </td>-->
                    </tr>
                </table></td>
            </tr>
            <tr>
                <td class="kmTextContent" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0; color: #3EAE99; font-family: 'Varela Round', sans-serif; font-size: 18px; line-height: 150%; text-align: left; padding-top:25px;padding-bottom:9px;padding-left:18px;padding-right:18px;">
                    <strong>Thank you for shopping with us.</strong>
                </td>
            </tr>
            <tr>
              <td class="kmTextContent" style="border-collapse: collapse; mso-table-lspace: 0; mso-table-rspace: 0;  font-family: 'Varela Round', sans-serif; font-size: 14px; text-align: left; padding-top:20px;padding-bottom:20px;padding-left:18px;padding-right:18px;">
                  Hotline: <?php echo get_option('SUPPORT_MOBILE_NO'); ?> 
                </td>
            </tr>

<?php include('../footer.php'); 

} else {
  echo 'Incorrect parameter.';
}
?>     