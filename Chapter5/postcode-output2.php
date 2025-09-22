<?php require '../header.php'; 
$postcode=$_REQUEST['postcode'];
if (preg_match('/^[0-9]{3}-[0-9]{4}$/', $postcode)){
  echo '郵便番号', $postcode, 'を確認しました｡';}
  else{echo $postcode, 'は適切な番号ではありません｡';
}
require '../footer.php'; ?>