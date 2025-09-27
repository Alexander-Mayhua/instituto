<?php
// src/model/Docente.php
require_once __DIR__ . '/../config/config.php';

class Docente {
    public static function all() {
        return db()->query('SELECT * FROM docentes ORDER BY id_docente DESC')->fetchAll();
    }
    public static function find($id) {
        $st = db()->prepare('SELECT * FROM docentes WHERE id_docente=?');
        $st->execute([$id]);
        return $st->fetch();
    }
    public static function create($data) {
        $sql = 'INSERT INTO docentes (dni, nombres, apellidos, correo, telefono, especialidad, grado_academico, estado) 
                VALUES (?,?,?,?,?,?,?,?)';
        db()->prepare($sql)->execute([
            $data['dni'],$data['nombres'],$data['apellidos'],$data['correo'],
            $data['telefono'],$data['especialidad'],$data['grado_academico'],$data['estado']
        ]);
    }
    public static function update($id, $data) {
        $sql = 'UPDATE docentes SET dni=?, nombres=?, apellidos=?, correo=?, telefono=?, especialidad=?, grado_academico=?, estado=? WHERE id_docente=?';
        db()->prepare($sql)->execute([
            $data['dni'],$data['nombres'],$data['apellidos'],$data['correo'],
            $data['telefono'],$data['especialidad'],$data['grado_academico'],$data['estado'],$id
        ]);
    }
    public static function delete($id) {
        db()->prepare('DELETE FROM docentes WHERE id_docente=?')->execute([$id]);
    }
}
