<?php

include_once('connection.php');

ContadorEstatus();

function ContadorEstatus(){
    $con = new LocalConector();
    $conex = $con->conectar();

    $datos = mysqli_query($conex, "SELECT id_estatus,descripcionEstatus 
                                           FROM EstatusPiezas 
                                          ORDER BY id_estatus;");

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}

?>
