<?php

require_once 'models/categoria.model.php';
require_once 'models/marca.model.php';
require_once 'models/producto.model.php';

require_once 'controllers/producto.controller.php';
require_once 'controllers/categoria.controller.php';
require_once 'controllers/marca.controller.php';

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

$listado = array();

$rutas = explode('/', $_SERVER['REQUEST_URI']);

$rutas_filtro = array_filter($rutas);

$numero_rutas = count($rutas_filtro);

if ($numero_rutas == 1) {
    echo json_encode(array(
        "detalle" => "Detalle No Encontrado",
        'rutas' => $rutas
    ));

    return;
} else {
    if (
        $rutas_filtro[2] == 'marca'
        || $rutas_filtro[2] == 'categoria'
        || $rutas_filtro[2] == 'producto'
    ) {
        require_once 'api/' . $rutas_filtro[2] . '.api.php';
    } else {
        echo json_encode(array(
            "error" => "Detalle No Encontrado",
            "codigo" => 404,
            'rutas' => $rutas
        ));

        return;
    }
}
