<?php
include ('../config/config.php');
include '../lib/category2.php';
if (!checkAdminLogin()) {
  $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
  redirect($link);
}


$subTotal = 0;
$totalDiscount = 0;
$promoDiscount = 0;
$deliveryCharge = 0;
$totalOrder = 0;
$grandTotal = 0;
$totalCosting = 0;
$vatTotal = 0;

//getting top 5 products from database
$arrayTopProduct = array();
$sqlTopProduct = "SELECT SUM(OP_product_quantity) AS product_quantity,product_id,PI_id,product_title,PI_inventory_title
  
                  FROM products
                  
                  LEFT JOIN order_products ON product_id=OP_product_id
                  LEFT JOIN product_inventories ON PI_id=OP_product_inventory_id
                  GROUP BY OP_order_id, OP_product_id, OP_product_inventory_id
                  ORDER BY product_quantity DESC LIMIT 5";
$resultTopProduct = mysqli_query($con, $sqlTopProduct);
if ($resultTopProduct) {
  while ($resultTopProductObj = mysqli_fetch_object($resultTopProduct)) {
    $arrayTopProduct[] = $resultTopProductObj;
  }
} else {
  if (DEBUG) {
    echo "resultTopProduct error: " . mysqli_error($con);
  }
}



//getting top 5 active user
$arrayTopUser = array();
$sqlTopUser = "SELECT * FROM users ORDER BY `user_last_login` DESC LIMIT 5";
$resultTopUser = mysqli_query($con, $sqlTopUser);
if ($resultTopUser) {
  while ($resultTopUserObj = mysqli_fetch_object($resultTopUser)) {
    $arrayTopUser[] = $resultTopUserObj;
  }
} else {
  if (DEBUG) {
    echo "sqlTopUser error: " . mysqli_error($con);
  }
}





//getting all child categories under master categories
$arrayProductCategory = array();
$childs = array();
$cat2DD = new Category2($con); /* $cat2DD == category2 library dropdown */
$sqlGetParentCategory = "SELECT * FROM categories WHERE category_parent_id=2";
$resultGetParentCategory = mysqli_query($con, $sqlGetParentCategory);
if ($resultGetParentCategory) {
  while ($resultGetParentCategoryObj = mysqli_fetch_object($resultGetParentCategory)) {
    $categoryID = $resultGetParentCategoryObj->category_id;
    $categoryName = $resultGetParentCategoryObj->category_name;
    $childs = array();
    $childs[] = $categoryID;
    $cat2DD->selected = $categoryID;
    $childsArray = $cat2DD->getChilds($categoryID);


    if (count($childs)) {
      foreach ($childsArray AS $child) {
        $childs[] = $child['category_id'];
      }
    }
    asort($childs);
    $childString = implode(',', $childs);

    //getting all products under main category and their child category
    $sqlGetProduct = "SELECT SUM(OP_product_quantity) AS product_quantity 
      
                      FROM product_categories, order_products, orders
                      
                      WHERE OP_product_id=PC_product_id
                      AND order_status = 'paid'
                      AND PC_category_id IN ($childString)";
    $resultGetProduct = mysqli_query($con, $sqlGetProduct);
    if ($resultGetProduct) {
      while ($resultGetProductObj = mysqli_fetch_object($resultGetProduct)) {
        $arrayProductCategory[]['category_name'] = $categoryName;
        $arrayProductCategory[(count($arrayProductCategory) - 1)]['category_quantity'] = $resultGetProductObj->product_quantity;
      }
    } else {
      echo "resultGetProduct error: " . mysqli_error($con);
    }
  }
} else {
  if (DEBUG) {
    echo "resultGetParentCategory error: " . mysqli_error($con);
  }
}



//getting order related statistics from database
$sqlGetOrderSum = "SELECT COUNT(order_id) AS totalOrder, SUM(order_vat_amount) AS vatTotal, SUM(order_total_amount) AS SubTotal, SUM(order_discount_amount) AS TotalDiscount, SUM(order_promotion_discount_amount) AS PromoDiscount, SUM(order_shipment_charge) AS TotalDelivery FROM orders WHERE order_status='paid'";
$resultGetOrderSum = mysqli_query($con, $sqlGetOrderSum);
if ($resultGetOrderSum) {
  $resultGetOrderSumObj = mysqli_fetch_object($resultGetOrderSum);
  if (isset($resultGetOrderSumObj->SubTotal)) {
    $subTotal = $resultGetOrderSumObj->SubTotal;
    $vatTotal = $resultGetOrderSumObj->vatTotal;
    $totalDiscount = $resultGetOrderSumObj->TotalDiscount;
    $promoDiscount = $resultGetOrderSumObj->PromoDiscount;
    $deliveryCharge = $resultGetOrderSumObj->TotalDelivery;
    $grandTotal = $subTotal + $deliveryCharge - $totalDiscount - $promoDiscount + $vatTotal;
    $totalOrder = $resultGetOrderSumObj->totalOrder;
  }
} else {
  if (DEBUG) {
    echo "resultGetOrderSum error: " . mysqli_error($con);
  }
}



//getting total ordered product cost
$sqlGetProductPrice = "SELECT SUM(PI_cost) AS totalCost
  
                      FROM orders, order_products
                      
                      LEFT JOIN product_inventories ON OP_product_id=PI_product_id
                      WHERE OP_order_id=order_id
                      AND order_status='paid'";

$resultGetProductPrice = mysqli_query($con,$sqlGetProductPrice);
if($resultGetProductPrice){
  $resultGetProductPriceObj = mysqli_fetch_object($resultGetProductPrice);
  if(isset($resultGetProductPriceObj->totalCost)){
    $totalCosting = $resultGetProductPriceObj->totalCost;
  }
} else {
  if(DEBUG){
    echo "resultGetProductPrice error: " . mysqli_error($con);
  }
}
//echo "<pre>";
//print_r($arrayProductCategory);
//echo "</pre>";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
    <title>Admin panel: Dashboard </title>


    <?php include basePath('admin/header.php'); ?>


    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages: ["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Category Name', 'Purchase Amount'],
<?php
$countProductCategoryArray = count($arrayProductCategory);
if ($countProductCategoryArray > 0):
  for ($a = 0; $a < $countProductCategoryArray; $a++):
    $categoryQuantity = 0;
    if (!empty($arrayProductCategory[$a]['category_quantity'])) {
      $categoryQuantity = $arrayProductCategory[$a]['category_quantity'];
    }
    ?>
              ['<?php echo $arrayProductCategory[$a]['category_name']; ?>', <?php echo $categoryQuantity; ?>],
    <?php
  endfor;
endif;
?>
        ]);

        var options = {
          title: 'Category Wish Sales',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
      }
    </script>



  </head>

  <body>

    <?php include basePath('admin/top_navigation.php'); ?>

    <?php include basePath('admin/module_link.php'); ?>


    <!-- Content wrapper -->
    <div class="wrapper">

      <!-- Left navigation -->
      <?php include basePath('admin/left_navigation.php'); ?>

      <!-- Content Start -->
      <div class="content">




        <div class="title"><h5>Dashboard</h5></div>


        <!-- Notification messages -->
        <?php include basePath('admin/message.php'); ?>
        <!-- Charts -->




        <div class="widgets">
          <div class="left"><!-- Left column -->

            
<?php if(getSession('admin_type') == "master"): ?>            
            
            <div class="widget">
              <div class="head"><h5 class="iChart8">Overall Statistics</h5><div class="num"></div></div>
              <table cellpadding="0" cellspacing="0" width="100%" class="tableStatic">
                <thead>
                  <tr>
                    <td width="70%">Description</td>
                    <td width="30%">Statistics</td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Total Complete Order</td>
                    <td><?php echo $totalOrder; ?></td>
                  </tr>
                  <tr>
                    <td>Total Sale</td>
                    <td><?php echo number_format($subTotal,2); ?></td>
                  </tr>
                  <tr>
                    <td>Total Cost</td>
                    <td><?php echo number_format($totalCosting,2); ?></td>
                  </tr>
                  <tr>
                    <td>Total Discount Given</td>
                    <td><?php echo number_format(($totalDiscount + $promoDiscount),2); ?></td>
                  </tr>
                  <tr>
                    <td>Total Vat</td>
                    <td><?php echo number_format(($vatTotal),2); ?></td>
                  </tr>
                  <tr>
                    <td>Total Delivery</td>
                    <td><?php echo number_format(($deliveryCharge),2); ?></td>
                  </tr>
                  <tr>
                    <td><strong>Net Profit</strong></td>
                    <td><strong><?php echo number_format(($grandTotal - $totalCosting),2); ?></strong></td>
                  </tr>
                </tbody>
              </table>                    
            </div>
            
<?php endif; ?>            
            
            <div class="widget">
              <div class="head"><h5 class="iChart8">Top 5 Products</h5><div class="num"></div></div>
              <table cellpadding="0" cellspacing="0" width="100%" class="tableStatic">
                <thead>
                  <tr>
                    <td width="40%">Name</td>
                    <td width="40%">Inventory</td>
                    <td width="20%">Quantity</td>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $countArrayTopProduct = count($arrayTopProduct);
                  if ($countArrayTopProduct > 0):
                    for ($i = 0; $i < $countArrayTopProduct; $i++):
                      ?>
                      <tr>
                        <td><?php echo $arrayTopProduct[$i]->product_title; ?></td>
                        <td><?php echo $arrayTopProduct[$i]->PI_inventory_title; ?></td>
                        <td align="center"><a href="#" title="" class="webStatsLink"><?php echo $arrayTopProduct[$i]->product_quantity; ?></a></td>
                      </tr>
                      <?php
                    endfor;
                  endif;
                  ?>        
                </tbody>
              </table>                    
            </div>




            <div class="widget"><!-- Pie chart 1 -->
              <div class="head"><h5 class="iChart8">Pie charts</h5></div>
              <div class="body">
                <div id="piechart" style="width: 316px; height: 316px; padding: 0px; position: relative;"></div>
              </div>
            </div>




          </div>




          <!-- Right column -->
          <div class="right">


            <div class="widget">
              <div class="head"><h5 class="iChart8">Top 5 Active User</h5><div class="num"></div></div>
              <table cellpadding="0" cellspacing="0" width="100%" class="tableStatic">
                <thead>
                  <tr>
                    <td width="35%">Name</td>
                    <td width="35%">Email</td>
                    <td width="30%">Last Login</td>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $countArrayTopUser = count($arrayTopUser);
                  if ($countArrayTopUser > 0):
                    for ($j = 0; $j < $countArrayTopUser; $j++):
                      ?>
                      <tr>
                        <td><?php echo $arrayTopUser[$j]->user_first_name; ?></td>
                        <td><?php echo $arrayTopUser[$j]->user_email; ?></td>
                        <td><?php echo date('d M Y h:i A', strtotime($arrayTopUser[$j]->user_last_login)); ?></td>
                      </tr>
                      <?php
                    endfor;
                  endif;
                  ?>        
                </tbody>
              </table>                    
            </div>


          </div>
        </div>












      </div>


      <!-- Content End -->

      <div class="fix"></div>
    </div>

    <?php include basePath('admin/footer.php'); ?>
