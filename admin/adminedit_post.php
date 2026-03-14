<?php
require_once 'adminheader.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    die('Статья не найдена.');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $image = isset($_POST['image']) ? trim($_POST['image']) : '';

    if (empty($title) || empty($content)) {
        $error = 'Заполните все поля.';
    } else {
        $stmt = $pdo->prepare("UPDATE posts SET title = ?, content = ?, image = ? WHERE id = ?");
        if ($stmt->execute([$title, $content, $image ?: null, $id])) {
            $success = 'Статья обновлена!';
            $post['title'] = $title;
            $post['content'] = $content;
            $post['image'] = $image;
        } else {
            $error = 'Ошибка при обновлении.';
        }
    }
}
?>

<h2>Редактировать статью</h2>

<?php if ($error): ?>
    <div style="color: red;"><?php echo $error; ?></div>
<?php endif; ?>
<?php if ($success): ?>
    <div style="color: green;"><?php echo $success; ?></div>
<?php endif; ?>

<form method="post" action="">
    <div>
        <label for="title">Заголовок:</label><br>
        <input type="text" name="title" id="title" size="50" value="<?php echo htmlspecialchars($post['title']); ?>" required>
    </div>
    <div>
        <label for="content">Текст статьи:</label><br>
        <textarea name="content" id="content" rows="15" cols="70" required><?php echo htmlspecialchars($post['content']); ?></textarea>
    </div>
    <div>
        <label for="image">Ссылка на изображение (оставьте пустым, чтобы убрать):</label><br>
        <input type="url" name="image" id="image" size="70" value="<?php echo htmlspecialchars($post['image']); ?>">
    </div>
    <?php if ($post['image']): ?>
        <div>
            <p>Текущее изображение:</p>
            <img src="<?php echo htmlspecialchars($post['image']); ?>" style="max-width: 200px;">
        </div>
    <?php endif; ?>
    <button type="submit">Сохранить</button>
</form>

<?php include 'adminfooter.php'; ?>