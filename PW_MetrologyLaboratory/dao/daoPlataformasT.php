<?php

include_once('connection.php');

todasLasPlataforma();

function todasLasPlataforma(){
    $con = new LocalConector();
    $conex = $con->conectar();

    $sqlPlataforma =  mysqli_query($conex, "SELECT id_plataforma, descripcionPlataforma, descripcionCliente 
                                                    FROM Plataforma P,Cliente C 
                                                    WHERE P.id_cliente = C.id_cliente
                                                      AND estatus = 1
                                                    ORDER BY descripcionCliente;");

    $resultado= mysqli_fetch_all($sqlPlataforma, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}

?>