<?php

include_once('connection.php');
$id_prueba = $_GET['id_prueba'];
resumenPrueba($id_prueba);

function resumenPrueba($id_prueba){
    $con = new LocalConector();
    $conex = $con->conectar();

    $datosPrueba =  mysqli_query($conex,
        "SELECT dm.numeroDeParte, 
                        m.cantidad, 
                        dm.descripcionMaterial, 
                        dm.imgMaterial, 
                        c.descripcionCliente, 
                        p.descripcionPlataforma,
                        prueba.id_prueba, 
                        prueba.fechaSolicitud, 
                        prueba.descripcionEstatus, 
                        prueba.descripcionPrueba, 
                        prueba.especificaciones,
                        prueba.id_metrologo, 
                        prueba.nombreMetro,  
                        prueba.id_solicitante, 
                        prueba.nombreSolic  
                    FROM   
                        Material m
                        JOIN DescripcionMaterial dm ON m.id_descripcion = dm.id_descripcion
                        JOIN Plataforma p ON dm.id_plataforma = p.id_plataforma
                        JOIN Cliente c ON p.id_cliente = c.id_cliente
                        JOIN EstatusMaterial em ON m.id_estatusMaterial = em.id_estatusMaterial
                        JOIN (
                            SELECT 
                                id_prueba, 
                                fechaSolicitud, 
                                descripcionEstatus, 
                                descripcionPrueba,
                                especificaciones,
                                s.id_metrologo, 
                                u_metro.nombreUsuario AS nombreMetro,
                                s.id_solicitante, 
                                u_solic.nombreUsuario AS nombreSolic
                            FROM 
                                Prueba s
                                LEFT JOIN Usuario u_metro ON s.id_metrologo = u_metro.id_usuario
                                LEFT JOIN Usuario u_solic ON s.id_solicitante = u_solic.id_usuario
                                LEFT JOIN TipoPrueba tp ON s.id_tipoPrueba = tp.id_tipoPrueba
                                LEFT JOIN EstatusPrueba ep ON s.id_estatusPrueba = ep.id_estatusPrueba
                            WHERE 
                                id_prueba = '$id_prueba'
                        ) AS prueba ON m.id_prueba = prueba.id_prueba;
");

    $resultado= mysqli_fetch_all($datosPrueba, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));

}

?>