<?php
require_once __DIR__.'/../include/model/const.php';
require_once __DIR__.'/../include/model/db.php';
require_once __DIR__.'/../include/model/thread.php';

if (!$_POST['submit']) {
    header('Location: /admin/index.php');
    exit;
}

$thread_id = filter_var($_POST['thread_id'], FILTER_VALIDATE_INT);
$post_id = filter_var($_POST['post_id'], FILTER_VALIDATE_INT);
$new_is_hidden = $_POST['value'] === 'true';

$pdo = get_db_connection();

$success = set_posts_is_hidden($pdo, $post_id, $new_is_hidden);

header('Location: /admin/thread.php?id='.$thread_id.'&s='.($success ? STATUS_CODE_SET_IS_HIDDEN_SUCCESS : STATUS_CODE_SET_IS_HIDDEN_FAIL).'#post-'.$post_id);

