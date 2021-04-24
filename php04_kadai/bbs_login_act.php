<?php
// var_dump($_POST);
// exit();

session_start();
include('functions.php');
$pdo = connect_to_db();

$username = $_POST['username'];
$password = sha1($_POST['password']);

$sql = 'SELECT * FROM member WHERE username=:username AND password=:password AND is_deleted=0';


// SQL準備&実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$status = $stmt->execute();

$val = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$val){
  echo "<p>ログイン情報に誤りがあります</p>";
  echo '<a href="todo_login.php">ログイン</a>';
}else{
  $_SESSION = array();
  $_SESSION['session_id'] = session_id();
  $_SESSION['is_admin'] = $val['is_admin'];
  $_SESSION['username'] = $val['username'];
  header("Location:bbs_input.php");
  exit();
}
