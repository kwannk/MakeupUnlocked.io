<?php
require_once 'config.php';
require_once 'functions.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'Все поля обязательны для заполнения.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Некорректный email.';
    } elseif (strlen($password) < 6) {
        $error = 'Пароль должен содержать не менее 6 символов.';
    } elseif ($password !== $confirm_password) {
        $error = 'Пароли не совпадают.';
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = 'Пользователь с таким email уже зарегистрирован.';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$name, $email, $hashedPassword])) {
                $success = 'Регистрация прошла успешно! <a href="login.php">Войдите</a>.';
            } else {
                $error = 'Ошибка при регистрации. Попробуйте позже.';
            }
        }
    }
}
?>
<?php include 'header.php'; ?>

<h2>Регистрация</h2>

<?php if ($error): ?>
    <div style="color: red;"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<?php if ($success): ?>
    <div style="color: green;"><?php echo $success; ?></div>
<?php endif; ?>

<form method="post" action="">
    <div>
        <label for="name">Имя:</label>
        <input type="text" name="name" id="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
    </div>
    <div>
        <label for="password">Пароль (не менее 6 символов):</label>
        <input type="password" name="password" id="password" required>
    </div>
    <div>
        <label for="confirm_password">Подтверждение пароля:</label>
        <input type="password" name="confirm_password" id="confirm_password" required>
    </div>
    <button type="submit">Зарегистрироваться</button>
</form>

<?php include 'footer.php'; ?>