<?php

include_once('connection.php');

$id_plataforma = $_GET['id_plataforma'];
seleccionarPlataforma($id_plataforma);
function seleccionarPlataforma($id_plataforma){
    $con = new LocalConector();
    $conex = $con->conectar();

    $datos = mysqli_query($conex, "SELECT C.id_cliente, C.descripcionCliente, P.id_plataforma, P.descripcionPlataforma
                                           FROM Cliente C
                                      LEFT JOIN Plataforma P ON C.id_cliente = P.id_cliente
                                            AND P.id_plataforma = '$id_plataforma'");

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}

?>