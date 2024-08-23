<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $tipoclienteCTR = new TipoClienteController;
    $id = (isset($rutas_filtro[3]) && is_numeric($rutas_filtro[3])) ? $rutas_filtro[3] : -1;
    if ($id !== -1) {
        echo $tipoclienteCTR->searchTiposCliente($id);
    } else {
        echo $tipoclienteCTR->getTiposCliente();
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json = file_get_contents('php://input');

    $datos = json_decode($json, true);

    $tipoclienteCTR = new TipoClienteController;
    echo $tipoclienteCTR->postTiposCliente($datos);
} else if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $id = (isset($rutas_filtro[3]) && is_numeric($rutas_filtro[3])) ? intval($rutas_filtro[3]) : -1;
    $json = file_get_contents('php://input');
    $datos = json_decode($json, true);
    try {
        $tipoclienteCTR = new TipoClienteController;
        if ($id !== -1) {
            $obj = $tipoclienteCTR->searchTiposCliente($id);
            if (count(json_decode($obj, true)) == 0) {
                echo json_encode(array(
                    "error" => "El Tipo de Cliente no existe",
                    "codigo" => 404
                ));
                return;
            } else if (intval($id) !== intval($datos['idtipocliente'])) {
                echo json_encode(array(
                    "error" => "El Id de tipo cliente no coincide",
                    "codigo" => 409,
                    "id" => $id,
                    "datos" => $datos
                ));
                return;
            }
            echo $tipoclienteCTR->putTiposCliente($id, $datos);
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
        $tipoclienteCTR = new TipoClienteController;
        if ($id !== -1) {
            $obj = $tipoclienteCTR->searchTiposCliente($id);
            if (count(json_decode($obj, true)) == 0) {
                echo json_encode(array(
                    "error" => "El tipo cliente no existe",
                    "codigo" => 404
                ));
                return;
            }
            echo $tipoclienteCTR->deleteTiposCliente($id);
        } else {
            echo json_encode(array(
                "error" => "El Id no es numérico",
                "codigo" => 500,
                "id" => $id
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
