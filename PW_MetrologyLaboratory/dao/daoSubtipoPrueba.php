<?php

include_once('connection.php');
$id_tipoPrueba = $_GET['id_tipoPrueba'];
SubTipoPrueba($id_tipoPrueba);

function SubTipoPrueba($id_tipoPrueba){
    $con = new LocalConector();
    $conex = $con->conectar();

    $sqlPrueba =  mysqli_query($conex, "SELECT id_subtipo,descripcion FROM SubtipoPrueba WHERE id_tipoPrueba='$id_tipoPrueba';");

    $resultado= mysqli_fetch_all($sqlPrueba, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}

?>