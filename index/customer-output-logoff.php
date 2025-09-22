<?php session_start();
require '../header.php'; 
require 'menu.php';
require_once '../connect.php';

  $sql = $pdo->prepare('SELECT * from customer where login=?'); // このアカウント名が使われているか判定
  $sql->execute([$_REQUEST['login']]);

if (empty($sql->fetchAll())) {
  $sql = $pdo->prepare('INSERT INTO customer values(null, ?, ?, ?, ?, ?)');
  $sql->execute([
    $_REQUEST['name'],
    $_REQUEST['address'],
    $_REQUEST['email'],
    $_REQUEST['login'],
    $_REQUEST['password']
  ]);
  echo 'お客様情報を登録しました｡';
}else{
  echo 'ログイン名がすでに使用されていますので､変更してください｡';
}

require '../footer.php'; 
?>