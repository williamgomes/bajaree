<?php
include ('../../config/config.php');
$ProductID = $_GET['ProductID'];
$InventoryID = $_GET['InventoryID'];
$OrderID = $_GET['OrderID'];


//getting supplier information
$arraySupplierInventory = array();
$sqlSupplierInventory = "SELECT * 
  
                        FROM supplier_inventories 
                        
                        LEFT JOIN suppliers ON supplier_id=SI_supplier_id
                        WHERE SI_product_inventory_id=$InventoryID
                        AND SI_status='active'";
$resultSupplierInventory = mysqli_query($con,$sqlSupplierInventory);
if($resultSupplierInventory){
  while($resultSupplierInventoryObj = mysqli_fetch_object($resultSupplierInventory)){
    $arraySupplierInventory[] = $resultSupplierInventoryObj;
  }
} else {
  echo "resultSupplierInventory error: " . mysqli_error($con);
}


$sqlOrderProduct = "SELECT 
                products.product_title,
                product_inventories.PI_inventory_title,
                (SELECT product_images.PI_file_name FROM product_images WHERE product_images.PI_inventory_id = order_products.OP_product_inventory_id AND product_images.PI_product_id = products.product_id ORDER BY product_images.PI_priority DESC LIMIT 1) as PI_file_name,
                order_products.OP_product_quantity,order_products.OP_id,order_products.OP_supplier_id,
                product_sizes.PS_size_title

                FROM order_products

                LEFT JOIN product_inventories ON product_inventories.PI_id = order_products.OP_product_inventory_id
                LEFT JOIN product_discounts ON product_discounts.PD_inventory_id = order_products.OP_product_inventory_id
                LEFT JOIN products ON products.product_id = order_products.OP_product_id
                LEFT JOIN product_sizes ON product_sizes.PS_size_id = product_inventories.PI_size_id
                WHERE order_products.OP_order_id=$OrderID
                AND order_products.OP_product_id=$ProductID
                AND order_products.OP_product_inventory_id=$InventoryID";
$executeOrderProduct = mysqli_query($con, $sqlOrderProduct);
if ($executeOrderProduct) {
  $executeOrderProductObj = mysqli_fetch_object($executeOrderProduct);
  if(isset($executeOrderProductObj->product_title)){
    echo '<img src="'.baseUrl('upload/product/mid/' . $executeOrderProductObj->PI_file_name).'" width="200px" align="middle" style="margin-left:50px;" />
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
              <td><strong>Title</strong></td>
              <td><strong>'.$executeOrderProductObj->product_title.'</strong></td>
              <td><strong>Inventory Title</strong></td>  
              <td><strong>'.$executeOrderProductObj->PI_inventory_title.'</strong></td>
          </tr>
          <tr>
              <td>Size:</td>
              <td><strong>'.$executeOrderProductObj->PS_size_title.'</strong></td>
              <td>Quantity:</td>
              <td><strong>'.$executeOrderProductObj->OP_product_quantity.'</strong></td>
          </tr>
       </tbody>
    </table><br><br>';
    
    echo '<table cellpadding="0" cellspacing="0" width="100%" class="tableStatic">
      <thead>
          <tr>
            <td width="50%">Supplier Name</td>
            <td width="30%">Supplier Price</td>
            <td width="20%">Confirmed?</td>
          </tr>
      </thead>
      <tbody>';
  $countSupplierInventoryArray = count($arraySupplierInventory);
  $status = '';
    if($countSupplierInventoryArray > 0){
      for($i = 0; $i < $countSupplierInventoryArray; $i++){
        if($executeOrderProductObj->OP_supplier_id == $arraySupplierInventory[$i]->supplier_id){ $status = 'checked="checked"'; }
          echo '<tr>
              <td><strong>' . $arraySupplierInventory[$i]->supplier_name . '</strong></td>
              <td><strong>'.$arraySupplierInventory[$i]->SI_product_cost.'</strong></td>
              <td><input type="checkbox" id="supplier_'. $arraySupplierInventory[$i]->supplier_id .'" onClick="saveSupplier('. $arraySupplierInventory[$i]->supplier_id .','. $executeOrderProductObj->OP_id .');" '. $status .'></td>
          </tr>';
      }
    } else {
      echo '<tr>
              <td colspan="2"><strong>No Supplier Found</strong></td>
          </tr>';
    }  
          
       echo '</tbody>
    </table>';
  }
} else {
  if (DEBUG) {
    echo "executeTempCart error: " . mysqli_error($con);
  }
}
			
?>