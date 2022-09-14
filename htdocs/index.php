<?php
require_once __DIR__.'/include/model/const.php';
require_once __DIR__.'/include/model/db.php';
require_once __DIR__.'/include/model/thread.php';

$threads = null;
$current_thread_id = null;

$pdo = get_db_connection();
if ($pdo) {
    $threads = get_thread_list($pdo);
}

?><!DOCTYPE html>
<html>
    <head>
	<title><?=htmlspecialchars(BBS_NAME)?></title>
    </head>
    <body>
	<?php include __DIR__.'/include/header.php'; ?>
	<div>
	    <h2>スレッド一覧</h2>
	    <?php if (is_null($threads)): ?>
		<p>スレッド一覧の取得に失敗しました。</p>
	    <?php else: ?>
		<ul>
		    <?php foreach ($threads as $thread): ?>
			<li><a href="/thread.php?id=<?=$thread['id']?>"><?=htmlspecialchars($thread['title'])?></a></li>
		    <?php endforeach; ?>
		</ul>
	    <?php endif; ?>
	</div>
	<?php include __DIR__.'/include/footer.php'; ?>
    </body>
</html>
