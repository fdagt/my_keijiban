<?php
require_once __DIR__.'/include/model/const.php';
require_once __DIR__.'/include/model/db.php';
require_once __DIR__.'/include/model/thread.php';
require_once __DIR__.'/include/model/util.php';

$posts = null;
$thread_info = null;
$current_thread_id = null;
if (isset($_GET['id']))
    $current_thread_id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
if (is_null($current_thread_id) || ($current_thread_id === false)) {
    header('Location: /index.php');
    exit;
}

$pdo = get_db_connection();
if ($pdo) {
    $posts = get_post_list($pdo, $current_thread_id);
    $thread_info = get_thread_info($pdo, $current_thread_id);
    $is_error = is_null($posts) || is_null($thread_info);
}

$pdo = null;
?><!DOCTYPE html>
<html>
    <head>
	<?php if ($is_error): ?>
	    <title>エラー | <?=htmlspecialchars(BBS_NAME)?></title>
	<?php else: ?>
	    <title><?=htmlspecialchars($thread_info['title'])?> | <?=htmlspecialchars(BBS_NAME)?></title>
	<?php endif; ?>
    </head>
    <body>
	<?php include __DIR__.'/include/header.php'; ?>
	<?php if ($is_error): ?>
	    <p>エラーが発生しました。時間をおいて再度アクセスしてください。</p>
	<?php else: ?>
	    <div>
		<h2><?=htmlspecialchars($thread_info['title'])?></h2>
		<?php
		$count = 0;
		foreach ($posts as $post):
		++$count;?>
		    <div id="post-<?=$count?>">
			<div><?=$count?>. <?=htmlspecialchars(nickname($post['poster_nickname']))?> <?=$post['created_at']?></div>
			<pre><?=htmlspecialchars($post['content'])?></pre>
		    </div>
		<?php endforeach; ?>
	    </div>
	    <hr>
	    <div>
		<h2>書き込む</h2>
		<form method="post" action="/f/new-post.php">
		    <input type="hidden" name="thread_id" value="<?=$current_thread_id?>">
		    <div>
			<label for="poster_nickname">名前</label>
			<br>
			<input type="text" id="poster_nickname" name="poster_nickname">
		    </div>
		    <div>
			<label for="content">書き込み内容</label>
			<br>
			<textarea id="content" name="content"></textarea>
		    </div>
		    <div>
			<input type="submit" name="submit" value="送信">
		    </div>
		</form>
	    </div>
	<?php endif; ?>
	<?php include __DIR__.'/include/footer.php'; ?>
    </body>
</html>
