<?php
// src/model/ConsumoApi.php
require_once __DIR__ . '/../config/config.php';

class ConsumoApi
{
    // --- CLIENTES ---
    public static function buscarClienteById($id)
    {
        $st = db()->prepare('SELECT * FROM client_api WHERE id = ?');
        $st->execute([$id]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function buscarClienteByDenominacion($data)
    {
        $sql = 'SELECT * FROM client_api WHERE razon_social LIKE ? ORDER BY id DESC';
        $st = db()->prepare($sql);
        $st->execute(['%'.$data.'%']);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function buscarClienteByIdYDenominacion(int $id, string $data = ''): array
    {
        if ($data === '') {
            $st = db()->prepare('SELECT * FROM client_api WHERE id = ? LIMIT 1');
            $st->execute([$id]);
            $row = $st->fetch(PDO::FETCH_ASSOC);
            return $row ? [$row] : [];
        }
        $st = db()->prepare('SELECT * FROM client_api WHERE id = ? AND razon_social LIKE ? LIMIT 1');
        $st->execute([$id, '%'.$data.'%']);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return $row ? [$row] : [];
    }

    public static function buscarClientesPorDenominacion(string $texto, int $limit = 50, int $offset = 0): array
    {
        $texto = trim($texto);
        if ($texto === '') return [];
        if ($limit < 1 || $limit > 200) $limit = 50;
        if ($offset < 0) $offset = 0;

        $sql = 'SELECT *
                FROM client_api
                WHERE estado = "Activo" AND razon_social LIKE ?
                ORDER BY razon_social ASC
                LIMIT ? OFFSET ?';
        $st = db()->prepare($sql);
        $st->bindValue(1, '%'.$texto.'%', PDO::PARAM_STR);
        $st->bindValue(2, $limit, PDO::PARAM_INT);
        $st->bindValue(3, $offset, PDO::PARAM_INT);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- DOCENTES ---
    /**
     * Buscar docentes:
     * - Si $texto es numérico (8–12 dígitos) => DNI exacto.
     * - Si no, LIKE por nombres o apellidos.
     * Solo estado = "Activo".
     */
    public static function buscarDocentes(string $texto, int $limit = 50, int $offset = 0): array
    {
        $texto = trim($texto);
        if ($texto === '') return [];
        if ($limit < 1 || $limit > 200) $limit = 50;
        if ($offset < 0) $offset = 0;

        $soloDigitos = preg_match('/^\d+$/', $texto);
        $pareceDni   = $soloDigitos && strlen($texto) >= 8 && strlen($texto) <= 12;

        if ($pareceDni) {
            $sql = 'SELECT id_docente, dni, nombres, apellidos, correo, telefono, especialidad,
                           grado_academico, estado, fecha_registro
                    FROM docentes
                    WHERE estado = "Activo" AND dni = :dni
                    ORDER BY apellidos ASC, nombres ASC
                    LIMIT :limit OFFSET :offset';
            $st = db()->prepare($sql);
            $st->bindValue(':dni', $texto, PDO::PARAM_STR);
        } else {
            $sql = 'SELECT id_docente, dni, nombres, apellidos, correo, telefono, especialidad,
                           grado_academico, estado, fecha_registro
                    FROM docentes
                    WHERE estado = "Activo" AND (nombres LIKE :q OR apellidos LIKE :q)
                    ORDER BY apellidos ASC, nombres ASC
                    LIMIT :limit OFFSET :offset';
            $st = db()->prepare($sql);
            $st->bindValue(':q', '%'.$texto.'%', PDO::PARAM_STR);
        }

        $st->bindValue(':limit',  $limit,  PDO::PARAM_INT);
        $st->bindValue(':offset', $offset, PDO::PARAM_INT);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
}
