<?php

include_once('connection.php');

// Función que devuelve la cantidad de pruebas que se encuentra en estatus:
// aprobado-en fila(2), en proceso(3), rechazado(5)

PruebasPendientes();
session_start();
function PruebasPendientes(){
    $con = new LocalConector();
    $conex = $con->conectar();
    $tipoUser = $_SESSION['tipoUsuario'];
    $usuario = $_SESSION['nomina'];

    if($tipoUser == 1){
        $datos = mysqli_query($conex, "SELECT COUNT(*)
                                               FROM Pruebas
                                              WHERE id_estatusPrueba IN (2, 3, 5);");
    }else{
        $datos = mysqli_query($conex, "SELECT COUNT(*)
                                               FROM Pruebas
                                              WHERE id_estatusPrueba IN (2, 3, 5)
                                                AND id_metrologo = '$usuario';");
    }

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}
?>