<?php
session_start();
require '../header.php';
require 'menu.php';
require_once '../connect.php';

$sql1 = 'SELECT * FROM purchase
    WHERE customer_id=? 
    ORDER BY id DESC';  
if (isset($_SESSION['customer'])) {
  $sql_purchase = $pdo->prepare($sql1);
  $sql_purchase->execute([$_SESSION['customer']['id']]);

  $purchase = $sql_purchase->fetchAll();
  if (!empty($purchase)) {// 過去に購入した履     歴が無い場合
    $sql2 = 'SELECT * FROM purchase_detail,product WHERE purchase_id=?
      AND product_id=id';
    foreach ($purchase as $row_purchase) {
      $sql_detail = $pdo->prepare($sql2);
      $sql_detail->execute([$row_purchase['id']]);  

      // 'SELECT `product_id`, p.name, count, `price`, 
      //         `price` * count AS subtotal
      // FROM `purchase_detail` AS d 
      // LEFT JOIN `product` AS p ON p.id = `product_id` 
      // LEFT JOIN `purchase` AS c ON c.id = `purchase_id` 
      // WHERE customer_id = ? ORDER BY d.id DESC'

      echo '<table>';
      echo '<tr><th>商品番号</th><th>商品名</th>', '<th>価格</th><th>個数</th><th>小計</th></tr>';
      $total = 0;
      foreach ($sql_detail as $row_detail) {
        echo '<tr>';
        echo '<td>', $row_detail['id'], '</td>';
        echo '<td><a href="detail.php?id=', $row_detail['id'], '">',
          $row_detail['name'], '</a></td>';
        echo '<td>', $row_detail['price'], '</td>';
        echo '<td>', $row_detail['count'], '</td>';
        $subtotal = $row_detail['price'] * $row_detail['count'];
        $total += $subtotal;
        echo '<td>', $subtotal, '</td>';
        echo '</tr>';
      }
      echo '<tr><td>合計</td><td></td><td></td><td></td><td>',
        $total, '</td></tr>';
      echo '</table>';
      echo '<hr>';
    }
  } else {
    echo '購入した履歴はありません';
  }
} else {
  echo '購入履歴を表示するには､ログインしてください';
}
require '../footer.php';
    ?>