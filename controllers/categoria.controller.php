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

    public function searchCategorias($id)
    {
        $this->conexion = $this->pdo->getPdo();

        $consulta = $this->conexion->prepare("SELECT * FROM categoria WHERE idcategoria = :id");
        $consulta->bindParam(':id', $id);
        $consulta->execute();
        $fila = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $dato = $fila[0] ?? null;
        // return json_encode($fila[0]['idproducto']);

        $this->conexion = null;

        $this->categoria = new Categoria();
        if ($dato !== null) {
            $this->categoria->idcategoria = $dato['idcategoria'];
            $this->categoria->nombre = $dato['nombre'];
            $this->categoria->descripcion = $dato['descripcion'];

            return json_encode($this->categoria) ?? null;
        } else {
            return json_encode(array());
        }
    }

    public function postCategorias($datos)
    {
        $this->conexion = $this->pdo->getPdo();

        $this->categoria = new Categoria(
            0,
            $datos['nombre'],
            $datos['descripcion'],
        );

        $sql = $this->conexion->prepare("INSERT INTO categoria(nombre, descripcion)
        VALUES (:nombre, :descripcion)");
        $sql->bindParam(':nombre', $this->categoria->nombre, PDO::PARAM_STR);
        $sql->bindParam(':descripcion', $this->categoria->descripcion, PDO::PARAM_STR);
        $resultado = $sql->execute();

        $this->conexion = null;

        if (!$resultado) {
            return json_encode(array(
                "codigo" => 500,
                "mensaje" => "Error al Registrar Categoria",
            ));
        } else {
            return json_encode(array(
                "codigo" => 200,
                "mensaje" => "Categoria Registrada",
            ));
        }
    }

    public function putCategorias($id, $datos)
    {
        $this->conexion = $this->pdo->getPdo();

        $this->categoria = new Categoria(
            $datos['idcategoria'],
            $datos['nombre'],
            $datos['descripcion'],
        );

        $sql = $this->conexion->prepare("UPDATE categoria SET nombre = :nombre,
        descripcion = :descripcion WHERE idcategoria = :id");
        $sql->bindParam(':id', $id);
        $sql->bindParam(':nombre', $this->categoria->nombre, PDO::PARAM_STR);
        $sql->bindParam(':descripcion', $this->categoria->descripcion, PDO::PARAM_STR);
        $resultado = $sql->execute();

        $this->conexion = null;

        if (!$resultado) {
            return json_encode(array(
                "codigo" => 500,
                "mensaje" => "Error al Actualizar Categoria",
            ));
        } else {
            return json_encode(array(
                "codigo" => 200,
                "mensaje" => "Categoria Actualizada",
            ));
        }
    }

    public function deleteCategorias($id)
    {
        $this->conexion = $this->pdo->getPdo();

        $sql = $this->conexion->prepare("DELETE FROM categoria WHERE idcategoria = :id");
        $sql->bindParam(':id', $id);
        $resultado = $sql->execute();

        if (!$resultado) {
            echo json_encode(array(
                "codigo" => 500,
                "mensaje" => "Error al Eliminar Categoria",
            ));
        } else {
            echo json_encode(array(
                "codigo" => 200,
                "mensaje" => "Categoria Eliminada",
            ));
        }

        $this->conexion = null;
    }

}
