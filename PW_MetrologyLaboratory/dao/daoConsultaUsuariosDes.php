<?php

include_once('connection.php');
usuarios();

function usuarios(){
    $con = new LocalConector();
    $conex = $con->conectar();

    $sqlDescMaterial =  mysqli_query($conex, "SELECT id_usuario,nombreUsuario,correoElectronico, descripcionTipo
                                                        FROM Usuario u, TipoUsuario tu
                                                        WHERE u.id_tipoUsuario = tu.id_tipoUsuario 
                                                          AND u.estatus = 0
                                                        ORDER BY descripcionTipo;");
    $resultado= mysqli_fetch_all($sqlDescMaterial, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}

?>