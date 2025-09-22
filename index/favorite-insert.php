<?php session_start(); ?>
<?php require '../header.php'; ?>
<?php require 'menu.php';?>
<?php require_once '../connect.php';
/*主キーの重複エラーが出ないように直してください｡
1.お客さんが気が付く方法
2,確実なロジック
3,コードが簡単
*/

if (isset($_SESSION['customer'])) {
  $customer_id = $_SESSION['customer']['id'];
  $product_id = $_REQUEST['id'];
  $product_name = $_REQUEST['name'];

  // すでに登録されているかチェック
  $check = $pdo->prepare(
    'SELECT COUNT(*) FROM favorite WHERE customer_id = ? AND product_id = ?'
  );
  $check->execute([$customer_id, $product_id]);
  $count = $check->fetchColumn();

  if ($count == 0) {
    // 登録されていなければ追加
    $sql = $pdo->prepare('INSERT INTO favorite VALUES (?, ?)');
    $sql->execute([$customer_id, $product_id]);
    echo $product_name.'をお気に入りに商品を追加しました';
  } else {
    // 登録済みならメッセージだけ
    echo $product_name.'はすでにお気に入りに登録されています'; }
    echo '<hr>';
}else {
  echo 'お気に入りに商品を追加するには､ログインしてください｡';
} 
  require 'favorite.php';
?>
<?php require '../footer.php'; ?>