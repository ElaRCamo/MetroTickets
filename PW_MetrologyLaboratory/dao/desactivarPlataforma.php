<?php

include_once('connection.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_GET['id_cliente'])){
        // Obtiene el valor del parámetro id_cliente
        $id_plataforma = $_GET['id_plataforma'];
        desactivarPlataforma($id_plataforma);
    }else{
        $respuesta = array("success" => false, "message" => "ID de la plataforma no proporcionado.");
        echo json_encode($respuesta);
    }
} else {
    $respuesta = array("success" => false, "message" => "Se esperaba REQUEST_METHOD");
    echo json_encode($respuesta);
}

function desactivarPlataforma($id_plataforma)
{
    $con = new LocalConector();
    $conex = $con->conectar();

    $stmt = $conex->prepare("UPDATE Plataforma
                                      SET estatus = 0
                                    WHERE id_plataforma = ?");
    $stmt->bind_param("i", $id_plataforma);

    if ($stmt->execute()) {
        $respuesta = array("success" => true, "message" => "Plataforma desactivada");
        echo json_encode($respuesta);
    } else {
        $respuesta = array("success" => false, "message" => "Error.");
        echo json_encode($respuesta);
    }
    $stmt->close();
    $conex->close();

}

?>