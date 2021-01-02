<?php 
  require("controllers/db.php"); 

  session_start();

  if (!isset($_SESSION["login"])) $_SESSION["login"] = false;
  if (!isset($_SESSION["role"])) $_SESSION["role"] = false;

  $products = getItems(0, 0);  
  $totaldata = count($products);
  $dataPerPage = 5;

  $totalPage = ceil($totaldata / $dataPerPage);
  $totalPage = $totalPage > 1 ? $totalPage : 0;

  if (isset($_GET["page"])) {
    $page = $_GET["page"];

    $startIndex = ($page * $dataPerPage) - $dataPerPage;

    $products = getItems($startIndex, $dataPerPage);
  } else {
    $products = getItems(0, $dataPerPage);
  }

  if (isset($_POST["cari"])) {
    $itemName = $_POST["cari"];

    if ($itemName) {
      $totalPage = 0;
      $products = searchItem($itemName);
    };
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <style>
    .mr-5 {
      margin-right: 5px;
    }

    .mr-15 {
      margin-right: 15px;
    }

    .mt-15 {
      margin-top: 15px;
    }

    .v-none {
      visibility: hidden;
    }

    body {
      margin: 0px;
    }

    nav {
      height: 36px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 5px 15px;
    }

    main {
      padding: 0px 15px;
    }

    .item-container-5 {
      display: grid;
      grid-template-columns: repeat(5, minmax(0, 1fr));
      grid-gap: 12px;
    }

    .item-container-4 {
      display: grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      grid-gap: 12px;
    }

    .item-container-2 {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      grid-gap: 12px;
    }

    .item {
      overflow: hidden;
      border-radius: 6px;
      background-color: pink;
      width: 100%;
      padding-bottom: 10px;
    }

    .item > * {
      padding: 0px 10px
    }

    .item > p {
      line-height: 12px;
    }

    .item-img {
      padding: 0px;
      height: 150px;
      width: 100%;
    }
    
    .pagination {
      display: flex;
    }

    .pagination > * {
      margin-right: 15px;
    }
  </style>
</head>
<body>
  <nav>
    <?php if ($_SESSION["role"] === "admin"): ?>
      <a href="input.php">Tambah Barang</a>
    <?php else: ?>
      <a class="v-none" href="">Tambah Barang</a>
    <?php endif; ?>

    <?php if (!$_SESSION["login"]): ?>
    <div>
      <a class="mr-15" href="register.php">Daftar</a>
      <a href="login.php">Masuk</a>
    </div>
    <?php endif; ?>

    <?php if ($_SESSION["login"]): ?>
      <a class="v-none" href="">Keluar</a>
      <a href="logout.php">Keluar</a>
    <?php endif; ?>
  </nav>

  <main>
    <form action="" method="post">
      <input type="search" name="cari" id="search" placeholder="Cari produk...">
    </form>

    <div id="item-container" class="item-container-5 mt-15">
      <?php foreach($products as $product) : ?>
        <div class="item">
          <img class="item-img" src="images/<?= $product["gambar"] ?>" alt="<?= $product["namabarang"] ?>">
          <p><?= $product["namabarang"] ?></p>
          <p>Rp. <?= $product["hargabarang"] ?></p>
          <?php if ($_SESSION["role"] === "admin"): ?>
            <div>
              <a class="mr-5" href="edit.php?id=<?= $product["idbarang"] ?>">Ubah</a>
              <a href="delete.php?id=<?= $product["idbarang"] ?>">Hapus</a>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>

    <ul class="pagination">
      <?php for($page = 1; $page <= $totalPage; $page++) : ?>
        <li type="none"><a href="?page=<?= $page ?>"><?= $page ?></a></li>
      <?php endfor; ?>
    </ul>

  </main>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const itemContainer = document.getElementById("item-container");

      const handleWindowSize = () => {
        const windowWidth = window.innerWidth;
        const smClass = "item-container-2";
        const mdClass = "item-container-4";
        const lgClass = "item-container-5";

        if (windowWidth <= 600) {
          itemContainer.classList.toggle(mdClass, false);
          itemContainer.classList.toggle(lgClass, false);
          itemContainer.classList.toggle(smClass, true);
        } else if (windowWidth <= 800) {
          itemContainer.classList.toggle(mdClass, true);
          itemContainer.classList.toggle(lgClass, false);
          itemContainer.classList.toggle(smClass, false);
          containerClass = "item-container-4";
        } else if (windowWidth >= 1000) {
          itemContainer.classList.toggle(mdClass, false);
          itemContainer.classList.toggle(lgClass, true);
          itemContainer.classList.toggle(smClass, false);
        }
      }

      handleWindowSize();

      window.addEventListener("resize", () => {
        handleWindowSize();
      });
    });
  </script>
</body>
</html>
