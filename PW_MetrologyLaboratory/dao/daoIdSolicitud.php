<?php

include_once('connection.php');

ConsultaIdMax();

function ConsultaIdMax()
{
    $con = new LocalConector();
    $conex = $con->conectar();

    $sqlIdMax = mysqli_query($conex, "SELECT MAX(id_prueba) AS max_id_prueba FROM `SolicitudPrueba`");

    // Verificar si la consulta fue exitosa
    if ($sqlIdMax) {
        // Obtener el resultado como un array asociativo
        $resultado = mysqli_fetch_assoc($sqlIdMax);
        //$max_id_prueba = $resultado['max_id_prueba'];

        //echo "El valor máximo de id_prueba es: " . $max_id_prueba;
        return $resultado;
    } else {
        echo "Error al ejecutar la consulta: " . mysqli_error($conex);
        return 0;
    }
}
?>