<?php

include_once('connection.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_GET['id_descripcion'])){
        // Obtiene el valor del parámetro id_cliente
        $id_descripcion = $_GET['id_descripcion'];
        desactivarMaterial($id_descripcion);
    }else{
        $respuesta = array("success" => false, "message" => "ID del material no proporcionado.");
        echo json_encode($respuesta);
    }
} else {
    $respuesta = array("success" => false, "message" => "Se esperaba REQUEST_METHOD");
    echo json_encode($respuesta);
}

function desactivarMaterial($id_descripcion)
{
    $con = new LocalConector();
    $conex = $con->conectar();

    $stmt = $conex->prepare("UPDATE DescripcionMaterial
                                      SET estatus = 0
                                    WHERE id_descripcion = ?");
    $stmt->bind_param("i", $id_descripcion);

    if ($stmt->execute()) {
        $respuesta = array("success" => true, "message" => "Material desactivado");
        echo json_encode($respuesta);
    } else {
        $respuesta = array("success" => false, "message" => "Error.");
        echo json_encode($respuesta);
    }
    $stmt->close();
    $conex->close();

}

?>