<?php

include_once('connection.php');
$id_prueba = $_GET['id_prueba'];
resumenPrueba($id_prueba);

function resumenPrueba($id_prueba){
    $con = new LocalConector();
    $conex = $con->conectar();

    $datosPrueba =  mysqli_query($conex,
        "SELECT   prueba.id_prueba,
                        prueba.id_tipoEvaluacion,
                        prueba.id_tipoPrueba,
                        prueba.descripcionPrueba, 
                        prueba.id_pruebaEspecial,
                        prueba.otroTipoEspecial,
                        prueba.especificaciones,
                        prueba.especificacionesLab,
                        prueba.normaNombre,
                        prueba.normaArchivo,
                        prueba.id_solicitante, 
                        prueba.nombreSolic,
                        prueba.correoSolic,
                        dm.numeroDeParte, 
                        m.cantidad, 
                        dm.descripcionMaterial, 
                        dm.imgMaterial, 
                        c.descripcionCliente, 
                        p.descripcionPlataforma,
                        em.descripcionEstatus AS estatusMaterial
                    FROM   
                        Material m
                        JOIN DescripcionMaterial dm ON m.id_descripcion = dm.id_descripcion
                        JOIN Plataforma p ON dm.id_plataforma = p.id_plataforma
                        JOIN Cliente c ON p.id_cliente = c.id_cliente
                        JOIN EstatusMaterial em ON m.id_estatusMaterial = em.id_estatusMaterial
                        JOIN (
                            SELECT 
                                id_prueba,
                                s.id_tipoPrueba,
                                descripcionPrueba,
                                id_tipoEvaluacion,
                                especificaciones,
                                especificacionesLab,
                                normaNombre,
                                normaArchivo,
                                otroTipoEspecial,
                                id_pruebaEspecial,
                                s.id_solicitante, 
                                u_solic.nombreUsuario AS nombreSolic,
                                u_solic.correoElectronico AS correoSolic
                            FROM 
                                Prueba s
                                LEFT JOIN Usuario u_solic ON s.id_solicitante = u_solic.id_usuario
                                LEFT JOIN TipoPrueba tp ON s.id_tipoPrueba = tp.id_tipoPrueba
                                LEFT JOIN EstatusPrueba ep ON s.id_estatusPrueba = ep.id_estatusPrueba
                                LEFT JOIN Prioridad p ON s.id_prioridad = p.id_prioridad
                            WHERE 
                                id_prueba = '$id_prueba'
                        ) AS prueba ON m.id_prueba = prueba.id_prueba;
");

    $resultado= mysqli_fetch_all($datosPrueba, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));

}

?>