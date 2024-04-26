<?php

include_once('connection.php');

$id_material = $_GET['id_descripcion'];
seleccionarMaterial($id_material);
function seleccionarMaterial($id_material){
    $con = new LocalConector();
    $conex = $con->conectar();

    $datos = mysqli_query($conex, "SELECT P.id_plataforma, P.descripcionPlataforma, M.id_descripcion, M.descripcionMaterial, M.numeroDeParte, M.imgMaterial 
                                           FROM Plataforma P 
                                      LEFT JOIN DescripcionMaterial M ON P.id_plataforma = M.id_plataforma 
                                            AND M.id_descripcion = $id_material 
                                          WHERE P.estatus = 1 
                                          ORDER BY (M.id_descripcion = $id_material) DESC;");

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}

?>