<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $categoriaCTR = new CategoriaController;
    // $id = (isset($rutas_filtro[3]) && is_numeric($rutas_filtro[3])) ? $rutas_filtro[3] : -1;
    // if ($id !== -1) {
    //     echo $categoriaCTR->searchProductos($id);
    // } else {
    //     echo $productoCTR->getProductos();
    // }

    echo $categoriaCTR->getCategorias();
}