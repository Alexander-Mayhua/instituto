<?php
// src/control/consumoApiController.php
require_once __DIR__ . '/../library/helpers.php';
require_once __DIR__ . '/../model/ClientApi.php';

class ConsumoApiController
{
    // 👉 Método principal que carga la vista
    public function index()
    {
        // no requiere login, solo muestra el formulario de búsqueda
        view('consumoapi/index');
    }

    public function verClienteApiByNombre()
{
     require_once __DIR__ . '/../model/ConsumoApi.php';
    $tipo  = $_POST['tipo']  ?? '';
    $token = $_POST['token'] ?? '';
    $data  = $_POST['data']  ?? '';

    if ($tipo !== 'verclienteapiByNombre') {
        echo json_encode(['status' => false, 'msg' => 'Parámetro tipo inválido']);
        return;
    }

    // ✅ ID = último segmento del token (hash-con-guiones + fecha + ID)
    $parts = explode('-', $token);
    $last  = end($parts);
    $id_cliente = (ctype_digit($last) ? (int)$last : null);

    if (!$id_cliente) {
        echo json_encode(['status' => false, 'msg' => 'Token inválido o incompleto']);
        return;
    }

    // Verifica estado del cliente del token
    $arr_Cliente = ConsumoApi::buscarClienteById($id_cliente);
    if (!$arr_Cliente || ($arr_Cliente['estado'] ?? null) !== 'Activo') {
        echo json_encode(['status' => false, 'msg' => 'Error, cliente no activo o no encontrado']);
        return;
    }

    // 🔒 SOLO el cliente del token; si hay texto, además debe matchear la razón social
    $arr_clientes = ConsumoApi::buscarClienteByIdYDenominacion($id_cliente, trim((string)$data));

    echo json_encode([
        'status'    => true,
        'msg'       => '',
        'contenido' => $arr_clientes
    ]);
}

}
