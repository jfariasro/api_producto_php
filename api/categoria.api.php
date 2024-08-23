<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $categoriaCTR = new CategoriaController;
    $id = (isset($rutas_filtro[3]) && is_numeric($rutas_filtro[3])) ? $rutas_filtro[3] : -1;
    if ($id !== -1) {
        echo $categoriaCTR->searchCategorias($id);
    } else {
        echo $categoriaCTR->getCategorias();
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json = file_get_contents('php://input');

    $datos = json_decode($json, true);

    // echo json_encode($datos);
    // return;

    $categoriaCTR = new CategoriaController;
    echo $categoriaCTR->postCategorias($datos);
    // echo json_encode(array(
    //     'menssage' => 'Este es el metodo post',
    //     'method' => 'POST',
    // ));
} else if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $id = (isset($rutas_filtro[3]) && is_numeric($rutas_filtro[3])) ? intval($rutas_filtro[3]) : -1;
    $json = file_get_contents('php://input');
    $datos = json_decode($json, true);
    try {
        $categoriaCTR = new CategoriaController;
        if ($id !== -1) {
            $obj = $categoriaCTR->searchCategorias($id);
            if (count(json_decode($obj, true)) == 0) {
                echo json_encode(array(
                    "error" => "La categoria no existe",
                    "codigo" => 404
                ));
                return;
            } else if (intval($id) !== intval($datos['idcategoria'])) {
                echo json_encode(array(
                    "error" => "El Id de categoria no coincide",
                    "codigo" => 409,
                    "id" => $id,
                    "datos" => $datos
                ));
                return;
            }
            echo $categoriaCTR->putCategorias($id, $datos);
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
        $categoriaCTR = new CategoriaController;
        if ($id !== -1) {
            $obj = $categoriaCTR->searchCategorias($id);
            if (count(json_decode($obj, true)) == 0) {
                echo json_encode(array(
                    "error" => "La categoria no existe",
                    "codigo" => 404
                ));
                return;
            }
            echo $categoriaCTR->deleteCategorias($id);
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
