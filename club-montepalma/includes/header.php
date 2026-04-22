<?php
$nav = [
    'inicio'         => ['href' => 'index.php',    'label' => 'Inicio'],
    'sobre-nosotros' => ['href' => 'about.php',    'label' => 'Sobre Nosotros'],
    'reservas'       => ['href' => 'reservas.php', 'label' => 'Reservas'],
    'eventos'        => ['href' => 'eventos.php',  'label' => 'Eventos'],
    'contacto'       => ['href' => 'contacto.php', 'label' => 'Contacto'],
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
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">

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
    <link rel="stylesheet" href="../assets/css/pages/home.css">
    <link rel="stylesheet" href="../assets/css/pages/perfil.css">
    <link rel="stylesheet" href="../assets/css/pages/auth.css">
    <link rel="stylesheet" href="../assets/css/pages/about.css">
    <link rel="stylesheet" href="../assets/css/pages/contacto.css">
    <?php if (isset($pageCSS)): ?>
        <link rel="stylesheet" href="../assets/css/pages/<?= htmlspecialchars($pageCSS) ?>">
    <?php endif; ?>

    <style>
        /* ── VARIABLES TEMA ── */
        :root, [data-theme="dark"] {
            --accent: #4a9cc7; --dark: #2d4a6b; --sun: #f0d020;
            --white: #ffffff; --bg: #1a2635; --black: #111111;
            --hdr-bg: #1a2635; --hdr-border: rgba(74,156,199,.25);
            --hdr-text: rgba(255,255,255,.65); --hdr-text-on: #ffffff;
            --brand-col: #ffffff;
        }
        [data-theme="light"] {
            --hdr-bg: #ffffff; --hdr-border: rgba(45,74,107,.12);
            --hdr-text: rgba(26,38,53,.55); --hdr-text-on: #1a2635;
            --brand-col: #1a2635;
        }

        /* ── RESET GLOBAL ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { overflow-x: hidden; }
        body { font-family: 'Montserrat', sans-serif; background: var(--page-bg, #f9f9f9); color: var(--page-text, #333); display: flex; flex-direction: column; min-height: 100vh; overflow-x: hidden; }

        /* ── HEADER ── */
        header {
            background: var(--hdr-bg);
            border-bottom: 1px solid var(--hdr-border);
            position: sticky; top: 0; z-index: 100;
            transition: background .35s ease, border-color .35s ease;
        }

        .header-inner {
            max-width: 92%; margin: 0 auto;
            display: flex; align-items: center;
            justify-content: space-between;
            padding: 18px 0;
        }

        .brand {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.3rem; font-weight: 300;
            letter-spacing: 0.12em; text-decoration: none;
            color: var(--brand-col); transition: color .35s ease;
            flex-shrink: 0;
        }
        .brand span { color: var(--sun); }

        /* ── NAV DESKTOP ── */
        .header-nav ul { list-style: none; display: flex; gap: 28px; }

        .header-nav ul li a {
            font-family: 'Montserrat', sans-serif;
            font-size: 0.7rem; font-weight: 400;
            letter-spacing: 0.15em; text-transform: uppercase;
            text-decoration: none; color: var(--hdr-text);
            position: relative; padding-bottom: 4px;
            transition: color .25s ease;
        }

        .header-nav ul li a::after {
            content: ''; position: absolute;
            bottom: 0; left: 0; width: 0; height: 1px;
            background: var(--accent); transition: width .3s ease;
        }

        .header-nav ul li a:hover,
        .header-nav ul li a.active { color: var(--hdr-text-on); }

        .header-nav ul li a:hover::after,
        .header-nav ul li a.active::after { width: 100%; }

        /* ── AUTH DESKTOP ── */
        .header-auth {
            display: flex; align-items: center; gap: 8px;
        }

        .header-auth a {
            font-family: 'Montserrat', sans-serif;
            font-size: 0.7rem; font-weight: 400;
            letter-spacing: 0.12em; text-transform: uppercase;
            text-decoration: none; padding: 8px 14px;
            transition: all .25s ease;
        }

        .btn-login { color: var(--hdr-text); border: 1px solid transparent; }
        .btn-login:hover { color: var(--hdr-text-on); border-color: var(--hdr-border); }

        .btn-register { color: var(--bg); background: var(--sun); border: 1px solid var(--sun); }
        .btn-register:hover { background: transparent; color: var(--sun); }

        /* ── PERFIL EN HEADER ── */
        .header-perfil {
            display: flex; align-items: center; gap: 8px;
            text-decoration: none; padding: 5px 12px 5px 5px;
            border: 1px solid var(--hdr-border); border-radius: 24px;
            color: var(--hdr-text); font-size: 0.7rem;
            letter-spacing: 0.08em; transition: all .25s ease;
        }
        .header-perfil:hover { border-color: var(--accent); color: var(--hdr-text-on); background: rgba(74,156,199,.1); }
        .header-perfil-avatar {
            width: 26px; height: 26px; border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--dark));
            display: flex; align-items: center; justify-content: center;
            font-family: 'Cormorant Garamond', serif; font-size: 0.85rem;
            color: #fff; flex-shrink: 0;
        }

        /* ── BOTÓN TEMA ── */
        .btn-theme {
            background: none; border: 1px solid var(--hdr-border);
            border-radius: 6px; cursor: pointer;
            width: 34px; height: 34px;
            display: flex; align-items: center; justify-content: center;
            color: var(--hdr-text); transition: all .25s ease; flex-shrink: 0;
        }
        .btn-theme:hover { border-color: var(--accent); background: rgba(74,156,199,.1); color: var(--hdr-text-on); }
        .btn-theme svg { width: 15px; height: 15px; }
        .icon-sun { display: none; }
        .icon-moon { display: block; }
        [data-theme="light"] .icon-sun  { display: block; }
        [data-theme="light"] .icon-moon { display: none; }

        /* ── HAMBURGUESA ── */
        .btn-hamburger {
            display: none;
            background: none; border: 1px solid var(--hdr-border);
            border-radius: 6px; cursor: pointer;
            width: 34px; height: 34px;
            align-items: center; justify-content: center;
            color: var(--hdr-text); transition: all .25s ease; flex-shrink: 0;
        }
        .btn-hamburger svg { width: 18px; height: 18px; }
        .btn-hamburger:hover { border-color: var(--accent); color: var(--hdr-text-on); }

        /* ── MENÚ MÓVIL ── */
        .mobile-menu {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: var(--hdr-bg);
            z-index: 999;
            flex-direction: column;
            padding: 24px;
            overflow-y: auto;
            transition: background .35s ease;
        }

        .mobile-menu.open { display: flex; }

        .mobile-menu-header {
            display: flex; align-items: center;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .mobile-menu-close {
            background: none; border: 1px solid var(--hdr-border);
            border-radius: 6px; cursor: pointer;
            width: 34px; height: 34px;
            display: flex; align-items: center; justify-content: center;
            color: var(--hdr-text); transition: all .25s;
        }
        .mobile-menu-close:hover { border-color: var(--accent); color: var(--hdr-text-on); }
        .mobile-menu-close svg { width: 18px; }

        .mobile-menu nav ul {
            list-style: none;
            display: flex; flex-direction: column; gap: 0;
        }

        .mobile-menu nav ul li a {
            display: block;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.8rem; letter-spacing: 0.2em;
            text-transform: uppercase; text-decoration: none;
            color: var(--hdr-text); padding: 18px 0;
            border-bottom: 1px solid var(--hdr-border);
            transition: color .2s ease;
        }

        .mobile-menu nav ul li a:hover,
        .mobile-menu nav ul li a.active { color: var(--hdr-text-on); }

        .mobile-menu-auth {
            margin-top: 32px;
            display: flex; flex-direction: column; gap: 12px;
        }

        .mobile-menu-auth a {
            display: block; text-align: center;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.72rem; letter-spacing: 0.15em;
            text-transform: uppercase; text-decoration: none;
            padding: 13px; border-radius: 4px;
            transition: all .25s ease;
        }

        .mobile-btn-login {
            color: var(--hdr-text-on);
            border: 1px solid var(--hdr-border);
        }
        .mobile-btn-login:hover { border-color: var(--accent); color: var(--accent); }

        .mobile-btn-register {
            background: var(--sun); color: var(--bg);
            border: 1px solid var(--sun);
        }
        .mobile-btn-register:hover { background: transparent; color: var(--sun); }

        .mobile-menu-bottom {
            margin-top: auto; padding-top: 24px;
            display: flex; align-items: center;
            justify-content: space-between;
        }

        .mobile-brand {
            font-family: 'Montserrat', sans-serif;
            font-size: 0.9rem; font-weight: 300;
            letter-spacing: 0.12em; color: var(--brand-col);
            text-decoration: none;
        }
        .mobile-brand span { color: var(--sun); }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .header-nav  { display: none; }
            .header-auth { display: none; }
            .btn-hamburger { display: flex; }

            .header-inner { padding: 14px 0; }
            .brand { font-size: 1.1rem; }
        }
    </style>

    <script>
        (function () {
            var t = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', t);
        })();
    </script>
</head>
<body>

<header>
    <div class="header-inner">
        <a href="index.php" class="brand">Club <span>Montepalma</span></a>

        <nav class="header-nav">
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

        <div class="header-auth">
            <button class="btn-theme" id="btn-theme" aria-label="Cambiar tema">
                <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z"/></svg>
                <svg class="icon-sun"  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
            </button>
            <?php if (estaLogueado()): ?>
                <a href="perfil.php" class="header-perfil">
                    <div class="header-perfil-avatar"><?= strtoupper(substr($_SESSION['user_name'], 0, 1)) ?></div>
                    <span><?= htmlspecialchars($_SESSION['user_name']) ?></span>
                </a>
            <?php else: ?>
                <a href="login.php"    class="btn-login">Iniciar Sesión</a>
                <a href="register.php" class="btn-register">Registrarse</a>
            <?php endif; ?>
        </div>

        <!-- Hamburguesa (solo móvil) -->
        <button class="btn-hamburger" id="btn-hamburger" aria-label="Abrir menú">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <line x1="3" y1="6"  x2="21" y2="6"/>
                <line x1="3" y1="12" x2="21" y2="12"/>
                <line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
        </button>
    </div>
</header>

<!-- MENÚ MÓVIL -->
<div class="mobile-menu" id="mobile-menu">
    <div class="mobile-menu-header">
        <a href="index.php" class="mobile-brand">Club <span>Montepalma</span></a>
        <button class="mobile-menu-close" id="mobile-menu-close" aria-label="Cerrar menú">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    </div>

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

    <div class="mobile-menu-auth">
        <?php if (estaLogueado()): ?>
            <a href="perfil.php" class="mobile-btn-login">Mi perfil — <?= htmlspecialchars($_SESSION['user_name']) ?></a>
            <a href="../includes/logout.php" class="mobile-btn-register" style="background:rgba(199,74,74,.15);color:#c74a4a;border-color:rgba(199,74,74,.3)">Cerrar sesión</a>
        <?php else: ?>
            <a href="login.php"    class="mobile-btn-login">Iniciar Sesión</a>
            <a href="register.php" class="mobile-btn-register">Registrarse</a>
        <?php endif; ?>
    </div>

    <div class="mobile-menu-bottom">
        <span style="font-size:.65rem;letter-spacing:.2em;text-transform:uppercase;color:var(--hdr-text)">© 2026 Club Montepalma</span>
        <button class="btn-theme" id="btn-theme-mobile" aria-label="Cambiar tema" style="border-color:var(--hdr-border)">
            <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z"/></svg>
            <svg class="icon-sun"  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
        </button>
    </div>
</div>

<script>
    // Tema
    function toggleTheme() {
        var html = document.documentElement;
        var next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        html.setAttribute('data-theme', next);
        localStorage.setItem('theme', next);
    }
    document.getElementById('btn-theme').addEventListener('click', toggleTheme);
    document.getElementById('btn-theme-mobile').addEventListener('click', toggleTheme);

    // Menú móvil
    var menu  = document.getElementById('mobile-menu');
    var open  = document.getElementById('btn-hamburger');
    var close = document.getElementById('mobile-menu-close');

    open.addEventListener('click',  function() { menu.classList.add('open');    document.body.style.overflow = 'hidden'; });
    close.addEventListener('click', function() { menu.classList.remove('open'); document.body.style.overflow = ''; });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && menu.classList.contains('open')) {
            menu.classList.remove('open');
            document.body.style.overflow = '';
        }
    });
</script>