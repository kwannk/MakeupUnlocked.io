<?php
require_once 'config.php';
require_once 'functions.php';

$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

$totalStmt = $pdo->query("SELECT COUNT(*) FROM posts");
$totalPosts = $totalStmt->fetchColumn();
$totalPages = ceil($totalPosts / $limit);

$stmt = $pdo->prepare("
    SELECT posts.*, users.name AS author_name 
    FROM posts 
    JOIN users ON posts.user_id = users.id 
    ORDER BY posts.created_at DESC 
    LIMIT :limit OFFSET :offset
");
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll();
?>
<?php include 'header.php'; ?>

<h2>Последние статьи</h2>

<?php if (empty($posts)): ?>
    <p>Пока нет статей.</p>
<?php else: ?>
    <?php foreach ($posts as $post): ?>
        <article>
            <h3><a href="post.php?id=<?php echo $post['id']; ?>"><?php echo htmlspecialchars($post['title']); ?></a></h3>
            <p>Автор: <?php echo htmlspecialchars($post['author_name']); ?> | Дата: <?php echo $post['created_at']; ?></p>
            
            <?php if (!empty($post['image'])): ?>
                <div class="post-image">
                    <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                </div>
            <?php endif; ?>
            
            <p><?php echo nl2br(htmlspecialchars(substr($post['content'], 0, 200))); ?>...</p>
            <a href="post.php?id=<?php echo $post['id']; ?>" class="read-more">Читать далее</a>
        </article>
        <hr>
    <?php endforeach; ?>

    <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>">« Предыдущая</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <?php if ($i == $page): ?>
                    <span class="current"><?php echo $i; ?></span>
                <?php else: ?>
                    <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo $page + 1; ?>">Следующая »</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php include 'footer.php'; ?>