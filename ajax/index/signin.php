<?php

include('../../config/config.php');
$password = '';
$email = '';
$remember = "";
$CartID = session_id();

extract($_POST);

if ($action == "signin" AND $email != "" AND $password != "") {
  
  $securePass = securedPass($password);
  $usernameCount = 0;
  $sqlCheck = "SELECT * FROM users WHERE user_email='$email'";
  $executeCheck = mysqli_query($con, $sqlCheck);
  if ($executeCheck) {
    $emailCount = mysqli_num_rows($executeCheck);
    if ($emailCount > 0) {
      //checking if password is correct
      $executeCheckResult = mysqli_fetch_object($executeCheck);
      if($executeCheckResult->user_password == $securePass){
      
        //getting user information from database
        if ($executeCheckResult->user_status != 'active') {
          $data = array("error" => 4, "error_text" => "Your account is inactive. Please contact Administrator."); // User not active
        } elseif ($executeCheckResult->user_verification != 'yes') {
          $data = array("error" => 5, "error_text" => "Please verify your Email address."); // Email not verified
        } elseif ($executeCheckResult->user_status == 'active' AND $executeCheckResult->user_verification == 'yes') {
          //checking if user already added product to cart
          $countTempCartProduct = 0;
          $sqlTempCart = "SELECT * FROM temp_carts WHERE TC_session_id='$CartID'";
          $executeTempCart = mysqli_query($con,$sqlTempCart);
          if($executeTempCart){
            $countTempCartProduct = mysqli_num_rows($executeTempCart);
            if($countTempCartProduct > 0){
              //updating userid into temp cart
              $updateCart = '';
              $updateCart .= ' TC_user_id = "' . intval($executeCheckResult->user_id) . '"';

              $sqlUpdateCart = "UPDATE temp_carts SET $updateCart WHERE TC_session_id='$CartID'";
              $executeUpdateCart = mysqli_query($con,$sqlUpdateCart);
              if(!$executeUpdateCart){
                if(DEBUG){
                  $data = array("error" => 1, "error_text" => "executeUpdateCart error: " . mysqli_error($con)); // executeUpdateCart query failed
                } else {
                  $data = array("error" => 1, "error_text" => "System Error: Cart Update failed."); // executeUpdateCart query failed
                }
              }
            }
          } else {
            if(DEBUG){
              $data = array("error" => 4, "error_text" => "executeTempCart error: " . mysqli_error($con));
            } else {
              $data = array("error" => 4, "error_text" => "System Error: Cart product check failed.");
            }
          }

          setSession('UserID', $executeCheckResult->user_id);
          setSession('Email', $email);
          setSession('FirstName', $executeCheckResult->user_first_name);
          setSession('IsEmailVerified', $executeCheckResult->user_verification);
          $expire = $config['ADMIN_COOKIE_EXPIRE_DURATION'];
          setcookie("a", base64_encode($email),time()+$expire,'/',NULL);
          setcookie("r", base64_encode($password), time()+$expire,'/',NULL);
          //if Remember Me checkbox checked

          if($remember != "yes"){
            setcookie("a", base64_encode($email), time()-3600,'/',NULL);
            setcookie("r", base64_encode($password), time()-3600,'/',NULL);
          }
          //print_r($_COOKIE);
          $data = array("error" => 0, "name" => $executeCheckResult->user_first_name); // User signed in successfully
        }
      } else {
        $data = array("error" => 5, "error_text" => "Wrong Password. Please try again."); // Username is not registered
      }
    } else {
      $data = array("error" => 2, "error_text" => "This Email is not registered."); // Username is not registered
    }
  } else {
    if(DEBUG){
      $data = array("error" => 3, "error_text" => "executeCheck error: " . mysqli_error($con)); // Username is not registered
    } else {
      $data = array("error" => 3, "error_text" => "Email check failed. Try again."); // Username is not registered
    }
  }
  echo json_encode($data);
}
?>