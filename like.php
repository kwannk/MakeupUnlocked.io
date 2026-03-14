<?php
require_once 'config.php';
require_once 'functions.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'error' => 'Необходима авторизация']);
    exit;
}

$user_id = $_SESSION['user_id'];
$post_id = isset($_POST['post_id']) ? (int)$_POST['post_id'] : 0;
$comment_id = isset($_POST['comment_id']) ? (int)$_POST['comment_id'] : 0;

if (($post_id && $comment_id) || (!$post_id && !$comment_id)) {
    echo json_encode(['success' => false, 'error' => 'Неверные данные']);
    exit;
}

if ($post_id) {
    $stmt = $pdo->prepare("SELECT id FROM posts WHERE id = ?");
    $stmt->execute([$post_id]);
    if (!$stmt->fetch()) {
        echo json_encode(['success' => false, 'error' => 'Пост не найден']);
        exit;
    }
    $type = 'post';
    $id_field = 'post_id';
    $id_value = $post_id;
} else {
    $stmt = $pdo->prepare("SELECT id FROM comments WHERE id = ?");
    $stmt->execute([$comment_id]);
    if (!$stmt->fetch()) {
        echo json_encode(['success' => false, 'error' => 'Комментарий не найден']);
        exit;
    }
    $type = 'comment';
    $id_field = 'comment_id';
    $id_value = $comment_id;
}

$stmt = $pdo->prepare("SELECT id FROM likes WHERE user_id = ? AND $id_field = ?");
$stmt->execute([$user_id, $id_value]);
$like = $stmt->fetch();

if ($like) {
    $stmt = $pdo->prepare("DELETE FROM likes WHERE id = ?");
    $stmt->execute([$like['id']]);
    $action = 'unliked';
} else {
    $stmt = $pdo->prepare("INSERT INTO likes (user_id, $id_field) VALUES (?, ?)");
    $stmt->execute([$user_id, $id_value]);
    $action = 'liked';
}

if ($post_id) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE post_id = ?");
    $stmt->execute([$post_id]);
} else {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE comment_id = ?");
    $stmt->execute([$comment_id]);
}
$count = $stmt->fetchColumn();

echo json_encode([
    'success' => true,
    'action' => $action,
    'count' => $count
]);