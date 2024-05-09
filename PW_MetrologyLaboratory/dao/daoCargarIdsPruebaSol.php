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
                        prueba.id_pruebaEspecial,
                        m.id_descripcion,
                        c.id_cliente,
                        p.id_plataforma
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
                                id_tipoEvaluacion,
                                id_pruebaEspecial
                            FROM 
                                Prueba s
                                LEFT JOIN TipoPrueba tp ON s.id_tipoPrueba = tp.id_tipoPrueba
                            WHERE 
                                id_prueba = '$id_prueba'
                        ) AS prueba ON m.id_prueba = prueba.id_prueba;
");

    $resultado= mysqli_fetch_all($datosPrueba, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));

}

?>