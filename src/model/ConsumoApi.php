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
    public static function buscarClienteByIdYDenominacion(int $id, string $data = ''): array
{
    if ($data === '') {
        $st = db()->prepare('SELECT * FROM client_api WHERE id = ? LIMIT 1');
        $st->execute([$id]);
        $row = $st->fetch();
        return $row ? [$row] : [];
    }

    $st = db()->prepare('SELECT * FROM client_api WHERE id = ? AND razon_social LIKE ? LIMIT 1');
    $st->execute([$id, '%'.$data.'%']);
    $row = $st->fetch();
    return $row ? [$row] : [];
}

   


// NUEVO: búsqueda global por razón social (LIKE %texto%), con límite/offset
public static function buscarClientesPorDenominacion(string $texto, int $limit = 50, int $offset = 0): array
{
    $texto = trim($texto);
    if ($texto === '') {
        return [];
    }
    if ($limit < 1 || $limit > 200) $limit = 50;
    if ($offset < 0) $offset = 0;

    $sql = 'SELECT *
            FROM client_api
            WHERE estado = \'Activo\' AND razon_social LIKE ?
            ORDER BY razon_social ASC
            LIMIT ? OFFSET ?';
    $st = db()->prepare($sql);
    $st->bindValue(1, '%'.$texto.'%', PDO::PARAM_STR);
    $st->bindValue(2, $limit, PDO::PARAM_INT);
    $st->bindValue(3, $offset, PDO::PARAM_INT);
    $st->execute();
    return $st->fetchAll();
}


}
