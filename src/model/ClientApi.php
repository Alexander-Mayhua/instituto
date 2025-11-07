<?php
// src/model/ClientApi.php
require_once __DIR__ . '/../config/config.php';
class ClientApi
{
    public static function all()
    {
        return db()->query('SELECT * FROM client_api ORDER BY id DESC')->fetchAll();
    }
    public static function find($id)
    {
        $st = db()->prepare('SELECT * FROM client_api WHERE id=?');
        $st->execute([$id]);
        return $st->fetch();
    }
    public static function create($d)
    {
        $sql = 'INSERT INTO client_api (ruc, razon_social, telefono, correo, estado) VALUES (?,?,?,?,?)';
        db()->prepare($sql)->execute([$d['ruc'], $d['razon_social'], $d['telefono'], $d['correo'], $d['estado']]);
    }
    public static function update($id, $d)
    {
        $sql = 'UPDATE client_api SET ruc=?, razon_social=?, telefono=?, correo=?, estado=? WHERE id=?';
        db()->prepare($sql)->execute([$d['ruc'], $d['razon_social'], $d['telefono'], $d['correo'], $d['estado'], $id]);
    }
    public static function delete($id)
    {
        db()->prepare('DELETE FROM client_api WHERE id=?')->execute([$id]);
    }




    // Buscar cliente por ID (para verificar token)
    public static function buscarClienteById($id)
    {
        $st = db()->prepare('SELECT * FROM client_api WHERE id=?');
        $st->execute([$id]);
        return $st->fetch();
    }

    //  Buscar cliente por denominación (razón social o nombre)
    public static function buscarClienteByDenominacion($data)
    {
        $sql = 'SELECT * FROM client_api WHERE razon_social LIKE ? ORDER BY id DESC';
        $st = db()->prepare($sql);
        $st->execute(['%' . $data . '%']);
        return $st->fetchAll();
    }

    /*
    public function buscarClienteByDenominacion($data)
    {
        $arrRespuesta = array[];
        $sql=$this->conexion->query("SELECT * FROM cliente_api denominacion='$data"");
        while ($objeto= $sql->fetch_objeto()){
        array_push($arrauRespuesta,$objeto);
        }
        return $arrRespuesta;
    }*/
}
