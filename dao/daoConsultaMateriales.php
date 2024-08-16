<?php

include_once('connection.php');
materiales();

function materiales(){
    $con = new LocalConector();
    $conex = $con->conectar();

    $sqlDescMaterial =  mysqli_query($conex, "SELECT id_descripcion,descripcionMaterial, numeroDeParte, imgMaterial, descripcionPlataforma, descripcionCliente 
                                                        FROM DescripcionMaterial DM, Plataforma P, Cliente C
                                                        WHERE DM.id_plataforma = P.id_plataforma 
                                                          AND P.id_cliente = C.id_cliente
                                                          AND DM.estatus = 1
                                                        ORDER BY descripcionCliente;");
    $resultado= mysqli_fetch_all($sqlDescMaterial, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}

?>