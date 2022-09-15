<?php

require_once __DIR__.'/../include/model/const.php';
require_once __DIR__.'/../include/model/db.php';
require_once __DIR__.'/../include/model/thread.php';

if (!isset($_POST['submit'])) {
    header('Location: /index.php');
    exit;
}

$title = $_POST['title'];
$poster_nickname = $_POST['poster_nickname'];
$content = $_POST['content'];

$pdo = get_db_connection();

$thread_id = make_new_thread($pdo, $title, $poster_nickname, new DateTime('now', new DateTimeZone(BBS_TIMEZONE)), $content);

if (is_null($thread_id))
    header('Location: /new-thread.php?s='.STATUS_CODE_NEW_THREAD_FAIL);
else
    header('Location: /thread.php?id='.$thread_id.'&s='.STATUS_CODE_NEW_THREAD_SUCCESS);
