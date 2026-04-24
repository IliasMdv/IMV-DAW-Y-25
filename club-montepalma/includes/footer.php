<style>
    /* ── FOOTER ── */
    footer {
        background-color: var(--bg);
        color: rgba(255, 255, 255, 0.65);
        padding: 60px 0 0 0;
        border-top: 1px solid rgba(74, 156, 199, 0.25);
        font-family: 'Montserrat', sans-serif;
    }

    .footer-inner {
        max-width: 92%;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1.5fr 1fr 1fr;
        gap: 48px;
        padding-bottom: 48px;
    }

    /* ── COLUMNA BRAND ── */
    .footer-brand {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .footer-brand .brand {
        font-family: 'Montserrat', sans-serif;
        font-size: 1.4rem;
        font-weight: 300;
        letter-spacing: 0.12em;
        text-decoration: none;
        color: var(--white);
    }

    .footer-brand .brand span {
        color: var(--sun);
    }

    .footer-brand p {
        font-size: 0.78rem;
        line-height: 1.7;
        max-width: 260px;
    }

    .footer-contact {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 8px;
    }

    .footer-contact a {
        font-size: 0.78rem;
        color: rgba(255, 255, 255, 0.65);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: color .25s ease;
    }

    .footer-contact a:hover {
        color: var(--accent);
    }

    .footer-contact .icon {
        width: 16px;
        opacity: 0.6;
    }

    /* ── COLUMNA LINKS ── */
    .footer-col h4 {
        font-size: 0.68rem;
        font-weight: 500;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: var(--white);
        margin-bottom: 20px;
    }

    .footer-col ul {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .footer-col ul li a {
        font-size: 0.78rem;
        color: rgba(255, 255, 255, 0.65);
        text-decoration: none;
        position: relative;
        padding-bottom: 3px;
        transition: color .25s ease;
    }

    .footer-col ul li a::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 1px;
        background: var(--accent);
        transition: width .3s ease;
    }

    .footer-col ul li a:hover {
        color: var(--white);
    }

    .footer-col ul li a:hover::after {
        width: 100%;
    }

    /* ── REDES SOCIALES ── */
    .footer-social {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .social-link {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.78rem;
        color: rgba(255, 255, 255, 0.65);
        text-decoration: none;
        transition: color .25s ease;
    }

    .social-link:hover {
        color: var(--accent);
    }

    .social-icon {
        width: 32px;
        height: 32px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: border-color .25s ease;
        flex-shrink: 0;
    }

    .social-link:hover .social-icon {
        border-color: var(--accent);
    }

    .social-icon svg {
        width: 14px;
        height: 14px;
        fill: currentColor;
    }

    /* ── BOTTOM BAR ── */
    .footer-bottom {
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        padding: 20px 0;
    }

    .footer-bottom-inner {
        max-width: 92%;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .footer-bottom p {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.35);
        letter-spacing: 0.05em;
    }

    .footer-bottom a {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.35);
        text-decoration: none;
        transition: color .25s ease;
    }

    .footer-bottom a:hover {
        color: var(--white);
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
        .footer-inner {
            grid-template-columns: 1fr;
            gap: 36px;
        }

        .footer-bottom-inner {
            flex-direction: column;
            gap: 8px;
            text-align: center;
        }
    }
</style>

<footer>
    <div class="footer-inner">

        <!-- Columna 1: Brand + Contacto -->
        <div class="footer-brand">
            <a href="index.php" class="brand">Club <span>Montepalma</span></a>
            <p>Centro Deportivo — Un espacio donde el deporte, el bienestar y la comunidad se unen.</p>
            <div class="footer-contact">
                <a href="tel:+34956655256">
                    <!-- Icono teléfono -->
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path
                            d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24 11.47 11.47 0 003.58.57 1 1 0 011 1V20a1 1 0 01-1 1A17 17 0 013 4a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.45.57 3.58a1 1 0 01-.25 1.01l-2.2 2.2z" />
                    </svg>
                    +34 956 65 52 56
                </a>
                <a href="https://mail.google.com/mail/?view=cm&fs=1&to=informacion@clubmontepalma.es" target="_blank" rel="noopener noreferrer">
                    <!-- Icono email -->
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M4 4h16a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2z" />
                        <polyline points="22,6 12,13 2,6" />
                    </svg>
                    informacion@clubmontepalma.es
                </a>
            </div>
        </div>

        <!-- Columna 2: Links rápidos -->
        <div class="footer-col">
            <h4>Navegación</h4>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="about.php">Sobre Nosotros</a></li>
                <li><a href="reservas.php">Reservas</a></li>
                <li><a href="events.php">Events</a></li>
                <li><a href="contact.php">Contacto</a></li>
            </ul>
        </div>

        <!-- Columna 3: Redes sociales -->
        <div class="footer-col">
            <h4>Síguenos</h4>
            <div class="footer-social">

                <a href="https://www.instagram.com/montepalma2.0/" class="social-link">
                    <div class="social-icon">
                        <!-- Instagram -->
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.308.975.975 1.246 2.242 1.308 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.308 3.608-.975.975-2.242 1.246-3.608 1.308-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.334-3.608-1.308-.975-.975-1.246-2.242-1.308-3.608C2.175 15.584 2.163 15.204 2.163 12s.012-3.584.07-4.85c.062-1.366.334-2.633 1.308-3.608.975-.975 2.242-1.246 3.608-1.308 1.266-.058 1.646-.07 4.85-.07zm0-2.163c-3.259 0-3.667.014-4.947.072-1.609.073-3.033.46-4.153 1.58C1.78 2.772 1.393 4.196 1.32 5.805 1.262 7.085 1.248 7.493 1.248 12c0 4.507.014 4.915.072 6.195.073 1.609.46 3.033 1.58 4.153 1.12 1.12 2.544 1.507 4.153 1.58 1.28.058 1.688.072 4.947.072s3.667-.014 4.947-.072c1.609-.073 3.033-.46 4.153-1.58 1.12-1.12 1.507-2.544 1.58-4.153.058-1.28.072-1.688.072-4.947s-.014-3.667-.072-4.947c-.073-1.609-.46-3.033-1.58-4.153-1.12-1.12-2.544-1.507-4.153-1.58C15.667.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                        </svg>
                    </div>
                    Instagram
                </a>

                <a href="https://www.facebook.com/C.D.Montepalma?locale=es_ES" class="social-link">
                    <div class="social-icon">
                        <!-- Facebook -->
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.41c0-3.025 1.792-4.697 4.533-4.697 1.312 0 2.686.236 2.686.236v2.97h-1.513c-1.491 0-1.956.93-1.956 1.885v2.27h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z" />
                        </svg>
                    </div>
                    Facebook
                </a>

                <a href="" class="social-link">
                    <div class="social-icon">
                        <!-- WhatsApp -->
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                    </div>
                    WhatsApp
                </a>

            </div>
        </div>

    </div>

    <script>
        document.querySelectorAll('.reveal').forEach(function (el) {
            el.classList.add('visible');
        });
    </script>

    <!-- Barra inferior -->
    <div class="footer-bottom">
        <div class="footer-bottom-inner">
            <p>© <?= date('Y') ?> Club Montepalma — Todos los derechos reservados</p>
            <div style="display:flex; gap:24px;">
                <a href="privacidad.php">Política de privacidad</a>
                <a href="terminos.php">Términos de servicio</a>
            </div>
        </div>
    </div>
</footer>