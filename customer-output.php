<?php session_start(); ?>
<?php require '../header.php'; ?>
<?php require 'menu.php'; ?>
<?php
require_once '../connect.php';

$name     = $_POST['name'] ?? '';
$address  = $_POST['address'] ?? '';
$login    = $_POST['login'] ?? '';
$pass1    = $_POST['password'] ?? '';            // ← フォームと合わせた
$pass2    = $_POST['password_confirm'] ?? '';    // ← フォームと合わせた

// パスワード確認
if ($pass1 !== $pass2) {
  echo 'パスワードが一致しません';
  require '../footer.php';
  exit();
}

if (isset($_SESSION['customer'])) {
  // 既存会員の更新処理
  $id = $_SESSION['customer']['id'];

  // 他の人が同じログイン名を使っていないかチェック
  $sql = $pdo->prepare('SELECT * FROM customer WHERE id != ? AND login = ?');
  $sql->execute([$id, $login]);

  if (empty($sql->fetchAll())) {
    if ($pass1 === '') {
      // パスワード変更なし
      $sql = $pdo->prepare('UPDATE customer SET name=?, address=?, login=? WHERE id=?');
      $sql->execute([$name, $address, $login, $id]);
    } else {
      // パスワード変更あり
      $sql = $pdo->prepare('UPDATE customer SET name=?, address=?, login=?, password=? WHERE id=?');
      $sql->execute([
        $name,
        $address,
        $login,
        password_hash($pass1, PASSWORD_DEFAULT),
        $id
      ]);
    }

    // セッションを更新
    $_SESSION['customer']['name']    = $name;
    $_SESSION['customer']['address'] = $address;
    $_SESSION['customer']['login']   = $login;

    echo 'お客様情報を更新しました';
  } else {
    echo 'ログイン名がすでに使用されています｡';
  }

} else {
  // 新規登録処理
  $sql = $pdo->prepare('SELECT * FROM customer WHERE login=?');
  $sql->execute([$login]);

  if (empty($sql->fetchAll())) {
    if ($pass1 === '') {
      echo 'パスワードを入力してください';
    } else {
      $sql = $pdo->prepare('INSERT INTO customer VALUES(NULL, ?, ?, ?, ?)');
      $sql->execute([
        $name,
        $address,
        $login,
        password_hash($pass1, PASSWORD_DEFAULT)
      ]);
      echo 'お客様情報を登録しました｡';
    }
  } else {
    echo 'ログイン名がすでに使用されています｡';
  }
}
?>

<?php require '../footer.php'; ?>
