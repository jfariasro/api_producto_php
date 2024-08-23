<?php

class ClienteController
{
    private $conexion;
    private $pdo;
    private Cliente $cliente;
    public function __construct()
    {
        $this->pdo = new Conexion();
    }

    public function getClientes()
    {
        $this->conexion = $this->pdo->getPdo();

        $consulta = $this->conexion->prepare("SELECT c.*,
        tc.nombre, tc.descripcion
        FROM cliente c JOIN tipocliente tc on c.idtipocliente = tc.idtipocliente");
        $consulta->execute();
        $filas = $consulta->fetchAll(PDO::FETCH_ASSOC);

        $listado = array();

        // return json_encode($filas);

        foreach ($filas as $datos) {
            // return json_encode($datos);
            $this->cliente = new Cliente(
                $datos['idcliente'],
                $datos['cedula'],
                $datos['razonsocial'],
                $datos['fechanacimiento'],
                $datos['edad'],
                $datos['idtipocliente'],
                new TipoCliente($datos['idtipocliente'], $datos['nombre'], $datos['descripcion']),
            );

            $listado[] = $this->cliente;
        }

        $this->conexion = null;

        return json_encode($listado);
    }

    public function searchClientes($id)
    {
        $this->conexion = $this->pdo->getPdo();

        $consulta = $this->conexion->prepare("SELECT c.*,
        tc.nombre, tc.descripcion
        FROM cliente c JOIN tipocliente tc on c.idtipocliente = tc.idtipocliente
        WHERE c.idcliente = :id");
        $consulta->bindParam(':id', $id);
        $consulta->execute();
        $fila = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $dato = $fila[0] ?? null;
        // return json_encode($fila[0]['idproducto']);

        $this->conexion = null;

        if ($dato !== null) {
            $this->cliente = new Cliente(
                $dato['idcliente'],
                $dato['cedula'],
                $dato['razonsocial'],
                $dato['fechanacimiento'],
                $dato['edad'],
                $dato['idtipocliente'],
                new TipoCliente($dato['idtipocliente'], $dato['nombre'], $dato['descripcion']),
            );

            return json_encode($this->cliente) ?? null;
        } else {
            return json_encode(array());
        }
    }

    public function postClientes($datos)
    {
        $this->conexion = $this->pdo->getPdo();

        $this->cliente = new Cliente(
            0,
            $datos['cedula'],
            $datos['razonsocial'],
            $datos['fechanacimiento'],
            $datos['edad'],
            $datos['idtipocliente'],
            new TipoCliente,
        );

        $sql = $this->conexion->prepare("INSERT INTO cliente (cedula, razonsocial, fechanacimiento, edad, idtipocliente)
        VALUES (:cedula, :razonsocial, :fechanacimiento, :edad, :idtipocliente)");
        $sql->bindParam(':cedula', $this->cliente->cedula, PDO::PARAM_STR);
        $sql->bindParam(':razonsocial', $this->cliente->razonsocial, PDO::PARAM_STR);
        $sql->bindParam(':fechanacimiento', $this->cliente->fechanacimiento);
        $sql->bindParam(':edad', $this->cliente->edad, PDO::PARAM_INT);
        $sql->bindParam(':idtipocliente', $this->cliente->idtipocliente, PDO::PARAM_INT);
        $resultado = $sql->execute();

        $this->conexion = null;

        if (!$resultado) {
            // return json_encode(http_response_code(500));
            return json_encode(array(
                "codigo" => 500,
                "mensaje" => "Cliente No Registrado",
            ));
        } else {
            // http_response_code(200); 
            return json_encode(array(
                "codigo" => 200,
                "mensaje" => "Cliente Registrado",
            ));
        }
    }

    public function putClientes($id, $datos)
    {
        $this->conexion = $this->pdo->getPdo();

        $this->cliente = new Cliente(
            $datos['idcliente'],
            $datos['cedula'],
            $datos['razonsocial'],
            $datos['fechanacimiento'],
            $datos['edad'],
            $datos['idtipocliente'],
            new TipoCliente,
        );

        $sql = $this->conexion->prepare("UPDATE cliente SET cedula = :cedula,
        razonsocial = :razonsocial, fechanacimiento = :fechanacimiento,
        edad = :edad, idtipocliente = :idtipocliente 
        WHERE idcliente = :id");
        $sql->bindParam(':id', $id);
        $sql->bindParam(':cedula', $this->cliente->cedula, PDO::PARAM_STR);
        $sql->bindParam(':razonsocial', $this->cliente->razonsocial, PDO::PARAM_STR);
        $sql->bindParam(':fechanacimiento', $this->cliente->fechanacimiento);
        $sql->bindParam(':edad', $this->cliente->edad, PDO::PARAM_INT);
        $sql->bindParam(':idtipocliente', $this->cliente->idtipocliente, PDO::PARAM_INT);
        $resultado = $sql->execute();

        $this->conexion = null;

        if (!$resultado) {
            return json_encode(array(
                "codigo" => 500,
                "mensaje" => "Error al Actualizar Cliente",
            ));
        } else {
            return json_encode(array(
                "codigo" => 200,
                "mensaje" => "Cliente Actualizado",
            ));
        }
    }

    public function deleteClientes($id)
    {
        $this->conexion = $this->pdo->getPdo();

        $sql = $this->conexion->prepare("DELETE FROM cliente WHERE idcliente = :id");
        $sql->bindParam(':id', $id);
        $resultado = $sql->execute();

        $this->conexion = null;

        if (!$resultado) {
            return json_encode(array(
                "codigo" => 500,
                "mensaje" => "Error al Eliminar Cliente",
            ));
        } else {
            return json_encode(array(
                "codigo" => 200,
                "mensaje" => "Cliente Eliminado",
            ));
        }

    }
}
