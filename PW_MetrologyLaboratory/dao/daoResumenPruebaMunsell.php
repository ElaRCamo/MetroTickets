<?php

include_once('connection.php');
$id_prueba = $_GET['id_prueba'];
resumenPrueba($id_prueba);

function resumenPrueba($id_prueba){
    $con = new LocalConector();
    $conex = $con->conectar();

    $datosPrueba =  mysqli_query($conex, "SELECT   prueba.id_prueba, 
                                prueba.fechaSolicitud, 
                                prueba.fechaRespuesta, 
                                prueba.fechaCompromiso,
                                prueba.id_estatusPrueba,
                                prueba.descripcionEstatus,
                                prueba.descripcionPrioridad,
                                prueba.descripcionPrueba, 
                                prueba.id_tipoPrueba,
                                prueba.id_prioridad,
                                prueba.especificaciones,
                                prueba.especificacionesLab,
                                prueba.resultados,
                                prueba.id_metrologo, 
                                prueba.nombreMetro,  
                                prueba.id_solicitante, 
                                prueba.nombreSolic,
                                pm.nomina,
                                pm.nombre,
                                pm.area
                            FROM   
                                PersonalMunsell pm
                                JOIN (
                                    SELECT 
                                        id_prueba, 
                                        fechaSolicitud, 
                                        fechaRespuesta,
                                        fechaCompromiso,
                                        s.id_estatusPrueba,
                                        descripcionEstatus,
                                        descripcionPrioridad,
                                        s.id_tipoPrueba, 
                                        s.id_prioridad,
                                        descripcionPrueba,
                                        especificaciones,
                                        especificacionesLab,
                                        resultados,
                                        s.id_metrologo, 
                                        u_metro.nombreUsuario AS nombreMetro,
                                        s.id_solicitante, 
                                        u_solic.nombreUsuario AS nombreSolic
                                    FROM 
                                        Pruebas s
                                        LEFT JOIN Usuario u_metro ON s.id_metrologo = u_metro.id_usuario
                                        LEFT JOIN Usuario u_solic ON s.id_solicitante = u_solic.id_usuario
                                        LEFT JOIN TipoPrueba tp ON s.id_tipoPrueba = tp.id_tipoPrueba
                                        LEFT JOIN SubtipoPrueba sp ON s.id_subtipo = sp.id_subtipo
                                        LEFT JOIN EstatusPrueba ep ON s.id_estatusPrueba = ep.id_estatusPrueba
                                        LEFT JOIN Prioridad p ON s.id_prioridad = p.id_prioridad
                                    WHERE 
                                        id_prueba = '$id_prueba'
                                ) AS prueba ON pm.id_prueba = prueba.id_prueba;");

    $resultado= mysqli_fetch_all($datosPrueba, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}
?>
