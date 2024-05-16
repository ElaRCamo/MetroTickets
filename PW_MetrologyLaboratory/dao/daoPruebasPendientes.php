<?php

include_once('connection.php');

$fecha_busqueda = date('Y-m') . '%';
PruebasMesActual($fecha_busqueda);
function PruebasMesActual($fecha_busqueda){
    $con = new LocalConector();
    $conex = $con->conectar();

    $datos = mysqli_query($conex, "SELECT COUNT(*)
                                          FROM Prueba
                                         WHERE id_estatusPrueba = 1
                                            OR id_estatusPrueba = 2;");

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}
?>