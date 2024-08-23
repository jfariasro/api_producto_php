<?php

class TipoCliente
{
    public function __construct(
        public int $idtipocliente = 0,
        public string $nombre = "",
        public string $descripcion = "",
    ) {
    }
}