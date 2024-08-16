<?php

include_once('connection.php');

metrologos();

function metrologos(){
    $con = new LocalConector();
    $conex = $con->conectar();

    $datos = mysqli_query($conex, "SELECT id_usuario,nombreUsuario 
                                            FROM Usuario
                                            WHERE id_tipoUsuario = 2
                                            ORDER BY id_usuario;");

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}

?>