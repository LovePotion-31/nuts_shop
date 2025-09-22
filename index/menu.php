<?php
@session_start();
ini_set('display_errors', "On");
require_once("../connect.php"); ?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">ナッツショップ</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">ホーム</a>
        </li> -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            購入
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="cart-show.php">カート</a></li>
            <!-- <li><hr class="dropdown-divider"></li> -->
            <li><a class="dropdown-item" href="purchase-input.php">購入</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            会員情報
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="favorite-show.php">お気に入り</a></li>
            <li><a class="dropdown-item" href="history.php">購入履歴</a></li>
            <!-- <li><hr class="dropdown-divider"></li> -->
            <li><a class="dropdown-item" href="customer-input.php">お客様情報変更</a></li>
          </ul>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link disabled">Disabled</a>
        </li> -->
      </ul>

      <form class="d-flex" role="search" action="index.php" method="post">
        <input class="form-control me-2" type="search" name="keyword" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>


      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <!-- ログイン/ログアウトをセッション状態で切り替え -->
        <!-- ユーザー名をログアウトのすぐ左に表示 -->
        <?php if (isset($_SESSION['customer'])): ?>
          <li class="nav-item pe-2 d-flex align-items-center">
            <?= $_SESSION["customer"]["name"] . 'さん' ?>
          </li>
        <?php endif; ?>
        <li class="nav-item" style="<?php echo isset($_SESSION['customer']) ? 'display:none;' : ''; ?>">
          <a class="nav-link" href="login-input.php">ログイン</a>
        </li>
        <li class="nav-item" style="<?php echo isset($_SESSION['customer']) ? '' : 'display:none;'; ?>">
          <a class="nav-link" href="logout-input.php">ログアウト</a>
        </li>

        <!-- 会員登録はログイン中は非表示 -->
        <li class="nav-item" style="<?php echo isset($_SESSION['customer']) ? 'display:none;' : ''; ?>">
          <a class="nav-link" href="customer-input.php">会員登録</a>
        </li>
      </ul>

    </div>
  </div>
</nav>

<?php
// 元のナビゲーション切り替え (コメントアウトのまま残す)
// if (isset($_SESSION["customer"])){
// echo '<a href="index.php">商品</a>&nbsp;&nbsp;';
// echo '<a href="favorite-show.php">お気に入り</a>&nbsp;&nbsp;';
// echo '<a href="history.php">購入履歴</a>&nbsp;&nbsp;';
// echo '<a href="cart-show.php">カート</a>&nbsp;&nbsp;';
// echo '<a href="purchase-input.php">購入</a>&nbsp;&nbsp;';
// echo '<a href="logout-input.php">ログアウト</a>&nbsp;&nbsp;';
// echo '<a href="customer-input.php">お客様情報確認･変更</a>&nbsp;&nbsp;';
// echo '<br>';
// echo '<br>';
// echo '<form action="index.php" method="post">
//   商品検索
//   <input type="text" name="keyword">
//   <input type="submit" value="検索">
// </form>';
// echo '<hr>';
// }else{
// echo '<a href="index.php">商品</a>&nbsp;&nbsp;';
// echo '<a href="cart-show.php">カート</a>&nbsp;&nbsp;';
// echo '<a href="purchase-input.php">購入</a>&nbsp;&nbsp;';
// echo '<a href="login-input.php">ログイン</a>&nbsp;&nbsp;';
// echo '<a href="customer-input.php">会員登録</a>&nbsp;&nbsp;';
// echo '<br>';
// echo '<br>';
// echo '<form action="index.php" method="post">
//   商品検索
//   <input type="text" name="keyword">
//   <input type="submit" value="検索">
// </form>';
// echo '<hr>';
// }
?>