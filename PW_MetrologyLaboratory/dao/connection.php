<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class LocalConector{
    private $host = "127.0.0.1:3306";
    private $usuario = "u543707098_MARIELA";
    private $clave = "Metrologia123";
    private $db = "u543707098_PRODUCCION";
    private $conexion;

    public function conectar(){
        $this->conexion = mysqli_connect($this->host, $this->usuario, $this->clave, $this->db);
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
        echo "conexion exitosa";
        return $this->conexion;
    }

    public function cerrarConexion() {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }

    public function getConexion() {
        return $this->conexion;
    }
}

