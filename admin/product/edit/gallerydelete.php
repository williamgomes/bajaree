<?php

include ('../../../config/config.php');
$PI_id = 0;
$PI_product_id = 0;
$jsonArray = array();
$jsonArray['msg'] = '';
$jsonArray['error'] = '';
$product_gallery = '';
if (isset($_POST['PI_id'])) {
    extract($_POST);


    

//getting image path and unlinking
    // "SELECT * FROM product_images WHERE PI_id='$PI_id'";
    $unlinkimg = mysqli_query($con, "SELECT * FROM product_images WHERE PI_id='$PI_id'");
    $unlinkrow = mysqli_fetch_object($unlinkimg);



    /* Start : */
    $orderProductSql = "SELECT OP_id FROM order_products WHERE OP_product_inventory_id = " . intval($unlinkrow->PI_id) . " AND  OP_product_id= " . intval($unlinkrow->PI_product_id);
    $orderProductSqlResult = mysqli_query($con, $orderProductSql);
    if ($orderProductSqlResult) {
        $orderProductSqlResultRowObj = mysqli_fetch_object($orderProductSqlResult);
        if (isset($orderProductSqlResultRowObj->OP_id)) {
            $jsonArray['msg'] .= base64_encode('This color already added to order so you can not delete');
        }
    } else {
        if (DEBUG) {
            // echo 'orderProductSqlResult Error: '.  mysqli_error($con);
        } else {
            //echo 'orderProductSqlResult Fail ';
        }
        $jsonArray['error'] .= base64_encode('product order select query fail');
    }
    /* End : */
    if ($jsonArray['error'] == '') {
        $imgname = $unlinkrow->PI_file_name;
        
        unlink(basePath().'upload/product/original/' . $imgname); //deleting original image
        unlink(basePath().'upload/product/large/' . $imgname); //deleting large image
        unlink(basePath().'upload/product/mid/' . $imgname); //deleting medium image
        unlink(basePath().'upload/product/small/' . $imgname); //deleting small image
//deleting image details from db
        $delimg = mysqli_query($con, "DELETE FROM product_images WHERE PI_id='$PI_id'");

        /* delete inventory also dev faruk */
        /* Start: inventory delete */
        
        /*Reason for deleting inventory record against the image is because
          the system is able to upload multiple images against one inventory.
                So if we delete an inventory, corrosponding images will have no inventory id to go for and the system will collaps */
        
        
//        $inventoryDeleteSql = "DELETE FROM product_inventories WHERE PI_product_id =" . intval($unlinkrow->PI_product_id) . " AND PI_inventory_id=" . intval($unlinkrow->PI_inventory_id);
//        $inventoryDeleteSqlResult = mysqli_query($con, $inventoryDeleteSql);
//        if ($inventoryDeleteSqlResult) {
//            $jsonArray['msg'] .= base64_encode('Invenory deleted for the same color.');
//        } else {
//            if (DEBUG) {
//                //  echo 'inventoryDeleteSqlResult error '.  mysqli_error($con);
//            } else {
//                // echo 'inventoryDeleteSqlResult fail';
//            }
//
//            $jsonArray['error'] .= base64_encode('inventory Delete query fail');
//        }
        /* End: inventory delete */
        $jsonArray['product_gallery'] = '';
        //$jsonArray['product_colors'] = '';
        //$product_colors ='';
//getting images from db

        if ($delimg) {
            $selimage = mysqli_query($con, "SELECT * FROM product_images WHERE PI_product_id='$PI_product_id'");
            //echo $msg = 'Image deleted successfully';
            $jsonArray['msg'] .= base64_encode('Image deleted successfully');

            /** End: colors array * */
            $product_gallery.= '<ul>';

            while ($showimg = mysqli_fetch_object($selimage)) {

                $product_gallery.= '<li><a href = "' . baseUrl('upload/product/large/' . $showimg->PI_file_name) . '" data-lightbox = "roadtrip" title = ""><img src = "' . baseUrl('upload/product/small/' . $showimg->PI_file_name) . '" alt = "" height = "84px" width = "100px" /></a>';
                $product_gallery.= '<div class = "actions">';
                $product_gallery.= '<a href = ""><img src = "' . baseUrl('admin/images/edit.png') . '" alt = "" /></a>&nbsp;';
                $product_gallery.= '<a href = "javascript:delete_product_image(' . $showimg->PI_id . ',' . $showimg->PI_product_id . ')"><img src = "' . baseUrl('admin/images/delete.png') . '" alt = "" /></a>';
                $product_gallery.= '</div></li>';
            }
            $product_gallery.= '</ul>';
        } else {
            $selimage = mysqli_query($con, "SELECT * FROM product_images WHERE PI_product_id='$PI_product_id'");
            //$err = 'Image deleted successfully';
            $jsonArray['error'] .= base64_encode('Image deleted successfully');



            /** End: colors array * */
            $product_gallery.= '<ul>';

            while ($showimg = mysqli_fetch_object($selimage)) {

                $product_gallery.= '<li><a href = "' . baseUrl('upload/product/large/' . $showimg->PI_file_name) . '" data-lightbox = "roadtrip" title = ""><img src = "' . baseUrl('upload/product/small/' . $showimg->PI_file_name) . '" alt = "" height = "84px" width = "100px" /></a>';
                $product_gallery.= '<div class = "actions">';
                $product_gallery.= '<a href = ""><img src = "' . baseUrl('admin/images/edit.png') . '" alt = "" /></a>&nbsp;';
                $product_gallery.= '<a href = "javascript:delete_product_image(' . $showimg->PI_id . ',' . $showimg->PI_product_id . ')"><img src = "' . baseUrl('admin/images/delete.png') . '" alt = "" /></a>';
                $product_gallery.= '</div></li>';
            }
            $product_gallery.= '</ul>';
        }
    }

    $jsonArray['product_gallery'] = $product_gallery;
    //$jsonArray['product_colors']=$product_colors;
    echo json_encode($jsonArray);
}
?>