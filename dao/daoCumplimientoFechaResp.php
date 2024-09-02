<?php

include_once('connection.php');

session_start();
PruebasCumplidas();

function PruebasCumplidas() {
    $con = new LocalConector();
    $conex = $con->conectar();

    $tipoUser = $_SESSION['tipoUsuario'];
    $usuario = $_SESSION['nomina'];
    $anio = date('Y');
    $mes = date('n');

    if($tipoUser == 1){
        $query = "SELECT
                    MONTH(fechaCompromiso) AS mes,
                    YEAR(fechaCompromiso) AS anio,
                    SUM(CASE WHEN fechaRespuesta <= fechaCompromiso THEN 1 ELSE 0 END) AS pruebasCumplidas,
                    COUNT(*) AS totalPruebas,
                    ROUND((SUM(CASE WHEN fechaRespuesta <= fechaCompromiso THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) AS porcentajeCumplimiento
                    FROM Pruebas
                    WHERE YEAR(fechaCompromiso) = $anio
                      AND MONTH(fechaCompromiso) = $mes
                    GROUP BY mes, anio
                    ORDER BY anio, mes;";
    }else{
        $query = "SELECT
                    MONTH(fechaCompromiso) AS mes,
                    YEAR(fechaCompromiso) AS anio,
                    SUM(CASE WHEN fechaRespuesta <= fechaCompromiso THEN 1 ELSE 0 END) AS pruebasCumplidas,
                    COUNT(*) AS totalPruebas,
                    ROUND((SUM(CASE WHEN fechaRespuesta <= fechaCompromiso THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) AS porcentajeCumplimiento
                    FROM Pruebas
                    WHERE YEAR(fechaCompromiso) = $anio
                      AND MONTH(fechaCompromiso) = $mes
                      AND id_metrologo = '$usuario'
                    GROUP BY mes, anio
                    ORDER BY anio, mes;";
    }

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