<?php

include_once('connection.php');
$id_prueba = $_GET['id_prueba'];
resumenPruebaMunsell($id_prueba);

function resumenPruebaMunsell($id_prueba){
    $con = new LocalConector();
    $conex = $con->conectar();

    $datosPrueba =  mysqli_query($conex,
        "SELECT   pm.nomina,
                        pm.nombre,
                        pm.area,
                        prueba.id_prueba, 
                        prueba.id_tipoPrueba,
                        prueba.fechaSolicitud, 
                        prueba.descripcionEstatus, 
                        prueba.descripcionPrioridad,
                        prueba.descripcionPrueba, 
                        prueba.especificaciones,
                        prueba.id_metrologo, 
                        prueba.nombreMetro,  
                        prueba.id_solicitante, 
                        prueba.nombreSolic  
                    FROM   
                        PersonalMunsell pm
                        JOIN (
                            SELECT 
                                id_prueba,
                                id_tipoPrueba,
                                fechaSolicitud, 
                                descripcionEstatus, 
                                descripcionPrioridad,
                                descripcionPrueba,
                                especificaciones,
                                s.id_metrologo, 
                                u_metro.nombreUsuario AS nombreMetro,
                                s.id_solicitante, 
                                u_solic.nombreUsuario AS nombreSolic
                            FROM 
                                Pruebas s
                                LEFT JOIN Usuario u_metro ON s.id_metrologo = u_metro.id_usuario
                                LEFT JOIN Usuario u_solic ON s.id_solicitante = u_solic.id_usuario
                                LEFT JOIN TipoPrueba tp ON s.id_tipoPrueba = tp.id_tipoPrueba
                                LEFT JOIN EstatusPrueba ep ON s.id_estatusPrueba = ep.id_estatusPrueba
                                LEFT JOIN Prioridad p ON s.id_prioridad = p.id_prioridad
                            WHERE 
                                id_prueba = '$id_prueba'
                        ) AS prueba ON pm.id_prueba = prueba.id_prueba;
");

    $resultado= mysqli_fetch_all($datosPrueba, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));

}

?>