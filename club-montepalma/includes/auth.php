<?php
// ============================================
// Club Montepalma — Funciones de Autenticación
// ============================================
require_once __DIR__ . '/db.php';

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ── REGISTRO ──────────────────────────────────
function registrarUsuario(string $email, string $password, string $nombre, string $apellidos, string $telefono = ''): array
{
    $pdo = getDB();

    // Comprobar si el email ya existe
    $stmt = $pdo->prepare('SELECT id_usuario FROM usuarios WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        return ['ok' => false, 'msg' => 'Este email ya está registrado.'];
    }

    $hash = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $pdo->prepare('
        INSERT INTO usuarios (email, password, nombre, apellidos, telefono)
        VALUES (?, ?, ?, ?, ?)
    ');
    $stmt->execute([$email, $hash, $nombre, $apellidos, $telefono]);

    return ['ok' => true, 'id' => $pdo->lastInsertId()];
}

// ── LOGIN ─────────────────────────────────────
function loginUsuario(string $email, string $password): array
{
    $pdo = getDB();

    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = ? AND activo = 1');
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if (!$usuario || !password_verify($password, $usuario['password'])) {
        return ['ok' => false, 'msg' => 'Email o contraseña incorrectos.'];
    }

    // Guardar en sesión
    $_SESSION['user_id'] = $usuario['id_usuario'];
    $_SESSION['user_name'] = $usuario['nombre'];
    $_SESSION['user_rol'] = $usuario['rol'];
    $_SESSION['user_email'] = $usuario['email'];

    return ['ok' => true, 'usuario' => $usuario];
}

// ── LOGOUT ────────────────────────────────────
function logout(): void
{
    session_destroy();
    header('Location: /club-montepalma/public/login.php');
    exit;
}

// ── HELPERS ───────────────────────────────────
function estaLogueado(): bool
{
    return isset($_SESSION['user_id']);
}

function esAdmin(): bool
{
    return isset($_SESSION['user_rol']) && $_SESSION['user_rol'] === 'admin';
}

function esEmpleado(): bool
{
    return isset($_SESSION['user_rol']) && in_array($_SESSION['user_rol'], ['admin', 'empleado']);
}

function requiereLogin(): void
{
    if (!estaLogueado()) {
        header('Location: /club-montepalma/public/login.php');
        exit;
    }
}

function requiereAdmin(): void
{
    requiereLogin();
    if (!esAdmin()) {
        header('Location: \club-montepalma\public\index.php');
        exit;
    }
}