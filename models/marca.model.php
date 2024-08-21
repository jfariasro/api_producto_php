<?php

class Marca
{
    public function __construct(
        public int $idmarca = 0,
        public string $nombre = "",
        public string $descripcion = "",
    ) {
    }
}