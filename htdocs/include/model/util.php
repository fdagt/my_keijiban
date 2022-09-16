<?php

require_once __DIR__.'/const.php';

function nickname(string $nickname) : string {
    return ($nickname === '') ? BBS_DEFAULT_NICKNAME : $nickname;
}

function is_strlen_in_range(string $str, int $lower_bound, int $upper_bound) : bool {
    $len = strlen($str);
    return ($lower_bound <= $len) && ($len <= $upper_bound);
}
