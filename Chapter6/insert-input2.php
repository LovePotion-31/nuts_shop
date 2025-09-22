<?php require '../header.php'; ?>
<p>商品を追加します｡</p>
<form action="insert-output2.php" method="post" enctype="multipart/form-data">
  商品名 <input type="text" name="name"><br>
  価格 <input type="text" name="price"><br>
  画像 <input type="file" name="file"><br>
  <input type="submit" value="追加">
</form>
<?php require '../footer.php'; ?>