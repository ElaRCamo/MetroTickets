<?php

include_once('connection.php');

$anio = $_GET['anio'];
ContadorMes();

function ContadorMes(){
    $con = new LocalConector();
    $conex = $con->conectar();

    $datos = mysqli_query($conex, "SELECT DISTINCT MONTH(fechaRespuesta) AS mes
                                           FROM Prueba
                                          WHERE YEAR(fechaRespuesta) = 2023 AND fechaRespuesta IS NOT NULL AND fechaRespuesta != '0000-00-00'
                                          UNION
                                         SELECT DISTINCT MONTH(fechaSolicitud) AS mes
                                           FROM Prueba
                                          WHERE YEAR(fechaSolicitud) = 2023 AND fechaSolicitud IS NOT NULL AND fechaSolicitud != '0000-00-00'
                                          ORDER BY mes;");

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}

?>