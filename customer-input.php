<?php
session_start();
require '../header.php';
require 'menu.php';

$is_login = isset($_SESSION['customer']);

$name = $is_login ? ($_SESSION['customer']['name'] ?? '') : '';
$address = $is_login ? ($_SESSION['customer']['address'] ?? '') : '';
$email = $is_login ? ($_SESSION['customer']['email'] ?? '') : '';
$login = $is_login ? ($_SESSION['customer']['login'] ?? '') : '';

$action = $is_login ? 'customer-output-login.php' : 'customer-output-logoff.php';
$title = $is_login ? 'お客様情報確認･変更' : 'お客様情報の入力';
?>
<h3><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h3>

<!-- yubinbango はメインフォームに class="h-adr" をつけて使う -->
<form id="entry" class="h-adr" action="<?= $action ?>" method="post">
  <span class="p-country-name" style="display:none;">Japan</span>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>  <!-- jQueryを読み込む-->

  <table>
    <tr>
      <td>お名前</td>
      <td>
        <input type="text" name="name" value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>">
      </td>
    </tr>

    <!-- 郵便番号→住所自動入力（別フォームを作らない） -->
    <tr>
      <td>郵便番号</td>
      <td>
        〒<input type="text" class="p-postal-code" size="8" maxlength="7" inputmode="numeric" pattern="\d{3}-?\d{4}">
      </td>
    </tr>
    <tr>
      <td>ご住所</td>
      <td>
        <input type="text" class="p-region p-locality p-street-address p-extended-address" name="address"
          value="<?= htmlspecialchars($address, ENT_QUOTES, 'UTF-8') ?>">
      </td>
    </tr>

    <tr>
      <td>メールアドレス</td>
      <td>
        <input type="email" name="email"  value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>">
      </td>
    </tr>

    <tr>
      <td>ログインID</td>
      <td>
        <input type="text" name="login" id ="username" value="<?= htmlspecialchars($login, ENT_QUOTES, 'UTF-8') ?>">
        <span id="username-error" style="color: red; display: none;">このアカウントはすでに使用されています。</span>
      </td>
    </tr>

    <tr>
      <td>パスワード</td>
      <td>
        <input type="password" id="pswd1" name="password">
          <button class="btn btn-outline-secondary" type="button" id="togglePswd1">
            <i class="bi bi-eye"></i>
          </button>
      </td>
    </tr>
    <tr>
      <td>パスワード確認</td>
      <td>
        <input type="password" id="pswd2" name="password_confirm">
                  <button class="btn btn-outline-secondary" type="button" id="togglePswd2">
            <i class="bi bi-eye"></i>
          </button>

      </td>
    </tr>
  </table>

  <input type="button" value="確定" disabled onclick="check()">
</form>
    <script>
      // 要素を読み込みを待ってから
        $(document).ready(function() { //ブラウザが入れてくるので最初に消す
            // ユーザー名入力時にAJAXで重複チェック
            $('#username').on('blur', function() {
              // 入力値の取得
                var username = $(this).val();
                if (username !== "") {
                    $.ajax({
                        url: 'check_username.php', // サーバー側で重複をチェックするPHPファイル
                        type: 'POST',
                        data: { username: username },
                    })
                    .done(function(response) {  // AJAX成功時に実行される
                      // php からの戻り値↑が入ってる
                        if (response === 'exists') {
                            $('#username-error').show();  // 重複があればエラーメッセージを表示
                            $('[value="確定"').attr('disabled',true)
                        } else {
                            $('#username-error').hide();  // 重複していなければエラーメッセージを非表示
                            $('[value="確定"').removeAttr('disabled',false)
                        }
                    })
                    .fail(function() {  // AJAX失敗時のエラーハンドリング
                        alert('エラーが発生しました。');
                    });
                }
            });
        });
    </script>

<script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
<script>
  // パスワード一致チェック
  function check() {
    const pswd1 = document.querySelector("#pswd1").value;
    const pswd2 = document.querySelector("#pswd2").value;

    if (pswd1 === "") {
      alert("パスワードを入力してください");
      return;
    }
    if (pswd1 !== pswd2) {
      alert("パスワードが一致しません");
      return;
    }
    document.querySelector("#entry").submit();
  }

  // 目隠し切替関数
  function setupToggle(inputId, btnId) {
    const input = document.getElementById(inputId);
    const btn   = document.getElementById(btnId);

    btn.addEventListener("click", function() {
      const isPassword = input.type === "password";
      input.type = isPassword ? "text" : "password";
      this.innerHTML = isPassword
        ? '<i class="bi bi-eye-slash"></i>'
        : '<i class="bi bi-eye"></i>';
    });
  }

  // 初期化
  setupToggle("pswd1", "togglePswd1");
  setupToggle("pswd2", "togglePswd2");
</script>
<?php require '../footer.php'; ?>