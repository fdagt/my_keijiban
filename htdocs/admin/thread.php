<?php
require_once __DIR__.'/../include/model/const.php';
require_once __DIR__.'/../include/model/db.php';
require_once __DIR__.'/../include/model/thread.php';

$thread_id = null;
if (isset($_GET['id']))
    $thread_id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
if (is_null($thread_id) || ($thread_id === false)) {
    header('Location: /admin/index.php');
    exit;
}

$posts = null;
$thread_info = null;
$is_error = true;

$pdo = get_db_connection();
if ($pdo) {
    $posts = get_post_list($pdo, $thread_id);
    $thread_info = get_thread_info($pdo, $thread_id);
    $is_error = is_null($posts) || is_null($is_error);
}
?><!DOCTYPE html>
<html>
    <head>
	<?php if ($is_error): ?>
	    <title>エラー | <?=htmlspecialchars(BBS_NAME)?> 管理ページ</title>
	<?php else: ?>
	    <title><?=htmlspecialchars($thread_info['title'])?> | <?=htmlspecialchars(BBS_NAME)?> 管理ページ</title>
	<?php endif; ?>
    </head>
    <body>
	<?php include __DIR__.'/../include/admin-header.php'; ?>
	<?php include __DIR__.'/../include/admin-status.php'; ?>
	<?php if ($is_error): ?>
	    <p>エラーが発生しました。</p>
	<?php else: ?>
	    <div>
		<h2><?=htmlspecialchars($thread_info['title'])?></h2>
		<?php
		$count = 0;
		foreach ($posts as $post) {
		    ++$count;
		    include __DIR__.'/../include/admin-post.php';
		}
		?>
	    </div>
	<?php endif; ?>
	<?php include __DIR__.'/../include/admin-footer.php'; ?>
    </body>
</html>
