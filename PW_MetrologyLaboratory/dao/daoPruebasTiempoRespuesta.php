
<?php

include_once('connection.php');

$fecha_busqueda = date('Y-m') . '%';
tiempRespuesta($fecha_busqueda);
function tiempRespuesta($fecha_busqueda){
    $con = new LocalConector();
    $conex = $con->conectar();

    $datos = mysqli_query($conex, "SELECT ROUND(AVG(TIMESTAMPDIFF(DAY, fechaSolicitud, fechaRespuesta)), 1) AS tiempoPromedioRespuestaDias 
                                           FROM Prueba 
                                          WHERE fechaRespuesta LIKE '$fecha_busqueda' 
                                            AND id_estatusPrueba = 3;");

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}
?>