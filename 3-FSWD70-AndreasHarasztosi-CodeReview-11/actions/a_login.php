<?php
  if ( isset($_POST['btn-login']) && !empty($_POST['btn-login']) ) {
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

    $pw = hash('sha256', $pass);

    //basic email validation
    if ( !filter_var($userName, FILTER_VALIDATE_EMAIL) ) {
    $error = true;
    $userNameError = "Your username must be a valid email address." ;
   } else {
    // checks whether the user name exists or not
      $result = $trvomatic->selectRow('user', 'userName, status', "WHERE userName = '$userName' AND
        password = '$pw';");
      $count = mysqli_num_rows($result);

      if ($count == 1) {
        $isadmin = array('User', 'Administrator');
        $user = $result->fetch_assoc();
        ob_start();
        session_start();
        $_SESSION['user'] = $user['userName'];
        $_SESSION['userStatus'] = $isadmin[$user['status']];
        header('Location: ../');
      } else {
        echo "<h3>Invalid username and/or password.</h3>
              <h4><a href=\"../\">back to Login</a></h4>";
      }
    }
  }
?>
