<?php
include ('../../config/config.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}

$faq_question = '';
$faq_answer = '';
$faq_priority = '';


if (isset($_POST['faq_create']) AND $_POST['faq_create'] == 'Submit') {

    extract($_POST);
    if ($faq_question == '') {
        $err = 'FAQ  Question field is required!!';
    } elseif ($faq_priority == '') {
        $err = 'FAQ Priority field is required!!';
    } elseif (!is_numeric($faq_priority)) {
        $err = 'FAQ Priority should be numeric!!';
    } elseif ($faq_answer == '') {
        $err = 'FAQ Answer field is required!!';
    }
//    else{
//         /* Start :Checking the question already exist or not */
//        $faqSql = "SELECT faq_question FROM faq";
//        $faqSqlResult = mysqli_query($faqSql);
//        while($faqSqlResultRow = mysqli_fetch_array($faqSqlResult)){
//            echo $faqSqlResultRow['faq_question'];
//        }
//        
//        /* End :Checking the user already exist or not */
//    }
    if ($err == '') {

        $faqFiled = '';
        $faqFiled .=' faq_question = "' . mysqli_real_escape_string($con, $faq_question) . '"';
        $faqFiled .=', faq_answer ="' . htmlentities(mysqli_real_escape_string($con, $faq_answer)) . '"';
        $faqFiled .=', faq_priority ="' . intval($faq_priority) . '"';

        $faqInsSql = "INSERT INTO faq SET $faqFiled";
        $faqInsSqlResult = mysqli_query($con, $faqInsSql);
        if ($faqInsSqlResult) {
            //$msg = "FAQ information insert successfully";
            $link = baseUrl('admin/faq/index.php?msg=' . base64_encode('FAQ information insert successfully.'));
            redirect($link);
        } else {
            if (DEBUG) {
                echo 'faqInsSqlResult Error: ' . mysqli_error($con);
            }
            $err = "Insert Query failed.";
        }
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>   
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
        <title>Admin Panel | Product</title>   
        <?php include basePath('admin/header.php'); ?>          

    </head>

    <body>

        <?php include basePath('admin/top_navigation.php'); ?>

        <?php include basePath('admin/module_link.php'); ?>


        <!-- Content wrapper -->
        <div class="wrapper">

            <!-- Left navigation -->
            <?php include ('faq_left_navigation.php'); ?>

            <!-- Content Start -->
            <div class="content">
                <div class="title"><h5>FAQ Module</h5></div>

                <!-- Notification messages -->
                <?php include basePath('admin/message.php'); ?>
                <!-- Charts -->
                <div class="widget first">
                    <div class="head">
                        <h5 class="iGraph">Create FAQ </h5></div>
                    <div class="body">
                        <div class="charts" style="width: 700px; height: auto;">
                            <form action="<?php echo baseUrl('admin/faq/faq_create.php'); ?>" method="post" class="mainForm">

                                <!-- Input text fields -->
                                <fieldset>
                                    <div class="widget first">
                                        <div class="head"><h5 class="iList">FAQ Information</h5></div>
                                        <div class="rowElem noborder"><label> Question:</label><div class="formRight"><input type="text" name="faq_question" value="<?php echo $faq_question; ?>"  /></div><div class="fix"></div></div>
                                        <div class="rowElem noborder"><label> Priority:</label><div class="formRight"><input type="text" name="faq_priority" value="<?php echo $faq_priority; ?>"  /></div><div class="fix"></div></div>
                                        <div class="head"><h5 class="iPencil">Answer:</h5></div>      
                                        <div><textarea class="tm" rows="5" cols="" name="faq_answer"><?php echo $faq_answer; ?></textarea></div>

                                        <input type="submit" name="faq_create" value="Submit" class="greyishBtn submitForm" />
                                        <div class="fix"></div>
                                    </div>
                                </fieldset>
                            </form>


                        </div>
                    </div>
                </div>

            </div>
            <!-- Content End -->

            <div class="fix"></div>
        </div>

        <?php include basePath('admin/footer.php'); ?>
