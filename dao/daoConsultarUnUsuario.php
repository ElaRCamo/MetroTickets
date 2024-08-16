<?php

include_once('connection.php');
$Nomina = $_GET['id_usuario'];
seleccionarUsuario($Nomina);
function seleccionarUsuario($Nomina){
    $con = new LocalConector();
    $conexion=$con->conectar();

    $datos = mysqli_query($conexion, "SELECT U.id_usuario, U.nombreUsuario, U.passwordHash, T.id_tipoUsuario, T.descripcionTipo, U.correoElectronico, U.foto 
                                            FROM TipoUsuario T
                                            LEFT JOIN Usuario U ON T.id_tipoUsuario = U.id_tipoUsuario
                                            AND U.id_usuario = '$Nomina'
                                            ORDER BY (U.id_usuario = '$Nomina') DESC;");

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}

?>


