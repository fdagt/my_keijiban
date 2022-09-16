<?php
require_once __DIR__.'/include/model/const.php';

$current_thread_id = null;
?><!DOCTYPE html>
<html>
    <head>
	<title>新しいスレッド | <?=htmlspecialchars(BBS_NAME)?></title>
    </head>
    <body>
	<?php include __DIR__.'/include/header.php'; ?>
	<?php include __DIR__.'/include/status.php'; ?>
	<div>
	    <h2>新しいスレッド</h2>
	    <form method="post" action="/f/new-thread.php">
		<div>
		    <label for="title">タイトル</label>
		    <br>
		    <input type="text" id="title" name="title"
			   required maxlength="<?=BBS_TITLE_LENGTH?>">
		</div>
		<div>
		    <label for="poster_nickname">名前</label>
		    <br>
		    <input type="text" id="poster_nickname" name="poster_nickname"
			   maxlength="<?=BBS_NICKNAME_LENGTH?>">
		</div>
		<div>
		    <label for="content">書き込み内容</label>
		    <br>
		    <textarea id="content" name="content"
			      required maxlength="<?=BBS_CONTENT_LENGTH?>"></textarea>
		</div>
		<div>
		    <input type="submit" name="submit" value="送信">
		</div>
	    </form>
	    
	</div>
	<?php include __DIR__.'/include/footer.php'; ?>
    </body>
</html>
