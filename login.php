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

    if ($_POST["username"] && $_POST["password"]) {
      $username = $_POST["username"];
      $password = $_POST["password"];

      $user = checkUser($username, $password);

      if ($user) {
        $_SESSION["login"] = true;
        $_SESSION["role"] = $user["role"];

        header("Location: /");
        die();
      } else {
        $script = "<script>alert('Username atau Password salah!')</script>";
        echo($script);
      }
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

      <div>
        <button name="submit" type="submit">Masuk</button>
        <a href="/">Kembali</button>
      </div>
    </form>
  </main>
</body>
</html>