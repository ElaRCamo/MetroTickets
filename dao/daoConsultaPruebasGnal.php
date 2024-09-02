<?php

include_once('connection.php');

ContadorPruebas();

function ContadorPruebas()
{
    $con = new LocalConector();
    $conex = $con->conectar();

    $anio_actual = date('Y');

    $datos = mysqli_query($conex, "SELECT COUNT(`id_prueba`) AS Pruebas, MONTH(`FechaRespuesta`) as Mes 
                                           FROM `Pruebas` 
                                          WHERE YEAR(`FechaRespuesta`) = $anio_actual 
                                            AND id_estatus <> 4
                                            AND id_estatus <> 6
                                            AND id_estatus <> 9
                                          GROUP BY MONTH(`FechaRespuesta`);");

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}


?>