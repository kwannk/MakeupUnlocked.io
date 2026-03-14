<?php
require_once 'adminheader.php';

$stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts = $stmt->fetchAll();
?>

<h2>Управление статьями</h2>

<p><a href="adminadd_post.php" class="button">➕ Добавить статью</a></p>

<?php if (empty($posts)): ?>
    <p>Статей нет.</p>
<?php else: ?>
    <table border="1" cellpadding="10" style="width:100%; border-collapse: collapse;">
        <tr>
            <th>ID</th>
            <th>Заголовок</th>
            <th>Дата</th>
            <th>Действия</th>
        </tr>
        <?php foreach ($posts as $post): ?>
        <tr>
            <td><?php echo $post['id']; ?></td>
            <td><?php echo htmlspecialchars($post['title']); ?></td>
            <td><?php echo $post['created_at']; ?></td>
            <td>
                <a href="adminedit_post.php?id=<?php echo $post['id']; ?>">✏️ Редактировать</a>
                <a href="admindelete_post.php?id=<?php echo $post['id']; ?>" onclick="return confirm('Удалить статью? Будут удалены все комментарии.')">🗑️ Удалить</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?php include 'adminfooter.php'; ?>