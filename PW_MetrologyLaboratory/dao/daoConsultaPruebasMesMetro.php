<?php

include_once('connection.php');

ContadorPruebas();

function ContadorPruebas()
{
    $con = new LocalConector();
    $conex = $con->conectar();

    $anio_actual = date('Y');

    $datos = mysqli_query($conex, "SELECT COUNT(p.id_prueba) AS Pruebas, MONTH(p.FechaRespuesta) AS Mes, u.nombreUsuario AS NombreMetrologo 
                                           FROM Prueba p JOIN Usuario u ON p.id_metrologo = u.id_usuario 
                                          WHERE YEAR(p.FechaRespuesta) = $anio_actual AND p.id_metrologo <> '00000000' 
                                          GROUP BY MONTH(p.FechaRespuesta), u.nombreUsuario 
                                          ORDER BY Mes, NombreMetrologo;");

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}


?>