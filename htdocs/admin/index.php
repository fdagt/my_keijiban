<?php
require_once __DIR__.'/../include/model/const.php';
require_once __DIR__.'/../include/model/db.php';
require_once __DIR__.'/../include/model/thread.php';

$threads = null;
$pdo = get_db_connection();
if ($pdo) {
    $threads = get_thread_and_first_post_list($pdo);
}

$pdo = null;    
?><!DOCTYPE html>
<html>
    <head>
	<title><?=htmlspecialchars(BBS_NAME)?> 管理ページ</title>
    </head>
    <body>
	<?php include __DIR__.'/../include/admin-header.php'; ?>
	<?php include __DIR__.'/../include/admin-status.php'; ?>
	<div>
	    <h2>スレッド一覧</h2>
	    <?php if (is_null($threads)): ?>
		<p>スレッドの取得に失敗しました。</p>
	    <?php else: ?>
		<ul>
		    <?php foreach ($threads as $thread): ?>
			<li>
			    <?php if ($thread['is_hidden']) echo '<del>'; ?>
			    <a href="/admin/thread.php?id=<?=$thread['id']?>">
				<?=htmlspecialchars($thread['title'])?>
			    </a>
			    <?php if ($thread['is_hidden']) echo '</del>'; ?>
			</li>
		    <?php endforeach; ?>
		</ul>
	    <?php endif; ?>
	</div>
	<?php include __DIR__.'/../include/admin-footer.php'; ?>
    </body>
</html>
