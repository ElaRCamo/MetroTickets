
<?php
include_once('connection.php');

// Función que calcula y devuelve el tiempo promedio de respuesta en días para las pruebas completadas en el mes actual,
// diferenciando entre todos los usuarios o un usuario específico según el tipo de usuario almacenado en la sesión.
session_start();
$fecha_busqueda = date('Y-m') . '%';
tiempRespuesta($fecha_busqueda);
function tiempRespuesta($fecha_busqueda){
    $con = new LocalConector();
    $conex = $con->conectar();
    $tipoUser = $_SESSION['tipoUsuario'];
    $usuario = $_SESSION['nomina'];


    if($tipoUser == 1){
        $datos = mysqli_query($conex, "SELECT ROUND(AVG(TIMESTAMPDIFF(DAY, fechaSolicitud, fechaRespuesta)), 1) AS tiempoPromedioRespuestaDias 
                                           FROM Pruebas 
                                          WHERE fechaRespuesta LIKE '$fecha_busqueda' 
                                            AND id_estatusPrueba IN (4, 9);");
    }else{
        $datos = mysqli_query($conex, "SELECT ROUND(AVG(TIMESTAMPDIFF(DAY, fechaSolicitud, fechaRespuesta)), 1) AS tiempoPromedioRespuestaDias 
                                           FROM Pruebas 
                                          WHERE fechaRespuesta LIKE '$fecha_busqueda' 
                                            AND id_estatusPrueba IN (4,9)
                                            AND id_metrologo = '$usuario';");
    }

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}
?>