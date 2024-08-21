<?php

class Conexion
{
    private ?PDO $pdo = null;

    public function __construct(
        private string $host = 'localhost',
        private string $dbname = 'prueba_api',
        private string $username = 'root',
        private string $password = '',
        private string $charset = 'utf8'
    ) {
    }

    private function conectar()
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            throw new Exception('Error de conexión: ' . $e->getMessage());
        }

        return $this->pdo;
    }

    public function getPdo()
    {
        if ($this->pdo === null) {
            $this->conectar();
        }

        return $this->pdo;
    }
}