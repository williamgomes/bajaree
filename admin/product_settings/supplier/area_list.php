<?php
include ('../../../config/config.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}
//saving tags in database
$aid = @getSession('admin_id'); //getting admin id
$supplierID = 0;

//checking for delete id
if (isset($_GET['del'])) {
    $DeleteID = $_GET['del'];
    $sqlDelete = "DELETE FROM supplier_areas WHERE SA_id=$DeleteID";
    $executeDelete = mysqli_query($con, $sqlDelete);
    $link = "area_list.php?sid=" . $_GET['sid'];
    redirect($link);
}

if(isset($_GET['sid']) AND $_GET['sid'] != ''){
  $supplierID = base64_decode($_GET['sid']);
}

$areas[] = array();

if (isset($_POST['submit'])) {
  
  extract($_POST);
  
  if (count($areas) == 0) {
    $err = "Area List is required.";
  } else {
    foreach($areas as $area){
      
      $addSupplierArea = '';
      $addSupplierArea .= ' SA_supplier_id = "' . mysqli_real_escape_string($con, $supplierID) . '"';
      $addSupplierArea .= ', SA_area_id = "' . mysqli_real_escape_string($con, $area) . '"';
      $addSupplierArea .= ', SA_updated_by = "' . mysqli_real_escape_string($con, $aid) . '"';
      
      $sqlAddSupplierArea = "INSERT INTO supplier_areas SET $addSupplierArea";
      $executeAddSupplierArea = mysqli_query($con,$sqlAddSupplierArea);
      if($executeAddSupplierArea){
        $msg = 'Area added successfully for the supplier.';
      } else {
        if(DEBUG){
          $err = 'executeAddSupplierArea error: ' . mysqli_error($con);
        } else {
          $err = 'executeAddSupplierArea query failed.';
        }
      }
    }
  }
}



$arrayAreas = array();
$sqlGetArea = "SELECT * FROM areas WHERE area_status='allow'";
$resultGetArea = mysqli_query($con, $sqlGetArea);
if($resultGetArea){
  while($resultGetAreaObj = mysqli_fetch_object($resultGetArea)){
    $arrayAreas[] = $resultGetAreaObj;
  }
} else {
  if(DEBUG){
     $err = "resultGetArea error: " . mysqli_error($con);
  } else {
    $err = "resultGetArea query failed.";
  }
}



$arraySupplierArea = array();
$arrayAllArea = array();
$sqlGetSupplierArea = "SELECT * FROM supplier_areas 
                      LEFT JOIN areas ON area_id=SA_area_id
                      LEFT JOIN admins ON admin_id=SA_updated_by
                      WHERE SA_supplier_id=$supplierID";
$resultGetSupplierArea = mysqli_query($con, $sqlGetSupplierArea);
if($resultGetSupplierArea){
  while($resultGetSupplierAreaObj = mysqli_fetch_object($resultGetSupplierArea)){
    $arraySupplierArea[] = $resultGetSupplierAreaObj;
    $arrayAllArea[] = $resultGetSupplierAreaObj->SA_area_id;
  }
} else {
  if(DEBUG){
     $err = "resultGetSupplierArea error: " . mysqli_error($con);
  } else {
    $err = "resultGetSupplierArea query failed.";
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
        <title>Admin Panel | Suppliers</title>

        <link href="<?php echo baseUrl('admin/css/main.css'); ?>" rel="stylesheet" type="text/css" /> 
        <script src="<?php echo baseUrl('admin/js/jquery.min.js'); ?>" type="text/javascript"></script>  
        <!--Start admin panel js/css --> 
        <?php include basePath('admin/header.php'); ?>   
        <!--End admin panel js/css -->    
        
       
        <!--end delete tags-->
        <script type="text/javascript">
            function del(pin_id) {
                jConfirm('You want to DELETE this?', 'Confirmation Dialog', function(r) {
                    if (r) {
                        /*alert(r);*/
                        window.location.href = 'area_list.php?<?php echo $_SERVER['QUERY_STRING']; ?>&del=' + pin_id;
                    }
                });
            }
        </script>
        <!--end delete tags-->


    </head>

    <body>

<?php include basePath('admin/top_navigation.php'); ?>

        <?php include basePath('admin/module_link.php'); ?>


        <!-- Content wrapper -->
        <div class="wrapper">

            <!-- Left navigation -->
<?php include basePath('admin/product_settings/product_settings_left_navigation.php'); ?>

            <!-- Content Start -->
            <div class="content">
                <div class="title"><h5>Supplier Module</h5></div>

                <!-- Notification messages -->
<?php include basePath('admin/message.php'); ?>

                <!-- Charts -->
                <div class="widget first">
                    <div class="head">
                        <h5 class="iGraph">Supplier</h5></div>
                    <div class="body">
                        <div class="charts" style="width: 700px; height: auto;">
                            <form action="area_list.php?sid=<?php echo $_GET['sid']; ?>" method="post" class="mainForm" enctype="multipart/form-data" >

                                <!-- Input text fields -->
                                <fieldset>
                                    <div class="widget first">
                                      
                                        <div class="head"><h5 class="iList">Assign Area</h5></div>
                                        <div class="rowElem noborder">
                                            <label>Area List:</label>
                                            <div class="formRight">
                                              <select multiple style="height: 200px; width: 260px;" name="areas[]">
                                                <option value=""> -- HOLD [CTRL] TO SELECT MULTIPLE -- </option>
<?php
$countArrayArea = count($arrayAreas);
if($countArrayArea > 0):
  for($x = 0; $x < $countArrayArea; $x++):
    if(!in_array($arrayAreas[$x]->area_id, $arrayAllArea)):
    ?>                                          
                                                <option value="<?php echo $arrayAreas[$x]->area_id; ?>"
                                                        ><?php echo $arrayAreas[$x]->area_name; ?></option>
     <?php
     endif;
  endfor;
endif;
?>                                                  
                                                
                                              </select>
                                            </div>
                                        </div>
                                        <div class="fix"></div>
                                        
                                        
                                        <input type="submit" name="submit" value="Assign Areas" class="greyishBtn submitForm" />
                                        <div class="fix"></div>


                                    </div>
                                </fieldset>

                            </form>		


                        </div>
                      
                      
                      
                      
                        <div class="table">
                            <div class="head">
                                <h5 class="iFrames">Supplier List</h5></div>
                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                <thead>
                                    <tr>
                                        <th>Area Name</th>
                                        <th>Updated</th>
                                        <th>Updated By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php
$countSupplierArea = count($arraySupplierArea);
if($countSupplierArea > 0):
  for($y = 0; $y < $countSupplierArea; $y++):
    ?>
                                  <tr class="gradeA">
                                            <td><?php echo $arraySupplierArea[$y]->area_name; ?></td>
                                            <td><?php echo $arraySupplierArea[$y]->SA_updated; ?></td>
                                            <td><?php echo $arraySupplierArea[$y]->admin_full_name; ?></td>
                                            <td class="center"><a href="javascript:del(<?php echo $arraySupplierArea[$y]->SA_id; ?>);"><img src="<?php echo baseUrl('admin/images/deleteFile.png');?>" height="14" width="14" /></a></td>
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

        </div>
        <!-- Content End -->

        <div class="fix"></div>
        </div>

<?php include basePath('admin/footer.php'); ?>