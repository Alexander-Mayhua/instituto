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

    $tipo   = $_POST['tipo']  ?? '';
    $token  = trim((string)($_POST['token'] ?? ''));
    $term   = trim((string)($_POST['data']  ?? ''));

    if ($tipo !== 'verclienteapiByNombre') {
        echo json_encode(['status' => false, 'msg' => 'Parámetro tipo inválido']);
        return;
    }

    // 1) Si HAY texto y NO hay token -> búsqueda global por nombre (LIKE %texto%)
    if ($term !== '' && $token === '') {
        $arr_clientes = ConsumoApi::buscarClientesPorDenominacion($term, 50, 0); // solo Activos si así lo pusiste en el modelo
        echo json_encode(['status' => true, 'msg' => '', 'contenido' => $arr_clientes]);
        return;
    }

    // 2) En los demás casos, el token es obligatorio (para devolver solo el dueño o validar acceso)
    if ($token === '') {
        echo json_encode(['status' => false, 'msg' => 'Token requerido (o ingrese texto para buscar por nombre).']);
        return;
    }

    // ID = último segmento del token
    $parts = explode('-', $token);
    $last  = end($parts);
    $id_cliente = (ctype_digit($last) ? (int)$last : null);

    if (!$id_cliente) {
        echo json_encode(['status' => false, 'msg' => 'Token inválido o incompleto']);
        return;
    }

    // Verificar dueño/token activo
    $owner = ConsumoApi::buscarClienteById($id_cliente);
    if (!$owner || ($owner['estado'] ?? null) !== 'Activo') {
        echo json_encode(['status' => false, 'msg' => 'Error, cliente no activo o no encontrado']);
        return;
    }

    // 2a) Si NO hay texto -> solo el cliente del token
    if ($term === '') {
        $arr_clientes = ConsumoApi::buscarClienteByIdYDenominacion($id_cliente, '');
        echo json_encode(['status' => true, 'msg' => '', 'contenido' => $arr_clientes]);
        return;
    }

    // 2b) Si HAY texto y SÍ hay token -> (elige política)
    // Política A: búsqueda global por nombre
    $arr_clientes = ConsumoApi::buscarClientesPorDenominacion($term, 50, 0);

    // // Política B (si prefieres scoped): exigir que el nombre coincida con el MISMO id del token
    // $arr_clientes = ConsumoApi::buscarClienteByIdYDenominacion($id_cliente, $term);

    echo json_encode(['status' => true, 'msg' => '', 'contenido' => $arr_clientes]);
}


}
