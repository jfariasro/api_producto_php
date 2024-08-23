<?php

require_once 'models/categoria.model.php';
require_once 'models/marca.model.php';
require_once 'models/producto.model.php';
require_once 'models/tipocliente.model.php';
require_once 'models/cliente.model.php';

require_once 'controllers/producto.controller.php';
require_once 'controllers/categoria.controller.php';
require_once 'controllers/marca.controller.php';
require_once 'controllers/tipocliente.controller.php';
require_once 'controllers/cliente.controller.php';

require_once 'config/conexion.php';

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

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
        || $rutas_filtro[2] == 'cliente'
        || $rutas_filtro[2] == 'tipocliente'
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
