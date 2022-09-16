<?php

require_once __DIR__.'/const.php';
require_once __DIR__.'/id.php';
require_once __DIR__.'/util.php';

function get_thread_list(PDO $pdo) : ?array {
    try {
        $stmt = $pdo->query('SELECT * FROM threads ORDER BY last_updated_at DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log($e->getMessage());
        return null;
    }
}

function get_thread_and_first_post_list(PDO $pdo) : ?array {
    try {
        $stmt = $pdo->query('SELECT threads.id AS id, title, last_updated_at, first_post_id, poster_nickname, created_at, public_id, is_hidden, content FROM threads INNER JOIN posts ON threads.first_post_id = posts.id ORDER BY last_updated_at DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log($e->getMessage());
        return null;
    }
}

function get_thread_info(PDO $pdo, int $thread_id) : ?array {
    try {
        $stmt = $pdo->prepare('SELECT * FROM threads WHERE id = :thread_id');
        $stmt->bindParam('thread_id', $thread_id, PDO::PARAM_INT);
        $stmt->execute();
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($record === false) ? null : $record;
    } catch (Exception $e) {
        error_log($e->getMessage());
        return null;
    }
}

function is_valid_new_thread_parameter(string $title, string $poster_nickname, string $content) : bool {
    $valid = true;
    $valid = $valid && is_strlen_in_range($title, 1, BBS_TITLE_LENGTH);
    $valid = $valid && is_strlen_in_range($poster_nickname, 0, BBS_NICKNAME_LENGTH);
    $valid = $valid && is_strlen_in_range($content, 1, BBS_CONTENT_LENGTH);
    return $valid;
}

function make_new_thread(PDO $pdo, string $title, string $poster_nickname, DateTime $created_at, string $ip_address, string $content) : ?int {
    if (!is_valid_new_thread_parameter($title, $poster_nickname, $content))
        return null;
    $public_id = get_id($pdo, $created_at, $ip_address);
    if (is_null($public_id))
        return null;
    $formatted_created_at = $created_at->format('Y-m-d H:i:s');
    try {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare('INSERT INTO threads (title, last_updated_at) VALUES (:title, :created_at)');
        $stmt->bindParam('created_at', $formatted_created_at);
        $stmt->bindParam('title', $title);
        $stmt->execute();
        $thread_id = $pdo->query('SELECT LAST_INSERT_ID()')->fetchColumn();
        $stmt = $pdo->prepare('INSERT INTO posts (thread_id, poster_nickname, created_at, public_id, is_hidden, content) VALUES (:thread_id, :poster_nickname, :created_at, :public_id, :is_hidden, :content)');
        $stmt->bindParam('thread_id', $thread_id, PDO::PARAM_INT);
        $stmt->bindParam('poster_nickname', $poster_nickname);
        $stmt->bindParam('created_at', $formatted_created_at);
        $stmt->bindParam('public_id', $public_id);
        $stmt->bindValue('is_hidden', IS_HIDDEN_FALSE);
        $stmt->bindParam('content', $content);
        $stmt->execute();
        $post_id = $pdo->query('SELECT LAST_INSERT_ID()')->fetchColumn();
        $stmt = $pdo->prepare('UPDATE threads SET first_post_id = :post_id WHERE id = :thread_id');
        $stmt->bindParam('post_id', $post_id);
        $stmt->bindParam('thread_id', $thread_id);
        $stmt->execute();
        $pdo->commit();
        return $thread_id;
    } catch (Exception $e) {
        if ($pdo->inTransaction())
            $pdo->rollBack();
        error_log($e->getMessage());
        return null;
    }
    
}

function get_post_list(PDO $pdo, int $thread_id) : ?array {
    try {
        $stmt = $pdo->prepare('SELECT * FROM posts WHERE thread_id = :thread_id');
        $stmt->bindParam('thread_id', $thread_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log($e->getMessage());
        return null;
    }
}

function is_valid_new_post_parameter(string $poster_nickname, string $content) : bool {
    $valid = true;
    $valid = $valid && is_strlen_in_range($poster_nickname, 0, BBS_NICKNAME_LENGTH);
    $valid = $valid && is_strlen_in_range($content, 1, BBS_CONTENT_LENGTH);
    return $valid;
}

function make_new_post(PDO $pdo, int $thread_id, string $poster_nickname, DateTime $created_at, string $ip_address, string $content) : ?int {
    if (!is_valid_new_post_parameter($poster_nickname, $content))
        return null;
    $public_id = get_id($pdo, $created_at, $ip_address);
    if (is_null($public_id))
        return null;
    $formatted_created_at = $created_at->format('Y-m-d H:i:s');
    try {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare('INSERT INTO posts (thread_id, poster_nickname, created_at, public_id, is_hidden, content) VALUES (:thread_id, :poster_nickname, :created_at, :public_id, :is_hidden, :content)');
        $stmt->bindParam('thread_id', $thread_id, PDO::PARAM_INT);
        $stmt->bindParam('poster_nickname', $poster_nickname);
        $stmt->bindParam('created_at', $formatted_created_at);
        $stmt->bindParam('public_id', $public_id);
        $stmt->bindValue('is_hidden', IS_HIDDEN_FALSE);
        $stmt->bindParam('content', $content);
        $stmt->execute();
        $post_id = $pdo->query('SELECT LAST_INSERT_ID()')->fetchColumn();
        $stmt = $pdo->prepare('UPDATE threads SET last_updated_at = :created_at WHERE id = :thread_id');
        $stmt->bindParam('thread_id', $thread_id, PDO::PARAM_INT);
        $stmt->bindParam('created_at', $formatted_created_at);
        $stmt->execute();
        $pdo->commit();
        return $post_id;
    } catch (Exception $e) {
        if ($pdo->inTransaction())
            $pdo->rollBack();
        error_log($e->getMessage());
        return null;
    }
    
}

function set_posts_is_hidden(PDO $pdo, int $post_id, bool $is_hidden) : bool {
    try {
        $stmt = $pdo->prepare('UPDATE posts SET is_hidden = :is_hidden WHERE id = :post_id');
        $stmt->bindValue('is_hidden', $is_hidden ? IS_HIDDEN_TRUE : IS_HIDDEN_FALSE);
        $stmt->bindParam('post_id', $post_id);
        $stmt->execute();
        return true;
    } catch (Exception $e) {
        error_log($e->getMessage());
        return false;
    }
}
