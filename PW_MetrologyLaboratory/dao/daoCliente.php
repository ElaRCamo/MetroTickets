<?php

include_once('connection.php');

ContadorCliente();

function ContadorCliente(){
    $con = new LocalConector();
    $conex = $con->conectar();

    $datos = mysqli_query($conex, "SELECT id_cliente,descripcionCliente FROM Cliente ORDER BY descripcionCliente;");

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
    echo '<script>alert("¡Dao Cliente!");</script>';
    echo $resultado;
}
?>