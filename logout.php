<?php 
  session_start();

  $_SESSION["login"] = false;
  $_SESSION["role"] = false;

  header("Location: /");
  die();
?>