<?php

include_once('connection.php');
$anio = date('Y');
$mes = date('M');
PruebasCumplidas($anio,$mes);
function PruebasCumplidas($anio,$mes){
    $con = new LocalConector();
    $conex = $con->conectar();

    $datos = mysqli_query($conex, "SELECT
                                                MONTH(fechaCompromiso) AS mes,
                                                YEAR(fechaCompromiso) AS anio,
                                                SUM(CASE WHEN fechaRespuesta <= fechaCompromiso THEN 1 ELSE 0 END) AS pruebasCumplidas,
                                                COUNT(*) AS totalPruebas,
                                                (SUM(CASE WHEN fechaRespuesta <= fechaCompromiso THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS porcentajeCumplimiento
                                            FROM Pruebas
                                            WHERE YEAR(fechaCompromiso) = '$anio'
                                              AND MONTH(fechaCompromiso) = '$mes'
                                            GROUP BY mes, anio
                                            ORDER BY anio, mes;");

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}
?>
