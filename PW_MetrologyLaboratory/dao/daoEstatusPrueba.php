<?php

include_once('connection.php');

ContadorEvaluacion();

function ContadorEvaluacion(){
    $con = new LocalConector();
    $conex = $con->conectar();

    $datos = mysqli_query($conex, "SELECT id_estatusPrueba,descripcionEstatus 
                                            FROM EstatusPrueba ORDER BY id_estatusPrueba;");

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}

?>