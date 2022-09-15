<?php

function get_thread_list(PDO $pdo) : ?array {
    try {
        $stmt = $pdo->query('SELECT * FROM threads ORDER BY last_updated_at DESC');
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

function make_new_thread(PDO $pdo, string $title, string $poster_nickname, DateTime $created_at, string $content) : ?int {
    $formatted_created_at = $created_at->format('Y-m-d H:i:s');
    try {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare('INSERT INTO threads (title, last_updated_at) VALUES (:title, :created_at)');
        $stmt->bindParam('created_at', $formatted_created_at);
        $stmt->bindParam('title', $title);
        $stmt->execute();
        $thread_id = $pdo->query('SELECT LAST_INSERT_ID()')->fetchColumn();
        $stmt = $pdo->prepare('INSERT INTO posts (thread_id, poster_nickname, created_at, content) VALUES (:thread_id, :poster_nickname, :created_at, :content)');
        $stmt->bindParam('thread_id', $thread_id, PDO::PARAM_INT);
        $stmt->bindParam('poster_nickname', $poster_nickname);
        $stmt->bindParam('created_at', $formatted_created_at);
        $stmt->bindParam('content', $content);
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

function make_new_post(PDO $pdo, int $thread_id, string $poster_nickname, DateTime $created_at, string $content) : ?int {
    $formatted_created_at = $created_at->format('Y-m-d H:i:s');
    try {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare('INSERT INTO posts (thread_id, poster_nickname, created_at, content) VALUES (:thread_id, :poster_nickname, :created_at, :content)');
        $stmt->bindParam('thread_id', $thread_id, PDO::PARAM_INT);
        $stmt->bindParam('poster_nickname', $poster_nickname);
        $stmt->bindParam('created_at', $formatted_created_at);
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
