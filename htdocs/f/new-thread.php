<?php

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

$thread_id = make_new_thread($pdo, $title, $poster_nickname, $content);

if (is_null($thread_id))
    header('Location: /new-thread.php');
else
    header('Location: /thread.php?id=' . $thread_id);
