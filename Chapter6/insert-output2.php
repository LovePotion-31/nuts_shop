<?php require '../header.php'; ?>
<?php
require_once '../connect.php';

try {
    if (empty($_REQUEST['name'])) {
        throw new Exception('商品名を入力してください｡');
    }
    if (!preg_match('/^[0-9]+$/', $_REQUEST['price'])) {
        throw new Exception('価格を整数で入力してください｡');
    }
    if (!is_uploaded_file($_FILES['file']['tmp_name'])) {
        throw new Exception('画像ファイルを選択してください｡');
    }

    $pdo->beginTransaction();

    // 商品をDBに追加
    // この入れ方だと商品IDがわからないので lastInsertId を使う
    $sql = $pdo->prepare('insert into product values(null, ?, ?)');
    // if ($sql->execute([htmlspecialchars($_REQUEST['name']), $_REQUEST['price']])) {
    //   // ファイルの保存処理が個々に来る
    //   // ファイルの名前が商品IDと一致するようにトランザクションで囲む
    //   // last_inserted_id で追加された商品IDを取得
    //   // ファイル名を 13.jpg のようにして ./image フォルダに移動
    //   // DBに入って､ファイルが保存出来たらコミット
    //   // 何かしらのエラーが起きたら ロールバック
    // }
    $sql->execute([
        htmlspecialchars($_REQUEST['name']),
        $_REQUEST['price'],
    ]);

    // last_inserted_id で追加された商品IDを取得
    $product_id = $pdo->lastInsertId();

    // 画像を保存するフォルダ
    if (!file_exists('../chapter7/image')) {
        mkdir('../chapter7/image'); // なければフォルダを作る
    }

    // MIMEタイプを調べる ("image/jpeg" / "image/png" など)
    $type = $_FILES['file']['type'];

    // 拡張子を決めてファイル名を作る
    if ($type == "image/jpeg") {
        $file = "../chapter7/image/{$product_id}.jpg";
    } else if ($type == "image/png") {
        $file = "../chapter7/image/{$product_id}.png";  // 元は pmg になっていたので修正
    } else {
        throw new Exception('JPEG または PNG の画像をアップロードしてください｡');
    }

    // 送られたファイルは xampp フォルダの tmp フォルダに一時的に保存される
    if (move_uploaded_file($_FILES['file']['tmp_name'], $file)) {
        echo $file, ' のアップロードに成功しました。';
        echo '<p><img alt="image" src="', $file, '" width="200"></p>';
    } else {
        throw new Exception('アップロードに失敗しました。');
    }

    // DBとファイル保存が成功したらコミット
    $pdo->commit();
    echo '追加に成功しました';

} catch (Exception $e) {
    // 何かしらのエラーが起きたらロールバック
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo 'エラー: ' . $e->getMessage();
}
?>
<?php require '../footer.php'; ?>
