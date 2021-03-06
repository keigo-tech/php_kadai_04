<?php
session_start();
include("functions.php");
check_session_id();

// 送信確認

// 受け取ったデータを変数に入れる
$message = $_POST['message'];
// $reply_post_id = $_POST['reply_post_id'];

// DB接続
$pdo = connect_to_db();

// データ登録SQL作成
// `created_at`と`updated_at`には実行時の`sysdate()`関数を用いて実行時の日時を入力する
$sql = 'INSERT INTO posts(id, message, created_at, updated_at) VALUES(NULL, :message, sysdate(), sysdate())';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':message', $message, PDO::PARAM_STR);
// $stmt->bindValue(':reply_post_id', $reply_post_id, PDO::PARAM_STR);
// var_dump($_POST);
// exit();
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
  header("Location:bbs_input.php");
  exit();
}
