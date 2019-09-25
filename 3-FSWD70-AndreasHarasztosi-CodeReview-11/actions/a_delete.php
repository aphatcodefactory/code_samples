<?php

ob_start();
session_start();

require_once '../classes/Database.php';
require_once './dbconnect.php';

$trvomatic->deleteRow($_GET['tbl'], 'WHERE '.$_GET['tbl'].'ID = '.$_GET['id']);

header('Location: ../');