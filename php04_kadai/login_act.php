<?php

session_start();
include('functions.php');
$pdo = connect_to_db();

$email = $_POST['email'];
$password = sha1($_POST['password']);

$sql = 'SELECT * FROM members WHERE email=:email AND password=:password';


// SQL準備&実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
// var_dump($_POST);
// exit();
$status = $stmt->execute();

$val = $stmt->fetchAll(PDO::FETCH_ASSOC);
if(!$val){
  echo "<p>ログイン情報に誤りがあります</p>";
  echo '<a href="login.php">ログイン</a>';
}else{
  $_SESSION = array();
  $_SESSION['session_id'] = session_id();
  // $_SESSION['is_admin'] = $val['is_admin'];
  $_SESSION['email'] = $val['email'];
  $_SESSION['time'] = time();
  header("Location:main.php");
  exit();
}
