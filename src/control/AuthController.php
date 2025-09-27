<?php
// src/control/AuthController.php
require_once __DIR__ . '/../library/helpers.php';
require_once __DIR__ . '/../model/Usuario.php';

class AuthController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            $usuario = trim($_POST['usuario'] ?? '');
            $clave   = trim($_POST['clave'] ?? '');
            $row = Usuario::findByUsuario($usuario);
            if ($row && md5($clave) === $row['clave']) {
                $_SESSION['user'] = ['id'=>$row['id_usuario'],'usuario'=>$row['usuario'],'rol'=>$row['rol']];
                redirect('?' );
            } else {
                set_flash('danger','Usuario o clave incorrectos');
            }
        }
        partial('auth/login');
    }
    public function logout() {
        session_destroy();
        redirect('?c=auth&a=login');
    }
}
