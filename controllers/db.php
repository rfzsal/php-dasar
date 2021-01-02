<?php
  $connection = mysqli_connect("localhost", "root", "", "_toko");

  function uploadImage() {
    $imgName = $_FILES["gambarbarang"]["name"];
    $tmpName = $_FILES["gambarbarang"]["tmp_name"];

    if (!$imgName) return false;

    $newImgName = uniqid();
    $newImgName .= $imgName;

    move_uploaded_file($tmpName, "images/$newImgName");

    return $newImgName;
  }

  function getItems($start = 0, $numData = 0) {
    global $connection;
    $sql = "SELECT * FROM barang";
    
    if ($start !== 0 || $numData !== 0) {
      $sql = "SELECT * FROM barang LIMIT $start, $numData";
    }

    $query = mysqli_query($connection, $sql);

    $results = [];

    while($queryResult = mysqli_fetch_assoc($query)) {
      $results[] = $queryResult;
    }

    return $results;
  }

  function getItem($id) {
    global $connection;
    $sql = "SELECT * FROM barang WHERE idbarang=$id";
    $query = mysqli_query($connection, $sql);

    $results = [];

    while($queryResult = mysqli_fetch_assoc($query)) {
      $results[] = $queryResult;
    }

    return $results;
  }

  function updateItem($id, $itemName, $itemPrice, $oldImage) {
    global $connection;

    $image = uploadImage();
    if (!$image) $image = $oldImage;

    $sql = "UPDATE barang SET namabarang='$itemName', hargabarang=$itemPrice, gambar='$image' WHERE idbarang=$id";
    mysqli_query($connection, $sql);

    return true;
  }

  function addNewItem($itemName, $itemPrice) {
    global $connection;

    $image = uploadImage();
    if (!$image) return false;

    $sql = "INSERT INTO barang VALUES ('$itemName', $itemPrice, null, '$image')";
    mysqli_query($connection, $sql);

    return mysqli_affected_rows($connection);
  }

  function deleteItem($id) {
    global $connection;
    $sql = "DELETE FROM barang WHERE idbarang=$id";
    mysqli_query($connection, $sql);

    return mysqli_affected_rows($connection);
  }

  function searchItem($itemName) {
    global $connection;
    $sql = "SELECT * FROM barang WHERE namabarang LIKE '%$itemName%'";
    $query = mysqli_query($connection, $sql);

    $results = [];

    while($queryResult = mysqli_fetch_assoc($query)) {
      $results[] = $queryResult;
    }

    return $results;
  }

  function addNewUser($username, $password, $role) {
    global $connection;
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO pengguna VALUES ('$username', '$hashedPassword', '$role')";
    mysqli_query($connection, $sql);

    return mysqli_affected_rows($connection);
  }

  function checkUser($username, $password) {
    global $connection;
    $sql = "SELECT * FROM pengguna WHERE username='$username'";
    $query = mysqli_query($connection, $sql);

    $results = [];

    while($queryResult = mysqli_fetch_assoc($query)) {
      $results[] = $queryResult;
    }

    if (count($results) === 0) return false;
    
    if (password_verify($password, $results[0]["password"])) {
      return $results[0];
    } else {
      return false;
    }
  }
?>