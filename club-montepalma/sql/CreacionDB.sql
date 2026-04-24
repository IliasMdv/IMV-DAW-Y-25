-- ============================================
-- Club Montepalma — Creación de Base de Datos
-- ============================================

CREATE DATABASE IF NOT EXISTS club_deportivo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE club_deportivo;

-- ── USUARIOS ──────────────────────────────────
CREATE TABLE usuarios (
    id_usuario     INT AUTO_INCREMENT PRIMARY KEY,
    email          VARCHAR(100) UNIQUE NOT NULL,
    password       VARCHAR(255) NOT NULL,
    nombre         VARCHAR(50) NOT NULL,
    apellidos      VARCHAR(100) NOT NULL,
    telefono       VARCHAR(15),
    rol            ENUM('admin', 'empleado', 'cliente') DEFAULT 'cliente',
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    activo         BOOLEAN DEFAULT TRUE
);

-- ── MEMBRESÍAS ────────────────────────────────
CREATE TABLE membresias (
    id_membresia   INT AUTO_INCREMENT PRIMARY KEY,
    nombre         VARCHAR(100) NOT NULL,
    descripcion    TEXT,
    precio_mes     DECIMAL(6,2) NOT NULL,
    precio_anual   DECIMAL(8,2),
    beneficios     TEXT,                          -- JSON o texto libre
    activa         BOOLEAN DEFAULT TRUE
);

-- ── SOCIOS (usuarios con membresía activa) ────
CREATE TABLE socios (
    id_socio       INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario     INT NOT NULL UNIQUE,
    id_membresia   INT NOT NULL,
    fecha_inicio   DATE NOT NULL,
    fecha_fin      DATE,
    estado         ENUM('activo', 'vencido', 'cancelado') DEFAULT 'activo',
    FOREIGN KEY (id_usuario)   REFERENCES usuarios(id_usuario)   ON DELETE CASCADE,
    FOREIGN KEY (id_membresia) REFERENCES membresias(id_membresia)
);

-- ── INSTALACIONES ─────────────────────────────
CREATE TABLE instalaciones (
    id_instalacion INT AUTO_INCREMENT PRIMARY KEY,
    nombre         VARCHAR(50) NOT NULL,
    tipo           ENUM('tenis', 'padel', 'futbol', 'piscina', 'fitness') NOT NULL,
    descripcion    TEXT,
    precio_hora    DECIMAL(6,2) NOT NULL,
    aforo          INT DEFAULT 1,
    estado         ENUM('disponible', 'mantenimiento') DEFAULT 'disponible'
);

-- ── RESERVAS ──────────────────────────────────
CREATE TABLE reservas (
    id_reserva     INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario     INT NOT NULL,
    id_instalacion INT NOT NULL,
    fecha          DATE NOT NULL,
    hora_inicio    TIME NOT NULL,
    hora_fin       TIME NOT NULL,
    estado         ENUM('pendiente', 'confirmada', 'cancelada') DEFAULT 'pendiente',
    precio_total   DECIMAL(6,2),
    notas          TEXT,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario)     REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_instalacion) REFERENCES instalaciones(id_instalacion),
    -- Evitar solapamiento de reservas en la misma instalación
    UNIQUE KEY no_overlap (id_instalacion, fecha, hora_inicio)
);

-- ── NOTICIAS ──────────────────────────────────
CREATE TABLE noticias (
    id_noticia        INT AUTO_INCREMENT PRIMARY KEY,
    titulo            VARCHAR(200) NOT NULL,
    contenido         TEXT NOT NULL,
    imagen            VARCHAR(255),
    fecha_publicacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    autor             INT NOT NULL,
    estado            ENUM('borrador', 'publicado') DEFAULT 'borrador',
    FOREIGN KEY (autor) REFERENCES usuarios(id_usuario)
);

-- ── EVENTOS ───────────────────────────────────
CREATE TABLE eventos (
    id_evento    INT AUTO_INCREMENT PRIMARY KEY,
    titulo       VARCHAR(200) NOT NULL,
    descripcion  TEXT,
    fecha        DATE NOT NULL,
    hora         TIME,
    ubicacion    VARCHAR(100),
    imagen       VARCHAR(255),
    aforo_max    INT,
    estado       ENUM('activo', 'cancelado', 'completo') DEFAULT 'activo'
);

-- ── INSCRIPCIONES EVENTOS ─────────────────────
CREATE TABLE inscripciones_eventos (
    id_inscripcion INT AUTO_INCREMENT PRIMARY KEY,
    id_evento      INT NOT NULL,
    id_usuario     INT NOT NULL,
    fecha          DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY una_por_evento (id_evento, id_usuario),
    FOREIGN KEY (id_evento)  REFERENCES eventos(id_evento)  ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
);

-- ── CONTACTOS ─────────────────────────────────
CREATE TABLE contactos (
    id_contacto INT AUTO_INCREMENT PRIMARY KEY,
    nombre      VARCHAR(100) NOT NULL,
    email       VARCHAR(100) NOT NULL,
    telefono    VARCHAR(15),
    mensaje     TEXT NOT NULL,
    fecha       DATETIME DEFAULT CURRENT_TIMESTAMP,
    leido       BOOLEAN DEFAULT FALSE
);