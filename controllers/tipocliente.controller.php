<?php

require_once 'config/conexion.php';

class TipoClienteController
{
    private $conexion;
    private $pdo;
    private TipoCliente $tipoCliente;
    public function __construct()
    {
        $this->pdo = new Conexion();
    }

    public function getTiposCliente()
    {
        $this->conexion = $this->pdo->getPdo();

        $consulta = $this->conexion->prepare("SELECT * FROM tipocliente");
        $consulta->execute();
        $filas = $consulta->fetchAll(PDO::FETCH_ASSOC);

        $listado = array();

        // return json_encode($filas);

        foreach ($filas as $datos) {
            // return json_encode($datos);
            $this->tipoCliente = new TipoCliente(
                $datos['idtipocliente'],
                $datos['nombre'],
                $datos['descripcion'],
            );

            $listado[] = $this->tipoCliente;
        }

        $this->conexion = null;

        return json_encode($listado);
    }

    public function searchTiposCliente($id)
    {
        $this->conexion = $this->pdo->getPdo();

        $consulta = $this->conexion->prepare("SELECT * FROM tipocliente WHERE idtipocliente = :id");
        $consulta->bindParam(':id', $id);
        $consulta->execute();
        $fila = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $dato = $fila[0] ?? null;
        // return json_encode($fila[0]['idproducto']);

        $this->conexion = null;

        if ($dato !== null) {
            $this->tipoCliente = new TipoCliente(
                $dato['idtipocliente'],
                $dato['nombre'],
                $dato['descripcion'],
            );

            return json_encode($this->tipoCliente) ?? null;
        } else {
            return json_encode(array());
        }
    }

    public function postTiposCliente($datos)
    {
        $this->conexion = $this->pdo->getPdo();

        $this->tipoCliente = new TipoCliente(
            0,
            $datos['nombre'],
            $datos['descripcion'],
        );

        $sql = $this->conexion->prepare("INSERT INTO tipocliente(nombre, descripcion)
        VALUES (:nombre, :descripcion)");
        $sql->bindParam(':nombre', $this->tipoCliente->nombre, PDO::PARAM_STR);
        $sql->bindParam(':descripcion', $this->tipoCliente->descripcion, PDO::PARAM_STR);
        $resultado = $sql->execute();

        $this->conexion = null;

        if (!$resultado) {
            return json_encode(array(
                "codigo" => 500,
                "mensaje" => "Error al Registrar Tipo de Cliente",
            ));
        } else {
            return json_encode(array(
                "codigo" => 200,
                "mensaje" => "Tipo de Cliente Registrado",
            ));
        }
    }

    public function putTiposCliente($id, $datos)
    {
        $this->conexion = $this->pdo->getPdo();

        $this->tipoCliente = new TipoCliente(
            $datos['idtipocliente'],
            $datos['nombre'],
            $datos['descripcion'],
        );

        $sql = $this->conexion->prepare("UPDATE tipocliente SET nombre = :nombre,
        descripcion = :descripcion WHERE idtipocliente = :id");
        $sql->bindParam(':id', $id);
        $sql->bindParam(':nombre', $this->tipoCliente->nombre, PDO::PARAM_STR);
        $sql->bindParam(':descripcion', $this->tipoCliente->descripcion, PDO::PARAM_STR);
        $resultado = $sql->execute();

        $this->conexion = null;

        if (!$resultado) {
            return json_encode(array(
                "codigo" => 500,
                "mensaje" => "Error al Actualizar Tipo de Cliente",
            ));
        } else {
            return json_encode(array(
                "codigo" => 200,
                "mensaje" => "Tipo de Cliente Actualizado",
            ));
        }
    }

    public function deleteTiposCliente($id)
    {
        $this->conexion = $this->pdo->getPdo();

        $sql = $this->conexion->prepare("DELETE FROM tipocliente WHERE idtipocliente = :id");
        $sql->bindParam(':id', $id);
        $resultado = $sql->execute();

        $this->conexion = null;

        if (!$resultado) {
            return json_encode(array(
                "codigo" => 500,
                "mensaje" => "Error al Eliminar Tipo de Cliente",
            ));
        } else {
            return json_encode(array(
                "codigo" => 200,
                "mensaje" => "Tipo de Cliente Eliminado",
            ));
        }
    }

}
