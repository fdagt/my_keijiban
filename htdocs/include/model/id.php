<?php

require_once __DIR__.'/const.php';

function get_salt(PDO $pdo, string $now) : ?string {
    try {
        $pdo->beginTransaction();
        $salt = $pdo->query('SELECT * FROM salt LIMIT 1')->fetch(PDO::FETCH_ASSOC);
        $salt_str = $salt['value'];
        if ($salt['updated_at'] !== $now) {
            $salt_str = random_bytes(BBS_SALT_LENGTH);
            $stmt = $pdo->prepare('UPDATE salt SET updated_at = :now, value = :value');
            $stmt->bindParam('now', $now);
            $stmt->bindParam('value', $salt_str);
            $stmt->execute();
        }
        $pdo->commit();
        return $salt_str;
    } catch (Exception $e) {
        error_log($e->getMessage());
        return null;
    }
}

function get_id(PDO $pdo, DateTime $now, string $ip_address) : ?string {
    $formatted_now = $now->format('Y-m-d');
    $salt = get_salt($pdo, $formatted_now);
    if (is_null($salt))
        return null;
    $str = $formatted_now.'!'.$ip_address.'!'.$salt;
    $hash = base64_encode(sha1($str, true));
    return substr($hash, 0, BBS_ID_LENGTH);
}
