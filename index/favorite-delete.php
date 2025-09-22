<?php session_start(); ?>
<?php require '../header.php'; ?>
<?php require 'menu.php';?>
<?php require_once '../connect.php';
if (isset($_SESSION['customer'])){
  
  $sql = $pdo -> prepare('delete from favorite where customer_id=? and product_id=?');
  $sql -> execute([$_SESSION['customer']['id'], $_REQUEST['id']]);
  echo 'お気に入りに商品を削除しました';
  echo '<hr>';
}  else {
  echo 'お気に入りから商品を削除するには､ログインしてください｡';
} 
  require 'favorite.php';
?>
<?php require '../footer.php'; ?>