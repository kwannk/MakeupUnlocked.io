<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Блог</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <a href="index.php">Главная</a>
            <?php if (isLoggedIn()): ?>
                <a href="logout.php">Выйти (<?php echo htmlspecialchars($_SESSION['user_name']); ?>)</a>
                <?php if (isAdmin()): ?>
                    <a href="admin/adminindex.php">Админ-панель</a>
                <?php endif; ?>
            <?php else: ?>
                <a href="register.php">Регистрация</a>
                <a href="login.php">Вход</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>