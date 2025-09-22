<?php 
session_start();
require '../header.php';
require 'menu.php';
require_once '../connect.php';


$sql = 
'INSERT INTO purchase (customer_id) 
values(?)';
$dbh = $pdo -> prepare( $sql);
$res = $dbh->execute([ $_SESSION['customer']['id']]);
if ($res) {
  $purchase_id = $pdo->lastInsertId();
  //  カートをループ
  foreach ($_SESSION['product'] as $product_id => $product) {
    $dbh = $pdo->prepare('INSERT INTO purchase_detail values(?,?,?)');
    $dbh -> execute([$purchase_id, $product_id, $product['count']]);
  }
  unset($_SESSION['product']);
  echo '購入手続きが完了しました｡ ありがとうございます｡';
} else {
  echo '購入手続き中にエラーが発生しました､申し訳ございません｡';
}

require '../footer.php';
  ?>