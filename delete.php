<?php 
  require("controllers/db.php");

  if (!$_SESSION["login"]) {
    header("Location: /");
    die();
  } else {
    if ($_SESSION["role"] !== "admin") {
      header("Location: /");
      die();
    }
  }

  if (isset($_GET["id"])) {
    $id = $_GET["id"];
    deleteItem($id);
  }

  header("Location: /");
  die();
?>