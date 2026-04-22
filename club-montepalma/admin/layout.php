<!DOCTYPE html>
<html lang="es" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' — Admin' : 'Admin' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="shortcut icon" href="../assets/images/logo/montepalma.jpg" />
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=Montserrat:wght@300;400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/club-montepalma/public/assets/css/base/variables.css">
    <link rel="stylesheet" href="/club-montepalma/public/assets/css/base/reset.css">
    <link rel="stylesheet" href="/club-montepalma/public/assets/css/base/animations.css">
    <link rel="stylesheet" href="/club-montepalma/public/assets/css/pages/perfil.css">
    <link rel="stylesheet" href="/club-montepalma/admin/admin.css">
    <script>(function () { var t = localStorage.getItem('theme') || 'dark'; document.documentElement.setAttribute('data-theme', t); })();</script>
</head>

<body class="admin-body">

    <aside class="admin-sidebar">
        <div class="admin-sidebar-brand">
            <a href="../admin/index.php">Club <span>Montepalma</span></a>
            <span>Admin</span>
        </div>

        <nav class="admin-nav">
            <?php
            $current_page = basename($_SERVER['PHP_SELF']);
            $nav_items = [
                'index.php' => ['Dashboard', 'M3 3h7v7H3zM14 3h7v7h-7zM14 14h7v7h-7zM3 14h7v7H3z'],
                'usuarios.php' => ['Usuarios', 'M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 7a4 4 0 100 8 4 4 0 000-8zM23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75'],
                'reservas.php' => ['Reservas', 'M3 4h18v18H3V4zM16 2v4M8 2v4M3 10h18'],
                'eventos.php' => ['Eventos', 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z'],
                'contactos.php' => ['Mensajes', 'M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2zM22 6l-10 7L2 6'],
            ];
            foreach ($nav_items as $file => [$label, $path]):
                ?>
                <a href="<?= $file ?>" class="admin-nav-item <?= $current_page === $file ? 'active' : '' ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="<?= $path ?>" />
                    </svg>
                    <?= $label ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <div class="admin-sidebar-footer">
            <a href="../public/perfil.php" class="admin-nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
                Mi perfil
            </a>
            <a href="../includes/logout.php" class="admin-nav-item admin-nav-logout">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9" />
                </svg>
                Salir
            </a>
        </div>
    </aside>

    <main class="admin-main">