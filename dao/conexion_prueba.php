<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conexion = mysqli_connect("127.0.0.1:3306","u909553968_Ela","LMGrammer2024#","u909553968_MetroTickects");

if($conexion){
    echo 'Conexión exitosa';
}else{
    echo 'Conexión fallida :(';
}
?>