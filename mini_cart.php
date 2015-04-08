<?php
//this array and query is for generating mini_cart.php page
$CartID = session_id();
$arrayMiniTempCart = array();   
$sqlMiniTempCart = "SELECT 
                products.product_id, products.product_title, products.product_default_inventory_id,  products.product_show_as_new_from, products.product_show_as_new_to, products.product_show_as_featured_from, products.product_show_as_featured_to,
                product_inventories.PI_inventory_title,product_inventories.PI_size_id,product_inventories.PI_cost,product_inventories.PI_current_price,product_inventories.PI_old_price,product_inventories.PI_quantity,
                product_discounts.PD_start_date,product_discounts.PD_end_date,product_discounts.PD_amount,product_discounts.PD_status,
                (SELECT product_images.PI_file_name FROM product_images WHERE product_images.PI_inventory_id = products.product_default_inventory_id AND product_images.PI_product_id = products.product_id ORDER BY product_images.PI_priority DESC LIMIT 1) as PI_file_name,
                temp_carts.TC_id,temp_carts.TC_unit_price,temp_carts.TC_per_unit_discount,temp_carts.TC_discount_amount,temp_carts.TC_product_quantity,temp_carts.TC_product_total_price

                FROM temp_carts

                LEFT JOIN product_inventories ON product_inventories.PI_id = temp_carts.TC_product_inventory_id
                LEFT JOIN product_discounts ON product_discounts.PD_inventory_id = temp_carts.TC_product_inventory_id
                LEFT JOIN products ON products.product_id = temp_carts.TC_product_id
                WHERE temp_carts.TC_session_id='$CartID'";
$executeMiniTempCart = mysqli_query($con,$sqlMiniTempCart);
if($executeMiniTempCart){
  while($executeMiniTempCartObj = mysqli_fetch_object($executeMiniTempCart)){
    $arrayMiniTempCart[] = $executeMiniTempCartObj;
  }
} else {
  if(DEBUG){
    echo "executeMiniTempCart error: " . mysqli_error($con);
  } else {
    echo "executeMiniTempCart error query failed";
  }
}

?>

<div class="modal fade signUpContent " id="ModalCart" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-80">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h6 class="modal-title text-left" id="myModalLabel">My Cart</h6>
            </div>
            <div class="modal-body-global modal-body-cart">
                <table width="100%" border="0" id="miniCart">

                  <?php
                  $TotalPrice = 0;
                  $countMiniTempCart = count($arrayMiniTempCart);
                  if ($countMiniTempCart > 0):
                    for ($a = 0; $a < $countMiniTempCart; $a++):
                      
                    
                      $ProductTitle = $arrayMiniTempCart[$a]->product_title;
                      $ProductID = $arrayMiniTempCart[$a]->product_id;
                      $ProductImage = $arrayMiniTempCart[$a]->PI_file_name;
                      $ProductDefaultInventoryTitle = $arrayMiniTempCart[$a]->PI_inventory_title;
                      $ProductUnitPrice = $arrayMiniTempCart[$a]->TC_unit_price;
                      $ProductUnitDiscount = $arrayMiniTempCart[$a]->TC_per_unit_discount;
                      $ProductTotalPrice = $arrayMiniTempCart[$a]->TC_product_total_price;
                      $ProductTotalDiscount = $arrayMiniTempCart[$a]->TC_discount_amount;
                      $ProductCartQuantity = $arrayMiniTempCart[$a]->TC_product_quantity;
                      $TempCartID = $arrayMiniTempCart[$a]->TC_id;
                      
                      $TotalPrice += ($ProductTotalPrice - $ProductTotalDiscount);
                    
                      ?>
                    
                    <tr class="cartProduct" id="cartItem_<?php echo $arrayMiniTempCart[$a]->TC_id; ?>">
                        <td width="20%" class="cartImg">
                          
                          <?php if($ProductImage == ''): ?>
                          <img title="<?php echo $ProductTitle; ?>" src="<?php echo baseUrl(); ?>upload/product/small/default.jpg" >
                          <?php else: ?>
                          <img title="<?php echo $ProductTitle; ?>" src="<?php echo baseUrl(); ?>upload/product/small/<?php echo $ProductImage; ?>" >
                          <?php endif; ?>
                          
<!--                          <img src="<?php echo baseUrl(); ?>upload/product/small/<?php echo $ProductImage; ?>" alt="product">-->
                        </td>
                        <td width="42%" class="cartProductDescription">
                          <h4>
                            <a target="_blank" href="<?php echo baseUrl(); ?>product/<?php echo $ProductID; ?>/<?php echo clean($ProductTitle); ?>"><?php echo $ProductTitle; ?></a>
                                <span><?php echo $ProductDefaultInventoryTitle; ?></span>
                          </h4>
                          <div class="priceglobal">
                                          
<!--                                          showing product current price based on discount-->
<?php if($ProductUnitDiscount > 0): ?>
                                <span class="current-price"><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format(($ProductUnitPrice - $ProductUnitDiscount), 2); ?></span>
                                <span class="old-price"> <?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($ProductUnitPrice, 2); ?></span><br/>
                                <span class="save-price"> save <?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($ProductUnitDiscount, 2); ?></span>
<?php else: ?>
                                <span><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format($ProductUnitPrice, 2); ?></span>                                
<?php endif; ?>                                
<!--                                              showing product current price based on discount-->
                                         
                            </div>
                            
                        </td>
                        <td width="18%" align="center"><div class="quantity">
                                <a href="javascript:void(0)" title="Increase" onClick="tmpCartIncrease(<?php echo $TempCartID; ?>);"><img src="<?php echo baseUrl(); ?>images/increase.png" alt="increase"></a>
                                
                                <?php if($arrayMiniTempCart[$a]->TC_product_quantity > 0): ?>
                                <span id="tempCartQuantity_<?php echo $TempCartID; ?>"><span class="cartQuantity"><?php echo $arrayMiniTempCart[$a]->TC_product_quantity; ?></span></span>
                                <?php else: ?>
                                <span id="tempCartQuantity_<?php echo $TempCartID; ?>"><span class="cartQuantity" style="color:red; font-weight: bold;"><?php echo $arrayMiniTempCart[$a]->TC_product_quantity; ?></span></span>
                                <?php endif; ?>
                                
                                <a style="padding:0;" href="javascript:void(0)" title="Decrease" onClick="tmpCartDecrease(<?php echo $TempCartID; ?>);"><img src="<?php echo baseUrl(); ?>images/decrease.png" alt="decrease"></a>
                            </div></td>
                            <td width="12%" align="center" class="subtotal"><span id="tmpCartTotalPrice_<?php echo $TempCartID; ?>"><strong><?php echo $config['CURRENCY_SIGN']; ?> <?php echo number_format(($ProductTotalPrice-$ProductTotalDiscount),2); ?></strong></span></td>
                        <td width="10%" align="center"><a id="deleteTempCart_<?php echo $arrayMiniTempCart[$a]->TC_id; ?>" class="cartProductDelete" href="javascript:void(0)" onClick="deleteFromCart(<?php echo $arrayMiniTempCart[$a]->TC_id; ?>,<?php echo $arrayMiniTempCart[$a]->product_id; ?>);">delete</a></td>
                    </tr>
                    
                  <?php
                      endfor; //$a = 0; $a < $countMiniTempCart; $a++
                  else: //$countMiniTempCart > 0
                    echo '<tr class="emptyMessage text-center padding-bottom-10"><td colspan="5"><h4 class="modal-title text-left" id="myModalLabel">Nothing added to cart yet.</h4></td></tr>';
                  endif; //$countMiniTempCart > 0
                  ?>
                  
                </table>
                <!--userForm--> 
                
            </div>

            
            <div class="modal-footer">
              <h3 id="miniCartTotalPrice" class="pull-right text-right clearfx" style="width: 100%; display: block; clear: both; margin-top: 0px; padding-right:45px; padding-bottom: 10px;"> Subtotal : <?php echo $config['CURRENCY_SIGN'].' '.number_format($TotalPrice, 2);?> </h3>
       


<a href="<?php echo baseUrl(); ?>my-cart" class="btn btn-primary"> VIEW  CART <i class="fa fa-shopping-cart"></i> </a>
<a href="javascript:void(0)" onClick="checkQuantity();" class="btn btn-primary"> CHECKOUT NOW <i class="fa fa-long-arrow-right"></i></a>
            </div>
        </div>
        <!-- /.modal-content --> 
    </div>
    <!-- /.modal-dialog --> 
</div>