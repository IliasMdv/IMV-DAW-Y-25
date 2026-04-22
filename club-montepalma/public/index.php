<?php
$currentPage = 'inicio';
$pageTitle   = 'Inicio';
include __DIR__ . '/../includes/header.php';
?>

<!-- ══════════════════════════════════════════
     HERO
══════════════════════════════════════════ -->
<div class="home-hero">
    <img src="../assets/images/actividades/reservasbg.jpg" alt="Club Montepalma" class="home-hero-bg">
    <div class="home-hero-overlay"></div>

    <!-- Líneas decorativas -->
    <div class="home-deco-line home-deco-line--left"></div>
    <div class="home-deco-line home-deco-line--right"></div>

    <div class="home-hero-content">
        <div class="home-hero-eyebrow">
            <span class="home-hero-dot"></span>
            Centro Deportivo
            <span class="home-hero-dot"></span>
        </div>
        <h1 class="home-hero-title">
            <span class="home-hero-title-line">Club</span>
            <span class="home-hero-title-line home-hero-title-accent">Montepalma</span>
        </h1>
        <p class="home-hero-desc">Deporte, bienestar y comunidad en un mismo lugar.</p>
        <div class="home-hero-actions">
            <a href="reservas.php" class="home-btn-primary">Reservar ahora</a>
            <a href="eventos.php"  class="home-btn-ghost">Ver eventos</a>
        </div>
    </div>

    <div class="home-hero-scroll">
        <div class="home-scroll-line"></div>
        <span>Scroll</span>
    </div>
</div>

<!-- ══════════════════════════════════════════
     MÉTRICAS
══════════════════════════════════════════ -->
<div class="home-metrics">
    <div class="home-metrics-inner">

        <div class="home-metric reveal reveal-delay-1">
            <span class="home-metric-num" data-target="1200">0</span>
            <span class="home-metric-plus">+</span>
            <p class="home-metric-label">Socios activos</p>
        </div>

        <div class="home-metric-divider"></div>

        <div class="home-metric reveal reveal-delay-2">
            <span class="home-metric-num" data-target="17">0</span>
            <p class="home-metric-label">Instalaciones</p>
        </div>

        <div class="home-metric-divider"></div>

        <div class="home-metric reveal reveal-delay-3">
            <span class="home-metric-num" data-target="98">0</span>
            <span class="home-metric-plus">%</span>
            <p class="home-metric-label">Satisfacción</p>
        </div>

        <div class="home-metric-divider"></div>

        <div class="home-metric reveal reveal-delay-4">
            <span class="home-metric-num" data-target="15">0</span>
            <p class="home-metric-label">Años de historia</p>
        </div>

    </div>
</div>

<!-- ══════════════════════════════════════════
     INSTALACIONES
══════════════════════════════════════════ -->
<div class="home-section home-inst-section">
    <div class="home-section-inner">

        <div class="home-section-header reveal">
            <p class="home-label">Nuestras instalaciones</p>
            <h2 class="home-heading">Todo lo que necesitas,<br><em>en un solo lugar</em></h2>
        </div>

        <div class="home-inst-grid">

            <div class="home-inst-card reveal reveal-delay-1">
                <div class="home-inst-num">01</div>
                <div class="home-inst-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                        <circle cx="12" cy="12" r="10"/><path d="M8 12h8M12 8v8"/>
                    </svg>
                </div>
                <h3>Pádel</h3>
                <p>4 pistas de cristal panorámico, cubiertas e iluminadas para jugar a cualquier hora.</p>
                <a href="reservas.php" class="home-inst-cta">Reservar →</a>
            </div>

            <div class="home-inst-card reveal reveal-delay-2">
                <div class="home-inst-num">02</div>
                <div class="home-inst-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                        <circle cx="12" cy="12" r="10"/><path d="M5 7c2 2 2 6 0 8M19 7c-2 2-2 6 0 8"/>
                    </svg>
                </div>
                <h3>Tenis</h3>
                <p>3 pistas de superficie rápida, cubiertas y al aire libre para todos los niveles.</p>
                <a href="reservas.php" class="home-inst-cta">Reservar →</a>
            </div>

            <div class="home-inst-card reveal reveal-delay-3">
                <div class="home-inst-num">03</div>
                <div class="home-inst-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 2a10 10 0 00-6.88 17.26M12 2a10 10 0 016.88 17.26"/>
                        <polygon points="12,7 14.5,11 12,13 9.5,11"/>
                    </svg>
                </div>
                <h3>Fútbol Sala</h3>
                <p>6 campos de césped artificial para partidos, ligas internas y entrenamientos.</p>
                <a href="reservas.php" class="home-inst-cta">Reservar →</a>
            </div>

            <div class="home-inst-card reveal reveal-delay-1">
                <div class="home-inst-num">04</div>
                <div class="home-inst-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                        <path d="M2 12c2-2 4-2 6 0s4 2 6 0 4-2 6 0"/>
                        <path d="M2 17c2-2 4-2 6 0s4 2 6 0 4-2 6 0"/>
                        <path d="M8 7a2 2 0 100-4 2 2 0 000 4zM8 7v5"/>
                    </svg>
                </div>
                <h3>Piscina</h3>
                <p>Carriles de nado olímpico con horario amplio para tu entrenamiento acuático.</p>
                <a href="reservas.php" class="home-inst-cta">Reservar →</a>
            </div>

            <div class="home-inst-card reveal reveal-delay-2">
                <div class="home-inst-num">05</div>
                <div class="home-inst-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                        <path d="M6 4v16M18 4v16M2 8h4M18 8h4M2 16h4M18 16h4"/>
                    </svg>
                </div>
                <h3>Fitness</h3>
                <p>Sala de 200m² con equipamiento de última generación y entrenadores especializados.</p>
                <a href="reservas.php" class="home-inst-cta">Reservar →</a>
            </div>

        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════
     POR QUÉ ELEGIRNOS
══════════════════════════════════════════ -->
<div class="home-section home-valores-section">
    <div class="home-section-inner">

        <div class="home-section-header reveal">
            <p class="home-label" style="color:var(--sun)">¿Por qué elegirnos?</p>
            <h2 class="home-heading" style="color:var(--white)">El club que marca<br><em style="color:var(--sun)">la diferencia</em></h2>
        </div>

        <div class="home-valores-grid">

            <div class="home-valor-card reveal reveal-delay-1">
                <div class="home-valor-stripe"></div>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
                <h3>Instalaciones de élite</h3>
                <p>Equipamiento profesional y mantenimiento diario para rendir al máximo.</p>
            </div>

            <div class="home-valor-card reveal reveal-delay-2">
                <div class="home-valor-stripe"></div>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                    <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                </svg>
                <h3>Horarios flexibles</h3>
                <p>Abierto de 7:00 a 23:00, para que entrenes cuando mejor te venga.</p>
            </div>

            <div class="home-valor-card reveal reveal-delay-3">
                <div class="home-valor-stripe"></div>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                </svg>
                <h3>Comunidad activa</h3>
                <p>Torneos, ligas y eventos sociales durante todo el año para conectar con deportistas.</p>
            </div>

            <div class="home-valor-card reveal reveal-delay-4">
                <div class="home-valor-stripe"></div>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                    <polyline points="20 12 20 22 4 22 4 12"/>
                    <rect x="2" y="7" width="20" height="5"/>
                    <line x1="12" y1="22" x2="12" y2="7"/>
                    <path d="M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7z"/>
                    <path d="M12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/>
                </svg>
                <h3>Membresías a medida</h3>
                <p>Desde la básica hasta la premium familiar, encuentra tu plan ideal.</p>
            </div>

        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════
     CTA REGISTRO
══════════════════════════════════════════ -->
<div class="home-cta reveal">
    <div class="home-cta-bg-text" aria-hidden="true">MONTEPALMA</div>
    <div class="home-cta-inner">
        <p class="home-label">Únete hoy</p>
        <h2 class="home-cta-title">Empieza a disfrutar<br>del club</h2>
        <p class="home-cta-desc">Regístrate gratis y accede a todas las instalaciones, eventos y reservas online desde cualquier dispositivo.</p>
        <div class="home-cta-btns">
            <a href="register.php" class="home-btn-primary">Crear cuenta gratis</a>
            <a href="about.php"    class="home-btn-outline">Saber más</a>
        </div>
    </div>
</div>

<script>
(function () {
    // ── Scroll reveal ──
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

    // ── Contador animado ──
    function animateCounter(el) {
        const target = parseInt(el.dataset.target, 10);
        const duration = 1800;
        const step = target / (duration / 16);
        let current = 0;
        const timer = setInterval(function () {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            el.textContent = Math.floor(current).toLocaleString('es-ES');
        }, 16);
    }

    const metricObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.querySelectorAll('.home-metric-num').forEach(animateCounter);
                metricObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.3 });

    const metricsEl = document.querySelector('.home-metrics');
    if (metricsEl) metricObserver.observe(metricsEl);
})();
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>