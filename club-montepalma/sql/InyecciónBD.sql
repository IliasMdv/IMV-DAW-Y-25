-- ============================================
-- Club Montepalma — Datos de prueba
-- ============================================
USE club_deportivo;

-- ── MEMBRESÍAS ────────────────────────────────
INSERT INTO
    membresias (
        nombre,
        descripcion,
        precio_mes,
        precio_anual,
        beneficios
    )
VALUES
    (
        'Básica',
        'Acceso a instalaciones en horario estándar',
        29.99,
        299.99,
        'Acceso fitness, 2 reservas/mes'
    ),
    (
        'Estándar',
        'Acceso completo con reservas ilimitadas',
        49.99,
        499.99,
        'Acceso fitness, reservas ilimitadas, 1 clase/semana'
    ),
    (
        'Premium',
        'Todo incluido con prioridad de reserva',
        79.99,
        799.99,
        'Todo incluido, prioridad reserva, clases ilimitadas, invitados'
    ),
    (
        'Familiar',
        'Membresía para hasta 4 miembros del mismo hogar',
        119.99,
        1199.99,
        'Todo Premium para 4 personas'
    );

-- ── USUARIOS ──────────────────────────────────
-- Contraseñas hasheadas con bcrypt (password: 'Test1234!')
INSERT INTO
    usuarios (email, password, nombre, apellidos, telefono, rol)
VALUES
    (
        'admin@montepalma.es',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'Carlos',
        'García Ruiz',
        '611111111',
        'admin'
    ),
    (
        'empleado@montepalma.es',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'Ana',
        'Martínez López',
        '622222222',
        'empleado'
    ),
    (
        'juan@email.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'Juan',
        'Pérez Sánchez',
        '633333333',
        'cliente'
    ),
    (
        'maria@email.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'María',
        'Gómez Torres',
        '644444444',
        'cliente'
    ),
    (
        'pedro@email.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'Pedro',
        'López Fernández',
        '655555555',
        'cliente'
    );

-- ── SOCIOS ────────────────────────────────────
INSERT INTO
    socios (
        id_usuario,
        id_membresia,
        fecha_inicio,
        fecha_fin,
        estado
    )
VALUES
    (3, 2, '2024-01-01', '2025-01-01', 'activo'),
    (4, 3, '2024-03-15', '2025-03-15', 'activo'),
    (5, 1, '2024-05-01', '2025-05-01', 'activo');

-- ── INSTALACIONES ─────────────────────────────
INSERT INTO
    instalaciones (nombre, tipo, descripcion, precio_hora, aforo)
VALUES
    -- Tenis
    (
        'Pista Tenis 1',
        'tenis',
        'Pista cubierta con iluminación LED',
        15.00,
        4
    ),
    (
        'Pista Tenis 2',
        'tenis',
        'Pista exterior con pista rápida',
        12.00,
        4
    ),
    (
        'Pista Tenis 3',
        'tenis',
        'Pista exterior de arcilla',
        12.00,
        4
    ),
    -- Pádel
    (
        'Pista Pádel 1',
        'padel',
        'Pista de cristal panorámica',
        10.00,
        4
    ),
    (
        'Pista Pádel 2',
        'padel',
        'Pista de pádel muro',
        8.00,
        4
    ),
    (
        'Pista Pádel 3',
        'padel',
        'Pista de pádel exterior',
        8.00,
        4
    ),
    (
        'Pista Pádel 4',
        'padel',
        'Pista de pádel cubierta',
        10.00,
        4
    ),
    -- Fútbol Sala
    (
        'Campo Fútbol 1',
        'futbol',
        'Campo de césped artificial (fútbol 7)',
        40.00,
        14
    ),
    (
        'Campo Fútbol 2',
        'futbol',
        'Campo de césped artificial (fútbol 7)',
        40.00,
        14
    ),
    (
        'Campo Fútbol 3',
        'futbol',
        'Campo de césped artificial (fútbol 7)',
        40.00,
        14
    ),
    (
        'Campo Fútbol 4',
        'futbol',
        'Campo de césped artificial (fútbol 5)',
        30.00,
        10
    ),
    (
        'Campo Fútbol 5',
        'futbol',
        'Campo de césped artificial (fútbol 5)',
        30.00,
        10
    ),
    (
        'Campo Fútbol 6',
        'futbol',
        'Campo de césped artificial (fútbol 5)',
        30.00,
        10
    ),
    -- Piscina
    (
        'Carril Piscina 1',
        'piscina',
        'Carril de nado olímpico (50m)',
        8.00,
        2
    ),
    (
        'Carril Piscina 2',
        'piscina',
        'Carril de nado olímpico (50m)',
        8.00,
        2
    ),
    (
        'Carril Piscina 3',
        'piscina',
        'Carril de nado olímpico (50m)',
        8.00,
        2
    ),
    -- Fitness
    (
        'Sala Fitness',
        'fitness',
        'Sala de musculación y cardio con 200m²',
        5.00,
        30
    );

-- ── RESERVAS ──────────────────────────────────
INSERT INTO
    reservas (
        id_usuario,
        id_instalacion,
        fecha,
        hora_inicio,
        hora_fin,
        estado,
        precio_total
    )
VALUES
    (
        3,
        1,
        '2025-03-01',
        '10:00:00',
        '11:00:00',
        'confirmada',
        15.00
    ),
    (
        4,
        4,
        '2025-03-01',
        '11:00:00',
        '12:00:00',
        'confirmada',
        10.00
    ),
    (
        5,
        2,
        '2025-03-02',
        '16:00:00',
        '17:00:00',
        'pendiente',
        12.00
    ),
    (
        3,
        14,
        '2025-03-03',
        '07:00:00',
        '08:00:00',
        'confirmada',
        8.00
    ),
    (
        4,
        17,
        '2025-03-03',
        '09:00:00',
        '10:00:00',
        'confirmada',
        5.00
    );

-- ── NOTICIAS ──────────────────────────────────
INSERT INTO
    noticias (titulo, contenido, autor, estado)
VALUES
    (
        'Nuevo torneo de tenis',
        'Abiertas inscripciones para el torneo de verano. ¡No te lo pierdas!',
        1,
        'publicado'
    ),
    (
        'Horarios especiales verano',
        'Consulta nuestros nuevos horarios para julio y agosto en recepción.',
        2,
        'publicado'
    ),
    (
        'Nueva sala de fitness',
        'Hemos renovado completamente nuestra sala con equipamiento de última generación.',
        1,
        'publicado'
    );

-- ── EVENTOS ───────────────────────────────────
INSERT INTO
    eventos (
        titulo,
        descripcion,
        fecha,
        hora,
        ubicacion,
        aforo_max
    )
VALUES
    (
        'Torneo de Pádel Verano',
        'Torneo abierto para todos los socios. Categorías A y B.',
        '2025-07-10',
        '09:00:00',
        'Pistas de Pádel',
        32
    ),
    (
        'Clase Abierta Fitness',
        'Clase gratuita de introducción al fitness para nuevos socios.',
        '2025-06-20',
        '18:00:00',
        'Sala Fitness',
        20
    ),
    (
        'Liga Interna Tenis',
        'Primera jornada de la liga interna de tenis.',
        '2025-06-28',
        '10:00:00',
        'Pistas de Tenis',
        16
    ),
    (
        'Aquagym al aire libre',
        'Sesión especial de aquagym en la piscina exterior.',
        '2025-07-05',
        '11:00:00',
        'Piscina',
        15
    );