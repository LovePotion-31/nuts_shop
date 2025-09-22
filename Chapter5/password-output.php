<?php require '../header.php';
$password=$_REQUEST['password'];
if (preg_match('/^(?=.*[a-z])(?=.*[A-Z]) (?=.*[0-9]) [a-zA-Z0-9]{8,}$/', $password)) {
  echo 'パスワード｢', $password, '｣を確認しました｡';
}
else{
  echo 'パスワード｢', $password, '｣は適切ではありません｡';}
require '../footer.php'; ?>

<!-- 再度検証 -->