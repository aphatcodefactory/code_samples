<?php

if ( isset($_POST['btn-signup']) && !empty($_POST['btn-signup']) ) {
  require_once '../classes/Database.php';
  require_once './dbconnect.php';
  $userName = htmlspecialchars(
    strip_tags(
      trim($_POST['userName'])
      )
  );
  $pass = htmlspecialchars(
    strip_tags(
      trim($_POST['pass'])
      )
  );

  //basic email validation
    if ( !filter_var($userName, FILTER_VALIDATE_EMAIL) ) {
      $error = true;
      $userNameError = "Your username must be a valid email address." ;
   } else {
    // checks whether the email address exists or not
    $result = $trvomatic->selectRow('user', 'userName', "WHERE userName = $userName;");
    if (mysqli_num_rows($result) != 0) {
       $emailError = "User name is already in use.";
    }
  }

  // password validation
    if (empty($pass)){
      $error = true;
      $passError = "Please enter password.";
   }

   $pw = hash('sha256', $pass);

   ob_start();
   session_start();

   $msg = $trvomatic->insertTbl('user', array('userName', 'password', 'status'), array($userName, $pw, 0));
   echo "<h2>$msg</h2><h4><a href=\"../\">Login here</a></h4>";
   unset($userName);
   unset($pw);
   $trvomatic->mysqli->close();
}
