<?php
session_start();
require __DIR__ . '/config/db.php';
require __DIR__ . '/includes/checkauth.php';
require __DIR__ . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SESSION['cart'])) redirect('/cart.php');
if (!verify_csrf($_POST['csrf_token'] ?? '')) die("CSRF");

$user_id = $_SESSION['user_id'];
$ids = array_keys($_SESSION['cart']);
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
$stmt->execute($ids);
$products = $stmt->fetchAll();

$errors = [];
$success = 0;
foreach ($products as $product) {
    $qty = $_SESSION['cart'][$product['id']];
    for ($i = 0; $i < $qty; $i++) {
        $ins = $pdo->prepare("INSERT INTO orders (user_id, product_id) VALUES (?, ?)");
        if ($ins->execute([$user_id, $product['id']])) $success++;
        else $errors[] = "Ошибка: " . h($product['title']);
    }
}
unset($_SESSION['cart']);
?>
<!DOCTYPE html>
<html lang="ru">
<head><meta charset="UTF-8"><title>Результат заказа</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="/assets/css/style.css" rel="stylesheet"></head>
<body class="p-4"><div class="container">
<h1>Оформление заказа</h1>
<?php if (empty($errors)): ?>
    <div class="alert alert-success">✅ Заказ оформлен! Создано заказов: <?= $success ?>.</div>
<?php else: ?>
    <div class="alert alert-danger"><?= implode('<br>', $errors) ?></div>
<?php endif; ?>
<a href="/" class="btn btn-primary">На главную</a>
<a href="/myorders.php" class="btn btn-secondary">Мои заказы</a>
</div></body></html>