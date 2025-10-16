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

    // 👉 Método que procesa la consulta
    public function verClienteApiByNombre()
    {
        $tipo = $_POST['tipo'] ?? '';
        $token = $_POST['token'] ?? '';
        $data  = $_POST['data'] ?? '';

        if ($tipo == "verclienteapiByNombre") {
            $token_arr = explode("-", $token);
            $id_cliente = $token_arr[2] ?? null;

            if (!$id_cliente) {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Token inválido o incompleto'
                ]);
                return;
            }

            $arr_Cliente = ClientApi::buscarClienteById($id_cliente);

            if ($arr_Cliente && $arr_Cliente['estado'] === 'Activo') {
                $arr_clientes = ClientApi::buscarClienteByDenominacion($data);
                $arr_Respuesta = [
                    'status' => true,
                    'msg' => '',
                    'contenido' => $arr_clientes
                ];
            } else {
                $arr_Respuesta = [
                    'status' => false,
                    'msg' => 'Error, cliente no activo o no encontrado'
                ];
            }

            echo json_encode($arr_Respuesta);
        }
    }
}
