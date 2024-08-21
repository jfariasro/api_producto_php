<?php

require_once 'config/conexion.php';

class CategoriaController
{
    private $conexion;
    private $pdo;
    private Categoria $categoria;
    public function __construct()
    {
        $this->pdo = new Conexion();
    }

    public function getCategorias()
    {
        $this->conexion = $this->pdo->getPdo();

        $consulta = $this->conexion->prepare("SELECT * FROM categoria");
        $consulta->execute();
        $filas = $consulta->fetchAll(PDO::FETCH_ASSOC);

        $listado = array();

        // return json_encode($filas);

        foreach ($filas as $datos) {
            // return json_encode($datos);
            $this->categoria = new Categoria;

            $this->categoria->idcategoria = $datos['idcategoria'];
            $this->categoria->nombre = $datos['nombre'];
            $this->categoria->descripcion = $datos['descripcion'];

            $listado[] = $this->categoria;
        }

        $this->conexion = null;

        return json_encode($listado);
    }

}
