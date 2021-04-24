<?php

session_start();
// include('functions.php');
include('bbs_read.php');
$pdo = connect_to_db();

// データ取得SQL作成
$sql = 'SELECT * FROM member';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>ひとこと掲示板</title>

	<link rel="stylesheet" href="style.css" />
</head>

<body>
<div id="wrap">
  <div id="head">
    <h1>ひとこと掲示板</h1>
  </div>
  <div id="content">
  	<div style="text-align: right"><a href="bbs_logout.php">ログアウト</a></div>
    <form action="bbs_create.php" method="post">
      <dl>
        <dt><?=$_SESSION['username']?>さん、メッセージをどうぞ</dt>
        <dd>
          <textarea name="message" cols="50" rows="5"></textarea>
          <!-- <input type="hidden" name="reply_post_id" value="" /> -->
        </dd>
      </dl>
      <div>
        <p>
          <input type="submit" value="投稿する" />
        </p>
      </div>
    </form>
    <?= $output ?>

<!-- <ul class="paging">
<li><a href="index.php?page=">前のページへ</a></li>
<li><a href="index.php?page=">次のページへ</a></li>
</ul> -->
  </div>
</div>
</body>
</html>
