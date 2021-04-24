<?php
// session_start();
include('functions.php');
// var_dump($_POST);
// exit();


// $name = $_SESSION['join']['name'];
// $email = $_SESSION['join']['email'];
// $password = sha1($_SESSION['join']['password']);
// $image = $_SESSION['join']['image'];

$name = $_POST['name'];
$email = $_POST['email'];
$password = sha1($_POST['password']);
$image = $_SESSION['join']['image'];

// DB接続
$pdo = connect_to_db();

$sql = 'INSERT INTO members(id, name, email, password, created_at, updated_at,authority) VALUES(NULL, :name, :email, :password, sysdate(), sysdate(), 1)';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
// var_dump($_SESSION);
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
  header("Location:thanks.php");
  exit();
}


?>
