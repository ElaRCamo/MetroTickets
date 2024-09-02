<?php

include_once('connection.php');

// Función que devuelve la cantidad de pruebas en el mes actual que se encuentra en estatus completado(4) o finalizado(9)

session_start();
$fecha_busqueda = date('Y-m') . '%';
PruebasMesActual($fecha_busqueda);
function PruebasMesActual($fecha_busqueda){
    $con = new LocalConector();
    $conex = $con->conectar();
    $tipoUser = $_SESSION['tipoUsuario'];
    $usuario = $_SESSION['nomina'];

    if($tipoUser == 1){
        $datos = mysqli_query($conex, "SELECT COUNT(*)
                                          FROM Pruebas
                                         WHERE fechaRespuesta LIKE '$fecha_busqueda'
                                           AND id_estatusPrueba IN  (4, 9);");
    }else{
        $datos = mysqli_query($conex, "SELECT COUNT(*)
                                          FROM Pruebas
                                         WHERE fechaRespuesta LIKE '$fecha_busqueda'
                                           AND id_metrologo = '$usuario'
                                           AND id_estatusPrueba IN  (4, 9);");
    }

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}
?>