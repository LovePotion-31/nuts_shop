<?php session_start(); ?>
<?php require '../header.php'; ?>
<?php require 'menu.php';?>
<?php
require_once '../connect.php';
unset($_SESSION['customer']);
$sql=$pdo->prepare('select * from customer where login=? and password=?');
$sql->execute([$_REQUEST['login'], $_REQUEST['password']]);
foreach ($sql as $row){
  $_SESSION['customer'] = [
    'id' => $row['id'],
    'name' => $row['name'],
    'address' => $row['address'],
    'email' => $row['email'],
    'login' => $row['login'],
    'password' => $row['password']
  ];
}
if (isset($_SESSION['customer'])){
  echo 'いらっしゃいませ', $_SESSION['customer']['name'], 'さん｡<br>
        3秒後自動的にでホーム画面に戻ります｡';

    echo '<script>
    setTimeout(function() {
    location.href = "product.php";
    }, 3000); // 3秒(3000ミリ秒)後に移動
    </script>';
} else{
  echo 'ログイン名またはパスワードが違います｡';
}


  ?>

<?php require '../footer.php'; ?>