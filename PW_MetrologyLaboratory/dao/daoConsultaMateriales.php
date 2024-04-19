<?php

include_once('connection.php');
materiales();

function materiales(){
    $con = new LocalConector();
    $conex = $con->conectar();

    $sqlDescMaterial =  mysqli_query($conex, "SELECT id_descripcion,descripcionMaterial, numeroDeParte, imgMaterial, descripcionPlataforma 
                                                        FROM DescripcionMaterial DM, Plataforma P 
                                                        WHERE DM.id_plataforma = P.id_plataforma 
                                                        AND DM.estatus = 1
                                                        ORDER BY id_descripcion;");
    $resultado= mysqli_fetch_all($sqlDescMaterial, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}

?>