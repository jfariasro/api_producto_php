<?php

class Categoria
{
    public function __construct(
        public int $idcategoria = 0,
        public string $nombre = "",
        public string $descripcion = "",
    ) {
    }
}
