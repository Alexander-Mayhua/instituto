<?php
// src/model/Token.php
require_once __DIR__ . '/../config/config.php';
class Token {
    public static function all() {
        $sql = 'SELECT t.*, c.razon_social FROM tokens t INNER JOIN client_api c ON c.id=t.id_client_api ORDER BY t.id DESC';
        return db()->query($sql)->fetchAll();
    }
    public static function find($id) {
        $st = db()->prepare('SELECT * FROM tokens WHERE id=?');
        $st->execute([$id]);
        return $st->fetch();
    }
    public static function clients() { return db()->query('SELECT id, razon_social FROM client_api ORDER BY razon_social')->fetchAll(); }
    public static function create($d) {
        $sql='INSERT INTO tokens (id_client_api, token, estado) VALUES (?,?,?)';
        db()->prepare($sql)->execute([$d['id_client_api'],$d['token'],$d['estado']]);
    }
    public static function update($id,$d) {
        $sql='UPDATE tokens SET id_client_api=?, token=?, estado=? WHERE id=?';
        db()->prepare($sql)->execute([$d['id_client_api'],$d['token'],$d['estado'],$id]);
    }
    public static function delete($id) {
        db()->prepare('DELETE FROM tokens WHERE id=?')->execute([$id]);
    }
}
