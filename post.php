<?php
require_once 'config.php';
require_once 'functions.php';

$post_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("
    SELECT posts.*, users.name AS author_name 
    FROM posts 
    JOIN users ON posts.user_id = users.id 
    WHERE posts.id = ?
");
$stmt->execute([$post_id]);
$post = $stmt->fetch();

if (!$post) {
    die('Статья не найдена.');
}

$stmt = $pdo->prepare("
    SELECT comments.*, users.name AS user_name 
    FROM comments 
    JOIN users ON comments.user_id = users.id 
    WHERE comments.post_id = ? 
    ORDER BY comments.created_at ASC
");
$stmt->execute([$post_id]);
$comments = $stmt->fetchAll();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE post_id = ?");
$stmt->execute([$post_id]);
$postLikes = $stmt->fetchColumn();

foreach ($comments as &$comment) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE comment_id = ?");
    $stmt->execute([$comment['id']]);
    $comment['likes'] = $stmt->fetchColumn();
}
?>
<?php include 'header.php'; ?>

<h2><?php echo htmlspecialchars($post['title']); ?></h2>
<p>Автор: <?php echo htmlspecialchars($post['author_name']); ?> | Дата: <?php echo $post['created_at']; ?></p>

<?php if (!empty($post['image'])): ?>
    <div class="post-image">
        <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
    </div>
<?php endif; ?>

<div>
    <?php echo nl2br(htmlspecialchars($post['content'])); ?>
</div>

<div class="like-section">
    <button class="like-button" data-post-id="<?php echo $post_id; ?>">❤️ <span class="likes-count"><?php echo $postLikes; ?></span> Нравится</button>
</div>

<hr>

<h3>Комментарии</h3>

<div id="comments-list">
    <?php if (empty($comments)): ?>
        <p>Пока нет комментариев. Будьте первым!</p>
    <?php else: ?>
        <?php foreach ($comments as $comment): ?>
            <div class="comment" data-comment-id="<?php echo $comment['id']; ?>">
                <strong><?php echo htmlspecialchars($comment['user_name']); ?></strong> 
                <small>(<?php echo date('d.m.Y H:i', strtotime($comment['created_at'])); ?>)</small>
                <p><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
                <button class="comment-like-button" data-comment-id="<?php echo $comment['id']; ?>">❤️ <span><?php echo $comment['likes']; ?></span></button>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php if (isLoggedIn()): ?>
    <h4>Добавить комментарий</h4>
    <form id="comment-form" data-post-id="<?php echo $post_id; ?>">
        <textarea name="comment" id="comment" rows="4" cols="50" required></textarea><br>
        <button type="submit" id="submit-comment">Отправить</button>
    </form>
    <div id="comment-error" style="color: red; display: none;"></div>
<?php else: ?>
    <p><a href="login.php">Войдите</a>, чтобы оставить комментарий.</p>
<?php endif; ?>

<script>
function escapeHtml(unsafe) {
    return unsafe.replace(/[&<>"']/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        if (m === '"') return '&quot;';
        if (m === "'") return '&#039;';
        return m;
    });
}

async function toggleLike(element, type, id) {
    const button = element.closest('button');
    if (!button) return;

    const formData = new FormData();
    formData.append(type === 'post' ? 'post_id' : 'comment_id', id);

    const response = await fetch('like.php', {
        method: 'POST',
        body: formData
    });
    const result = await response.json();

    if (result.success) {
        const countSpan = button.querySelector('span');
        countSpan.textContent = result.count;
        if (result.action === 'liked') {
            button.classList.add('liked');
        } else {
            button.classList.remove('liked');
        }
    } else {
        alert(result.error || 'Ошибка при обработке лайка');
    }
}

document.querySelector('.like-button')?.addEventListener('click', function(e) {
    toggleLike(e.target, 'post', this.dataset.postId);
});

const commentsList = document.getElementById('comments-list');
if (commentsList) {
    commentsList.addEventListener('click', function(e) {
        const button = e.target.closest('.comment-like-button');
        if (!button) return;
        toggleLike(e.target, 'comment', button.dataset.commentId);
    });
}

const commentForm = document.getElementById('comment-form');
if (commentForm) {
    commentForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(commentForm);
        formData.append('post_id', commentForm.dataset.postId);

        const response = await fetch('add_comment.php', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();
        if (result.success) {
            const newComment = result.comment;
            const commentHtml = `
                <div class="comment" data-comment-id="${newComment.id}">
                    <strong>${escapeHtml(newComment.user_name)}</strong> 
                    <small>(${escapeHtml(newComment.created_at)})</small>
                    <p>${escapeHtml(newComment.comment)}</p>
                    <button class="comment-like-button" data-comment-id="${newComment.id}">❤️ <span>0</span></button>
                </div>
            `;
            if (commentsList.children.length === 1 && commentsList.children[0].tagName === 'P') {
                commentsList.innerHTML = commentHtml;
            } else {
                commentsList.insertAdjacentHTML('beforeend', commentHtml);
            }
            commentForm.reset();
            document.getElementById('comment-error').style.display = 'none';
        } else {
            const errorDiv = document.getElementById('comment-error');
            errorDiv.textContent = result.error;
            errorDiv.style.display = 'block';
        }
    });
}
</script>

<?php include 'footer.php'; ?>