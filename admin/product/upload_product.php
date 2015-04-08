<?php
include ('../../config/config.php');
require_once '../../lib/excel/PHPExcel/IOFactory.php';

$excel = '';


if(isset($_POST['upload'])){
  
  extract($_POST);
  
  if ($_FILES["excel"]["tmp_name"] == "") {
    $err = "Please upload a file.";
  } else {
    $now = date("d-m-Y_H.i.s");
    $excel_name = basename($_FILES['excel']['name']);
    $extension = pathinfo($excel_name, PATHINFO_EXTENSION); /* it will return file extensions */
    $new_excel_name = 'Import_' . $now . '.' . $extension; /* create custom file name  */
    $file_source = $_FILES["excel"]["tmp_name"];


    if (!is_dir($config['IMAGE_UPLOAD_PATH'] . '/excel/')) {
      mkdir($config['IMAGE_UPLOAD_PATH'] . '/excel/', 0777, TRUE);
    }
    $file_target_path = $config['IMAGE_UPLOAD_PATH'] . '/excel/' . $new_excel_name;


    if ($extension == 'xls' OR $extension == 'xlsx') {

      if (move_uploaded_file($file_source, $file_target_path)) {

        $path = $file_target_path;

        $objPHPExcel = PHPExcel_IOFactory::load($path);

        $sheetCount = $objPHPExcel->getSheetCount();

        if ($sheetCount < 5) {

          $err = "Wrong excel sheet selected. Please check before upload.";
        } else {

          //$err = "Total " . $sheetCount . " sheet(s) in this excel file.";

          //print_r($objPHPExcel->getWorksheetIterator());
          $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
          $highestRow = $objWorksheet->getHighestRow(); // e.g. 10

          $productID = 0;
          $productTitle = '';
          $productLongDesc = '';
          $productShortDesc = '';
          $productExpress = '';
          $productSKU = '';
          $productMetaTitle = '';
          $productMetaKeyword = '';
          $productMetaDesc = '';
          $productTags = '';
          $arrayProductID = array();

          for ($row = 2; $row <= $highestRow; ++$row) {

            $productSKU = $objWorksheet->getCellByColumnAndRow(5, $row);

            if ($productSKU == "") {
              $productID = $objWorksheet->getCellByColumnAndRow(0, $row);
              $productTitle = $objWorksheet->getCellByColumnAndRow(1, $row);
              $productLongDesc = $objWorksheet->getCellByColumnAndRow(2, $row);
              $productShortDesc = $objWorksheet->getCellByColumnAndRow(3, $row);
              $productExpress = $objWorksheet->getCellByColumnAndRow(4, $row);
              $productSKU = 'P-' . $productID;
              $productMetaTitle = $objWorksheet->getCellByColumnAndRow(6, $row);
              $productMetaKeyword = $objWorksheet->getCellByColumnAndRow(7, $row);
              $productMetaDesc = $objWorksheet->getCellByColumnAndRow(8, $row);
              $productTags = $objWorksheet->getCellByColumnAndRow(9, $row);



              $ProductCreate = '';
              if ($productID != '') {
                $ProductCreate .= ' product_id = "' . mysqli_real_escape_string($con, $productID) . '"';
                $ProductCreate .= ', product_title = "' . mysqli_real_escape_string($con, $productTitle) . '"';
                $ProductCreate .= ', product_sku = "' . mysqli_real_escape_string($con, $productSKU) . '"';
              } else {
                $ProductCreate .= ' product_title = "' . mysqli_real_escape_string($con, $productTitle) . '"';
              }
              $ProductCreate .= ', product_short_description = "' . mysqli_real_escape_string($con, $productShortDesc) . '"';
              $ProductCreate .= ', product_long_description = "' . mysqli_real_escape_string($con, $productLongDesc) . '"';
              $ProductCreate .= ', product_is_express = "' . mysqli_real_escape_string($con, $productExpress) . '"';
              $ProductCreate .= ', product_meta_title = "' . mysqli_real_escape_string($con, $productMetaTitle) . '"';
              $ProductCreate .= ', product_meta_keywords = "' . mysqli_real_escape_string($con, $productMetaKeyword) . '"';
              $ProductCreate .= ', product_meta_description = "' . mysqli_real_escape_string($con, $productMetaDesc) . '"';
              $ProductCreate .= ', product_tags = "' . mysqli_real_escape_string($con, $productTags) . '"';

              $CreateProductSql = "INSERT INTO products SET $ProductCreate";
              $ExecuteCreateProduct = mysqli_query($con, $CreateProductSql);
              $InsertedProductID = mysqli_insert_id($con);

              if ($ExecuteCreateProduct) {
                $arrayProductID[] = mysqli_insert_id($con);
              } else {
                if (DEBUG) {
                  $err = 'ExecuteCreateProduct Error: ' . mysqli_error($con);
                } else {
                  $err = 'ExecuteCreateProduct query failed';
                }
              }
            }
          }

          //now checking second sheet for new data
          $objWorksheet2 = $objPHPExcel->setActiveSheetIndex(1);
          $highestRow = $objWorksheet2->getHighestRow(); // e.g. 10

          $catProductID = 0;
          $categoryID = 0;

          for ($row = 2; $row <= $highestRow; ++$row) {

            $catProductID = $objWorksheet2->getCellByColumnAndRow(0, $row)->getValue();

            if (in_array($catProductID, $arrayProductID)) {

              $categoryID = $objWorksheet2->getCellByColumnAndRow(2, $row)->getValue();



              $addProductCategory = '';
              $addProductCategory .= ' PC_product_id  = "' . intval($catProductID) . '"';
              $addProductCategory .= ', PC_category_id = "' . intval($categoryID) . '"';

              $sqlAddProductCategory = "INSERT INTO product_categories SET $addProductCategory";
              $ExecuteAddProductCategory = mysqli_query($con, $sqlAddProductCategory);

              if (!$ExecuteAddProductCategory){
                if (DEBUG) {
                  $err = 'ExecuteAddProductCategory Error: ' . mysqli_error($con);
                } else {
                  $err = 'ExecuteAddProductCategory query failed.';
                }
              } else {
                
              }
            }
          }




          //now checking third sheet for new data
          $objWorksheet3 = $objPHPExcel->setActiveSheetIndex(2);
          $highestRow = $objWorksheet3->getHighestRow(); // e.g. 10

          $ProductID = 0;
          $productInventoryID = 0;
          $productInventoryTitle = '';
          $productInventorySizeID = 0;
          $productInventoryQuantity = 0;
          $productInventoryCost = 0;
          $productInventoryCurrentPrice = 0;
          $arrayProductInventoryID = array();

          for ($row = 2; $row <= $highestRow; ++$row) {

            $ProductID = $objWorksheet3->getCellByColumnAndRow(2, $row)->getValue();

            if (in_array($ProductID, $arrayProductID)) {

              $productInventoryID = $objWorksheet3->getCellByColumnAndRow(0, $row)->getValue();
              $productInventoryTitle = $objWorksheet3->getCellByColumnAndRow(1, $row)->getValue();
              $productInventorySizeID = $objWorksheet3->getCellByColumnAndRow(4, $row)->getValue();
              $productInventoryQuantity = $objWorksheet3->getCellByColumnAndRow(6, $row)->getValue();
              $productInventoryCost = $objWorksheet3->getCellByColumnAndRow(7, $row)->getValue();
              $productInventoryCurrentPrice = $objWorksheet3->getCellByColumnAndRow(9, $row)->getValue();



              $addProductInventory = '';
              $addProductInventory .= ' PI_id  = "' . intval($productInventoryID) . '"';
              $addProductInventory .= ', PI_inventory_title = "' . mysqli_real_escape_string($con, $productInventoryTitle) . '"';
              $addProductInventory .= ', PI_product_id = "' . intval($ProductID) . '"';
              $addProductInventory .= ', PI_size_id = "' . intval($productInventorySizeID) . '"';
              $addProductInventory .= ', PI_quantity = "' . intval($productInventoryQuantity) . '"';
              $addProductInventory .= ', PI_cost = "' . floatval($productInventoryCost) . '"';
              $addProductInventory .= ', PI_current_price = "' . floatval($productInventoryCurrentPrice) . '"';

              $sqlAddProductInventory = "INSERT INTO product_inventories SET $addProductInventory";
              $ExecuteAddProductInventory = mysqli_query($con, $sqlAddProductInventory);

              if ($ExecuteAddProductInventory) {
                $arrayProductInventoryID[] = mysqli_insert_id($con);
              } else {
                if (DEBUG) {
                  $err = 'ExecuteAddProductInventory Error: ' . mysqli_error($con);
                } else {
                  $err = 'ExecuteAddProductInventory query failed.';
                }
              }
            }
          }






          //now checking forth sheet for new data
          $objWorksheet4 = $objPHPExcel->setActiveSheetIndex(3);
          $highestRow = $objWorksheet4->getHighestRow(); // e.g. 10

          $ProductID = 0;
          $sizeID = 0;
          $sizeTitle = 0;

          for ($row = 2; $row <= $highestRow; ++$row) {

            $ProductID = $objWorksheet4->getCellByColumnAndRow(2, $row)->getValue();

            if (in_array($ProductID, $arrayProductID)) {

              $sizeID = $objWorksheet4->getCellByColumnAndRow(0, $row)->getValue();
              $sizeTitle = $objWorksheet4->getCellByColumnAndRow(1, $row)->getValue();



              $addProductSize = '';
              $addProductSize .= ' PS_size_title  = "' . mysqli_real_escape_string($con, $sizeTitle) . '"';
              $addProductSize .= ', PS_size_id = "' . intval($sizeID) . '"';
              $addProductSize .= ', PS_product_id = "' . intval($ProductID) . '"';

              $sqlAddProductSize = "INSERT INTO product_sizes SET $addProductSize";
              $ExecuteAddProductSize = mysqli_query($con, $sqlAddProductSize);

              if (!$ExecuteAddProductSize){
                if (DEBUG) {
                  $err = 'ExecuteAddProductSize Error: ' . mysqli_error($con);
                } else {
                  $err = 'ExecuteAddProductSize query failed.';
                }
              } else {
                
              }
            }
          }




          //now checking fifth sheet for new data
          $objWorksheet5 = $objPHPExcel->setActiveSheetIndex(4);
          $highestRow = $objWorksheet5->getHighestRow(); // e.g. 10

          $ProductID = 0;
          $sizeID = 0;
          $sizeTitle = 0;

          for ($row = 2; $row <= $highestRow; ++$row) {

            $ProductInvID = $objWorksheet5->getCellByColumnAndRow(2, $row)->getValue();

            if (in_array($ProductInvID, $arrayProductInventoryID)) {

              $supplierID = $objWorksheet5->getCellByColumnAndRow(0, $row)->getValue();
              $ProductCost = $objWorksheet5->getCellByColumnAndRow(4, $row)->getValue();



              $addProductSupplier = '';
              $addProductSupplier .= ' SI_supplier_id  = "' . intval($supplierID) . '"';
              $addProductSupplier .= ', SI_product_inventory_id  = "' . intval($ProductInvID) . '"';
              $addProductSupplier .= ', SI_product_cost = "' . floatval($ProductCost) . '"';

              $sqlAddProductSupplier = "INSERT INTO supplier_inventories SET $addProductSupplier";
              $ExecuteAddProductSupplier = mysqli_query($con, $sqlAddProductSupplier);

              if (!$ExecuteAddProductSupplier){
                if (DEBUG) {
                  $err = 'ExecuteAddProductSize Error: ' . mysqli_error($con);
                } else {
                  $err = 'ExecuteAddProductSize query failed.';
                }
              } else {
                
              }
            }
          }
          
          
          
          if($err == ""){
            $msg = "Product uploaded from excel file successfully";
          }
        }
      } else {
        echo "File upload failed.";
      }
    } else {
      echo "Wrong file type. Only Excel files.";
    }
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
        <title>Admin Panel | Product Module</title>

        <link href="<?php echo baseUrl('admin/css/main.css'); ?>" rel="stylesheet" type="text/css" /> 
        <script src="<?php echo baseUrl('admin/js/jquery.min.js'); ?>" type="text/javascript"></script>  
        <!--Start admin panel js/css --> 
        <?php include basePath('admin/header.php'); ?>   
        <!--End admin panel js/css -->    

   
    </head>

    <body>


        <?php include basePath('admin/top_navigation.php'); ?>

        <?php include basePath('admin/module_link.php'); ?>


        <!-- Content wrapper -->
        <div class="wrapper">

            <!-- Left navigation -->
            <?php include ('product_left_navigation.php'); ?>

            <!-- Content Start -->
            <div class="content">
                <div class="title"><h5>Product Upload Module</h5></div>

                <!-- Notification messages -->
                <?php include basePath('admin/message.php'); ?>

                <!-- Charts -->

                
                
                <div class="widget first">
                    <div class="head">
                        <h5 class="iGraph">Product Upload from Excel</h5></div>
                    <div class="body">
                        <div class="charts" style="width: 700px; height: auto;">
                          <form action="upload_product.php" method="post" class="mainForm" enctype="multipart/form-data">

                                <!-- Input text fields -->
                                <fieldset>
                                  <div class="widget first">
                                    <div class="head">
                                      <h5 class="iList">Upload from Excel</h5></div>
                                    
                                    <div class="rowElem noborder"><label>Upload Excel:</label><div class="formRight"><span id="sprytextfield3"><span id="sprytextfield4">
                                            <input type="file" name="excel" />
                                          </span></span></div><div class="fix"></div></div>    


                                    <input type="submit" name="upload" value="Submit Excel" class="greyishBtn submitForm" />
                                    <div class="fix"></div>

                                  </div>
                                </fieldset>

                            </form>		


                        </div>
                    </div>
                </div>
                
                
            </div>

        </div>
        </div>

        </div>
        <!-- Content End -->

        <div class="fix"></div>
        </div>

        <?php include basePath('admin/footer.php'); ?>

