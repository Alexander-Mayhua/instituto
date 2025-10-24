<?php
// src/model/ConsumoDocente.php
require_once __DIR__ . '/../config/config.php';

class ConsumoDocente
{
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
