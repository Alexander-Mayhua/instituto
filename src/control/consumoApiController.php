<?php
// src/control/consumoApiController.php
require_once __DIR__ . '/../library/helpers.php';
require_once __DIR__ . '/../model/ClientApi.php';
require_once __DIR__ . '/../model/ConsumoApi.php';   // valida token + búsquedas

class ConsumoApiController
{
    public function index()
    {
        view('consumoapi/index');
    }

    // Ruta: ?c=consumoapi&a=verDocenteApiByNombreODni
    // Espera: POST { tipo:'verdocenteapibynombreodni', token, data }
    public function verDocenteApiByNombreODni()
{
    require_once __DIR__ . '/../model/ConsumoApi.php'; // trae buscarDocentes y (opcional) valida cliente
    header('Content-Type: application/json; charset=utf-8');

    $tipo  = strtolower($_POST['tipo'] ?? '');
    $term  = trim((string)($_POST['data'] ?? ''));
    $token = trim((string)($_POST['token'] ?? '')); // <-- ahora OPCIONAL

    if ($tipo !== 'verdocenteapibynombreodni') {
        echo json_encode(['status' => false, 'msg' => 'Parámetro tipo inválido']); return;
    }

    // ✅ Token OPCIONAL: si viene, se valida; si no viene, se continúa sin bloquear.
    if ($token !== '') {
        $parts = array_filter(array_map('trim', explode('-', $token)), 'strlen');
        $last  = end($parts);
        $id_cliente = (ctype_digit($last) ? (int)$last : null);

        if (!$id_cliente) {
            echo json_encode(['status' => false, 'msg' => 'Token inválido o incompleto']); return;
        }

        $owner  = ConsumoApi::buscarClienteById($id_cliente);
        $estado = is_array($owner) ? ($owner['estado'] ?? null) : null;
        if (!$owner || $estado !== 'Activo') {
            echo json_encode(['status' => false, 'msg' => 'Error, cliente no activo o no encontrado']); return;
        }
        // Si llega aquí, token válido; pero la búsqueda NO se relaciona al token.
    }

    if ($term === '') {
        echo json_encode(['status' => true, 'msg' => '', 'contenido' => []]); return;
    }

    try {
        $docentes = ConsumoApi::buscarDocentes($term, 50, 0); // DNI exacto o LIKE por nombres/apellidos
        echo json_encode(['status' => true, 'msg' => '', 'contenido' => $docentes]);
    } catch (\Throwable $e) {
        echo json_encode(['status' => false, 'msg' => 'Error interno']);
    }
}
}
