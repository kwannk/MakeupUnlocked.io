<?php
require_once 'adminheader.php';

$limit = 20;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$totalStmt = $pdo->query("SELECT COUNT(*) FROM comments");
$totalComments = $totalStmt->fetchColumn();
$totalPages = ceil($totalComments / $limit);

$stmt = $pdo->prepare("
    SELECT comments.*, users.name AS user_name, posts.title AS post_title
    FROM comments
    JOIN users ON comments.user_id = users.id
    JOIN posts ON comments.post_id = posts.id
    ORDER BY comments.created_at DESC
    LIMIT :limit OFFSET :offset
");
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$comments = $stmt->fetchAll();
?>

<h2>Управление комментариями</h2>

<?php if (empty($comments)): ?>
    <p>Комментариев нет.</p>
<?php else: ?>
    <table border="1" cellpadding="10" style="width:100%; border-collapse: collapse;">
        <tr>
            <th>ID</th>
            <th>Автор</th>
            <th>Статья</th>
            <th>Комментарий</th>
            <th>Дата</th>
            <th>Действия</th>
        </tr>
        <?php foreach ($comments as $comment): ?>
        <tr>
            <td><?php echo $comment['id']; ?></td>
            <td><?php echo htmlspecialchars($comment['user_name']); ?></td>
            <td><a href="../post.php?id=<?php echo $comment['post_id']; ?>" target="_blank"><?php echo htmlspecialchars($comment['post_title']); ?></a></td>
            <td><?php echo nl2br(htmlspecialchars(substr($comment['comment'], 0, 100))); ?>...</td>
            <td><?php echo $comment['created_at']; ?></td>
            <td>
                <a href="admindelete_comment.php?id=<?php echo $comment['id']; ?>" onclick="return confirm('Удалить комментарий?')">🗑️ Удалить</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page-1; ?>">« Предыдущая</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <?php if ($i == $page): ?>
                    <span class="current"><?php echo $i; ?></span>
                <?php else: ?>
                    <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>
            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo $page+1; ?>">Следующая »</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php include 'adminfooter.php'; ?>