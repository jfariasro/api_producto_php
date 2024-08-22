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

    public function searchMarcas($id)
    {
        $this->conexion = $this->pdo->getPdo();

        $consulta = $this->conexion->prepare("SELECT * FROM marca WHERE idmarca = :id");
        $consulta->bindParam(':id', $id);
        $consulta->execute();
        $fila = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $dato = $fila[0] ?? null;
        // return json_encode($fila[0]['idproducto']);

        $this->conexion = null;

        $this->marca = new Marca();
        if ($dato !== null) {
            $this->marca->idmarca = $dato['idmarca'];
            $this->marca->nombre = $dato['nombre'];
            $this->marca->descripcion = $dato['descripcion'];

            return json_encode($this->marca) ?? null;
        } else {
            return json_encode(array());
        }
    }

    public function postMarcas($datos)
    {
        $this->conexion = $this->pdo->getPdo();

        $this->marca = new Marca(
            0,
            $datos['nombre'],
            $datos['descripcion'],
        );

        $sql = $this->conexion->prepare("INSERT INTO marca(nombre, descripcion)
        VALUES (:nombre, :descripcion)");
        $sql->bindParam(':nombre', $this->marca->nombre, PDO::PARAM_STR);
        $sql->bindParam(':descripcion', $this->marca->descripcion, PDO::PARAM_STR);
        $resultado = $sql->execute();

        $this->conexion = null;

        if (!$resultado) {
            return json_encode(array(
                "codigo" => 500,
                "mensaje" => "Error al Registrar Marca",
            ));
        } else {
            return json_encode(array(
                "codigo" => 200,
                "mensaje" => "Marca Registrada",
            ));
        }
    }

    public function putMarcas($id, $datos)
    {
        $this->conexion = $this->pdo->getPdo();

        $this->marca = new Marca(
            $datos['idmarca'],
            $datos['nombre'],
            $datos['descripcion'],
        );

        $sql = $this->conexion->prepare("UPDATE marca SET nombre = :nombre,
        descripcion = :descripcion WHERE idmarca = :id");
        $sql->bindParam(':id', $id);
        $sql->bindParam(':nombre', $this->marca->nombre, PDO::PARAM_STR);
        $sql->bindParam(':descripcion', $this->marca->descripcion, PDO::PARAM_STR);
        $resultado = $sql->execute();

        $this->conexion = null;

        if (!$resultado) {
            return json_encode(array(
                "codigo" => 500,
                "mensaje" => "Error al Actualizar Marca",
            ));
        } else {
            return json_encode(array(
                "codigo" => 200,
                "mensaje" => "Marca Actualizada",
            ));
        }
    }

    public function deleteMarcas($id)
    {
        $this->conexion = $this->pdo->getPdo();

        $sql = $this->conexion->prepare("DELETE FROM marca WHERE idmarca = :id");
        $sql->bindParam(':id', $id);
        $resultado = $sql->execute();

        if (!$resultado) {
            echo json_encode(array(
                "codigo" => 500,
                "mensaje" => "Error al Eliminar Marca",
            ));
        } else {
            echo json_encode(array(
                "codigo" => 200,
                "mensaje" => "Marca Eliminada",
            ));
        }

        $this->conexion = null;
    }

}