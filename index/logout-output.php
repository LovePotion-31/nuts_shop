<?php session_start(); ?>
<?php require '../header.php'; ?>
<?php require 'menu.php';?>
<?php
if (isset($_SESSION['customer'])){
  unset($_SESSION['customer']);
  echo 'ログアウトしました｡<br>
        3秒後自動的にホーム画面に戻ります｡';
      echo '<script>
    setTimeout(function() {
    location.href = "product.php";
    }, 3000); // 3秒(3000ミリ秒)後に移動
    </script>';
} else{
  echo 'すでにログアウトしています｡';
}
  ?>

<?php require '../footer.php'; ?>