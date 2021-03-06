<?php
session_start();
include("functions.php");
check_session_id();

// DB接続
$pdo = connect_to_db();

// データ取得SQL作成
$sql = 'SELECT * FROM posts';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
  // fetchAll()関数でSQLで取得したレコードを配列で取得できる
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
  $output = "";
  // <tr><td>deadline</td><td>todo</td><tr>の形になるようにforeachで順番に$outputへデータを追加
  // `.=`は後ろに文字列を追加する，の意味
  foreach ($result as $record) {
    // $output .= "<tr>";
    // $output .= "<td>{$record["deadline"]}</td>";
    // $output .= "<td>{$record["todo"]}</td>";
    // edit deleteリンクを追加
    // $output .= "<td><a href='todo_edit.php?id={$record["id"]}'>edit</a></td>";
    // $output .= "<td><a href='todo_delete.php?id={$record["id"]}'>delete</a></td>";
    // $output .= "</tr>";

    //オリジナル
    $output .= "<div class='msg'>";
    $output .= "<p><span class='name'>{$_SESSION['username']}</span></p>";
    $output .= "<p>{$record['message']}</p>";
    $output .= "<p class='day'><a href='bbs_read.php?id={$record["id"]}'></a><a href='view.php?id={$record["id"]}'>返信元のメッセージ</a><a href='bbs_delete.php?id={$record["id"]}'style='color:#F33;'>削除</a></p>";
    $output .= "</div>";
  }
  // $valueの参照を解除する．解除しないと，再度foreachした場合に最初からループしない
  // 今回は以降foreachしないので影響なし
  unset($value);
}
?>
