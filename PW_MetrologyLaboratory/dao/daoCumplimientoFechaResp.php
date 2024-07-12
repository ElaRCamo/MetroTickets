<?php

include_once('connection.php');

$anio = date('Y');
$mes = date('n'); // Cambiado a 'n' para obtener el mes en formato numérico

PruebasCumplidas($anio, $mes);

function PruebasCumplidas($anio, $mes) {
    $con = new LocalConector();
    $conex = $con->conectar();

    // Escapar los valores para prevenir inyecciones SQL
    $anio = mysqli_real_escape_string($conex, $anio);
    $mes = mysqli_real_escape_string($conex, $mes);

    $query = "
        SELECT
            MONTH(fechaCompromiso) AS mes,
            YEAR(fechaCompromiso) AS anio,
            SUM(CASE WHEN fechaRespuesta <= fechaCompromiso THEN 1 ELSE 0 END) AS pruebasCumplidas,
            COUNT(*) AS totalPruebas,
            ROUND((SUM(CASE WHEN fechaRespuesta <= fechaCompromiso THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) AS porcentajeCumplimiento
        FROM Pruebas
        WHERE YEAR(fechaCompromiso) = $anio
          AND MONTH(fechaCompromiso) = $mes
        GROUP BY mes, anio
        ORDER BY anio, mes;
    ";

    $datos = mysqli_query($conex, $query);

    // Comprobar si la consulta se ejecutó correctamente
    if ($datos) {
        $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
        echo json_encode(array("data" => $resultado));
    } else {
        echo json_encode(array("error" => "Error en la consulta: " . mysqli_error($conex)));
    }
}

?>

