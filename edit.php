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

  if (!isset($_GET["id"])) {
    header("Location: /");
    die();
  }

  $id = $_GET["id"];
  $product = getItem($id)[0];

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

    $itemName = $_POST["namabarang"];
    $itemPrice = $_POST["hargabarang"];
    $oldImage = $_POST["gambarbaranglama"];
    
    if (updateItem($id, $itemName, $itemPrice, $oldImage)) {
      header("Location: /");
      die();
    } else {
      $script = "<script>alert('Terjadi kesalahan update!')</script>";
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
      height: 22px;
      margin-bottom: 5px
    }

    form div {
      margin-top: 10px
    }

    div a {
      margin-left: 5px;
    }

    p {
      margin: 0px;
      margin-top: 5px;
      margin-bottom: 2px;
    }

    img {
      width: 150px;
      height: 150px;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>
  <main>
    <form action="" method="post" enctype="multipart/form-data">
      <label for="namabarang">Nama Barang</label>
      <input id="namabarang" name="namabarang" type="text" value="<?= $product["namabarang"]; ?>">

      <label for="hargabarang">Harga Barang</label>
      <input id="hargabarang" name="hargabarang" type="text" value="<?= $product["hargabarang"]; ?>">

      <p>Gambar Barang</p>
      <img src="images/<?= $product["gambar"]; ?>" alt="<?= $product["namabarang"]; ?>">

      <label for="gambarbarang">Upload Gambar Baru</label>
      <input id="gambarbarang" name="gambarbarang" type="file">
      <input name="gambarbaranglama" type="hidden" value="<?= $product["gambar"]; ?>" >

      <div>
        <button name="submit" type="submit">Submit</button>
        <a href="/">Batal</button>
      </div>
    </form>
  </main>
</body>
</html>