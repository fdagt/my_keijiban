<?php

require_once __DIR__.'/../include/model/db.php';
require_once __DIR__.'/../include/model/thread.php';

if (!isset($_POST['submit'])) {
    header('Location: /index.php');
    exit;
}

$thread_id = filter_var($_POST['thread_id'], FILTER_VALIDATE_INT);
$poster_nickname = $_POST['poster_nickname'];
$content = $_POST['content'];

$pdo = get_db_connection();

$post_id = make_new_post($pdo, $thread_id, $poster_nickname, $content);

header('Location: /thread.php?id=' . $thread_id);
