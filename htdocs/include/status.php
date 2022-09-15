<?php

require_once __DIR__.'/model/const.php';

$status_code = null;
if (isset($_GET['s']))
    $status_code = filter_var($_GET['s'], FILTER_VALIDATE_INT);
if ($status_code === false)
    $status_code = null;

if ($status_code === STATUS_CODE_NEW_THREAD_SUCCESS): ?>
    <p>スレッドが作成されました。</p>
<?php elseif ($status_code === STATUS_CODE_NEW_THREAD_FAIL): ?>
    <p>スレッドの作成に失敗しました。</p>
<?php elseif ($status_code === STATUS_CODE_NEW_POST_SUCCESS): ?>
    <p>書き込みが完了しました。</p>
<?php elseif ($status_code === STATUS_CODE_NEW_POST_FAIL): ?>
    <p>書き込みに失敗しました。</p>
<?php endif; ?>
