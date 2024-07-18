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
                    s.id_tipoPrueba,
                    tp.descripcionPrueba,
                    s.especificaciones,
                    s.id_metrologo,
                    u_metro.nombreUsuario AS nombreMetro,
                    s.id_solicitante,
                    u_solic.nombreUsuario AS nombreSolic,
                    CASE
                        WHEN s.id_estatusPrueba = 1 
                            THEN CONCAT('<span class=\"badge bg-secondary\">', ep.descripcionEstatus, '</span>')
                        WHEN s.id_estatusPrueba = 2 
                            THEN CONCAT('<span class=\"badge bg-primary\">', ep.descripcionEstatus, '</span>')
                        WHEN s.id_estatusPrueba = 3 
                            THEN CONCAT('<span class=\"badge bg-warning text-dark\">', ep.descripcionEstatus, '</span>')
                        WHEN s.id_estatusPrueba = 4 
                            THEN CONCAT('<span class=\"badge bg-success\">', ep.descripcionEstatus, '</span>')
                        WHEN s.id_estatusPrueba = 5 
                            THEN CONCAT('<span class=\"badge bg-danger\">', ep.descripcionEstatus, '</span>')
                        WHEN s.id_estatusPrueba = 6 
                            THEN CONCAT('<span class=\"badge bg-dark\">', ep.descripcionEstatus, '</span>')
                    END AS estatusVisual,
                    CASE
                        WHEN s.id_prioridad = 1 
                            THEN CONCAT('<span class=\"badge bg-secondary\">', p.descripcionPrioridad, '</span>')
                        WHEN s.id_prioridad = 2 
                            THEN CONCAT('<span class=\"badge bg-success\">', p.descripcionPrioridad, '</span>')
                        WHEN s.id_prioridad = 3 
                            THEN CONCAT('<span class=\"badge bg-warning text-dark\">', p.descripcionPrioridad, '</span>')
                        WHEN s.id_prioridad = 4 
                            THEN CONCAT('<span class=\"badge bg-danger\">', p.descripcionPrioridad, '</span>')
                    END AS prioridadVisual
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