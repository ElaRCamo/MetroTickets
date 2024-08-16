<?php

include_once('connection.php');

ContadorPrioridad();

function ContadorPrioridad(){
    $con = new LocalConector();
    $conex = $con->conectar();

    $datos = mysqli_query($conex, "SELECT id_prioridad,descripcionPrioridad
                                            FROM Prioridad ORDER BY id_prioridad;");

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}

?>