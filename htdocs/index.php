<?php
require_once __DIR__.'/include/model/const.php';
require_once __DIR__.'/include/model/db.php';
require_once __DIR__.'/include/model/thread.php';

$threads = null;
$current_thread_id = null;

$pdo = get_db_connection();
if ($pdo) {
    $threads = get_thread_and_first_post_list($pdo);
}

?><!DOCTYPE html>
<html>
    <head>
	<title><?=htmlspecialchars(BBS_NAME)?></title>
    </head>
    <body>
	<?php include __DIR__.'/include/header.php'; ?>
	<?php include __DIR__.'/include/status.php'; ?>
	<div>
	    <h2>スレッド一覧</h2>
	    <?php if (is_null($threads)): ?>
		<p>スレッド一覧の取得に失敗しました。</p>
	    <?php else: ?>
		<?php
		foreach ($threads as $thread):
		if ($thread['is_hidden'] === IS_HIDDEN_FALSE): ?>
		    <div>
			<h2><a href="/thread.php?id=<?=$thread['id']?>"><?=htmlspecialchars($thread['title'])?></a></h2>
			<?php 
			$count = 1;
			$post = ['id' => $thread['first_post_id'],
				 'thread_id' => $thread['id'],
				 'poster_nickname' => $thread['poster_nickname'],
				 'created_at' => $thread['created_at'],
				 'is_hidden' => $thread['is_hidden'],
				 'content' => $thread['content']];
			include __DIR__.'/include/post.php'; ?>
		    </div>
		<?php endif; endforeach;?>
	    <?php endif; ?>
	</div>
	<?php include __DIR__.'/include/footer.php'; ?>
    </body>
</html>
