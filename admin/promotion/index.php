<?php
include ('../../config/config.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}


//checking for activation id
if (isset($_GET['actid'])) {
    $ActID = $_GET['actid'];
    $sqlActivate = "UPDATE promotions SET promotion_status='active' WHERE promotion_id=$ActID";
    $executeActivate = mysqli_query($con, $sqlActivate);
}

//checking for deactivation id
if (isset($_GET['inactid'])) {
    $InactID = $_GET['inactid'];
    $sqlInactivate = "UPDATE promotions SET promotion_status='inactive' WHERE promotion_id=$InactID";
    $executeInactivate = mysqli_query($con, $sqlInactivate);
}

$promotionArray = array();
$promotionSql = "SELECT * FROM promotions ORDER BY promotion_id DESC";
$promotionSqlResult = mysqli_query($con, $promotionSql);
if ($promotionSqlResult) {
    while ($promotionSqlResultRowObj = mysqli_fetch_object($promotionSqlResult)) {
        $promotionArray[] = $promotionSqlResultRowObj;
    }
    mysqli_free_result($promotionSqlResult);
} else {
    if (DEBUG) {
        echo 'promotionSqlResult Error : ' . mysqli_errno($con);
    }
}


//getting all promotion codes from database
$arrayPromotionCode = array();
$sqlAllCode = "SELECT * FROM promotion_codes";
$executeAllCode = mysqli_query($con, $sqlAllCode);
if ($executeAllCode) {
    while ($getAllCode = mysqli_fetch_object($executeAllCode)) {
        $arrayPromotionCode[$getAllCode->PC_promotion_id][] = $getAllCode;
    }
} else {
    if (DEBUG) {
        echo "executeAllCode error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
        <title>Admin panel | Promotion list</title>

        <link href="<?php echo baseUrl('admin/css/main.css'); ?>" rel="stylesheet" type="text/css" /> 
        <script src="<?php echo baseUrl('admin/js/jquery.min.js'); ?>" type="text/javascript"></script>  
        <!--Start admin panel js/css --> 
        <?php include basePath('admin/header.php'); ?>   
        <!--End admin panel js/css -->    


        <!-- Activation Script -->
        <script type="text/javascript">
            function active(pin_id) {
                jConfirm('You want to ACTIVATE this?', 'Confirmation Dialog', function(r) {
                    if (r) {
                        /*alert(r);*/
                        window.location.href = 'index.php?actid=' + pin_id;
                    }
                });
            }
        </script>
        <!--Activation Script -->

        <!-- Deactivation Script -->
        <script type="text/javascript">
            function inactive(pin_id) {
                jConfirm('You want to DEACTIVATE this?', 'Confirmation Dialog', function(r) {
                    if (r) {
                        /*alert(r);*/
                        window.location.href = 'index.php?inactid=' + pin_id;
                    }
                });
            }
        </script>
        <!--Deactivation Script -->        

    </head>

    <body>

        <?php include basePath('admin/top_navigation.php'); ?>

        <?php include basePath('admin/module_link.php'); ?>


        <!-- Content wrapper -->
        <div class="wrapper">

            <!-- Left navigation -->
            <?php include 'promotion_left_navigation.php'; ?>

            <!-- Content Start -->
            <div class="content">




                <div class="title"><h5> Promotion Module </h5></div>

                <!-- Notification messages -->
                <?php include basePath('admin/message.php'); ?>
                <!-- Charts -->
                <div class="table">
                    <div class="head"><h5 class="iFrames">Promotion List</h5></div>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Expire Date</th>
                                <th>Discount Type</th>
                                <th>Status</th>
                                <th>Code List</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $promotionArrayCounter = count($promotionArray);
                            if ($promotionArrayCounter > 0):
                                ?>
    <?php for ($i = 0; $i < $promotionArrayCounter; $i++): ?>
                                    <tr class="gradeA">
                                        <td><?php echo $promotionArray[$i]->promotion_title; ?></td>
                                        <td><?php echo $promotionArray[$i]->promotion_expire; ?></td>
                                        <td><?php echo $promotionArray[$i]->promotion_discount_type; ?></td>
                                        <td class="center">
        <?php if ($promotionArray[$i]->promotion_status == 'active') {
            echo '<a href="javascript:inactive(' . $promotionArray[$i]->promotion_id . ');"><img src="' . baseUrl('admin/images/customButton/on.png') . '" width="60" /></a>';
        } else {
            echo '<a href="javascript:active(' . $promotionArray[$i]->promotion_id . ');"><img src="' . baseUrl('admin/images/customButton/off.png') . '" width="60" /></a>';
        } ?>
                                        </td>
                                        <td class="center">
                                            <?php
                                            $countArrayCode = 0;
                                            if (isset($arrayPromotionCode[$promotionArray[$i]->promotion_id])) {
                                                $countArrayCode = count($arrayPromotionCode[$promotionArray[$i]->promotion_id]);
                                                if ($countArrayCode > 0) {
                                                    ?>
                                                    <a href="code_list.php?pid=<?php echo base64_encode($promotionArray[$i]->promotion_id); ?>"><img src="<?php echo baseUrl('admin/images/icons/custom/expand.png') ?>" height="14" width="14" alt="Edit" /></a>
                                                    <?php
                                                }
                                            } else {
                                                echo 'No code list';
                                            }
                                            ?>
                                        </td>
                                        <td class="center">

                                            <a href="promotion_edit.php?pid=<?php echo base64_encode($promotionArray[$i]->promotion_id); ?>"><img src="<?php echo baseUrl('admin/images/pencil-grey-icon.png') ?>" height="14" width="14" alt="Edit" /></a>

                                        </td>
                                    </tr>
    <?php endfor; /* $i=0; i<$adminArrayCounter; $++  */ ?>
<?php endif; /* count($adminArray) > 0 */ ?>


                        </tbody>
                    </table>
                </div>

            </div>


            <!-- Content End -->

            <div class="fix"></div>
        </div>

<?php include basePath('admin/footer.php'); ?>
