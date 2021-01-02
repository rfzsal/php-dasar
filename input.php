<?php
  require("controllers/db.php");

  session_start();

  if (!$_SESSION["login"]) {
    header("Location: /");
    die();
  } else {
    if ($_SESSION["role"] !== "admin") {
      header("Location: /");
      die();
    }
  }

  if (isset($_POST["submit"])) {
    if (!$_SESSION["login"]) {
      header("Location: /");
      die();
    } else {
      if ($_SESSION["role"] !== "admin") {
        header("Location: /");
        die();
      }
    }

    if ($_POST["namabarang"] && $_POST["hargabarang"]) {
      $itemName = $_POST["namabarang"];
      $itemPrice = $_POST["hargabarang"];

      if (addNewItem($itemName, $itemPrice) > 0) {
        header("Location: /");
        die();
      } else {
        $script = "<script>alert('Terjadi kesalahan input!')</script>";
        echo($script);
      }
    } else {
      $script = "<script>alert('Masukan data barang!')</script>";
      echo($script);
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <style>
    main {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding-top: 15px
    }
  
    form {
      display: flex;
      flex-direction: column;
      align-items: start;
    }

    form input {
      margin-bottom: 5px;
      height: 22px;
    }

    form div {
      margin-top: 10px
    }

    div a {
      margin-left: 5px;
    }
  </style>
</head>
<body>
  <main>
    <form action="" method="post" enctype="multipart/form-data">
      <label for="namabarang">Nama Barang</label>
      <input id="namabarang" name="namabarang" type="text">

      <label for="hargabarang">Harga Barang</label>
      <input id="hargabarang" name="hargabarang" type="text">

      <label for="gambarbarang">Gambar Barang</label>
      <input id="gambarbarang" name="gambarbarang" type="file">

      <div>
        <button name="submit" type="submit">Submit</button>
        <a href="/">Batal</button>
      </div>
    </form>
  </main>
</body>
</html>