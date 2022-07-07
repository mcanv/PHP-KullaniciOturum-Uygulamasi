<?php

$config = include(__DIR__ . './config.php');
session_start();

$host     = $config->DB_HOST;
$db       = $config->DB_NAME;
$user     = $config->DB_USER;
$password = $config->DB_PASS;

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

try {
    $db = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (PDOException $e) {
    die($e->getMessage());
}