<?php

include_once('connection.php');

ContadorPruebasGnal();

//Esta funcion genera el numero de pruebas por mes que estan en alguna etapa del proceso(pendiente de aprobacion(1),
// aprobado-en fila(2), en proceso(3), rechazado(5)
function ContadorPruebasGnal()
{
    $con = new LocalConector();
    $conex = $con->conectar();

    $anio_actual = date('Y');

    $datos = mysqli_query($conex, "SELECT 
                                                COUNT(`id_prueba`) AS Pruebas, 
                                                MONTH(`FechaSolicitud`) AS Mes 
                                            FROM 
                                                `Pruebas`
                                            WHERE 
                                                YEAR(`FechaSolicitud`) = $anio_actual
                                                AND id_estatusPrueba IN (1, 2, 3, 5)
                                            GROUP BY 
                                                MONTH(`FechaSolicitud`);");

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}

?>