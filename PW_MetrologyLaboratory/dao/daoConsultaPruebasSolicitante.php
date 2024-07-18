<?php

include_once('connection.php');
session_start();
$id_solicitante = $_SESSION['nomina'];
resumenPrueba($id_solicitante);

function resumenPrueba($id_solicitante){
    $con = new LocalConector();
    $conex = $con->conectar();

    $datosPrueba =  mysqli_query($conex,
        "SELECT
                    s.id_prueba,
                    s.fechaSolicitud,
                    s.fechaRespuesta,
                    s.fechaCompromiso,
                    p.descripcionPrioridad,
                    s.id_tipoPrueba,
                    tp.descripcionPrueba,
                    s.especificaciones,
                    s.id_metrologo,
                    u_metro.nombreUsuario AS nombreMetro,
                    s.id_solicitante,
                    u_solic.nombreUsuario AS nombreSolic,
                    CASE
                        WHEN s.id_estatusPrueba = 1 THEN CONCAT('<span class=\"label label-success\">', ep.descripcionEstatus, '</span>')
                        ELSE ep.descripcionEstatus
                    END AS estatusVisual
                FROM
                    Pruebas s
                    LEFT JOIN Usuario u_metro ON s.id_metrologo = u_metro.id_usuario
                    LEFT JOIN Usuario u_solic ON s.id_solicitante = u_solic.id_usuario
                    LEFT JOIN TipoPrueba tp ON s.id_tipoPrueba = tp.id_tipoPrueba
                    LEFT JOIN EstatusPrueba ep ON s.id_estatusPrueba = ep.id_estatusPrueba
                    LEFT JOIN Prioridad p ON s.id_prioridad = p.id_prioridad
                WHERE
                    s.id_solicitante = '$id_solicitante'
                    AND s.id_estatusPrueba <> 6
                ORDER BY
                    s.id_prueba DESC;
                ");

    $resultado= mysqli_fetch_all($datosPrueba, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));

}

?>