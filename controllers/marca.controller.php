<?php

require_once 'config/conexion.php';

class MarcaController
{
    private $conexion;
    private $pdo;
    private Marca $marca;
    public function __construct()
    {
        $this->pdo = new Conexion();
    }

    public function getMarcas()
    {
        $this->conexion = $this->pdo->getPdo();

        $consulta = $this->conexion->prepare("SELECT * FROM marca");
        $consulta->execute();
        $filas = $consulta->fetchAll(PDO::FETCH_ASSOC);

        $listado = array();

        // return json_encode($filas);

        foreach ($filas as $datos) {
            // return json_encode($datos);
            $this->marca = new Marca;

            $this->marca->idmarca = $datos['idmarca'];
            $this->marca->nombre = $datos['nombre'];
            $this->marca->descripcion = $datos['descripcion'];

            $listado[] = $this->marca;
        }

        $this->conexion = null;

        return json_encode($listado);
    }

}