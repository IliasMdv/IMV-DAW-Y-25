# Club Montepalma — Plataforma de Gestión Deportiva

![Club Montepalma](/assets/images/logo/montepalma.jpg)

> Plataforma web completa para la gestión de reservas, eventos y socios del Club Deportivo Montepalma. Desarrollada con PHP, MySQL y CSS vanilla, sin frameworks externos.

---

## Índice

1. [Descripción del proyecto](#descripción-del-proyecto)
2. [Tecnologías utilizadas](#tecnologías-utilizadas)
3. [Estructura del proyecto](#estructura-del-proyecto)
4. [Requisitos del sistema](#requisitos-del-sistema)
5. [Instalación y configuración](#instalación-y-configuración)
6. [Base de datos](#base-de-datos)
7. [Funcionalidades](#funcionalidades)
8. [Roles y permisos](#roles-y-permisos)
9. [Páginas del proyecto](#páginas-del-proyecto)
10. [Sistema de reservas](#sistema-de-reservas)
11. [Panel de administración](#panel-de-administración)
12. [Credenciales de prueba](#credenciales-de-prueba)

---

## Descripción del proyecto

Club Montepalma es una aplicación web diseñada para centralizar la gestión de un club deportivo. Permite a los socios reservar instalaciones deportivas, inscribirse en eventos y gestionar su perfil, mientras que los administradores disponen de un panel completo para gestionar usuarios, reservas, eventos y mensajes de contacto.

---

## Tecnologías utilizadas

| Capa | Tecnología |
|---|---|
| Backend | PHP 8.x |
| Base de datos | MySQL 8.x / MariaDB |
| Frontend | HTML5, CSS3 vanilla, JavaScript ES6 |
| Servidor local | XAMPP (Apache + MySQL) |
| Tipografía | Google Fonts (Cormorant Garamond, Montserrat) |
| Autenticación | PHP Sessions + password_hash (bcrypt) |

---

## Estructura del proyecto

```
club-montepalma/
│
├── admin/                          # Panel de administración
│   ├── index.php                   # Dashboard
│   ├── usuarios.php                # Gestión de usuarios
│   ├── reservas.php                # Gestión de reservas
│   ├── eventos.php                 # Gestión de eventos
│   ├── contactos.php               # Mensajes de contacto
│   ├── layout.php                  # Cabecera del panel admin
│   ├── layout_end.php              # Cierre del panel admin
│   └── admin.css                   # Estilos exclusivos del panel
│
├── includes/                       # Archivos PHP reutilizables
│   ├── db.php                      # Conexión PDO a la base de datos
│   ├── auth.php                    # Autenticación y gestión de sesiones
│   ├── header.php                  # Cabecera global (HTML + nav)
│   ├── footer.php                  # Pie de página global
│   └── logout.php                  # Cierre de sesión
│
├── public/                         # Páginas públicas
│   ├── index.php                   # Inicio
│   ├── about.php                   # Sobre Nosotros
│   ├── reservas.php                # Reservas de instalaciones
│   ├── eventos.php                 # Listado de eventos
│   ├── contacto.php                # Formulario de contacto
│   ├── login.php                   # Inicio de sesión
│   ├── register.php                # Registro de usuario
│   ├── perfil.php                  # Perfil del usuario
│   └── assets/
│       ├── css/
│       │   ├── base/
│       │   │   ├── variables.css   # Variables CSS (colores, temas)
│       │   │   ├── reset.css       # Reset y estilos base
│       │   │   └── animations.css  # Animaciones y scroll reveal
│       │   ├── components/
│       │   │   ├── buttons.css
│       │   │   ├── cards.css
│       │   │   ├── modals.css
│       │   │   ├── tabs.css
│       │   │   └── events.css
│       │   ├── layout/
│       │   │   ├── hero.css
│       │   │   ├── grid.css
│       │   │   └── tables.css
│       │   ├── pages/
│       │   │   ├── home.css
│       │   │   ├── auth.css
│       │   │   ├── perfil.css
│       │   │   ├── about.css
│       │   │   └── contacto.css
│       │   └── responsive.css      # Media queries globales
│       └── images/
│           ├── actividades/        # Imágenes del hero
│           ├── equipo/             # Fotos del equipo
│           └── logo/               # Logo del club
│
├── CreacionBD.sql                  # Script de creación de la BD
└── InyeccionBD.sql                 # Script de datos de prueba
```

---

## Requisitos del sistema

- **PHP** 8.0 o superior
- **MySQL** 8.0 o superior / MariaDB 10.4+
- **Apache** con `mod_rewrite` activado
- **XAMPP** 8.x (recomendado para entorno local)
- Extensiones PHP requeridas: `pdo`, `pdo_mysql`, `mbstring`

---

## Instalación y configuración

### 1. Clonar o copiar el proyecto

Copia la carpeta `club-montepalma` en el directorio raíz de tu servidor:

```
# XAMPP Windows
C:\xampp\htdocs\club-montepalma\

# XAMPP Linux/Mac
/opt/lampp/htdocs/club-montepalma/
```

### 2. Crear la base de datos

1. Abre **phpMyAdmin** en `http://localhost/phpmyadmin`
2. Ve a la pestaña **Importar**
3. Sube y ejecuta `CreacionBD.sql`
4. Sube y ejecuta `InyeccionBD.sql`

### 3. Configurar la conexión

Edita el archivo `includes/db.php` con tus credenciales:

```php
defined('DB_HOST') or define('DB_HOST', 'localhost');
defined('DB_NAME') or define('DB_NAME', 'club_deportivo');
defined('DB_USER') or define('DB_USER', 'root');      // usuario MySQL
defined('DB_PASS') or define('DB_PASS', '');           // contraseña MySQL
```

### 4. Verificar la instalación

Abre en tu navegador:

```
http://localhost/club-montepalma/public/index.php
```

---

## Base de datos

La base de datos `club_deportivo` contiene las siguientes tablas:

| Tabla | Descripción |
|---|---|
| `usuarios` | Registro de usuarios con roles (admin, empleado, cliente) |
| `membresias` | Tipos de membresía disponibles |
| `socios` | Relación usuario–membresía activa |
| `instalaciones` | Pistas e instalaciones deportivas |
| `reservas` | Reservas de instalaciones por usuario |
| `eventos` | Eventos y torneos del club |
| `inscripciones_eventos` | Relación usuario–evento inscrito |
| `noticias` | Publicaciones del club |
| `contactos` | Mensajes recibidos del formulario de contacto |

### Diagrama simplificado

```
usuarios ──< socios >── membresias
usuarios ──< reservas >── instalaciones
usuarios ──< inscripciones_eventos >── eventos
usuarios ──< noticias
contactos (independiente)
```

---

## Funcionalidades

### Públicas (sin login)
- Consultar instalaciones disponibles
- Ver próximos eventos
- Formulario de contacto
- Página Sobre Nosotros con embed de Instagram

### Usuario registrado
- Reservar instalaciones con selector visual de franjas horarias
- Inscribirse en eventos
- Ver y cancelar reservas activas
- Historial de reservas
- Gestión de perfil

### Administrador
- Dashboard con estadísticas en tiempo real
- Gestión completa de usuarios (activar/desactivar, cambiar rol)
- Gestión de reservas (confirmar/cancelar)
- Gestión de eventos (cambiar estado, ver inscritos)
- Lectura de mensajes de contacto

---

## Roles y permisos

| Acción | Público | Cliente | Empleado | Admin |
|---|:---:|:---:|:---:|:---:|
| Ver instalaciones | ✅ | ✅ | ✅ | ✅ |
| Reservar | ❌ | ✅ | ✅ | ✅ |
| Ver eventos | ✅ | ✅ | ✅ | ✅ |
| Inscribirse en eventos | ❌ | ✅ | ✅ | ✅ |
| Ver perfil | ❌ | ✅ | ✅ | ✅ |
| Panel admin | ❌ | ❌ | ❌ | ✅ |
| Gestionar usuarios | ❌ | ❌ | ❌ | ✅ |

---

## Páginas del proyecto

| URL | Descripción |
|---|---|
| `/public/index.php` | Página de inicio con métricas, instalaciones y CTA |
| `/public/about.php` | Historia del club, equipo y widget de Instagram |
| `/public/reservas.php` | Reserva de instalaciones con selector visual |
| `/public/eventos.php` | Listado de eventos con inscripción |
| `/public/contacto.php` | Formulario + información + mapa |
| `/public/login.php` | Inicio de sesión |
| `/public/register.php` | Registro con indicador de seguridad de contraseña |
| `/public/perfil.php` | Perfil del usuario autenticado |
| `/admin/index.php` | Dashboard de administración |

---

## Sistema de reservas

### Instalaciones disponibles

| Instalación | Pistas | Duración | Precio |
|---|:---:|:---:|---|
| Pádel | 4 | 60 min | 10 €/h |
| Tenis | 3 | 60 min | 12 €/h |
| Fútbol 7 | 2 campos mixtos | 60 min | 40 € |
| Fútbol 5 | Hasta 6 (mixtos) | 60 min | 30 € |
| Piscina | 3 carriles | 60 min | 8 €/h |

### Lógica de fútbol

Los 6 campos de fútbol funcionan como unidades:
- **Fútbol 7** ocupa **3 unidades**
- **Fútbol 5** ocupa **1 unidad**
- Total disponible: **6 unidades simultáneas**
- Restricción extra: no pueden reservarse 2 partidos de Fútbol 7 con exactamente la misma hora de inicio

### Franjas horarias

- De **08:00** a **22:00**
- Intervalos de **30 minutos** (en punto y a y media)
- Las franjas se muestran en un **grid visual**: verde = disponible, rojo = ocupada
- Al seleccionar una franja disponible se activa el botón de confirmación

---

## Panel de administración

Accesible en `/admin/index.php` únicamente para usuarios con rol `admin`.

### Dashboard
- Número de usuarios activos
- Reservas confirmadas
- Ingresos totales
- Socios activos
- Mensajes sin leer
- Eventos activos
- Tabla de últimas 5 reservas
- Tabla de últimos 5 mensajes

### Gestión de usuarios
- Listado completo con email, teléfono, rol y estado
- Cambio de rol desde un selector inline
- Activar / desactivar usuario con un clic

### Gestión de reservas
- Listado completo ordenado por fecha
- Cambio de estado (pendiente / confirmada / cancelada) inline

### Gestión de eventos
- Listado con contador de inscritos
- Cambio de estado (activo / cancelado / completo) inline

### Mensajes de contacto
- Listado con indicador de leído/no leído
- Botón para marcar como leído

---

## Credenciales de prueba

> ⚠️ Cambiar antes de pasar a producción.

| Rol | Email | Contraseña |
|---|---|---|
| Admin | `admin@montepalma.es` | `Test1234!` |
| Empleado | `empleado@montepalma.es` | `Test1234!` |
| Cliente | `juan@email.com` | `Test1234!` |

---

## Modo oscuro / claro

La aplicación incluye un toggle de tema en el header que alterna entre modo oscuro y claro. La preferencia se guarda en `localStorage` y persiste entre páginas y sesiones.

---

## Notas de seguridad

- Las contraseñas se almacenan hasheadas con **bcrypt** (`password_hash`)
- Todas las consultas SQL usan **PDO con sentencias preparadas** para prevenir inyección SQL
- Las sesiones se gestionan con `session_start()` y se destruyen completamente en el logout
- Los datos de entrada se sanean con `htmlspecialchars()` antes de mostrarlos
- Las rutas de admin verifican el rol antes de servir cualquier contenido

---

## Contacto y créditos

**Proyecto desarrollado por:** Ilias Mohamed Velasco  
**Centro:** Club Montepalma — Proyecto de Fin de Ciclo  
**Año:** 2026
