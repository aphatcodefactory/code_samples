<?php
  ob_start();
  session_start();

  require_once 'classes/Database.php';
  require_once 'actions/dbconnect.php';

  if (isset($_SESSION['user']) != '') {
    include_once 'home.php';
  } else {
    include_once 'login.php';
  }
