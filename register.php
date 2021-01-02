<?php
  require("controllers/db.php");

  session_start();

  if ($_SESSION["login"]) {
    header("Location: /");
    die();
  }

  if (isset($_POST["submit"])) {
    if ($_SESSION["login"]) {
      header("Location: /");
      die();
    }

    if ($_POST["username"] && $_POST["password"] && $_POST["role"]) {
      $username = $_POST["username"];
      $password = $_POST["password"];
      $role = $_POST["role"];

      if (addNewUser($username, $password, $role) > 0) {
        header("Location: /login.php");
        die();
      } else {
        $script = "<script>alert('Terjadi kesalahan input!')</script>";
        echo($script);
      }
    } else {
      $script = "<script>alert('Masukan data pengguna!')</script>";
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

    form select {
      margin-bottom: 15px;
    }
  </style>
</head>
<body>
  <main>
    <form action="" method="post" enctype="multipart/form-data">
      <label for="username">Username</label>
      <input id="username" name="username" type="text">

      <label for="password">Password</label>
      <input id="password" name="password" type="password">

      <label for="role">Role</label>
      <select name="role" id="role">
        <option default value="user">User</option>
        <option value="admin">Admin</option>
      </select>

      <div>
        <button name="submit" type="submit">Daftar</button>
        <a href="/">Kembali</button>
      </div>
    </form>
  </main>
</body>
</html>