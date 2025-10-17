<?php
session_start();
require '../header.php';
require 'menu.php';
require_once '../connect.php';

// 1ページあたりの件数
$limit = 4;

// 現在のオフセット (デフォルト0)
$offset = isset($_GET['page']) ? (int) $_GET['page'] : 0;
if ($offset < 0)
    $offset = 0;

// 総件数を取得
$query = "SELECT COUNT(*) AS count FROM product";
$sql = $pdo->query($query);
$item_count = $sql->fetch()["count"];

// ページ数
$page_count = ceil($item_count / $limit);

// 商品一覧取得
if (isset($_REQUEST['keyword'])) {
    $keyword = '%' . $_REQUEST['keyword'] . '%';
    $sql = $pdo->prepare("SELECT * FROM product WHERE name LIKE ? LIMIT $limit OFFSET $offset");
    $sql->execute([$keyword]);
} else {
    $sql = $pdo->query("SELECT * FROM product LIMIT $limit OFFSET $offset");
}

// 商品一覧取得
// if (isset($_REQUEST['keyword'])) {
//     $keyword = '%' . $_REQUEST['keyword'] . '%';
//     $sql = $pdo->prepare("SELECT * FROM product WHERE name LIKE ?");
//     $sql->execute([$keyword]);
// } else {
//     $sql = $pdo->query("SELECT * FROM product");
// }

// テーブル表示
echo '<div class="container">
     <div class="row">';


foreach ($sql as $row) {
    $id = $row['id'];
    echo '<div class="col-sm-6 col-md-4 col-lg-3">';
    echo '<p><a href="detail.php?id=', $id, '">','<img src="image/' . $id . '.jpg" alt="">','</a></p>';
    echo '<p>', '商品番号:', $id, '</p>';
    echo '<p>', '商品名:', $row['name'];
    echo '<p>', '価格:', $row['price'], '</p>';
    echo '</div>';
}
echo '</div></div>';

    // // シンプルページャー出力
    // echo '<div>';
    // for ($i = 0; $i < $page_count; $i++) {
    //     $offset_val = $i * $limit;
    //     if ($offset_val == $offset) {
    //         echo "<strong>" . ($i+1) . "</strong> ";
    //     } else {
    //         echo "<a href='?page=$offset_val'>" . ($i+1) . "</a> ";
    //     }
    // }
?>

<?php
// 現在のページ番号を計算
$current_page = floor($offset / $limit);
?>
<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-center">

    <!-- Previous -->
    <li class="page-item <?= ($current_page <= 0) ? 'disabled' : '' ?>">
      <?php if ($current_page > 0): ?>
        <a class="page-link" href="?page=<?= ($current_page - 1) * $limit ?>">Previous</a>
      <?php else: ?>
        <span class="page-link">Previous</span>
      <?php endif; ?>
    </li>

    <!-- Page numbers -->
    <?php for ($i = 0; $i < $page_count; $i++): ?>
      <?php $offset_val = $i * $limit; ?>
      <li class="page-item <?= ($i == $current_page) ? 'active' : '' ?>">
        <a class="page-link" href="?page=<?= $offset_val ?>"><?= $i+1 ?></a>
      </li>
    <?php endfor; ?>

    <!-- Next -->   
    <li class="page-item <?= ($current_page >= $page_count - 1) ? 'disabled' : '' ?>">
      <?php if ($current_page < $page_count - 1): ?>
        <a class="page-link" href="?page=<?= ($current_page + 1) * $limit ?>">Next</a>
      <?php else: ?>
        <span class="page-link">Next</span>
      <?php endif; ?>
    </li>

  </ul>
</nav>
<?php
require '../footer.php';
?>