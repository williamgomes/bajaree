<?php

/* ======================================================= EMAIL FUNCTIONS START =================================================== */

/**
 * This function used to send emails using PHP Mailer Class<br> 
 * @input: $UserEmail, $UserName, $ReplyToEmail, $EmailSubject, $EmailBody; return true/$status(if error)
 * used for signup.php 
 */
function sendEmailFunction($UserEmail = '', $UserName = '', $ReplyToEmail = '', $EmailSubject = '', $EmailBody = '') {

    global $config;
    $status = '';

    if ($UserEmail == '' OR $UserName == '' OR $EmailSubject == '' OR $EmailBody == '') {

        $status = "Parameters missing.";
    } else {
        require_once(basePath("lib/email/class.phpmailer.php"));
        $mail = new PHPMailer();
        $mail->Host = get_option('SMTP_SERVER_ADDRESS');
        $mail->Port = get_option('SMTP_PORT_NO');
        $mail->SMTPSecure = 'ssl';
        $mail->IsSMTP(); // send via SMTP
        $mail->SMTPDebug = 0;
        //IsSMTP(); // send via SMTP
        $mail->SMTPAuth = true; // turn on SMTP authentication
        $mail->Username = get_option('HOSTING_ID'); // Enter your SMTP username
        $mail->Password = get_option('HOSTING_PASS'); // SMTP password
        $webmaster_email = get_option('EMAIL_ADDRESS_GENERAL'); //Add reply-to email address
        $email = $UserEmail; // Add recipients email address
        $name = $UserName; // Add Your Recipient's name
        $mail->From = get_option('EMAIL_ADDRESS_GENERAL');
        $mail->FromName = get_option('EMAIL_ADDRESS_GENERAL');
        $mail->AddAddress($email, $name);
        $mail->AddReplyTo($ReplyToEmail, "Bajaree");
        //$mail->extension=php_openssl.dll;
        $mail->WordWrap = 50; // set word wrap
        /* $mail->AddAttachment("/var/tmp/file.tar.gz"); // attachment
          $mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // attachment */
        $mail->IsHTML(true); // send as HTML
        $mail->Subject = $EmailSubject;
        $mail->Body = $EmailBody;
        $mail->AltBody = $mail->Body;     //Plain Text Body
   
        if (!$mail->Send()) {
	
          $status = "Email sending failed.";

        } else {
           $status = '';
        }
    }

    if ($status == '') {
        return true;
    } else {
        return $status;
    }
}



/* ======================================================= EMAIL FUNCTIONS END =================================================== */
?>