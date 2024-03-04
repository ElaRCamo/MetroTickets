<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class LocalConector{
    private $host = "127.0.0.1:3306";
    private $usuario = "u543707098_MARIELA";
    private $clave = "Metrologia1";
    private $db = "u543707098_PRODUCCION";

    public function conectar(){
        $conexion = mysqli_connect($this->host,$this->usuario,$this->clave,$this->db);

        if($conexion){
             echo 'Conexión exitosa';
         }else{
             echo 'Conexión fallida';
         }
    }
}
?>