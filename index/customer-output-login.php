<?php session_start();
require '../header.php';
require 'menu.php';
require_once '../connect.php';

$id = $_SESSION['customer']['id']; // 顧客ID
$sql = $pdo->prepare('SELECT * from customer where id !=? and login=?'); // idが違って､ログイン名が等しい
// ログイン名を変更しようとした場合の処理
$sql->execute([$id, $_REQUEST['login']]);
//  fetch はDBの戻り値を配列に変える関数
//  上のSQL分でカラならばばtrue (login名は使われていない)
if (empty($sql->fetch())) {
  // 更新
  if (empty($_REQUEST['password'])) { // パスワード欄がカラだったら
    // パスワード欄がカラだった場合パスワード以外を更新する
    $sql = $pdo->prepare('UPDATE customer set 
  name=?, 
  address=?, 
  email=?, 
  login=? 
  where id=?');

    $sql->execute([
      $_REQUEST['name'],
      $_REQUEST['address'],
      $_REQUEST['email'],
      $_REQUEST['login'],
      $id
    ]);
    // 更新された顧客情報をセッションに入れ直し
    $_SESSION['customer'] = [
      'id' => $id,
      'name' => $_REQUEST['name'],
      'address' => $_REQUEST['address'],
      'email' => $_REQUEST['email'],
      'login' => $_REQUEST['login'],
      'password' => $_SESSION['customer']['password'],
    ];
    echo 'お客様情報を更新しました';
  } else { //パスワードの入力があった場合
    // パスワードも含めて更新する
    $sql = $pdo->prepare('UPDATE customer set 
      name=?, 
      address=?, 
      email=?, 
      login=?,
      password=? 
      where id=?');

    $sql->execute([
      $_REQUEST['name'],
      $_REQUEST['address'],
      $_REQUEST['email'],
      $_REQUEST['login'],
      $_REQUEST['password'],
      $id
    ]);
    // 更新された顧客情報をセッションに入れ直し
    $_SESSION['customer'] = [
      'id' => $id,
      'name' => $_REQUEST['name'],
      'address' => $_REQUEST['address'],
      'email' => $_REQUEST['email'],
      'login' => $_REQUEST['login'],
      'password' => $_REQUEST['password'],
    ];
    echo 'お客様情報を更新しました';
  }
} else {
  echo 'ログイン名がすでに使用されていますので､変更してください｡';
}

require '../footer.php';
?>