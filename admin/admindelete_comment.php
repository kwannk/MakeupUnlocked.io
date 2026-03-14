<?php
require_once '../config.php';
require_once '../functions.php';

if (!isAdmin()) {
    redirect('../index.php');
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("DELETE FROM comments WHERE id = ?");
$stmt->execute([$id]);

redirect('admincomments.php');