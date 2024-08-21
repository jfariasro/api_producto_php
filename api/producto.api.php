<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $productoCTR = new ProductoController;
    $id = (isset($rutas_filtro[3]) && is_numeric($rutas_filtro[3])) ? $rutas_filtro[3] : -1;
    if ($id !== -1) {
        echo $productoCTR->searchProductos($id);
    } else {
        echo $productoCTR->getProductos();
    }
    // $consulta = "SELECT p.*,
    // c.nombre categorias, c.descripcion des_cat,
    // m.nombre marcas, m.descripcion des_mar
    // from
    // producto p JOIN categoria c ON c.idcategoria = p.idcategoria
    // JOIN marca m ON m.idmarca = p.idmarca";

    // $resultado = mysqli_query($conexion, $consulta);

    // // var_dump(mysqli_fetch_assoc($resultado));

    // while ($datos = mysqli_fetch_assoc($resultado)) {

    //     $producto = new Producto;
    //     $producto->idproducto = $datos['idproducto'];

    //     $producto->categoria = new Categoria;
    //     $producto->categoria->idcategoria = $datos['idcategoria'];
    //     $producto->categoria->nombre = $datos['categorias'];
    //     $producto->categoria->descripcion = $datos['des_cat'];

    //     $producto->marca = new Marca;
    //     $producto->marca->idmarca = $datos['idmarca'];
    //     $producto->marca->nombre = $datos['marcas'];
    //     $producto->marca->descripcion = $datos['des_mar'];

    //     $producto->nombre = $datos['nombre'];
    //     $producto->cantidad = $datos['cantidad'];
    //     $producto->precio = $datos['precio'];

    //     $listado[] = $producto;
    // }

    // // var_dump($listado);

    // echo json_encode($listado);
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json = file_get_contents('php://input');

    $datos = json_decode($json, true);

    // echo json_encode($datos);
    // return;

    $productoCTR = new ProductoController;
    echo $productoCTR->postProductos($datos);
    // echo json_encode(array(
    //     'menssage' => 'Este es el metodo post',
    //     'method' => 'POST',
    // ));
} else if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $id = (isset($rutas_filtro[3]) && is_numeric($rutas_filtro[3])) ? intval($rutas_filtro[3]) : -1;
    $json = file_get_contents('php://input');
    $datos = json_decode($json, true);
    try {
        $productoCTR = new ProductoController;
        if ($id !== -1) {
            $obj = $productoCTR->searchProductos($id);
            if (count(json_decode($obj, true)) == 0) {
                echo json_encode(array(
                    "error" => "El producto no existe",
                    "codigo" => 404
                ));
                return;
            } else if (intval($id) !== intval($datos['idproducto'])) {
                echo json_encode(array(
                    "error" => "El Id de producto no coincide",
                    "codigo" => 409,
                    "id" => $id,
                    "datos" => $datos
                ));
                return;
            }
            echo $productoCTR->putProductos($id, $datos);
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
        $productoCTR = new ProductoController();
        if ($id !== -1) {
            $obj = $productoCTR->searchProductos($id);
            if (count(json_decode($obj, true)) == 0) {
                echo json_encode(array(
                    "error" => "El producto no existe",
                    "codigo" => 404
                ));
                return;
            }
            return $productoCTR->deleteProductos($id);
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
