<?php
include_once('connection.php');

$id_prueba = $_GET ['id_prueba'];

consultarTipoPrueba($id_prueba);
function consultarTipoPrueba($id_prueba)
{
    // Crear una nueva instancia de la conexión
    $con = new LocalConector();
    $conex = $con->conectar();

    $queryTipoPrueba = "SELECT id_tipoPrueba FROM Pruebas WHERE id_prueba = '$id_prueba'";
    // Ejecutar la consulta
    $resultado = $conex->query($queryTipoPrueba);

    $conex -> close();

    $resultado = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}