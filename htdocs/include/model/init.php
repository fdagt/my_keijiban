<?php

require_once __DIR__.'/const.php';
require_once __DIR__.'/db.php';

function create_threads_table(PDO $pdo) : bool {
    try {
        $stmt = $pdo->prepare('CREATE TABLE IF NOT EXISTS threads (
id INT AUTO_INCREMENT,
title VARCHAR(:title_length),
PRIMARY KEY (id)
)');
        $stmt->bindValue('title_length', BBS_TITLE_BYTE_LENGTH, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (Exception $e) {
        error_log($e->getMessage());
        return false;
    }
}

function create_posts_table(PDO $pdo) : bool {
    try {
        $stmt = $pdo->prepare('CREATE TABLE IF NOT EXISTS posts (
id INT AUTO_INCREMENT,
thread_id INT,
poster_nickname VARCHAR(:nickname_length),
content VARCHAR(:content_length),
PRIMARY KEY (id),
FOREIGN KEY (thread_id) REFERENCES threads(id)
)');
        $stmt->bindValue('nickname_length', BBS_NICKNAME_BYTE_LENGTH, PDO::PARAM_INT);
        $stmt->bindValue('content_length', BBS_CONTENT_BYTE_LENGTH, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (Exception $e) {
        error_log($e->getMessage());
        return false;
    }
}

function create_tables(PDO $pdo) : bool {
    $success = true;
    $success = create_threads_table($pdo) && $success;
    $success = create_posts_table($pdo) && $success;
    return $success;
}

function initialize_main() {
    $pdo = new PDO('mysql:host='.DB_HOST, DB_USER, DB_PASSWORD);
    if (!create_database($pdo, DB_NAME)) {
        echo 'Failed to create a database.', PHP_EOL;
        return 1;
    }
    if (!use_database($pdo, DB_NAME)) {
        echo 'Something is wrong with the database.', PHP_EOL;
        return 1;
    }
    if (!create_tables($pdo)) {
        echo 'Failed to create tables.', PHP_EOL;
        return 1;
    }
    return 0;
}