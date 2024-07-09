<?php

include_once('connection.php');
$id_prueba = $_GET['id_prueba'];
resumenPrueba($id_prueba);

function resumenPrueba($id_prueba){
    $con = new LocalConector();
    $conex = $con->conectar();

    $datosPrueba =  mysqli_query($conex,
        "SELECT   prueba.id_prueba,
                        prueba.id_tipoPrueba,
                        prueba.especificaciones,
                        prueba.id_subtipo,
                        prueba.imagenCotas,
                        prueba.normaNombre,
                        prueba.normaArchivo,
                        m.numParte, 
                        m.cantidad, 
                        c.id_cliente, 
                        p.id_plataforma,
                        m.revisionDibujo,
                        m.modMatematico
                    FROM   
                        Piezas m
                        JOIN Plataforma p ON m.id_plataforma = p.id_plataforma
                        JOIN Cliente c ON p.id_cliente = c.id_cliente
                        JOIN (
                            SELECT 
                                id_prueba,
                                s.id_tipoPrueba,
                                s.id_subtipo, 
                                imagenCotas,
                                especificaciones,
                                normaNombre,
                                normaArchivo
                            FROM 
                                Pruebas s
                                LEFT JOIN TipoPrueba tp ON s.id_tipoPrueba = tp.id_tipoPrueba
                            WHERE 
                                id_prueba = '$id_prueba'
                        ) AS prueba ON m.id_prueba = prueba.id_prueba;
");

    $resultado= mysqli_fetch_all($datosPrueba, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));

}

?>