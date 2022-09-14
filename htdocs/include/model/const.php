<?php

# Configurable zone.
# データベースの設定
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'my_keijiban');

# 掲示板の名前
define('BBS_NAME', 'マイ掲示板');
# スレッドタイトルの最大長
define('BBS_TITLE_LENGTH', 64);
# 投稿者名の最大長
define('BBS_NICKNAME_LENGTH', 64);
# 書き込み内容の最大長
define('BBS_CONTENT_LENGTH', 1000);

# Not configurable zone.
# Do not edit.
define('BBS_TITLE_BYTE_LENGTH', 4 * BBS_TITLE_LENGTH);
define('BBS_NICKNAME_BYTE_LENGTH', 4 * BBS_NICKNAME_LENGTH);
define('BBS_CONTENT_BYTE_LENGTH', 4 * BBS_CONTENT_LENGTH);
