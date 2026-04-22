<?php
$currentPage = '';
$pageTitle   = 'Iniciar Sesión';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

// Si ya está logueado, redirigir al inicio
if (estaLogueado()) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!$email || !$password) {
        $error = 'Por favor rellena todos los campos.';
    } else {
        $resultado = loginUsuario($email, $password);
        if ($resultado['ok']) {
            header('Location: index.php');
            exit;
        } else {
            $error = $resultado['msg'];
        }
    }
}

include __DIR__ . '/../includes/header.php';
?>

<div class="auth-page">
    <div class="rv-bg"></div>

    <div class="auth-card reveal">

        <div class="auth-header">
            <p class="rv-hero-sub">Bienvenido de nuevo</p>
            <h1 class="auth-title">Iniciar Sesión</h1>
        </div>

        <?php if ($error): ?>
            <div class="auth-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" class="auth-form">

            <div class="auth-field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                       placeholder="tu@email.com" required>
            </div>

            <div class="auth-field">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password"
                       placeholder="••••••••" required>
            </div>

            <button type="submit" class="auth-btn">Entrar</button>

        </form>
        <p class="auth-alt">
            ¿No tienes cuenta? <a href="register.php">Regístrate gratis</a>
        </p>

    </div>
</div>

<script>
    document.querySelectorAll('.reveal').forEach(el => el.classList.add('visible'));
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>