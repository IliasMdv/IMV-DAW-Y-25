<?php
$currentPage = '';
$pageTitle   = 'Registrarse';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

if (estaLogueado()) {
    header('Location: index.php');
    exit;
}

$error   = '';
$success = false;
$datos   = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'nombre'    => trim($_POST['nombre']    ?? ''),
        'apellidos' => trim($_POST['apellidos'] ?? ''),
        'email'     => trim($_POST['email']     ?? ''),
        'telefono'  => trim($_POST['telefono']  ?? ''),
        'password'  => $_POST['password']       ?? '',
        'password2' => $_POST['password2']      ?? '',
    ];

    // Validaciones
    if (empty($datos['nombre']) || empty($datos['apellidos']) || empty($datos['email']) || empty($datos['password'])) {
        $error = 'Por favor rellena todos los campos obligatorios.';
    } elseif (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
        $error = 'El email no tiene un formato válido.';
    } elseif (strlen($datos['password']) < 6) {
        $error = 'La contraseña debe tener al menos 6 caracteres.';
    } elseif ($datos['password'] !== $datos['password2']) {
        $error = 'Las contraseñas no coinciden.';
    } else {
        $resultado = registrarUsuario(
            $datos['email'],
            $datos['password'],
            $datos['nombre'],
            $datos['apellidos'],
            $datos['telefono']
        );

        if ($resultado['ok']) {
            // Login automático tras registro
            loginUsuario($datos['email'], $datos['password']);
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

    <div class="auth-card auth-card--wide reveal">

        <div class="auth-card-header">
            <a href="index.php" class="auth-brand">Club <span>Montepalma</span></a>
            <h1>Crear cuenta</h1>
            <p>Únete al club y accede a todas las instalaciones y eventos.</p>
        </div>

        <?php if ($error): ?>
        <div class="auth-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/>
            </svg>
            <?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>

        <form method="POST" class="auth-form" novalidate>

            <div class="auth-row">
                <div class="auth-field">
                    <label for="nombre">Nombre <span class="auth-required">*</span></label>
                    <input type="text" id="nombre" name="nombre"
                           value="<?= htmlspecialchars($datos['nombre'] ?? '') ?>"
                           placeholder="Juan" autocomplete="given-name" required>
                </div>
                <div class="auth-field">
                    <label for="apellidos">Apellidos <span class="auth-required">*</span></label>
                    <input type="text" id="apellidos" name="apellidos"
                           value="<?= htmlspecialchars($datos['apellidos'] ?? '') ?>"
                           placeholder="Pérez García" autocomplete="family-name" required>
                </div>
            </div>

            <div class="auth-field">
                <label for="email">Email <span class="auth-required">*</span></label>
                <input type="email" id="email" name="email"
                       value="<?= htmlspecialchars($datos['email'] ?? '') ?>"
                       placeholder="tu@email.com" autocomplete="email" required>
            </div>

            <div class="auth-field">
                <label for="telefono">Teléfono <span class="auth-optional">(opcional)</span></label>
                <input type="tel" id="telefono" name="telefono"
                       value="<?= htmlspecialchars($datos['telefono'] ?? '') ?>"
                       placeholder="600 000 000" autocomplete="tel">
            </div>

            <div class="auth-row">
                <div class="auth-field">
                    <label for="password">Contraseña <span class="auth-required">*</span></label>
                    <div class="auth-input-wrap">
                        <input type="password" id="password" name="password"
                               placeholder="Mín. 6 caracteres" autocomplete="new-password" required>
                        <button type="button" class="auth-toggle-pass" tabindex="-1" aria-label="Ver contraseña">
                            <svg class="icon-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg class="icon-eye-off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="display:none">
                                <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19M1 1l22 22"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="auth-field">
                    <label for="password2">Confirmar contraseña <span class="auth-required">*</span></label>
                    <div class="auth-input-wrap">
                        <input type="password" id="password2" name="password2"
                               placeholder="Repite la contraseña" autocomplete="new-password" required>
                        <button type="button" class="auth-toggle-pass2" tabindex="-1" aria-label="Ver contraseña">
                            <svg class="icon-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg class="icon-eye-off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="display:none">
                                <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19M1 1l22 22"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Indicador de seguridad de contraseña -->
            <div class="auth-strength" id="auth-strength">
                <div class="auth-strength-bar">
                    <div class="auth-strength-fill" id="strength-fill"></div>
                </div>
                <span id="strength-label"></span>
            </div>

            <button type="submit" class="auth-submit">Crear cuenta</button>

        </form>

        <div class="auth-footer">
            ¿Ya tienes cuenta? <a href="login.php">Iniciar Sesión</a>
        </div>

    </div>
</div>

<script>
    document.querySelectorAll('.reveal').forEach(function(el) {
        el.classList.add('visible');
    });

    // Toggle contraseña 1
    function togglePass(btnClass, inputId) {
        document.querySelector(btnClass).addEventListener('click', function() {
            var input  = document.getElementById(inputId);
            var eyeOn  = this.querySelector('.icon-eye');
            var eyeOff = this.querySelector('.icon-eye-off');
            if (input.type === 'password') {
                input.type = 'text';
                eyeOn.style.display  = 'none';
                eyeOff.style.display = 'block';
            } else {
                input.type = 'password';
                eyeOn.style.display  = 'block';
                eyeOff.style.display = 'none';
            }
        });
    }

    togglePass('.auth-toggle-pass',  'password');
    togglePass('.auth-toggle-pass2', 'password2');

    // Indicador de seguridad
    document.getElementById('password').addEventListener('input', function() {
        var val    = this.value;
        var fill   = document.getElementById('strength-fill');
        var label  = document.getElementById('strength-label');
        var score  = 0;

        if (val.length >= 6)  score++;
        if (val.length >= 10) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        var levels = ['', 'Muy débil', 'Débil', 'Aceptable', 'Fuerte', 'Muy fuerte'];
        var colors = ['', '#c74a4a', '#f0a020', '#f0d020', '#4ac778', '#4a9cc7'];
        var pct    = (score / 5) * 100;

        fill.style.width      = pct + '%';
        fill.style.background = colors[score] || 'transparent';
        label.textContent     = val.length ? levels[score] : '';
        label.style.color     = colors[score];
    });
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>