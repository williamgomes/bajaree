<?php
include ('../../config/config.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}
$aid = getSession('admin_id');

//checking for activation id
if (isset($_GET['actid'])) {
    $ActID = $_GET['actid'];
    $sqlActivate = "UPDATE cities SET city_status='allow' WHERE city_id=$ActID";
    $executeActivate = mysqli_query($con, $sqlActivate);
}

//checking for deactivation id
if (isset($_GET['inactid'])) {
    $InactID = $_GET['inactid'];
    $sqlInactivate = "UPDATE cities SET city_status='notallow' WHERE city_id=$InactID";
    $executeInactivate = mysqli_query($con, $sqlInactivate);
}


//getting all city from table
$arrayCity = array();
$sqlAllCity = "SELECT * FROM cities";
$executeAllCity = mysqli_query($con, $sqlAllCity);
if ($executeAllCity) {
    while ($getAllCity = mysqli_fetch_object($executeAllCity)) {
        $arrayCity[] = $getAllCity;
    }
} else {
    if (DEBUG) {
        echo "executeAllCity error: " . mysqli_error($con);
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
        <title>Admin Panel | City List</title>

        <?php include basePath('admin/header.php'); ?>


        <!--Effect on left error menu, top message menu, body-->
        <!-- Activation Script -->
        <script type="text/javascript">
            function active(pin_id) {
                jConfirm('You want to ACTIVATE this?', 'Confirmation Dialog', function(r) {
                    if (r) {
                        /*alert(r);*/
                        window.location.href = 'city_list.php?actid=' + pin_id;
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
                        window.location.href = 'city_list.php?inactid=' + pin_id;
                    }
                });
            }
        </script>
        <!--Deactivation Script -->



        <link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
        <link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
    </head>

    <body>


        <?php include basePath('admin/top_navigation.php'); ?>

        <?php include basePath('admin/module_link.php'); ?>


        <!-- Content wrapper -->
        <div class="wrapper">

            <!-- Left navigation -->
            <?php include ('country_left_navigation.php'); ?>

            <!-- Content Start -->
            <div class="content">
                <div class="title"><h5>Country Module</h5></div>

                <!-- Notification messages -->
                <?php include basePath('admin/message.php'); ?>

                <!-- Charts -->



                <div class="table">
                    <div class="head">
                        <h5 class="iFrames">City List</h5></div>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                        <thead>
                            <tr>
                                <th>City ID</th>
                                <th>Country Name</th>
                                <th>City Name</th>
                                <th>City Status</th>
                                <th>City Updated By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cityArrayCounter = count($arrayCity);
                            if ($cityArrayCounter > 0):
                                ?>          
                                <?php for ($i = 0; $i < $cityArrayCounter; $i++): ?>                   
                                    <tr class="gradeA">
                                        <td><?php echo $arrayCity[$i]->city_id; ?></td>
                                        <td>
                                            <?php
                                            $cid = $arrayCity[$i]->city_country_id;
                                            $GetCountry = mysqli_query($con, "SELECT * FROM countries WHERE country_id='$cid'");
                                            $SetCountry = mysqli_fetch_array($GetCountry);
                                            echo $SetCountry['country_name'];
                                            ?>
                                        </td>
                                        <td><?php echo $arrayCity[$i]->city_name; ?></td>
                                        <td class="center">
                                            <?php if ($arrayCity[$i]->city_status == 'allow') {
                                                echo '<a href="javascript:inactive(' . $arrayCity[$i]->city_id . ');"><img src="' . baseUrl('admin/images/customButton/on.png') . '" width="60" /></a>';
                                            } else {
                                                echo '<a href="javascript:active(' . $arrayCity[$i]->city_id . ');"><img src="' . baseUrl('admin/images/customButton/off.png') . '" width="60" /></a>';
                                            } ?>
                                        </td>
                                        <td><?php
                                            $adminid = $arrayCity[$i]->city_updated_by;
                                            $adminsql = mysqli_query($con, "SELECT (admin_full_name) FROM admins WHERE admin_id='$adminid'");
                                            $adminrow = mysqli_fetch_array($adminsql);
                                            echo $adminrow[0];
                                            ?></td>
                                        <td class="center"><a href="edit_city.php?cid=<?php echo base64_encode($arrayCity[$i]->city_id); ?>" title="Edit"><img src="<?php echo baseUrl('admin/images/pencil-grey-icon.png') ?>" height="14" width="14" alt="Edit" /></a>&nbsp;&nbsp;&nbsp;&nbsp;<!--<a href="javascript:del(<?php echo $GetCity['city_id']; ?>);"><img src="../images/delete.png" /></a>--></td>
                                    </tr>
    <?php endfor; /* $i=0; i<$adminArrayCounter; $++  */ ?>
<?php endif; /* count($adminArray) > 0 */ ?> 
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
        <script type="text/javascript">
            var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
            var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "custom", {pattern: "XXXX000000"});
            var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
            var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "currency");
        </script>
