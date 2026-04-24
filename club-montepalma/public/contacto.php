<?php
$currentPage = 'contacto';
$pageTitle = 'Contacto';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $asunto = trim($_POST['asunto'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');

    if (empty($nombre) || empty($email) || empty($asunto) || empty($mensaje)) {
        $error = 'Por favor rellena todos los campos obligatorios.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'El email no tiene un formato válido.';
    } else {
        try {
            $pdo = getDB();
            $stmt = $pdo->prepare('
                INSERT INTO contactos (nombre, email, telefono, mensaje)
                VALUES (?, ?, ?, ?)
            ');
            $stmt->execute([$nombre, $email, $telefono, $asunto . ' — ' . $mensaje]);
            $success = true;
        } catch (Exception $e) {
            $error = 'Ha ocurrido un error al enviar el mensaje. Inténtalo de nuevo.';
        }
    }
}

include __DIR__ . '/../includes/header.php';
?>

<!-- ── HERO ── -->
<div class="about-hero">
    <div class="about-hero-overlay"
        style="background: linear-gradient(135deg, var(--bg) 0%, var(--dark) 50%, #0f1c2e 100%);"></div>
    <div class="about-hero-content">
        <p class="rv-hero-sub">Estamos aquí para ayudarte</p>
        <h1 class="rv-hero-title">Contacto</h1>
        <p class="rv-hero-desc">Escríbenos y te responderemos en menos de 24 horas.</p>
    </div>
</div>

<!-- ── FORMULARIO + INFO ── -->
<div class="contact-section">
    <div class="contact-inner">

        <!-- Info -->
        <div class="contact-info reveal">
            <p class="home-label">Información de contacto</p>
            <h2 class="about-heading">Hablemos</h2>

            <div class="contact-info-items">

                <div class="contact-info-item">
                    <div class="contact-info-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                    </div>
                    <div>
                        <span>Dirección</span>
                        <p>Calle Montepalma 12, San Fernando, Andalucía</p>
                    </div>
                </div>

                <div class="contact-info-item">
                    <div class="contact-info-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path
                                d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.8 19.79 19.79 0 01.09 1.18 2 2 0 012.08 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 7.91a16 16 0 006.16 6.16l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z" />
                        </svg>
                    </div>
                    <div>
                        <span>Teléfono</span>
                        <p>+34 600 000 000</p>
                    </div>
                </div>

                <div class="contact-info-item">
                    <div class="contact-info-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                            <polyline points="22,6 12,13 2,6" />
                        </svg>
                    </div>
                    <div>
                        <span>Email</span>
                        <p>info@montepalma.es</p>
                    </div>
                </div>

                <div class="contact-info-item">
                    <div class="contact-info-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                    </div>
                    <div>
                        <span>Horario de atención</span>
                        <p>Lunes a Viernes: 9:00 — 20:00</p>
                        <p>Sábados: 9:00 — 14:00</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Formulario -->
        <div class="contact-form-wrap reveal reveal-delay-2">

            <?php if ($success): ?>
                <div class="contact-success">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                    <h3>¡Mensaje enviado!</h3>
                    <p>Gracias por contactarnos. Te responderemos en menos de 24 horas.</p>
                </div>
            <?php else: ?>

                <?php if ($error): ?>
                    <div class="auth-error" style="margin-bottom:20px">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 8v4M12 16h.01" />
                        </svg>
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="contact-form" novalidate>

                    <div class="auth-row">
                        <div class="auth-field">
                            <label for="nombre">Nombre <span class="auth-required">*</span></label>
                            <input type="text" id="nombre" name="nombre"
                                value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" placeholder="Tu nombre" required>
                        </div>
                        <div class="auth-field">
                            <label for="email">Email <span class="auth-required">*</span></label>
                            <input type="email" id="email" name="email"
                                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" placeholder="tu@email.com" required>
                        </div>
                    </div>

                    <div class="auth-row">
                        <div class="auth-field">
                            <label for="telefono">Teléfono <span class="auth-optional">(opcional)</span></label>
                            <input type="tel" id="telefono" name="telefono"
                                value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>" placeholder="600 000 000">
                        </div>
                        <div class="auth-field">
                            <label for="asunto">Asunto <span class="auth-required">*</span></label>
                            <input type="text" id="asunto" name="asunto"
                                value="<?= htmlspecialchars($_POST['asunto'] ?? '') ?>"
                                placeholder="¿En qué podemos ayudarte?" required>
                        </div>
                    </div>

                    <div class="auth-field">
                        <label for="mensaje">Mensaje <span class="auth-required">*</span></label>
                        <textarea id="mensaje" name="mensaje" rows="5" placeholder="Escribe tu mensaje aquí..."
                            required><?= htmlspecialchars($_POST['mensaje'] ?? '') ?></textarea>
                    </div>

                    <button type="submit" class="auth-submit">Enviar mensaje</button>

                </form>

            <?php endif; ?>
        </div>

    </div>
</div>

<!-- ── MAPA ── -->
<div class="contact-map">
    <iframe src="https://www.google.com/maps?q=Club+Deportivo+Montepalma+Algeciras&output=embed" width="100%"
        height="420" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
        title="Ubicación Club Deportivo Montepalma">
    </iframe>
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