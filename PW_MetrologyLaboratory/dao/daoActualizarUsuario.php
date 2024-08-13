<?php

include_once('connection.php');
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $adminTipo = $_SESSION['tipoUsuario'];

        if($_POST['id_usuario'] && $_POST['tipoDeUsuarioE'] !== null){
            $id_usuario = $_POST['id_usuario'];
            $tipoUsuario = $_POST['tipoDeUsuarioE'];

            if($adminTipo === 2 && $tipoUsuario === 1 ){
                $respuesta = array("error" => false, "message" => "Permisos insuficientes");
            }else{
                actualizarUsuario($id_usuario,$tipoUsuario);
            }
        }else{
            $respuesta = array("success" => false, "message" => "Faltan dtos en el formulario.");
            echo json_encode($respuesta);
        }

} else {
    $respuesta = array("error" => false, "message" => "Se esperaba REQUEST_METHOD");
    echo json_encode($respuesta);
}

function actualizarUsuario($id_usuario,$tipoUsuario)
{
    $con = new LocalConector();
    $conex = $con->conectar();

    $stmt = $conex->prepare("UPDATE Usuario
                                      SET id_tipoUsuario = ?
                                    WHERE id_usuario = ?");
    $stmt->bind_param("is", $tipoUsuario,$id_usuario);

    if ($stmt->execute()) {
        $respuesta = array("success" => true, "message" => "Perfil de usuario actualizado");
        echo json_encode($respuesta);
    } else {
        $respuesta = array("error" => false, "message" => "Error.");
        echo json_encode($respuesta);
    }
    $stmt->close();
    $conex->close();
}
?>