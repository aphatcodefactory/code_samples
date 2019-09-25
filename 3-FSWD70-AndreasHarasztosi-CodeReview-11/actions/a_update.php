<?php

ob_start();
session_start();

require_once '../classes/Database.php';
require_once './dbconnect.php';

//switch ($_GET['tbl']) {
//  case 'restaurant':
    $trvomatic->updateRow($_GET['tbl'], "*", "WHERE restaurantID = ".$_GET['id']);
  //   break;
  //
  // case 'thtdo':
  //   $trvomatic->updateRow("thtdo", "*", "WHERE thtdoID = ".$_GET['id']);
  //   break;
  //
  // case 'event':
  //   $trvomatic->updateRow("event", "*", "WHERE eventID = ".$_GET['id']);
  //   break;
//}
