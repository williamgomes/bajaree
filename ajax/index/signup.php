<?php

include('../../config/config.php');
include ('../../lib/email/mail_helper_functions.php');

$email = '';
$password = '';
$first_name = '';
$phone = '';
$CartID = session_id();

extract($_POST);

if ($action == "signup") {
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $data = array("error" => 1, "error_text" => "Correct Email format is required."); // Incorrect email address format
  } else {
    $emailCount = 0;
    $sqlCheck = "SELECT * FROM users WHERE user_email='$email'";
    $executeCheck = mysqli_query($con, $sqlCheck);
    if ($executeCheck) {
      $emailCount = mysqli_num_rows($executeCheck);
      if ($emailCount > 0) {
        $data = array("error" => 2, "error_text" => "This Email already exist."); // Email address already registered with database
      } else {

        $securePass = securedPass($password);
        $userHash = session_id();

        $AddUser = '';
        $AddUser .= ' user_email = "' . mysqli_real_escape_string($con, $email) . '"';
        $AddUser .= ', user_password = "' . mysqli_real_escape_string($con, $securePass) . '"';
        $AddUser .= ', user_first_name = "' . mysqli_real_escape_string($con, $first_name) . '"';
        $AddUser .= ', user_phone = "' . mysqli_real_escape_string($con, $phone) . '"';
        $AddUser .= ', user_hash = "' . mysqli_real_escape_string($con, $userHash) . '"';

        $sqlAddUser = "INSERT INTO users SET $AddUser";
        $executeAddUser = mysqli_query($con, $sqlAddUser);
        if ($executeAddUser) {
          //setting up user session values
          $userID = mysqli_insert_id($con);
          setSession('FirstName', $first_name);
          setSession('UserID', $userID);
          setSession('Email', $email);
          setSession('IsEmailVerified', "no");
          
          //sending email to user
          $Subject = "Registration confirmation from bajaree.com";
          $EmailBody = file_get_contents(baseUrl('emails/signup/signup.body.php?user_id=' . $userID));
          $sendEmailToApplicant = sendEmailFunction($email,$first_name,'no-reply@bajaree.com',$Subject,$EmailBody);
          
          if($sendEmailToApplicant){
            
            //checking if user already added product to cart
            $countTempCartProduct = 0;
            $sqlTempCart = "SELECT * FROM temp_carts WHERE TC_session_id='$CartID'";
            $executeTempCart = mysqli_query($con, $sqlTempCart);
            if ($executeTempCart) {
              $countTempCartProduct = mysqli_num_rows($executeTempCart);
              if ($countTempCartProduct > 0) {
                //updating userid into temp cart
                $updateCart = '';
                $updateCart .= ' TC_user_id = "' . intval($userID) . '"';

                $sqlUpdateCart = "UPDATE temp_carts SET $updateCart WHERE TC_session_id='$CartID'";
                $executeUpdateCart = mysqli_query($con, $sqlUpdateCart);
                if (!$executeUpdateCart) {
                  if (DEBUG) {
                    $data = array("error" => 5, "error_text" => "executeUpdateCart error: " . mysqli_error($con)); // Incorrect email address format
                  } else {
                    $data = array("error" => 5, "error_text" => "System Error: Cart Update failed."); // Incorrect email address format
                  }
                }
              }
            } else {
              if (DEBUG) {
                $data = array("error" => 6, "error_text" => "executeTempCart error: " . mysqli_error($con)); // Incorrect email address format
              } else {
                $data = array("error" => 6, "error_text" => "System Error: Cart product check failed."); // Incorrect email address format
              }
            }
          } else {
            $data = array("error" => 7, "error_text" => "Email send failed"); // Incorrect email address format
          }

          

          $data = array("error" => 0, "name" => $first_name); // User added successfully
        } else {
          if(DEBUG){
            $data = array("error" => 3, "error_text" => "executeAddUser error: " . mysqli_error($con)); // $executeAddUser failed
          } else {
            $data = array("error" => 3, "error_text" => "System Error: Your information could not save."); // $executeAddUser failed
          }
        }
      }
    } else {
      if(DEBUG){
        $data = array("error" => 4, "error_text" => "executeCheck error: " . mysqli_error($con)); // $executeCheck query failed
      } else {
        $data = array("error" => 4, "error_text" => "System Error: Information verification failed."); // $executeCheck query failed
      }
    }
  }
  echo json_encode($data);
}
?>