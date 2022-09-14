<?php

require_once __DIR__.'/const.php';

function get_db_connection() : ?PDO {
    try {
        return new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
    } catch (Exception $e) {
        error_log($e->getMessage());
        return null;
    }
}

function create_database(PDO $pdo, string $dbname) : bool {
    try {
        $pdo->query('CREATE DATABASE IF NOT EXISTS '.$dbname);
        return true;
    } catch (Exception $e) {
        error_log($e->getMessage());
        return false;
    }
}

function use_database(PDO $pdo, string $dbname) : bool {
    try {
        $pdo->query('USE '.$dbname);
        return true;
    } catch (Exception $e) {
        error_log($e->getMessage());
        return false;
    }
}
