<?php
// src/config/config1.php (placeholder por compatibilidad con la captura)
require_once __DIR__.'/config.php';

/*
<?php
// src/config/config.php
// Cambia estos valores según tu entorno local
define('DB_HOST', 'localhost');
define('DB_NAME', 'instituto');
define('DB_USER', 'root');
define('DB_PASS', '');
define('APP_NAME', 'Instituto');

function db() : PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4';
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $opt);
    }
    return $pdo;
}*/