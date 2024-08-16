<?php

include_once('connection.php');

ContadorEstatus();

function ContadorEstatus(){
    $con = new LocalConector();
    $conex = $con->conectar();

    $datos = mysqli_query($conex, "SELECT id_estatusPrueba,descripcionEstatus 
                                           FROM EstatusPrueba 
                                          WHERE id_estatusPrueba <> 6 AND id_estatusPrueba <> 9
                                          ORDER BY id_estatusPrueba;");

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}

?>