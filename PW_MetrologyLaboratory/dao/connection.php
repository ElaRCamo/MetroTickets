<?php
class LocalConector{
    private $host = "127.0.0.1:3306";
    private $usuario = "u543707098_MARIELA";
    private $clave = "Grammer1";
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