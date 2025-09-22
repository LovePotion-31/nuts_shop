<?php require '../header.php'; ?>
<?php
// デフォルトタイムゾーンセット
// ※ Japanは環境依存なので､使わないようにしましょう
// date_default_timezone_set('Japan');
date_default_timezone_set('Asia/Tokyo');
echo '<p>',date('Y/m/d H:i:s'),'</p>';
echo '<p>',date('Y年m月d日 H時i分s秒'),'</p>';

$today = date('y-m-d');

echo $today, "\n"; //2025-08-25
echo strtotime($today), "\n";
      // ↑ 文字列の日付をタイムスタンプに変える関数
      // この数字は1970-01-01から秒をカウントした値
      //  UNIXタイムスタンプといいます｡
?>
<?php require '../footer.php'; ?>