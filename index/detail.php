<?php require '../header.php'; ?>
<?php require 'menu.php'; ?>
<?php
require_once '../connect.php';
$sql = $pdo->prepare('select * from product where id=?');
$sql->execute([$_REQUEST['id']]);
foreach ($sql as $row) {
  echo '<p><img class=detailimg alt="image" src="image/', $row['id'], '.jpg" width="50%"></p>';
  echo '<form action="cart-insert.php" method="post">';
  echo '<p>商品番号:', $row['id'], '</p>';
  echo '<p>商品名:', $row['name'], '</p>';
  echo '<p>価格:', $row['price'], '</p>';
  echo '<p>個数:<select name="count">';
  for ($i = 1; $i <= 10; $i++) {
    echo '<option value="', $i, '">', $i, '</option>';
  }
  echo '</select></p>';
  echo '<input type="hidden" name="id" value="', $row['id'], '">';
  echo '<input type="hidden" name="name" value="', $row['name'], '">';
  echo '<input type="hidden" name="price" value="', $row['price'], '">';
  echo '<p><input type="submit" value="カートに追加"></p>';
  echo '</form>';
  // ログイン判定
  if (isset($_SESSION['customer'])) {
    // 登録済み判定
    //   $query = 'SELECT COUNT (*) AS count FROM favorite
    //               WHERE custmer_id = ?
    //               AND product_id = ?';

    //   $sql = $pod -> prepare($query);
    //   $sql -> execute([$_SESSION['customer']['id'], $_REQUEST['id']]);
    //   $registered = $sql -> fetch()['count'];
    //   //  var_dump($registered); 0か1か
    //   if ($registered) {
    //     echo '<p>お気に入りに登録されています｡';
    //   } else {
    //     // 登録していない
    //     echo '<a href="favorite-insert.php?id=' . $row['id'] .
    //       '&name=' . urlencode($row['name']) . '">お気に入りに追加</a>';
    //   }

    $customer_id = $_SESSION['customer']['id'];
    $product_id = $_REQUEST['id'];

    $check = $pdo->prepare(
      'SELECT COUNT(*) FROM favorite WHERE customer_id = ? AND product_id = ?'
    );
    $check->execute([$customer_id, $product_id]);
    $count = $check->fetchColumn();

    if ($count == 0) {
      // 登録されていなければ追加
      $sql = $pdo->prepare('INSERT INTO favorite VALUES (?, ?)');
      $sql->execute([$customer_id, $product_id]);
      echo '<a href="favorite-insert.php?id=' . $row['id'] .
        '&name=' . urlencode($row['name']) . '">お気に入りに追加</a>';
    } else {
      echo 'お気に入りにすでに登録されています｡';
    }
  } else {
    echo 'お気に入りに登録するにはログインしてください｡';
  }
}

?>

<?php require '../footer.php'; ?>