<?php

function get_thread_list(PDO $pdo) : ?array {
    try {
        $stmt = $pdo->query('SELECT * FROM threads ORDER BY id DESC');
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

function make_new_thread(PDO $pdo, string $title, string $poster_nickname, string $content) : ?int {
    try {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare('INSERT INTO threads (title) VALUES (:title)');
        $stmt->bindParam('title', $title);
        $stmt->execute();
        $thread_id = $pdo->query('SELECT LAST_INSERT_ID()')->fetchColumn();
        $stmt = $pdo->prepare('INSERT INTO posts (thread_id, poster_nickname, content) VALUES (:thread_id, :poster_nickname, :content)');
        $stmt->bindParam('thread_id', $thread_id, PDO::PARAM_INT);
        $stmt->bindParam('poster_nickname', $poster_nickname);
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

function make_new_post(PDO $pdo, int $thread_id, string $poster_nickname, string $content) : ?int {
    try {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare('INSERT INTO posts (thread_id, poster_nickname, content) VALUES (:thread_id, :poster_nickname, :content)');
        $stmt->bindParam('thread_id', $thread_id, PDO::PARAM_INT);
        $stmt->bindParam('poster_nickname', $poster_nickname);
        $stmt->bindParam('content', $content);
        $stmt->execute();
        $post_id = $pdo->query('SELECT LAST_INSERT_ID()')->fetchColumn();
        $pdo->commit();
        return $post_id;
    } catch (Exception $e) {
        if ($pdo->inTransaction())
            $pdo->rollBack();
        error_log($e->getMessage());
        return null;
    }
    
}
