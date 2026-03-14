<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$host = 'sql100.infinityfree.com';
$dbname = 'if0_41366010_blog';
$username = 'if0_41366010';
$password = 'gRJSZHF9sQr7d';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}
?>