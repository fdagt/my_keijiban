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
# タイムゾーン
define('BBS_TIMEZONE', 'Asia/Tokyo');
# デフォルトの投稿者名
define('BBS_DEFAULT_NICKNAME', '名無しさん');
# IDの長さ(0~20)
define('BBS_ID_LENGTH', 12);

# Not configurable zone.
# Do not edit.
define('BBS_TITLE_BYTE_LENGTH', 4 * BBS_TITLE_LENGTH);
define('BBS_NICKNAME_BYTE_LENGTH', 4 * BBS_NICKNAME_LENGTH);
define('BBS_CONTENT_BYTE_LENGTH', 4 * BBS_CONTENT_LENGTH);
define('BBS_SALT_LENGTH', 30);

define('STATUS_CODE_NEW_THREAD_SUCCESS', 0x10);
define('STATUS_CODE_NEW_THREAD_FAIL', 0x11);
define('STATUS_CODE_NEW_POST_SUCCESS', 0x20);
define('STATUS_CODE_NEW_POST_FAIL', 0x21);
define('STATUS_CODE_SET_IS_HIDDEN_SUCCESS', 0x31);
define('STATUS_CODE_SET_IS_HIDDEN_FAIL', 0x31);

define('IS_HIDDEN_TRUE', 1);
define('IS_HIDDEN_FALSE', 0);
