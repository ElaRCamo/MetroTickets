<?php

include_once('connection.php');

$id_cliente = $_GET['id_cliente'];
seleccionarCliente($id_cliente);
function seleccionarCliente($id_cliente){
    $con = new LocalConector();
    $conex = $con->conectar();

    $datos = mysqli_query($conex, "SELECT descripcionCliente 
                                            FROM Cliente 
                                            WHERE id_cliente = '$id_cliente'");

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}

?>