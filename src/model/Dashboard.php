<?php
// src/model/Dashboard.php
require_once __DIR__ . '/../config/config.php';
class Dashboard {
    public static function metrics() {
        $pdo = db();
        $docentes = $pdo->query('SELECT COUNT(*) c FROM docentes')->fetch()['c'] ?? 0;
        $clientes = $pdo->query('SELECT COUNT(*) c FROM client_api')->fetch()['c'] ?? 0;
        $tokens   = $pdo->query('SELECT COUNT(*) c FROM tokens')->fetch()['c'] ?? 0;
        $usuarios = $pdo->query('SELECT COUNT(*) c FROM usuarios')->fetch()['c'] ?? 0;
        return compact('docentes','clientes','tokens','usuarios');
    }
    public static function docentesByEstado() {
        return db()->query('SELECT estado, COUNT(*) total FROM docentes GROUP BY estado')->fetchAll();
    }
    public static function docentesByGrado() {
        return db()->query('SELECT grado_academico as grado, COUNT(*) total FROM docentes GROUP BY grado_academico')->fetchAll();
    }
}
