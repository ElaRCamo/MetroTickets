<?php

include_once('connection.php');

$anio = $_GET['anio'];
ContadorMes($anio);

function ContadorMes($anio){
    $con = new LocalConector();
    $conex = $con->conectar();

    $datos = mysqli_query($conex, "SELECT DISTINCT MONTH(fechaRespuesta) AS mes
                                           FROM Pruebas
                                          WHERE YEAR(fechaRespuesta) = $anio AND fechaRespuesta IS NOT NULL 
                                            AND fechaRespuesta != '0000-00-00'
                                          ORDER BY mes");

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}

?>