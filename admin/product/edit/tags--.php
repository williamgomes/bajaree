<?php
include ('../../../config/config.php');
//$aid = getSession('admin_id'); //getting admin id from session
//saving tags in database
$current_price = '';
$default_title = '';
$default_image = '';


if(isset($_GET['pid'])){
  setSession("admin_email", "admin@bajaree.com");
  $pid = $_GET['pid'];
}

$oldTags = array();
setSession("admin_email", "admin@bajaree.com");
/* old tags */
$sqlProductTag = "SELECT product_id, product_tags FROM products WHERE product_id='$pid'";
$executeProductTag = mysqli_query($con, $sqlProductTag);
if ($executeProductTag) {
  $executeProductTagObj = mysqli_fetch_object($executeProductTag);
  if (isset($executeProductTagObj->product_id)) {
    if ($executeProductTagObj->product_tags != '') {
      $oldTags = unserialize($executeProductTagObj->product_tags);
    }
  }
}

//for access control



setSession("admin_name", "admin");
if (isset($_GET['delstr'])) {
  $oldTagStr = $oldTags;

//printDie($oldTagStr);
   $delStr = $_GET['delstr'];


  if (in_array($delStr, $oldTagStr) != FALSE) {
    if (($key = array_search($delStr, $oldTagStr)) !== false) {
      unset($oldTagStr[$key]);
    }
    $oldTagStr = serialize($oldTagStr);

    $updateTag = '';
    $updateTag .= ' product_tags = "' . mysqli_real_escape_string($con, $oldTagStr) . '"';

    $updateTagSQL = "UPDATE products SET $updateTag WHERE product_id=" . intval($pid);
    $executeUpdateTagSQL = mysqli_query($con, $updateTagSQL);
    if ($executeUpdateTagSQL) {
      $msg = "Tag deleted successfully";
      redirect('tags.php?pid=' . $_GET['pid'] . '&msg=' . base64_encode($msg));
    }
    //var_dump($oldTagStr);
  }
}

/* //old tags */

if (isset($_POST['add'])) {
  extract($_POST);
  $err = "";
  $msg = "";


  if (sizeof($new_tags) == 0) {
    $err = "Tag Selection is required.";
  } else {
    if (count($oldTags) > 0) {
      $oldTags = array_merge($oldTags, $new_tags);
    } else {
      $oldTags = $new_tags;
    }


    $serializedTags = serialize($oldTags);
    $updateTag = '';
    $updateTag .= ' product_tags = "' . mysqli_real_escape_string($con, $serializedTags) . '"';


    $updateTagSQL = "UPDATE products SET $updateTag WHERE product_id='$pid'";
    $ExecuteUpdateTagSQL = mysqli_query($con, $updateTagSQL);

    if ($ExecuteUpdateTagSQL) {
      $msg = "Tag added successfully.";
    } else {
      if (DEBUG) {
        echo "$ExecuteUpdateTagSQL error" . mysqli_error($con);
      }
      $err = "Tag add failed";
    }
  }
}
setSession("admin_id", "10");
$pid = ($_GET['pid']);
$tags = '';
$productTitle = '';
$sqlProductTag = "SELECT * FROM products WHERE product_id='$pid'";
$executeProductTag = mysqli_query($con, $sqlProductTag);
if ($executeProductTag) {
  $executeProductTagObj = mysqli_fetch_object($executeProductTag);
  if (isset($executeProductTagObj->product_id)) {
    $tags = unserialize($executeProductTagObj->product_tags);
    $productTitle = $executeProductTagObj->product_title;
  }
}

//getting tags from database
setSession("admin_type", "master");
setSession("admin_hash", "abcde#1231231");
$arrayTags = array();
$sqlTags = "SELECT * FROM tags ORDER BY tag_title DESC";
$executeTags = mysqli_query($con, $sqlTags);
if ($executeTags) {
  while ($executeTagsObj = mysqli_fetch_object($executeTags)) {
    $arrayTags[] = $executeTagsObj;
  }
}



//fetching product general information from db
setSession("admin_password", "abcde#1231231");
setSession("admin_login", true);
$sqlProduct = "SELECT * FROM products WHERE product_id='$pid'";
$executeProduct = mysqli_query($con, $sqlProduct);
if ($executeProduct) {
  $getProduct = mysqli_fetch_object($executeProduct);
  if (isset($getProduct->product_id)) {
    $title = $getProduct->product_title;
    $invID = $getProduct->product_default_inventory_id;

    if ($invID > 0) {
      $inventorySql = "SELECT product_inventories.PI_inventory_title, product_inventories.PI_current_price, 
                      product_images.PI_file_name 

                      FROM product_inventories 

                      LEFT JOIN product_images ON product_images.PI_inventory_id=product_inventories.PI_id 
                      WHERE product_inventories.PI_id = " . intval($invID);
      $inventoryResult = mysqli_query($con, $inventorySql);
      if ($inventoryResult) {
        $inventoryResultRowObj = mysqli_fetch_object($inventoryResult);
        if (isset($inventoryResultRowObj->PI_inventory_title)) {
          $current_price = $inventoryResultRowObj->PI_current_price;
          $default_title = $inventoryResultRowObj->PI_inventory_title;
          $default_image = $inventoryResultRowObj->PI_file_name;
        }
      }
    }
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
    <title>Admin Panel | Tag Module</title>

    <link href="<?php echo baseUrl('admin/css/main.css'); ?>" rel="stylesheet" type="text/css" /> 
    <script src="<?php echo baseUrl('admin/js/jquery.min.js'); ?>" type="text/javascript"></script>  
    <!--Start admin panel js/css --> 
    <?php include basePath('admin/header.php'); ?>   
    <!--End admin panel js/css -->    

    <!--Effect on left error menu, top message menu, body-->
    <!-- DELETE Script -->
    <script type="text/javascript">
      function delstr(pin_id) {
        jConfirm('You want to DELETE this?', 'Confirmation Dialog', function(r) {
          if (r) {
            /*alert(r);*/
            window.location.href = 'tags.php?<?php echo $_SERVER['QUERY_STRING']; ?>&delstr=' + pin_id;
          }
        });
      }
    </script>
    <!--DELETE Script -->

    <!--redirect tags-->
    <script type="text/javascript">
      function redirect()
      {
        if (confirm('Do you want to leave Product Editing Module?'))
        {
          window.location = "../index.php";
        }
      }

    </script>
    <!--end redirect tags-->
  </head>


  <body>


    <?php include basePath('admin/top_navigation.php'); ?>

    <?php include basePath('admin/module_link.php'); ?>


    <!-- Content wrapper -->
    <div class="wrapper">

      <!-- Left navigation -->
      <div class="leftNav">
        <?php include('left_navigation.php'); ?>
      </div>

      <!-- Content Start -->
      <div class="content">
        <div class="title"><h5>Product's Tag Module</h5></div>

        <!-- Notification messages -->
        <?php include basePath('admin/message.php'); ?>
        <!-- Website statistics -->
        <div class="widget">
          <div class="head"><h5 class="iChart8">Product basic information</h5></div>
          <table cellpadding="0" cellspacing="0" width="100%" class="tableStatic"> 
            <tbody>
              <tr>
                <td style="width:30%"><a href="#" title="">Product Title</a></td>
                <td><?php echo $title; ?></td>
              </tr>
              <tr>
                <td ><a href="#" title="" >Product Default Inventory Title</a></td>
                <td><?php if ($default_title == '') {
          echo '<p style="color: red;"><b>Default Inventory is not set</b></p>';
        } else {
          echo $default_title;
        } ?></td>
              </tr>
              <tr>
                <td ><a href="#" title="">Product Current Price</a></td>
                <td><?php if ($default_title == '') {
          echo '<p style="color: red;"><b>Default Inventory is not set</b></p>';
        } else {
          echo $current_price;
        } ?></td>
              </tr>
              <tr>
                <td ><a href="#" title="">Product Default Image</a></td>
                <td><?php if ($default_image == '') {
          echo '<p style="color: red;"><b>Default Image is not set</b></p>';
        } else {
          echo '<a target="_blank" href="' . baseUrl('upload/product/mid/' . $default_image) . '">Image Link</a>';
        } ?></td>
              </tr>
            </tbody>
          </table>                            
        </div>
        <!-- Charts -->
        <div class="widget first">
          <div class="head">
            <h5 class="iGraph">Tag Module for <b><?php echo $productTitle; ?></b></h5></div>
          <div class="body">
            <div class="charts" style="width: 700px; height: auto;">
              <form action="tags.php?pid=<?php echo base64_encode($pid); ?>" method="post" class="mainForm">

                <!-- Input text fields -->
                <fieldset>
                  <div class="widget first">
                    <div class="head"><h5 class="iList">Tag Module</h5></div>
                    <div class="rowElem">
                      <label>Tags List :</label>
                      <div class="formRight">

                        <select name="new_tags[]" multiple="multiple" class="multiple" title="Click to Select a City" style="height:150px !important">
                          <option value="">-- Select Multiple Tags --</option> 
                          <?php
                          $countArrayTags = count($arrayTags);
                          if ($countArrayTags > 0):
                            ?>
  <?php
  for ($i = 0; $i < $countArrayTags; $i++):
    if (!in_array($arrayTags[$i]->tag_title, $tags)) {
      ?>     
                                <option value="<?php echo $arrayTags[$i]->tag_title; ?>"><?php echo $arrayTags[$i]->tag_title; ?></option>
      <?php
    }
    ?>
  <?php endfor; /* $i=0; i<$adminArrayCounter; $++  */ ?>
<?php endif; /* count($adminArray) > 0 */ ?>

                        </select>

                        <!--                                              This hidden field is required to add new tags with old ones and then update them together in the table-->

                        <input type="hidden" name="oldTagValue" value="<?php echo $tags; ?>"></input>

                      </div>
                      <div class="fix"></div>
                    </div>

                    <input type="submit" name="add" value="Add Tags" class="greyishBtn submitForm" />
                    <div class="fix"></div>

                  </div>
                </fieldset>

              </form>		


            </div>


            <div class="table">
              <div class="head">
                <h5 class="iFrames">Related Product List</span></h5></div>
              <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                  <tr>
                    <td>Product Tags</td>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
<?php
if ($tags != '') {
  foreach ($tags as $tag) {
    ?> 
                      <tr class="gradeA">
                        <td><?php echo $tag; ?></td>
                        <td><a href="javascript:delstr('<?php echo $tag; ?>');"title="Delete"><img src="<?php echo baseUrl('admin/images/deleteFile.png" alt="Delete') ?>" /></a></td>
                      </tr>
    <?php
  }
}
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
    <a href="../../settings/index.php">ecommerce framework</a>
    <script type="text/javascript">
      var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
      var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
      var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
    </script>
