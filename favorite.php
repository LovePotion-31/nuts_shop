<?php require_once '../connect.php';
if (isset($_SESSION['customer'])) { // ログイン判定

  $sql_favorite = $pdo->prepare('SELECT * FROM favorite WHERE customer_id = ?'); 
    $sql_favorite->execute([$_SESSION['customer']['id']]);  
   
  $favorite = $sql_favorite->fetch(); // favoriteテーブルにお気に入りを登録してあるか確認
//  var_dump($favorite);
  if (!empty($favorite)) {   // お気に入りの商品があるかどうか
    echo '<table>';
    echo '<tr><th>商品番号</th><th>商品名</th>';
    echo '<th>価格</th><th></th></tr>';

    $sql = $pdo->prepare(
      'SELECT * from favorite, product where customer_id=? and product_id=id'
    );
    $sql->execute([$_SESSION['customer']['id']]);
    foreach ($sql as $row) {
      $id = $row['id'];
      echo '<tr>';
      echo '<td>' . $id . '</td>';
      echo '<td>  <a href="detail.php?id=' . $id . '">', $row['name'],
        '</a></td>';
      echo '<td>' . $row['price'] . '</td>';
      echo '<td> <a href="favorite-delete.php?id=' . $id . '">削除</a></td>';
      echo '</tr>';
    }
  } else {
    echo 'お気に入りに選択した商品はありません';
  }
  echo '</table>';
} else {
  echo 'お気に入りを表示するには､ ログインしてください｡ 
  ';
}
?>