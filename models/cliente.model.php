<?php

class Cliente
{
    public function __construct(
        public int $idcliente = 0,
        public string $cedula = "",
        public string $razonsocial = "",
        public string $fechanacimiento = "",
        public int $edad = 0,
        public int $idtipocliente = 0,
        public TipoCliente $tipoCliente = new TipoCliente,
    ) {
    }
}
