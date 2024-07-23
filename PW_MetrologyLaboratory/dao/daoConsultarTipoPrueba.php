<?php
include_once('connection.php');

$id_prueba = $_GET ['id_prueba'];

consultarTipoPrueba($id_prueba);
function consultarTipoPrueba($id_prueba)
{
    // Crear una nueva instancia de la conexión
    $con = new LocalConector();
    $conex = $con->conectar();

    $datos = mysqli_query($conex, "SELECT id_tipoPrueba FROM Pruebas WHERE id_prueba = '$id_prueba'");

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}
?>