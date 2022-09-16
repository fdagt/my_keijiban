<?php
require_once __DIR__.'/model/const.php';

$status_code = null;
if (isset($_GET['s']))
    $status_code = filter_var($_GET['s'], FILTER_VALIDATE_INT);

if ($status_code === STATUS_CODE_SET_IS_HIDDEN_SUCCESS): ?>
    <p>表示・非表示の切り替えに成功しました。</p>
<?php elseif ($status_code === STATUS_CODE_SET_IS_HIDDEN_FAIL): ?>
    <p>表示・非表示の切り替えに失敗しました。</p>
<?php endif; ?>
