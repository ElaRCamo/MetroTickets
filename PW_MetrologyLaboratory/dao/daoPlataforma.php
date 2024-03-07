<?php

include_once('connection.php');

$id_cliente = $_GET['id_cliente'];
contadorPlataforma($id_cliente);

function contadorPlataforma($id_cliente){
    $con = new LocalConector();
    $conex = $con->conectar();

    $sqlPlataforma =  mysqli_query($conex, "SELECT id_plataforma,descripcionPlataforma FROM Plataforma WHERE id_cliente='$id_cliente' ORDER BY descripcionPlataforma;");

    $resultado= mysqli_fetch_all($sqlPlataforma, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}

?>