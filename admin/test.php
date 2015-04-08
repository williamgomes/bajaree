<?php

include ('../config/config.php');
if (!is_dir($config['IMAGE_UPLOAD_PATH'] . '/product/original/merg/')) {
    mkdir($config['IMAGE_UPLOAD_PATH'] . '/product/original/merg/', 0777, TRUE);
}
if (!is_dir($config['IMAGE_UPLOAD_PATH'] . '/product/large/merg/')) {
    mkdir($config['IMAGE_UPLOAD_PATH'] . '/product/large/merg/', 0777, TRUE);
}
if (!is_dir($config['IMAGE_UPLOAD_PATH'] . '/product/mid/merg/')) {
    mkdir($config['IMAGE_UPLOAD_PATH'] . '/product/mid/merg/', 0777, TRUE);
}
if (!is_dir($config['IMAGE_UPLOAD_PATH'] . '/product/small/merg/')) {
    mkdir($config['IMAGE_UPLOAD_PATH'] . '/product/small/merg/', 0777, TRUE);
}
$sql = "SELECT * FROM `product_images`";
$sqlResult = mysqli_query($con, $sql);
if ($sqlResult) {
    while ($sqlResultRowObj = mysqli_fetch_object($sqlResult)) {

        // echo  $sqlResultRowObj->PI_file_name,'<br/>';
        $newName = $sqlResultRowObj->PI_product_id . '_' . $sqlResultRowObj->PI_id . '.' . pathinfo($sqlResultRowObj->PI_file_name, PATHINFO_EXTENSION);
        //  echo '<br>';

        $image_source = $config['IMAGE_UPLOAD_PATH'] . '/product/original/' . $sqlResultRowObj->PI_file_name;
        $image_target_path = $config['IMAGE_UPLOAD_PATH'] . '/product/original/merg/' . $newName;
        $status=array();
        $status[]= copy($image_source, $image_target_path);
        
        $image_source = $config['IMAGE_UPLOAD_PATH'] . '/product/large/' . $sqlResultRowObj->PI_file_name;
        $image_target_path = $config['IMAGE_UPLOAD_PATH'] . '/product/large/merg/' . $newName;
        $status[]= copy($image_source, $image_target_path);
        
        $image_source = $config['IMAGE_UPLOAD_PATH'] . '/product/mid/' . $sqlResultRowObj->PI_file_name;
        $image_target_path = $config['IMAGE_UPLOAD_PATH'] . '/product/mid/merg/' . $newName;
        $status[]= copy($image_source, $image_target_path);
        
        $image_source = $config['IMAGE_UPLOAD_PATH'] . '/product/small/' . $sqlResultRowObj->PI_file_name;
        $image_target_path = $config['IMAGE_UPLOAD_PATH'] . '/product/small/merg/' . $newName;
        $status[]= copy($image_source, $image_target_path);
           if (!in_array(0, $status)) {
            // printDie($status);
            $editsql = "UPDATE product_images SET PI_file_name='".$newName."' WHERE PI_id=".$sqlResultRowObj->PI_id;
            $editsqlResult = mysqli_query($con, $editsql);
            if ($editsqlResult) {
              
            }
        }else{
             printDie($sqlResultRowObj); 
        }
    }
}else{
    echo mysqli_error($con);
}
?>