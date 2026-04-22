<?php
// ============================================
// Club Montepalma — Conexión a Base de Datos
// Usar: $pdo = getDB();
// ============================================

defined('DB_HOST')    or define('DB_HOST',    'localhost');
defined('DB_NAME')    or define('DB_NAME',    'club_deportivo');
defined('DB_USER')    or define('DB_USER',    'root');
defined('DB_PASS')    or define('DB_PASS',    '');
defined('DB_CHARSET') or define('DB_CHARSET', 'utf8mb4');

function getDB(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // En producción nunca mostrar el error real
            error_log('DB Error: ' . $e->getMessage());
            die(json_encode(['error' => 'Error de conexión a la base de datos.']));
        }
    }

    return $pdo;
}