<?php

include_once('connection.php');

$id_plataforma = $_GET['id_plataforma'];
contadorPlataforma($id_plataforma );

function contadorPlataforma($id_plataforma ){
    $con = new LocalConector();
    $conex = $con->conectar();

    $sqlDescMaterial =  mysqli_query($conex, "SELECT id_descripcion,descripcionMaterial FROM DescripcionMaterial WHERE id_plataforma='$id_plataforma' ORDER BY descripcionMaterial;");
    $resultado= mysqli_fetch_all($sqlDescMaterial, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}

?>

