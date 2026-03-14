<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../functions.php';

if (!isAdmin()) {
    redirect('../index.php');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ-панель</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <nav>
            <a href="../index.php">На сайт</a>
            <a href="adminindex.php">Управление статьями</a>
            <a href="admincomments.php">Комментарии</a>
            <a href="adminadd_post.php">Добавить статью</a>
            <a href="../logout.php">Выйти</a>
        </nav>
    </header>
    <main>