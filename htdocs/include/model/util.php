<?php

require_once __DIR__.'/const.php';

function nickname(string $nickname) : string {
    return ($nickname === '') ? BBS_DEFAULT_NICKNAME : $nickname;
}

function is_strlen_in_range(string $str, int $lower_bound, int $upper_bound) : bool {
    $len = strlen($str);
    return ($lower_bound <= $len) && ($len <= $upper_bound);
}

function process_post_content(string $content) : string {
    $matches = null;
    preg_match_all("/https?:\\/\\/(?:www\\.)?[-a-zA-Z0-9@:%._\\+~#=]{1,256}\\.[a-zA-Z0-9()]{1,6}\\b(?:[-a-zA-Z0-9()@:%_\\+.~#?&\\/=]*)/", $content, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
    $prev = 0;
    $result = '';
    foreach ($matches as $match) {
        $url = htmlspecialchars($match[0][0]);
        $index = $match[0][1];
        $prefix = htmlspecialchars(substr($content, $prev, $index - $prev));
        $link = '<a href="'.$url.'">'.$url.'</a>';
        $result = $result.$prefix.$link;
        $prev = $index + strlen($match[0][0]);
    }
    $result = $result.htmlspecialchars(substr($content, $prev));
    return $result;
}
