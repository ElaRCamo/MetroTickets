<?php

include_once('connection.php');
session_start();

$Nomina = $_SESSION['nomina'];
cargarPerfilUsuario($Nomina);
function cargarPerfilUsuario($Nomina){
    $con = new LocalConector();
    $conexion=$con->conectar();

    $datos = mysqli_query($conexion, "SELECT id_usuario, nombreUsuario, passwordHash, correoElectronico, foto 
                                            FROM Usuario
                                            WHERE id_usuario = '$Nomina';");

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}
?>


