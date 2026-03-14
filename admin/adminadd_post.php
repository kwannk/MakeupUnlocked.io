<?php
require_once 'adminheader.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $image = isset($_POST['image']) ? trim($_POST['image']) : '';

    if (empty($title) || empty($content)) {
        $error = 'Заполните все поля.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO posts (title, content, image, user_id) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$title, $content, $image ?: null, $_SESSION['user_id']])) {
            $success = 'Статья добавлена!';
        } else {
            $error = 'Ошибка при добавлении.';
        }
    }
}
?>

<h2>Добавить статью</h2>

<?php if ($error): ?>
    <div style="color: red;"><?php echo $error; ?></div>
<?php endif; ?>
<?php if ($success): ?>
    <div style="color: green;"><?php echo $success; ?></div>
<?php endif; ?>

<form method="post" action="">
    <div>
        <label for="title">Заголовок:</label><br>
        <input type="text" name="title" id="title" size="50" required>
    </div>
    <div>
        <label for="content">Текст статьи:</label><br>
        <textarea name="content" id="content" rows="15" cols="70" required></textarea>
    </div>
    <div>
        <label for="image">Ссылка на изображение (необязательно):</label><br>
        <input type="url" name="image" id="image" size="70" placeholder="https://example.com/image.jpg">
    </div>
    <button type="submit">Добавить</button>
</form>

<?php include 'adminfooter.php'; ?>