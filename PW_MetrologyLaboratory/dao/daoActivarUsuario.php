<?php

include_once('connection.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_GET['id_usuario'])){
        // Obtiene el valor del parámetro id_cliente
        $id_usuario = $_GET['id_usuario'];
        desactivarUsuario($id_usuario);
    }else{
        $respuesta = array("success" => false, "message" => "ID del usuario no proporcionado.");
        echo json_encode($respuesta);
    }
} else {
    $respuesta = array("success" => false, "message" => "Se esperaba REQUEST_METHOD");
    echo json_encode($respuesta);
}

function desactivarUsuario($id_usuario)
{
    $con = new LocalConector();
    $conex = $con->conectar();

    $stmt = $conex->prepare("UPDATE Usuario
                                      SET estatus = 1
                                    WHERE id_usuario = ?");
    $stmt->bind_param("s", $id_usuario);

    if ($stmt->execute()) {
        $respuesta = array("success" => true, "message" => "Perfil de usuario activado");
        echo json_encode($respuesta);
    } else {
        $respuesta = array("success" => false, "message" => "Error.");
        echo json_encode($respuesta);
    }
    $stmt->close();
    $conex->close();

}

?>