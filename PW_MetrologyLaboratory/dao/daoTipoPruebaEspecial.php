<?php
include_once('connection.php');
function ContadorPruebaEspecial(){
    $con = new LocalConector();
    $conex = $con->conectar();

    $sqlPruebaEspecial =  mysqli_query($conex, "SELECT id_pruebaEspecial,descripcionEspecial FROM TipoPruebaEspecial WHERE id_tipoPrueba='5';");

    $resultado= mysqli_fetch_all($sqlPruebaEspecial, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}

?>