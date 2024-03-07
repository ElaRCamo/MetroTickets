<?php

include_once('connection.php');

ftipoEvaluacion();

function ftipoEvaluacion(){
    $con = new LocalConector();
    $conex = $con->conectar();

    $datos = mysqli_query($conex, "SELECT id_tipoEvaluacion,descripcionEvaluacion FROM TipoEvaluacion ORDER BY descripcionEvaluacion;");

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}

?>