<?php

include_once('connection.php');
$id_prueba = $_GET['id_prueba'];
resumenPrueba($id_prueba);

function resumenPrueba($id_prueba){
    $con = new LocalConector();
    $conex = $con->conectar();

    $datosPrueba =  mysqli_query($conex,
        "SELECT   z.numParte, 
                        z.cantidad, 
                        c.descripcionCliente, 
                        p.descripcionPlataforma,
                        z.revisionDibujo, 
                        z.ModMatematico,
                        prueba.id_prueba, 
                        prueba.fechaSolicitud, 
                        prueba.descripcionEstatus, 
                        prueba.descripcionPrioridad,
                        prueba.descripcionPrueba, 
                        prueba.especificaciones,
                        prueba.normaNombre,
                        prueba.normaArchivo,
                        prueba.id_metrologo, 
                        prueba.nombreMetro,  
                        prueba.id_solicitante, 
                        prueba.nombreSolic  
                    FROM   
                        Piezas z
                        JOIN Plataforma p ON z.id_plataforma = p.id_plataforma
                        JOIN Cliente c ON p.id_cliente = c.id_cliente
                        JOIN EstatusPiezas ep ON z.id_estatus = ep.id_estatus
                        JOIN (
                            SELECT 
                                id_prueba, 
                                fechaSolicitud, 
                                descripcionEstatus, 
                                descripcionPrioridad,
                                descripcionPrueba,
                                especificaciones,
                                normaNombre,
                                normaArchivo,
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
                        ) AS prueba ON z.id_prueba = prueba.id_prueba;
");

    $resultado= mysqli_fetch_all($datosPrueba, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));

}

?>