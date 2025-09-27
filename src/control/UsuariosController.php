<?php
// src/control/UsuariosController.php
require_once __DIR__ . '/../library/helpers.php';
require_once __DIR__ . '/../model/Usuario.php';
class UsuariosController {
    public function index() { require_login(); $rows = Usuario::allPublic(); view('usuarios/index', compact('rows')); }
}
