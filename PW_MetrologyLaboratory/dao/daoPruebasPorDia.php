<?php

include_once('connection.php');


PruebasPorDia();
function PruebasPorDia(){
    $con = new LocalConector();
    $conex = $con->conectar();

    $datos = mysqli_query($conex, "SELECT ROUND(COUNT(*) / DAY(LAST_DAY(fechaRespuesta)), 1) AS eficienciaOperativa
                                           FROM Pruebas
                                          WHERE MONTH(fechaRespuesta) = MONTH(CURRENT_DATE())
                                            AND YEAR(fechaRespuesta) = YEAR(CURRENT_DATE())
                                            AND id_estatusPrueba = 3;");

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}
?>