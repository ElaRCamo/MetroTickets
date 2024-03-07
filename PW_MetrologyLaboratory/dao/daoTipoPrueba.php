<?php

include_once('connection.php');

$id_tipoEvaluacion = $_GET['id_tipoEvaluacion'];
ContadorTipoPrueba($id_tipoEvaluacion);

function ContadorTipoPrueba($id_tipoEvaluacion){
    $con = new LocalConector();
    $conex = $con->conectar();

    $sqlPlataforma =  mysqli_query($conex, "SELECT id_tipoPrueba,descripcionPrueba FROM TipoPrueba WHERE id_tipoEvaluacion='$id_tipoEvaluacion' ORDER BY descripcionPrueba;");

    $resultado= mysqli_fetch_all($sqlPlataforma, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}

?>