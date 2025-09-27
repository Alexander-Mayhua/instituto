<?php
// src/model/Usuario.php
require_once __DIR__ . '/../config/config.php';

class Usuario {
    public static function findByUsuario($usuario) {
        $st = db()->prepare('SELECT * FROM usuarios WHERE usuario=? AND estado="Activo"');
        $st->execute([$usuario]);
        return $st->fetch();
    }
    public static function allPublic() {
        // No exponer la contraseña
        return db()->query('SELECT id_usuario, usuario, rol, estado, fecha_registro FROM usuarios ORDER BY id_usuario DESC')->fetchAll();
    }
}
