<?php
// src/model/ConsumoApi.php
require_once __DIR__ . '/../config/config.php';

class ConsumoApi
{
    // Buscar cliente por ID (para verificar token)
    public static function buscarClienteById($id)
    {
        $st = db()->prepare('SELECT * FROM client_api WHERE id=?');
        $st->execute([$id]);
        return $st->fetch();
    }

    // Buscar cliente por denominación (razón social o nombre)
    public static function buscarClienteByDenominacion($data)
    {
        $sql = 'SELECT * FROM client_api WHERE razon_social LIKE ? ORDER BY id DESC';
        $st = db()->prepare($sql);
        $st->execute(['%' . $data . '%']);
        return $st->fetchAll();
    }
}
