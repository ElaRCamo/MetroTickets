<?php

include_once('connection.php');
$id_prueba = $_GET['id_prueba'];
ContadorTipoPrueba($id_prueba);

function ContadorTipoPrueba($id_prueba){
    $con = new LocalConector();
    $conex = $con->conectar();

    $sqlPrueba =  mysqli_query($conex, "SELECT id_tipoPrueba FROM Pruebas
                                                WHERE id_prueba = '$id_prueba';");

    $resultado= mysqli_fetch_all($sqlPrueba, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}

?>