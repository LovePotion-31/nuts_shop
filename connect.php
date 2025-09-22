<?php
// ローカルじゃない場合else
if( $_SERVER['HTTP_HOST'] == 'localhost'){
  $host   = 'localhost';
  $dbname = 'shop'; 
  $user   = 'root';
  $pswd   = 'Sato333!';
  
} else {
  $host   = 'localhost';
  $dbname = 'sato32';  // xserverで変わる情報 xs619812_xss
  $user   = 'sato32'; 
  $pswd   = 'Sato333@'; 
}

try{
$pdo=new PDO(
  "mysql:host=$host;dbname=$dbname;charset=utf8",
  $user , 
  $pswd 
  ) ;
// 例外的なエラーをキャッチして自動分岐します
  // どれかの値が間違っている場合に分岐  $e はエラーを代入してくる
} catch (PDOException $e) {
echo'なにかがちがうよ';
}

