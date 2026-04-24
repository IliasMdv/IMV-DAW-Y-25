<?php
$nav = [
    'inicio' => ['href' => 'index.php', 'label' => 'Inicio'],
    'sobre-nosotros' => ['href' => 'about.php', 'label' => 'Sobre Nosotros'],
    'reservas' => ['href' => 'reservas.php', 'label' => 'Reservas'],
    'eventos' => ['href' => 'eventos.php', 'label' => 'Eventos'],
    'contacto' => ['href' => 'contacto.php', 'label' => 'Contacto'],
];
require_once __DIR__ . '/../includes/auth.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' — Admin' : 'Admin — Club Montepalma' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=Montserrat:wght@300;400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
    <link rel="icon" href="../assets/images/logo/montepalma.jpg" type="image/jpeg">
</head>

<body class="admin-body">

    <aside class="admin-sidebar">
        <div class="admin-sidebar-brand">
            <a href="index.php">Club <span>Montepalma</span></a>
            <span>Panel Admin</span>
        </div>
        <nav class="admin-nav">
            <a href="index.php" class="admin-nav-item <?= ($currentPage ?? '') === 'dashboard' ? 'active' : '' ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="3" y="3" width="7" height="7" />
                    <rect x="14" y="3" width="7" height="7" />
                    <rect x="3" y="14" width="7" height="7" />
                    <rect x="14" y="14" width="7" height="7" />
                </svg>
                Dashboard
            </a>
            <a href="usuarios.php" class="admin-nav-item <?= ($currentPage ?? '') === 'usuarios' ? 'active' : '' ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                </svg>
                Usuarios
            </a>
            <a href="reservas.php" class="admin-nav-item <?= ($currentPage ?? '') === 'reservas' ? 'active' : '' ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="3" y="4" width="18" height="18" rx="2" />
                    <path d="M16 2v4M8 2v4M3 10h18" />
                </svg>
                Reservas
            </a>
            <a href="contactos.php" class="admin-nav-item <?= ($currentPage ?? '') === 'contactos' ? 'active' : '' ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                    <polyline points="22,6 12,13 2,6" />
                </svg>
                Mensajes
            </a>
        </nav>
    </aside>

    <main class="admin-main">