<?php
$currentPage = 'sobre-nosotros';
$pageTitle = 'Sobre Nosotros';
include __DIR__ . '/../includes/header.php';
?>
<!-- ── HERO ── -->
<div class="about-hero">
    <img src="../assets/images/actividades/about-bg.jpg" alt="Club Montepalma" class="about-hero-bg">
    <div class="about-hero-overlay"></div>
    <div class="about-hero-content">
        <p class="rv-hero-sub">Desde 1990</p>
        <h1 class="rv-hero-title">Sobre Nosotros</h1>
        <p class="rv-hero-desc">Deporte, comunidad y bienestar en un mismo lugar.</p>
    </div>
</div>

<!-- ── PRESENTACIÓN + INSTAGRAM ── -->
<div class="about-section">
    <div class="about-inner">

        <!-- Texto -->
        <div class="about-text reveal">
            <p class="home-label">Nuestra historia</p>
            <h2 class="about-heading">Un club construido<br><em>por y para la comunidad</em></h2>
            <p>Fundado en 1990, el Club Deportivo Montepalma nació con una idea simple: crear un espacio donde el
                deporte fuera accesible para todos, sin importar la edad ni el nivel.</p>
            <p>Hoy contamos con más de 1.200 socios, 17 instalaciones de primer nivel y un equipo de profesionales
                dedicados a que cada visita sea mejor que la anterior.</p>
            <p>Organizamos torneos, ligas internas y actividades sociales durante todo el año porque creemos que el
                deporte es, ante todo, una herramienta para conectar personas.</p>
            <a href="reservas.php" class="home-btn-primary about-cta">Reserva una instalación</a>
        </div>

        <!-- Instagram embed -->
        <div class="about-instagram reveal reveal-delay-2">
            <p class="home-label">Síguenos en Instagram</p>
            <div class="about-ig-widget">
                <blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/montepalma2.0/"
                    data-instgrm-version="14"
                    style="background:#fff; border:0; border-radius:12px; margin:0; max-width:100%; width:100%;">
                </blockquote>
                <script async src="//www.instagram.com/embed.js"></script>
            </div>
        </div>

    </div>
</div>

<!-- ── VALORES / CIFRAS ── -->
<div class="about-valores">
    <div class="rv-bg"></div>
    <div class="about-inner">

        <div class="about-valores-grid">

            <div class="about-valor reveal reveal-delay-1">
                <span class="about-valor-num">1990</span>
                <p>Año de fundación</p>
            </div>

            <div class="about-valor reveal reveal-delay-2">
                <span class="about-valor-num">1.200+</span>
                <p>Socios activos</p>
            </div>

            <div class="about-valor reveal reveal-delay-3">
                <span class="about-valor-num">17</span>
                <p>Instalaciones</p>
            </div>

            <div class="about-valor reveal reveal-delay-4">
                <span class="about-valor-num">35</span>
                <p>Años de historia</p>
            </div>

        </div>

    </div>
</div>

<!-- ── EQUIPO ── -->
<div class="about-section about-section--light">
    <div class="about-inner">

        <div class="about-section-header reveal">
            <p class="home-label">Nuestro equipo</p>
            <h2 class="about-heading" style="color: var(--card-text)">Las personas detrás<br><em>del club</em></h2>
        </div>

        <div class="about-equipo-grid">

            <div class="about-miembro reveal reveal-delay-1">
                <div class="about-miembro-foto">
                    <img src="../assets/images/equipo/director.jpg" alt="Director"
                        onerror="this.parentElement.classList.add('no-img')">
                </div>
                <h3>Carlos García</h3>
                <span>Director General</span>
            </div>

            <div class="about-miembro reveal reveal-delay-2">
                <div class="about-miembro-foto">
                    <img src="../assets/images/equipo/coordinadora.jpg" alt="Coordinadora"
                        onerror="this.parentElement.classList.add('no-img')">
                </div>
                <h3>Ana Martínez</h3>
                <span>Coordinadora Deportiva</span>
            </div>

            <div class="about-miembro reveal reveal-delay-3">
                <div class="about-miembro-foto">
                    <img src="../assets/images/equipo/entrenador.jpg" alt="Entrenador"
                        onerror="this.parentElement.classList.add('no-img')">
                </div>
                <h3>Pedro López</h3>
                <span>Entrenador Principal</span>
            </div>

        </div>

    </div>
</div>

<script>
    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    document.querySelectorAll('.reveal').forEach(function (el) {
        observer.observe(el);
    });
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>