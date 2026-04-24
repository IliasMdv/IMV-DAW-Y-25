<?php
require_once __DIR__ . '/auth.php';
$nav = [
    'inicio' => ['href' => 'index.php', 'label' => 'Inicio'],
    'sobre-nosotros' => ['href' => 'about.php', 'label' => 'Sobre Nosotros'],
    'reservas' => ['href' => 'reservas.php', 'label' => 'Reservas'],
    'eventos' => ['href' => 'eventos.php', 'label' => 'Eventos'],
    'contacto' => ['href' => 'contacto.php', 'label' => 'Contacto'],
];
$current = isset($currentPage) ? $currentPage : '';
?>
<!DOCTYPE html>
<html lang="es" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' — Club Montepalma' : 'Club Montepalma' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=Montserrat:wght@300;400;500&display=swap"
        rel="stylesheet">
    <link rel="icon" href="../assets/images/logo/montepalma.jpg" type="image/jpeg">

    <!-- Base -->
    <link rel="stylesheet" href="../assets/css/base/variables.css">
    <link rel="stylesheet" href="../assets/css/base/reset.css">
    <link rel="stylesheet" href="../assets/css/base/animations.css">
    <!-- Components -->
    <link rel="stylesheet" href="../assets/css/components/buttons.css">
    <link rel="stylesheet" href="../assets/css/components/cards.css">
    <link rel="stylesheet" href="../assets/css/components/modals.css">
    <link rel="stylesheet" href="../assets/css/components/tabs.css">
    <link rel="stylesheet" href="../assets/css/components/events.css">
    <!-- Layout -->
    <link rel="stylesheet" href="../assets/css/layout/hero.css">
    <link rel="stylesheet" href="../assets/css/layout/grid.css">
    <link rel="stylesheet" href="../assets/css/layout/tables.css">
    <!-- Responsive -->
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <!-- Páginas -->
    <link rel="stylesheet" href="../assets/css/pages/perfil.css">
    <link rel="stylesheet" href="../assets/css/pages/about.css">
    <link rel="stylesheet" href="../assets/css/pages/reservas.css">
    <link rel="stylesheet" href="../assets/css/pages/contacto.css">
    <link rel="stylesheet" href="../assets/css/pages/home.css">
    <link rel="stylesheet" href="../assets/css/pages/auth.css">

    <?php if (isset($pageCSS)): ?>
        <link rel="stylesheet" href="../assets/css/pages/<?= htmlspecialchars($pageCSS) ?>">
    <?php endif; ?>

    <style>
        :root {
            --header-h: 70px;
            --accent: #4a9cc7;
            --dark: #2d4a6b;
            --sun: #f0d020;
            --white: #ffffff;
            --bg: #1a2635;
        }

        [data-theme="dark"] {
            --header-bg: #1a2635;
            --header-border: rgba(74, 156, 199, .25);
            --header-text: rgba(255, 255, 255, .65);
            --header-text-active: #ffffff;
            --brand-color: #ffffff;
            --mobile-menu-bg: #1a2635;
        }

        [data-theme="light"] {
            --header-bg: #ffffff;
            --header-border: rgba(45, 74, 107, .12);
            --header-text: rgba(26, 38, 53, .6);
            --header-text-active: #1a2635;
            --brand-color: #1a2635;
            --mobile-menu-bg: #ffffff;
        }

        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            width: 100%;
            min-height: 100vh;
        }

        /* ── HEADER ── */
        header {
            background-color: var(--header-bg);
            color: var(--header-text-active);
            padding: 22px 0;
            border-bottom: 1px solid var(--header-border);
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: background-color .3s ease, border-color .3s ease;
        }

        .header-inner {
            max-width: 92%;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        /* ── BRAND ── */
        .brand {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.4rem;
            font-weight: 300;
            letter-spacing: 0.12em;
            text-decoration: none;
            color: var(--brand-color);
            transition: color .3s ease;
            flex-shrink: 0;
        }

        .brand span {
            color: var(--sun);
        }

        /* ── NAV DESKTOP ── */
        nav ul {
            list-style: none;
            display: flex;
            gap: 32px;
        }

        nav ul li a {
            font-family: 'Montserrat', sans-serif;
            font-size: 0.72rem;
            font-weight: 400;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            text-decoration: none;
            color: var(--header-text);
            position: relative;
            padding-bottom: 4px;
            transition: color .25s ease;
        }

        nav ul li a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 1px;
            background: var(--accent);
            transition: width .3s ease;
        }

        nav ul li a:hover,
        nav ul li a.active {
            color: var(--header-text-active);
        }

        nav ul li a:hover::after,
        nav ul li a.active::after {
            width: 100%;
        }

        /* ── AUTH ── */
        .header-auth {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .header-auth a {
            font-family: 'Montserrat', sans-serif;
            font-size: 0.72rem;
            font-weight: 400;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            text-decoration: none;
            padding: 8px 16px;
            transition: all .25s ease;
        }

        .btn-login {
            color: var(--header-text);
            border: 1px solid transparent;
            border-radius: 6px;
        }

        .btn-login:hover {
            color: var(--header-text-active);
            border-color: var(--header-border);
        }

        .btn-register {
            color: var(--bg) !important;
            background: var(--sun);
            border: 1px solid var(--sun);
            border-radius: 6px;
        }

        .btn-register:hover {
            background: transparent !important;
            color: var(--sun) !important;
        }

        /* ── BOTÓN TEMA ── */
        .btn-theme {
            background: none;
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: 6px;
            cursor: pointer;
            padding: 7px 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: border-color .25s, background .25s;
            color: var(--header-text);
            margin-right: 4px;
        }

        .btn-theme:hover {
            border-color: var(--accent);
            background: rgba(74, 156, 199, .1);
            color: var(--header-text-active);
        }

        [data-theme="light"] .btn-theme {
            border-color: rgba(26, 38, 53, .2);
        }

        .btn-theme svg {
            width: 16px;
            height: 16px;
            display: none;
        }

        [data-theme="dark"] .btn-theme .icon-moon {
            display: block;
        }

        [data-theme="dark"] .btn-theme .icon-sun {
            display: none;
        }

        [data-theme="light"] .btn-theme .icon-sun {
            display: block;
        }

        [data-theme="light"] .btn-theme .icon-moon {
            display: none;
        }

        /* ── PERFIL ── */
        .header-perfil {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            padding: 6px 14px 6px 6px;
            border: 1px solid rgba(255, 255, 255, .15);
            border-radius: 24px;
            transition: border-color .25s, background .25s;
            color: rgba(255, 255, 255, .8);
            font-family: 'Montserrat', sans-serif;
            font-size: 0.72rem;
            letter-spacing: 0.08em;
        }

        .header-perfil:hover {
            border-color: var(--accent);
            background: rgba(74, 156, 199, .1);
            color: var(--white);
        }

        [data-theme="light"] .header-perfil {
            border-color: rgba(26, 38, 53, .2);
            color: rgba(26, 38, 53, .7);
        }

        [data-theme="light"] .header-perfil:hover {
            border-color: var(--accent);
            color: var(--dark);
        }

        .header-perfil-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--dark));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Cormorant Garamond', serif;
            font-size: 0.9rem;
            color: var(--white);
            flex-shrink: 0;
        }

        /* ── HAMBURGUESA ── */
        .btn-hamburger {
            display: none;
            flex-direction: column;
            justify-content: center;
            gap: 5px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 6px;
            z-index: 1100;
        }

        .btn-hamburger span {
            display: block;
            width: 22px;
            height: 1.5px;
            background: var(--header-text-active);
            transition: transform .3s ease, opacity .3s ease;
            transform-origin: center;
        }

        /* Animación a X */
        .btn-hamburger.open span:nth-child(1) {
            transform: translateY(6.5px) rotate(45deg);
        }

        .btn-hamburger.open span:nth-child(2) {
            opacity: 0;
        }

        .btn-hamburger.open span:nth-child(3) {
            transform: translateY(-6.5px) rotate(-45deg);
        }

        /* ── MENÚ MÓVIL ── */
        .mobile-menu {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--mobile-menu-bg);
            z-index: 999;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0;
            opacity: 0;
            pointer-events: none;
            transition: opacity .3s ease;
        }

        .mobile-menu.open {
            display: flex;
            opacity: 1;
            pointer-events: all;
        }

        .mobile-menu nav ul {
            flex-direction: column;
            align-items: center;
            gap: 0;
        }

        .mobile-menu nav ul li {
            width: 100%;
            text-align: center;
            border-bottom: 1px solid var(--header-border);
        }

        .mobile-menu nav ul li:first-child {
            border-top: 1px solid var(--header-border);
        }

        .mobile-menu nav ul li a {
            display: block;
            padding: 20px;
            font-size: 0.85rem;
            letter-spacing: 0.25em;
            color: var(--header-text);
        }

        .mobile-menu nav ul li a:hover,
        .mobile-menu nav ul li a.active {
            color: var(--header-text-active);
            background: rgba(74, 156, 199, .06);
        }

        .mobile-menu nav ul li a::after {
            display: none;
        }

        .mobile-menu-auth {
            margin-top: 32px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            width: 80%;
        }

        .mobile-menu-auth a {
            width: 100%;
            text-align: center;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.72rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            text-decoration: none;
            padding: 14px;
            border-radius: 6px;
            transition: all .25s;
        }

        .mobile-menu-auth .btn-login {
            color: var(--header-text);
            border: 1px solid var(--header-border);
        }

        .mobile-menu-auth .btn-register {
            background: var(--sun);
            color: var(--bg) !important;
            border: 1px solid var(--sun);
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {

            header nav,
            .header-auth {
                display: none;
            }

            .btn-hamburger {
                display: flex;
            }
        }

        @media (max-width: 1024px) {

            header nav,
            .header-auth {
                display: none;
            }

            .btn-hamburger {
                display: flex;
            }
        }

        @media (max-width: 560px) {
            body {
                overflow-x: hidden !important;
            }

            .perfil-inner {
                grid-template-columns: 1fr;
            }

            .perfil-sidebar {
                position: static;
                width: 100%;
            }

            .perfil-page {
                padding: 20px 4% 50px;
            }

            .perfil-block {
                padding: 18px 14px;
            }

            .perfil-table {
                font-size: 0.72rem;
            }

            .perfil-table th,
            .perfil-table td {
                padding: 8px 6px;
                white-space: normal;
                word-break: break-word;
            }

            .perfil-table th:first-child,
            .perfil-table td:first-child {
                max-width: 90px;
            }

            .perfil-eventos-grid {
                grid-template-columns: 1fr;
            }

            .perfil-btn-cancel {
                font-size: 0.6rem;
                padding: 4px 8px;
            }
        }
    </style>

    <script>
        (function () {
            var saved = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', saved);
        })();
    </script>
</head>

<body>
    <header>
        <div class="header-inner">

            <a href="index.php" class="brand">Club <span>Montepalma</span></a>

            <!-- Nav desktop -->
            <nav>
                <ul>
                    <?php foreach ($nav as $key => $item): ?>
                        <li>
                            <a href="<?= htmlspecialchars($item['href']) ?>"
                                class="<?= ($current === $key) ? 'active' : '' ?>">
                                <?= htmlspecialchars($item['label']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>

            <!-- Auth desktop -->
            <div class="header-auth">
                <button class="btn-theme" id="btn-theme" title="Cambiar tema" aria-label="Cambiar modo oscuro/claro">
                    <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z" />
                    </svg>
                    <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="5" />
                        <path
                            d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" />
                    </svg>
                </button>

                <?php if (estaLogueado()): ?>
                    <a href="perfil.php" class="header-perfil">
                        <div class="header-perfil-avatar"><?= strtoupper(substr($_SESSION['user_name'], 0, 1)) ?></div>
                        <span><?= htmlspecialchars($_SESSION['user_name']) ?></span>
                    </a>
                <?php else: ?>
                    <a href="login.php" class="btn-login">Iniciar Sesión</a>
                    <a href="register.php" class="btn-register">Registrarse</a>
                <?php endif; ?>
            </div>

            <!-- Hamburguesa (solo móvil) -->
            <button class="btn-hamburger" id="btn-hamburger" aria-label="Abrir menú">
                <span></span>
                <span></span>
                <span></span>
            </button>

        </div>
    </header>

    <!-- Menú móvil overlay -->
    <div class="mobile-menu" id="mobile-menu">
        <nav>
            <ul>
                <?php foreach ($nav as $key => $item): ?>
                    <li>
                        <a href="<?= htmlspecialchars($item['href']) ?>" class="<?= ($current === $key) ? 'active' : '' ?>">
                            <?= htmlspecialchars($item['label']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <div class="mobile-menu-auth">
            <?php if (estaLogueado()): ?>
                <a href="perfil.php" class="header-perfil" style="justify-content:center; width:100%;">
                    <div class="header-perfil-avatar"><?= strtoupper(substr($_SESSION['user_name'], 0, 1)) ?></div>
                    <span><?= htmlspecialchars($_SESSION['user_name']) ?></span>
                </a>
            <?php else: ?>
                <a href="login.php" class="btn-login">Iniciar Sesión</a>
                <a href="register.php" class="btn-register">Registrarse</a>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Tema
        document.getElementById('btn-theme').addEventListener('click', function () {
            var html = document.documentElement;
            var current = html.getAttribute('data-theme');
            var next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
        });

        // Hamburguesa
        var btnHamburger = document.getElementById('btn-hamburger');
        var mobileMenu = document.getElementById('mobile-menu');

        btnHamburger.addEventListener('click', function () {
            var isOpen = mobileMenu.classList.toggle('open');
            btnHamburger.classList.toggle('open', isOpen);
            document.body.style.overflow = isOpen ? 'hidden' : '';
        });

        // Cerrar al hacer clic en un enlace
        mobileMenu.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                mobileMenu.classList.remove('open');
                btnHamburger.classList.remove('open');
                document.body.style.overflow = '';
            });
        });
    </script>