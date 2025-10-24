<?php
// src/control/consumoApiDocente.php
require_once __DIR__ . '/../library/helpers.php';
require_once __DIR__ . '/../model/ConsumoApi.php';      // valida token (cliente)
require_once __DIR__ . '/../model/ConsumoDocente.php';  // busca docentes

class consumoApiDocente
{
    // Interfaz
    public function index()
    {
        view('consumoDocente/index');
    }

    // Endpoint JSON: ?c=consumodocente&a=buscar
    public function buscar()
    {
        header('Content-Type: application/json; charset=utf-8');

        $token = trim((string)($_POST['token'] ?? ''));
        $term  = trim((string)($_POST['data']  ?? ''));

        // 🔒 token obligatorio y cliente Activo
        if ($token === '') { echo json_encode(['status'=>false,'msg'=>'Token requerido']); return; }

        $parts = explode('-', $token);
        $last  = end($parts);
        $id_cliente = (ctype_digit($last) ? (int)$last : null);
        if (!$id_cliente) { echo json_encode(['status'=>false,'msg'=>'Token inválido o incompleto']); return; }

        $owner = ConsumoApi::buscarClienteById($id_cliente);
        if (!$owner || ($owner['estado'] ?? null) !== 'Activo') {
            echo json_encode(['status'=>false,'msg'=>'Error, cliente no activo o no encontrado']); return;
        }

        // 🔎 solo por nombre/apellido o DNI
        if ($term === '') { echo json_encode(['status'=>true,'msg'=>'','contenido'=>[]]); return; }

        try {
            $docentes = ConsumoDocente::buscarDocentes($term, 50, 0);
            echo json_encode(['status'=>true,'msg'=>'','contenido'=>$docentes]);
        } catch (\Throwable $e) {
            echo json_encode(['status'=>false,'msg'=>'Error interno']);
        }
    }
}
