<?php
// src/model/Token.php
require_once __DIR__ . '/../config/config.php';

class Token
{
    public static function all()
    {
        $sql = 'SELECT t.*, c.razon_social 
                FROM tokens t 
                INNER JOIN client_api c ON c.id = t.id_client_api 
                ORDER BY t.id DESC';
        return db()->query($sql)->fetchAll();
    }

    public static function find($id)
    {
        $st = db()->prepare('SELECT * FROM tokens WHERE id = ?');
        $st->execute([$id]);
        return $st->fetch();
    }

    public static function clients()
    {
        return db()->query('SELECT id, razon_social FROM client_api ORDER BY razon_social')->fetchAll();
    }

    public static function create($d)
    {
        $sql = 'INSERT INTO tokens (id_client_api, token, estado) VALUES (?, ?, ?)';
        db()->prepare($sql)->execute([$d['id_client_api'], $d['token'], $d['estado']]);
    }

    // ✅ Mejorado: mantiene el token actual si no se envía uno nuevo
    public static function update($id, $d)
    {
        // Obtenemos el token actual para conservarlo
        $st = db()->prepare('SELECT token FROM tokens WHERE id = ?');
        $st->execute([$id]);
        $tokenActual = $st->fetchColumn();

        // Si el nuevo token viene vacío, mantenemos el actual
        $token = !empty($d['token']) ? $d['token'] : $tokenActual;

        $sql = 'UPDATE tokens 
                SET id_client_api = ?, token = ?, estado = ? 
                WHERE id = ?';
        db()->prepare($sql)->execute([$d['id_client_api'], $token, $d['estado'], $id]);
    }

    public static function delete($id)
    {
        db()->prepare('DELETE FROM tokens WHERE id = ?')->execute([$id]);
    }

    // ✅ Valida si el token existe y está activo
    public static function validarTokenActivo($token)
    {
        $st = db()->prepare('SELECT t.*, c.razon_social 
                             FROM tokens t 
                             INNER JOIN client_api c ON c.id = t.id_client_api 
                             WHERE t.token = ? LIMIT 1');
        $st->execute([$token]);
        $row = $st->fetch();

        if (!$row) {
            return ['valido' => false, 'msg' => 'Token no encontrado'];
        }

        if (strtolower($row['estado']) !== 'activo') {
            return ['valido' => false, 'msg' => 'Token inactivo'];
        }

        return ['valido' => true, 'msg' => 'Token válido', 'data' => $row];
    }
}
