<?php
  ob_start();
  session_start();
  unset($_SESSION['user']);
  unset($_SESSION['userStatus']);
  session_destroy();
  ob_end_flush();
  header('Location: ../');
