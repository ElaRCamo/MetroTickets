<?php

include_once('connection.php');

$id_descripcion = $_GET['id_descripcion'];
CargarNumDeParte($id_descripcion);

function CargarNumDeParte($id_descripcion){
    $con = new LocalConector();
    $conex = $con->conectar();

    $datos = mysqli_query($conex, "SELECT numeroDeParte FROM `DescripcionMaterial` WHERE id_descripcion='$id_descripcion';");

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}

?>