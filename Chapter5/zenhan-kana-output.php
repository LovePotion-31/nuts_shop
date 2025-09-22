<?php require '../header.php';
echo 'フリガナは｢', mb_convert_kana($_REQUEST['furigana']), '｣です｡';
require '../footer.php'; ?>