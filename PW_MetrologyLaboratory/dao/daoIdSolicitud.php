<?php

include_once('connection.php');

ConsultaIdMax();

function ConsultaIdMax()
{
    $con = new LocalConector();
    $conex = $con->conectar();

    $sqlIdMax = mysqli_query($conex, "SELECT MAX(id_prueba) AS max_id_prueba FROM `Prueba`");

    $resultado = mysqli_fetch_all($sqlIdMax, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}
?>