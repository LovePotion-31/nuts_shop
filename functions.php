<?php
//  function 関数の前につける)必須)
//  ()の中身､引数 ← 必要ない場合もある､この例では必須
//  :void は戻り値の型を指定(省略可)
//  作っただけだと実行されない
//  呼び出し元よりあとにあっても実行できる
//  ローカル変数とグローバル変数
//  引数の数が合わないとFatal Error
//  1.引数で渡す 2.グローバル宣言する 3.クラスにしてクラス変数に代入

class Result
{
  public $name = "次郎"; //グローバル宣言する
  function sum($scores_jiro)
  {
    // 配列の値を合計
    $total = 0; // 初期化する
    foreach ($scores_jiro as $val) {
      $total += $val;
    } // $name はローカル変数 関数の中にある変数
    // $this は自身のクラス
    return $this->name . $total;  // 戻り値(呼び出した場所に返す値)
  }
}
$scores_jiro = ['国語' => 65, '算数' => 75, '英語' => 85];
// $name= '太郎'; // ← グローバル変数 関数の外にある変数
// クラスを使うにはインスタンス化 (コピーを作る) します
$result_jiro = new Result();
echo $result_jiro->sum($scores_jiro);
//  -> アロー演算子 クラス内の

$scores_taro = ['国語' => 55, '算数' => 65, '英語' => 75];