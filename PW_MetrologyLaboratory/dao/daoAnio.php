<?php

include_once('connection.php');

ContadorAnios();

function ContadorAnios(){
    $con = new LocalConector();
    $conex = $con->conectar();

    $datos = mysqli_query($conex, "SELECT DISTINCT YEAR(fechaRespuesta) AS anio
                                           FROM Prueba
                                          WHERE fechaRespuesta IS NOT NULL 
                                            AND fechaRespuesta != '0000-00-00'");

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}

?>