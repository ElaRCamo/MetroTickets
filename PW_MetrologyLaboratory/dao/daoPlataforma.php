<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once('connection.php');

$con = new LocalConector();
$conex = $con->conectar();

$sqlPlataforma = 'SELECT id_plataforma,descripcionPlataforma FROM Plataforma WHERE id_cliente='.$_GET['id_cliente'].' ORDER BY descripcionPlataforma';
$resultado=mysqli_query($conex, $sqlPlataforma);
header('Content-Type: application/json');
echo json_encode($resultado);
