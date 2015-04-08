<?php
include ('../../config/config.php');
require_once '../../lib/excel/PHPExcel.php';//including phpexcel library

/*function for generating product sheet*/
//your request

/** Include PHPExcel */


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();




/*------------------------setting data for product sheet---------------------------------*/

////query for generating product list from database
//$sqlGetProduct="SELECT * FROM products ORDER BY product_id ASC";
//$resultGetProduct=mysqli_query($con, $sqlGetProduct);//get the result (ressource)
//
//$objPHPExcel->setActiveSheetIndex(0); //setting sheet index
//$objPHPExcel->getActiveSheet()->setTitle('Product List'); //renaming current sheet
//$getCellValueSheet1=$objPHPExcel->getActiveSheet();
//
////creating an bold style for cells
//$styleArray = array(
//'font' => array(
//'bold' => true
//));
//
//$getCellValueSheet1->setCellValue('A1', 'product_id')
//                    ->setCellValue('B1', 'product_title')
//                      ->setCellValue('C1', 'product_short_description')
//                        ->setCellValue('D1', 'product_long_description')
//                          ->setCellValue('E1', 'product_is_express')
//                            ->setCellValue('F1', 'product_sku')
//                              ->setCellValue('G1', 'product_meta_title')
//                                ->setCellValue('H1', 'product_meta_keywords')
//                                  ->setCellValue('I1', 'product_meta_description')
//                                    ->setCellValue('J1', 'product_tags')
//                                      ->setCellValue('K1', 'product_avg_rating');//write in the sheet
//
////applying bold font style to necessary cells
//$getCellValueSheet1->getStyle('A1')->applyFromArray($styleArray);
//$getCellValueSheet1->getStyle('B1')->applyFromArray($styleArray);
//$getCellValueSheet1->getStyle('C1')->applyFromArray($styleArray);
//$getCellValueSheet1->getStyle('D1')->applyFromArray($styleArray);
//$getCellValueSheet1->getStyle('E1')->applyFromArray($styleArray);
//$getCellValueSheet1->getStyle('F1')->applyFromArray($styleArray);
//$getCellValueSheet1->getStyle('G1')->applyFromArray($styleArray);
//$getCellValueSheet1->getStyle('H1')->applyFromArray($styleArray);
//$getCellValueSheet1->getStyle('I1')->applyFromArray($styleArray);
//$getCellValueSheet1->getStyle('J1')->applyFromArray($styleArray);
//$getCellValueSheet1->getStyle('K1')->applyFromArray($styleArray);
//
//
//$Line=2; //starting from second row as first row contains column names
//$arrayTags = array();
//
//while($resultGetProductObj=mysqli_fetch_object($resultGetProduct)){//extract each record
//  $tags = '';
//  if($resultGetProductObj->product_tags != ''){
//    $arrayTags = unserialize($resultGetProductObj->product_tags);
//    if(count($arrayTags) > 0){
//      $tags = implode(', ', $arrayTags);
//    }
//  }
//  
//  $getCellValueSheet1->setCellValue('A'.$Line, $resultGetProductObj->product_id)
//                      ->setCellValue('B'.$Line, $resultGetProductObj->product_title)
//                        ->setCellValue('C'.$Line, $resultGetProductObj->product_short_description)
//                          ->setCellValue('D'.$Line, $resultGetProductObj->product_long_description)
//                            ->setCellValue('E'.$Line, $resultGetProductObj->product_is_express)
//                              ->setCellValue('F'.$Line, $resultGetProductObj->product_sku)
//                                ->setCellValue('G'.$Line, $resultGetProductObj->product_meta_title)
//                                  ->setCellValue('H'.$Line, $resultGetProductObj->product_meta_keywords)
//                                    ->setCellValue('I'.$Line, $resultGetProductObj->product_meta_description)
//                                      ->setCellValue('J'.$Line, $tags)
//                                        ->setCellValue('K'.$Line, $resultGetProductObj->product_avg_rating);//write in the sheet
//    ++$Line;
//}
//

/*--------------------------setting data for product sheet----------------------------------*/




/*---------------------------setting data for category sheet---------------------------------*/

//query for generating product list from database
$sqlGetCategory="SELECT * FROM categories ORDER BY category_id ASC";
$resultGetCategory=mysqli_query($con, $sqlGetCategory);//get the result (ressource)

$objPHPExcel->createSheet(); //creating a new sheet
$objPHPExcel->setActiveSheetIndex(0); //setting sheet index
$objPHPExcel->getActiveSheet()->setTitle('Category List'); //renaming current sheet
$getCellValueSheet2=$objPHPExcel->getActiveSheet();
$styleArray = array(
'font' => array(
'bold' => true
));

$getCellValueSheet2->setCellValue('A1', 'category_id')
                    ->setCellValue('B1', 'category_name')
                      ->setCellValue('C1', 'category_description')
                          ->setCellValue('D1', 'category_priority');//write in the sheet

$getCellValueSheet2->getStyle('A1')->applyFromArray($styleArray);
$getCellValueSheet2->getStyle('B1')->applyFromArray($styleArray);
$getCellValueSheet2->getStyle('C1')->applyFromArray($styleArray);
$getCellValueSheet2->getStyle('D1')->applyFromArray($styleArray);

/*setting data for second sheet*/

$Line=2;//starting from second row as first row contains column names

if($resultGetCategory){
  while($resultGetCategoryObj=mysqli_fetch_object($resultGetCategory)){//extract each record
      $getCellValueSheet2->setCellValue('A'.$Line, $resultGetCategoryObj->category_id)
                          ->setCellValue('B'.$Line, $resultGetCategoryObj->category_name)
                            ->setCellValue('C'.$Line, $resultGetCategoryObj->category_description)
                              ->setCellValue('D'.$Line, $resultGetCategoryObj->category_priority);//write in the sheet
      ++$Line;
  }
} else {
  if(DEBUG){
    echo "resultGetCategory error: " . mysqli_error($con);
  }
}


/*----------------------------setting data for category sheet---------------------------*/









/*---------------------------setting data for size sheet---------------------------------*/

//query for generating product list from database
$sqlGetSize="SELECT * FROM sizes ORDER BY size_id ASC";
$resultGetSize=mysqli_query($con, $sqlGetSize);//get the result (ressource)

$objPHPExcel->createSheet(); //creating a new sheet
$objPHPExcel->setActiveSheetIndex(1); //setting sheet index
$objPHPExcel->getActiveSheet()->setTitle('Size List'); //renaming current sheet
$getCellValueSheet3=$objPHPExcel->getActiveSheet();
$styleArray = array(
'font' => array(
'bold' => true
));

$getCellValueSheet3->setCellValue('A1', 'size_id')
                    ->setCellValue('B1', 'size_title');//write in the sheet

$getCellValueSheet3->getStyle('A1')->applyFromArray($styleArray);
$getCellValueSheet3->getStyle('B1')->applyFromArray($styleArray);

/*setting data for second sheet*/

$Line=2;//starting from second row as first row contains column names

if($resultGetSize){
  while($resultGetSizeObj=mysqli_fetch_object($resultGetSize)){//extract each record
      $getCellValueSheet3->setCellValue('A'.$Line, $resultGetSizeObj->size_id)
                          ->setCellValue('B'.$Line, $resultGetSizeObj->size_title);//write in the sheet
      ++$Line;
  }
} else {
  if(DEBUG){
    echo "resultGetSize error: " . mysqli_error($con);
  }
}


/*----------------------------setting data for size sheet---------------------------*/







/*---------------------------setting data for product categories sheet---------------------------------*/

////query for generating product list from database
//$sqlGetProductCategory="SELECT * FROM product_categories 
//                LEFT JOIN products ON product_id=PC_product_id
//                LEFT JOIN categories ON category_id=PC_category_id
//                ORDER BY PC_id ASC";
//$resultGetProductCategory=mysqli_query($con, $sqlGetProductCategory);//get the result (ressource)
//
//$objPHPExcel->createSheet(); //creating a new sheet
//$objPHPExcel->setActiveSheetIndex(3); //setting sheet index
//$objPHPExcel->getActiveSheet()->setTitle('Category wise Product List'); //renaming current sheet
//$getCellValueSheet4=$objPHPExcel->getActiveSheet();
//$styleArray = array(
//'font' => array(
//'bold' => true
//));
//
//$getCellValueSheet4->setCellValue('A1', 'PC_product_id')
//                    ->setCellValue('B1', 'product_title')
//                      ->setCellValue('C1', 'PC_category_id')
//                          ->setCellValue('D1', 'category_name');//write in the sheet
//
//$getCellValueSheet4->getStyle('A1')->applyFromArray($styleArray);
//$getCellValueSheet4->getStyle('B1')->applyFromArray($styleArray);
//$getCellValueSheet4->getStyle('C1')->applyFromArray($styleArray);
//$getCellValueSheet4->getStyle('D1')->applyFromArray($styleArray);
//
///*setting data for second sheet*/
//
//$Line=2;//starting from second row as first row contains column names
//
//while($resultGetProductCategoryObj=mysqli_fetch_object($resultGetProductCategory)){//extract each record
//    $getCellValueSheet4->setCellValue('A'.$Line, $resultGetProductCategoryObj->PC_product_id)
//                        ->setCellValue('B'.$Line, $resultGetProductCategoryObj->product_title)
//                          ->setCellValue('C'.$Line, $resultGetProductCategoryObj->PC_category_id)
//                            ->setCellValue('D'.$Line, $resultGetProductCategoryObj->category_name);//write in the sheet
//    ++$Line;
//}
//
//
///*----------------------------setting data for product categories sheet---------------------------*/
//
//
//
//
//
//
///*---------------------------setting data for product inventories sheet---------------------------------*/
//
////query for generating product list from database
//$sqlGetProductInventory="SELECT * FROM product_inventories 
//                LEFT JOIN products ON product_id=PI_product_id
//                LEFT JOIN sizes ON size_id=PI_size_id
//                ORDER BY PI_id ASC";
//$resultGetProductInventory=mysqli_query($con, $sqlGetProductInventory);//get the result (ressource)
//
//$objPHPExcel->createSheet(); //creating a new sheet
//$objPHPExcel->setActiveSheetIndex(4); //setting sheet index
//$objPHPExcel->getActiveSheet()->setTitle('Product Inventory List'); //renaming current sheet
//$getCellValueSheet5=$objPHPExcel->getActiveSheet();
//$styleArray = array(
//'font' => array(
//'bold' => true
//));
//
//$getCellValueSheet5->setCellValue('A1', 'PI_inventory_title')
//                    ->setCellValue('B1', 'PI_product_id')
//                      ->setCellValue('C1', 'product_title')
//                        ->setCellValue('D1', 'PI_size_id')
//                          ->setCellValue('E1', 'size_title')
//                            ->setCellValue('F1', 'PI_quantity')
//                              ->setCellValue('G1', 'PI_cost')
//                                ->setCellValue('H1', 'PI_old_price')
//                                  ->setCellValue('I1', 'PI_current_price');//write in the sheet
//
//$getCellValueSheet5->getStyle('A1')->applyFromArray($styleArray);
//$getCellValueSheet5->getStyle('B1')->applyFromArray($styleArray);
//$getCellValueSheet5->getStyle('C1')->applyFromArray($styleArray);
//$getCellValueSheet5->getStyle('D1')->applyFromArray($styleArray);
//
///*setting data for second sheet*/
//
//$Line=2;//starting from second row as first row contains column names
//
//while($resultGetProductInventoryObj=mysqli_fetch_object($resultGetProductInventory)){//extract each record
//    $getCellValueSheet5->setCellValue('A'.$Line, $resultGetProductInventoryObj->PI_inventory_title)
//                        ->setCellValue('B'.$Line, $resultGetProductInventoryObj->PI_product_id)
//                          ->setCellValue('C'.$Line, $resultGetProductInventoryObj->product_title)
//                            ->setCellValue('D'.$Line, $resultGetProductInventoryObj->PI_size_id)
//                              ->setCellValue('E'.$Line, $resultGetProductInventoryObj->size_title)
//                                ->setCellValue('F'.$Line, $resultGetProductInventoryObj->PI_quantity)
//                                  ->setCellValue('G'.$Line, $resultGetProductInventoryObj->PI_cost)
//                                    ->setCellValue('H'.$Line, $resultGetProductInventoryObj->PI_old_price)
//                                      ->setCellValue('I'.$Line, $resultGetProductInventoryObj->PI_current_price);//write in the sheet
//    ++$Line;
//}
//
//
///*----------------------------setting data for product inventories sheet---------------------------*/
//
//
//
//
//
///*---------------------------setting data for product sizes sheet---------------------------------*/
//
////query for generating product list from database
//$sqlGetProductSize="SELECT * FROM product_sizes
//                LEFT JOIN products ON product_id=PS_product_id
//                LEFT JOIN sizes ON size_id=PS_size_id
//                ORDER BY PS_id ASC";
//$resultGetProductSize=mysqli_query($con, $sqlGetProductSize);//get the result (ressource)
//
//$objPHPExcel->createSheet(); //creating a new sheet
//$objPHPExcel->setActiveSheetIndex(5); //setting sheet index
//$objPHPExcel->getActiveSheet()->setTitle('Product Size List'); //renaming current sheet
//$getCellValueSheet6=$objPHPExcel->getActiveSheet();
//$styleArray = array(
//'font' => array(
//'bold' => true
//));
//
//$getCellValueSheet6->setCellValue('A1', 'PS_size_id')
//                    ->setCellValue('B1', 'size_title')
//                      ->setCellValue('C1', 'PS_product_id')
//                        ->setCellValue('D1', 'product_title');//write in the sheet
//
//$getCellValueSheet6->getStyle('A1')->applyFromArray($styleArray);
//$getCellValueSheet6->getStyle('B1')->applyFromArray($styleArray);
//$getCellValueSheet6->getStyle('C1')->applyFromArray($styleArray);
//$getCellValueSheet6->getStyle('D1')->applyFromArray($styleArray);
//
///*setting data for second sheet*/
//
//$Line=2;//starting from second row as first row contains column names
//
//while($resultGetProductSizeObj=mysqli_fetch_object($resultGetProductSize)){//extract each record
//    $getCellValueSheet6->setCellValue('A'.$Line, $resultGetProductSizeObj->PS_size_id)
//                        ->setCellValue('B'.$Line, $resultGetProductSizeObj->size_title)
//                          ->setCellValue('C'.$Line, $resultGetProductSizeObj->PS_product_id)
//                            ->setCellValue('D'.$Line, $resultGetProductSizeObj->product_title);//write in the sheet
//    ++$Line;
//}
//
//
///*----------------------------setting data for product sizes sheet---------------------------*/
//
//
//
//
//
//
///*---------------------------setting data for supplier inventory sheet---------------------------------*/
//
////query for generating product list from database
//$sqlGetSupplierInventory="SELECT * FROM supplier_inventories
//                LEFT JOIN suppliers ON supplier_id=SI_supplier_id
//                LEFT JOIN product_inventories ON PI_id=SI_product_inventory_id
//                ORDER BY SI_id ASC";
//$resultGetSupplierInventory=mysqli_query($con, $sqlGetSupplierInventory);//get the result (ressource)
//
//$objPHPExcel->createSheet(); //creating a new sheet
//$objPHPExcel->setActiveSheetIndex(6); //setting sheet index
//$objPHPExcel->getActiveSheet()->setTitle('Supplier Inventory List'); //renaming current sheet
//$getCellValueSheet7=$objPHPExcel->getActiveSheet();
//$styleArray = array(
//'font' => array(
//'bold' => true
//));
//
//$getCellValueSheet7->setCellValue('A1', 'SI_supplier_id')
//                    ->setCellValue('B1', 'supplier_name')
//                      ->setCellValue('C1', 'SI_product_inventory_id')
//                        ->setCellValue('D1', 'PI_inventory_title')
//                          ->setCellValue('E1', 'SI_product_cost');//write in the sheet
//
//$getCellValueSheet7->getStyle('A1')->applyFromArray($styleArray);
//$getCellValueSheet7->getStyle('B1')->applyFromArray($styleArray);
//$getCellValueSheet7->getStyle('C1')->applyFromArray($styleArray);
//$getCellValueSheet7->getStyle('D1')->applyFromArray($styleArray);
//$getCellValueSheet7->getStyle('E1')->applyFromArray($styleArray);
//
///*setting data for second sheet*/
//
//$Line=2;//starting from second row as first row contains column names
//
//while($resultGetSupplierInventoryObj=mysqli_fetch_object($resultGetSupplierInventory)){//extract each record
//    $getCellValueSheet7->setCellValue('A'.$Line, $resultGetSupplierInventoryObj->SI_supplier_id)
//                        ->setCellValue('B'.$Line, $resultGetSupplierInventoryObj->supplier_name)
//                          ->setCellValue('C'.$Line, $resultGetSupplierInventoryObj->SI_product_inventory_id)
//                            ->setCellValue('D'.$Line, $resultGetSupplierInventoryObj->PI_inventory_title)
//                              ->setCellValue('E'.$Line, $resultGetSupplierInventoryObj->SI_product_cost);//write in the sheet
//    ++$Line;
//}
//

/*----------------------------setting data for supplier inventory sheet---------------------------*/





// Redirect output to a client’s web browser (Excel5)
$now = date("d-m-Y_H.i.s");
$fileName = "NonRelated-Export-" . $now;
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'. $fileName .'.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
