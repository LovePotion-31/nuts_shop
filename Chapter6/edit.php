<?php require '../header.php'; ?>
<div class="th0">商品番号</div>
<div class="th1">商品名</div>
<div class="th1">価格</div>
<form action="edit3.php" method="post">
  <input type="hidden" name="command" value="insert">
  <div class="th0"></div>
  <div class="th1"><input type="text" name="name"></div>
  <div class="th1"><input type="text" name="price"></div>
  <div class="th2"><input type="submit" value="追加"></div>
</form><br>
<?php require '../footer.php'; ?>