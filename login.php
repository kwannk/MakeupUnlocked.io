<?php
require_once 'config.php';
require_once 'functions.php';

if (isLoggedIn()) {
    redirect('index.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = 'Заполните все поля.';
    } else {
        $stmt = $pdo->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            redirect('index.php');
        } else {
            $error = 'Неверный email или пароль.';
        }
    }
}
?>
<?php include 'header.php'; ?>

<h2>Вход</h2>

<?php if ($error): ?>
    <div style="color: red;"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<form method="post" action="">
    <div>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
    </div>
    <div>
        <label for="password">Пароль:</label>
        <input type="password" name="password" id="password" required>
    </div>
    <button type="submit">Войти</button>
</form>

<?php include 'footer.php'; ?>  