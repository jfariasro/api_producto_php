<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $clienteCTR = new ClienteController;
    $id = (isset($rutas_filtro[3]) && is_numeric($rutas_filtro[3])) ? $rutas_filtro[3] : -1;
    if ($id !== -1) {
        echo $clienteCTR->searchClientes($id);
    } else {
        echo $clienteCTR->getClientes();
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json = file_get_contents('php://input');

    $datos = json_decode($json, true);

    $clienteCTR = new ClienteController;
    echo $clienteCTR->postClientes($datos);
} else if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $id = (isset($rutas_filtro[3]) && is_numeric($rutas_filtro[3])) ? intval($rutas_filtro[3]) : -1;
    $json = file_get_contents('php://input');
    $datos = json_decode($json, true);
    try {
        $clienteCTR = new ClienteController;
        if ($id !== -1) {
            $obj = $clienteCTR->searchClientes($id);
            if (count(json_decode($obj, true)) == 0) {
                echo json_encode(array(
                    "error" => "El cliente no existe",
                    "codigo" => 404
                ));
                return;
            } else if (intval($id) !== intval($datos['idcliente'])) {
                echo json_encode(array(
                    "error" => "El Id de cliente no coincide",
                    "codigo" => 409,
                    "id" => $id,
                    "datos" => $datos
                ));
                return;
            }
            echo $clienteCTR->putClientes($id, $datos);
        } else {
            echo json_encode(array(
                "error" => "El Id no es numérico",
                "codigo" => 500
            ));

            return;
        }
    } catch (Exception $ex) {
        echo json_encode(array(
            "error" => $ex->getMessage(),
            "codigo" => 500
        ));

        return;
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $id = (isset($rutas_filtro[3]) && is_numeric($rutas_filtro[3])) ? intval($rutas_filtro[3]) : -1;
    try {
        $clienteCTR = new ClienteController();
        if ($id !== -1) {
            $obj = $clienteCTR->searchClientes($id);
            if (count(json_decode($obj, true)) == 0) {
                echo json_encode(array(
                    "error" => "El cliente no existe",
                    "codigo" => 404
                ));
                return;
            }
            echo $clienteCTR->deleteClientes($id);
        } else {
            echo json_encode(array(
                "error" => "El Id no es numérico",
                "codigo" => 500,
                "id"=> $id
            ));

            return;
        }
    } catch (Exception $ex) {
        echo json_encode(array(
            "error" => $ex->getMessage(),
            "codigo" => 500
        ));

        return;
    }
}
