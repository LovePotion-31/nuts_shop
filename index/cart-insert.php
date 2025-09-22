<?php session_start(); ?>
<?php require '../header.php'; ?>
<?php require 'menu.php'; ?>
<?php
/*
カートにはひとつずつしか入れられない
*/
$id=$_REQUEST['id'];
//値が入っていない場合にカラにしている
// if (!isset($_SESSION['product'])) {
//   $_SESSION['product']=[];
// }
$count=0;
if (isset($_SESSION['product'][$id])) {
  // 特定の商品の数量をとりだして
  $count=$_SESSION['product'][$id]['count'];
}
// 3次元配列 ここのnameは商品名です
$_SESSION['product'][$id]=[
  'name'=>$_REQUEST['name'],
  'price'=>$_REQUEST['price'],
  'count'=>$count+$_REQUEST['count'] // カートに加算
];
echo '<p>カートに商品を追加しました｡ </p>';
echo '<hr>';
require 'cart.php';
  ?>
<?php require '../footer.php'; ?>
