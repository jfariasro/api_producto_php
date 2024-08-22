<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $marcaCTR = new MarcaController;
    $id = (isset($rutas_filtro[3]) && is_numeric($rutas_filtro[3])) ? $rutas_filtro[3] : -1;
    if ($id !== -1) {
        echo $marcaCTR->searchMarcas($id);
    } else {
        echo $marcaCTR->getMarcas();
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json = file_get_contents('php://input');

    $datos = json_decode($json, true);

    // echo json_encode($datos);
    // return;

    $marcaCTR = new MarcaController;
    echo $marcaCTR->postMarcas($datos);
    // echo json_encode(array(
    //     'menssage' => 'Este es el metodo post',
    //     'method' => 'POST',
    // ));
} else if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $id = (isset($rutas_filtro[3]) && is_numeric($rutas_filtro[3])) ? intval($rutas_filtro[3]) : -1;
    $json = file_get_contents('php://input');
    $datos = json_decode($json, true);
    try {
        $marcaCTR = new MarcaController;
        if ($id !== -1) {
            $obj = $marcaCTR->searchMarcas($id);
            if (count(json_decode($obj, true)) == 0) {
                echo json_encode(array(
                    "error" => "La marca no existe",
                    "codigo" => 404
                ));
                return;
            } else if (intval($id) !== intval($datos['idmarca'])) {
                echo json_encode(array(
                    "error" => "El Id de marca no coincide",
                    "codigo" => 409,
                    "id" => $id,
                    "datos" => $datos
                ));
                return;
            }
            echo $marcaCTR->putMarcas($id, $datos);
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
        $marcaCTR = new MarcaController;
        if ($id !== -1) {
            $obj = $marcaCTR->searchMarcas($id);
            if (count(json_decode($obj, true)) == 0) {
                echo json_encode(array(
                    "error" => "La marca no existe",
                    "codigo" => 404
                ));
                return;
            }
            return $marcaCTR->deleteMarcas($id);
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