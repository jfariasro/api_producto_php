<?php

class Producto
{
    public function __construct(
        public int $idproducto = 0,
        public int $idcategoria = 0,
        public Categoria $categoria = new Categoria,
        public int $idmarca = 0,
        public Marca $marca = new Marca,
        public string $nombre = "",
        public int $cantidad = 0,
        public float $precio = 0,
    ) {
    }

}