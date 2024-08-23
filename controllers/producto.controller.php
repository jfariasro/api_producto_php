<?php

class ProductoController
{
    private $conexion;
    private $pdo;
    private Producto $producto;
    public function __construct()
    {
        $this->pdo = new Conexion();
    }

    public function getProductos()
    {
        $this->conexion = $this->pdo->getPdo();

        $consulta = $this->conexion->prepare("SELECT p.*,
            c.nombre categorias, c.descripcion des_cat,
            m.nombre marcas, m.descripcion des_mar
            from
            producto p JOIN categoria c ON c.idcategoria = p.idcategoria
            JOIN marca m ON m.idmarca = p.idmarca");
        $consulta->execute();
        $filas = $consulta->fetchAll(PDO::FETCH_ASSOC);

        $listado = array();

        // return json_encode($filas);

        foreach ($filas as $datos) {
            // return json_encode($datos);
            $this->producto = new Producto(
                $datos['idproducto'],
                $datos['idcategoria'],
                new Categoria($datos['idcategoria'], $datos['categorias'], $datos['des_cat']),
                $datos['idmarca'],
                new Marca($datos['idmarca'], $datos['marcas'], $datos['des_mar']),
                $datos['nombre'],
                $datos['cantidad'],
                $datos['precio']
            );

            $listado[] = $this->producto;
        }

        $this->conexion = null;

        return json_encode($listado);
    }

    public function searchProductos($id)
    {
        $this->conexion = $this->pdo->getPdo();

        $consulta = $this->conexion->prepare("SELECT p.*,
            c.nombre categorias, c.descripcion des_cat,
            m.nombre marcas, m.descripcion des_mar
            from
            producto p JOIN categoria c ON c.idcategoria = p.idcategoria
            JOIN marca m ON m.idmarca = p.idmarca WHERE p.idproducto = :id");
        $consulta->bindParam(':id', $id);
        $consulta->execute();
        $fila = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $dato = $fila[0] ?? null;
        // return json_encode($fila[0]['idproducto']);

        $this->conexion = null;

        if ($dato !== null) {
            $this->producto = new Producto(
                $dato['idproducto'],
                $dato['idcategoria'],
                new Categoria($dato['idcategoria'], $dato['categorias'], $dato['des_cat']),
                $dato['idmarca'],
                new Marca($dato['idmarca'], $dato['marcas'], $dato['des_mar']),
                $dato['nombre'],
                $dato['cantidad'],
                $dato['precio']
            );

            return json_encode($this->producto) ?? null;
        } else {
            return json_encode(array());
        }
    }

    public function postProductos($datos)
    {
        $this->conexion = $this->pdo->getPdo();

        $this->producto = new Producto(
            0,
            $datos['idcategoria'],
            new Categoria,
            $datos['idmarca'],
            new Marca,
            $datos['nombre'],
            $datos['cantidad'],
            $datos['precio']
        );

        $sql = $this->conexion->prepare("INSERT INTO producto (nombre, idcategoria, idmarca, cantidad, precio)
        VALUES (:nombre, :idcategoria, :idmarca, :cantidad, :precio)");
        $sql->bindParam(':nombre', $this->producto->nombre, PDO::PARAM_STR);
        $sql->bindParam(':idcategoria', $this->producto->idcategoria, PDO::PARAM_INT);
        $sql->bindParam(':idmarca', $this->producto->idmarca, PDO::PARAM_INT);
        $sql->bindParam(':cantidad', $this->producto->cantidad, PDO::PARAM_INT);
        $sql->bindParam(':precio', $this->producto->precio);
        $resultado = $sql->execute();

        $this->conexion = null;

        if (!$resultado) {
            // return json_encode(http_response_code(500));
            return json_encode(array(
                "codigo" => 500,
                "mensaje" => "Producto No Registrado",
            ));
        } else {
            // http_response_code(200); 
            return json_encode(array(
                "codigo" => 200,
                "mensaje" => "Producto Registrado",
            ));
        }
    }

    public function putProductos($id, $datos)
    {
        $this->conexion = $this->pdo->getPdo();

        $this->producto = new Producto(
            $datos['idproducto'],
            $datos['idcategoria'],
            new Categoria,
            $datos['idmarca'],
            new Marca,
            $datos['nombre'],
            $datos['cantidad'],
            $datos['precio']
        );

        $sql = $this->conexion->prepare("UPDATE producto SET nombre = :nombre,
        idcategoria = :idcategoria, idmarca = :idmarca, cantidad = :cantidad, precio = :precio 
        WHERE idproducto = :id");
        $sql->bindParam(':id', $id);
        $sql->bindParam(':nombre', $this->producto->nombre, PDO::PARAM_STR);
        $sql->bindParam(':idcategoria', $this->producto->idcategoria, PDO::PARAM_INT);
        $sql->bindParam(':idmarca', $this->producto->idmarca, PDO::PARAM_INT);
        $sql->bindParam(':cantidad', $this->producto->cantidad, PDO::PARAM_INT);
        $sql->bindParam(':precio', $this->producto->precio);
        $resultado = $sql->execute();

        $this->conexion = null;

        if (!$resultado) {
            return json_encode(array(
                "codigo" => 500,
                "mensaje" => "Error al Actualizar Producto",
            ));
        } else {
            return json_encode(array(
                "codigo" => 200,
                "mensaje" => "Producto Actualizado",
            ));
        }
    }

    public function deleteProductos($id)
    {
        $this->conexion = $this->pdo->getPdo();

        $sql = $this->conexion->prepare("DELETE FROM producto WHERE idproducto = :id");
        $sql->bindParam(':id', $id);
        $resultado = $sql->execute();

        $this->conexion = null;

        if (!$resultado) {
            return json_encode(array(
                "codigo" => 500,
                "mensaje" => "Error al Eliminar Producto",
            ));
        } else {
            return json_encode(array(
                "codigo" => 200,
                "mensaje" => "Producto Eliminado",
            ));
        }

    }
}
