<?php
require_once 'config.php';
require_once 'functions.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'error' => 'Необходима авторизация']);
    exit;
}

$post_id = isset($_POST['post_id']) ? (int)$_POST['post_id'] : 0;
$comment_text = isset($_POST['comment']) ? trim($_POST['comment']) : '';

if (!$post_id || empty($comment_text)) {
    echo json_encode(['success' => false, 'error' => 'Неверные данные']);
    exit;
}
$stmt = $pdo->prepare("SELECT id FROM posts WHERE id = ?");
$stmt->execute([$post_id]);
if (!$stmt->fetch()) {
    echo json_encode(['success' => false, 'error' => 'Пост не найден']);
    exit;
}
$stmt = $pdo->prepare("INSERT INTO comments (post_id, user_id, comment) VALUES (?, ?, ?)");
$stmt->execute([$post_id, $_SESSION['user_id'], $comment_text]);
$comment_id = $pdo->lastInsertId();

$stmt = $pdo->prepare("
    SELECT comments.*, users.name AS user_name 
    FROM comments 
    JOIN users ON comments.user_id = users.id 
    WHERE comments.id = ?
");
$stmt->execute([$comment_id]);
$comment = $stmt->fetch(PDO::FETCH_ASSOC);

$comment['created_at'] = date('d.m.Y H:i', strtotime($comment['created_at']));

echo json_encode(['success' => true, 'comment' => $comment]);