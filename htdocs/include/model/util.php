<?php

require_once __DIR__.'/const.php';

function nickname(string $nickname) : string {
    return ($nickname === '') ? BBS_DEFAULT_NICKNAME : $nickname;
}
