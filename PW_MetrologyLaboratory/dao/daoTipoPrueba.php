<?php

include_once('connection.php');

ContadorTipoPrueba();

function ContadorTipoPrueba(){
    $con = new LocalConector();
    $conex = $con->conectar();

    $sqlPrueba =  mysqli_query($conex, "SELECT id_tipoPrueba,descripcionPrueba FROM TipoPrueba;");

    $resultado= mysqli_fetch_all($sqlPrueba, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}

?>