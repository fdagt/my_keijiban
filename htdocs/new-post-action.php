<?php

require_once __DIR__.'/include/model/const.php';
require_once __DIR__.'/include/model/db.php';
require_once __DIR__.'/include/model/thread.php';

if (!isset($_POST['submit'])) {
    header('Location: /index.php');
    exit;
}

$thread_id = filter_var($_POST['thread_id'], FILTER_VALIDATE_INT);
$poster_nickname = $_POST['poster_nickname'];
$content = $_POST['content'];
$post_id = null;

$pdo = get_db_connection();
if ($pdo && ($thread_id !== false))
    $post_id = make_new_post($pdo, $thread_id, $poster_nickname, new DateTime('now', new DateTimeZone(BBS_TIMEZONE)), $_SERVER['REMOTE_ADDR'], $content);

header('Location: /thread.php?id='.$thread_id.'&s='.(is_null($post_id) ? STATUS_CODE_NEW_POST_FAIL : STATUS_CODE_NEW_POST_SUCCESS));
