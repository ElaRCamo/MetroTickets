<?php
include_once('connection.php');
consultarTipoPrueba("2024-0170");
function consultarTipoPrueba($id_prueba)
{
    // Crear una nueva instancia de la conexión
    $con = new LocalConector();
    $conex = $con->conectar();

    $queryTipoPrueba = "SELECT id_tipoPrueba FROM Pruebas WHERE id_prueba = '$id_prueba'";
    // Ejecutar la consulta
    $resultado = $conex->query($queryTipoPrueba);
    // Obtener la fila del resultado
    $fila = $resultado->fetch_assoc();

    $conex -> close();

    return $fila['id_tipoPrueba'];
}
