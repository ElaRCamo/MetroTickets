<?php
include_once('connection.php');
require_once('functionsAdmin.php');
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_GET['id_usuario'])){
        // Obtiene el valor del parámetro id_cliente
        $id_usuario = $_GET['id_usuario'];
        $respuesta = activarUsuario($id_usuario);
    }else{
        $respuesta = array("success" => false, "message" => "ID del usuario no proporcionado.");
    }
} else {
    $respuesta = array("success" => false, "message" => "Se esperaba REQUEST_METHOD");
}
echo json_encode($respuesta);

function activarUsuario($id_usuario)
{
    $con = new LocalConector();
    $conex = $con->conectar();

    $stmt = $conex->prepare("UPDATE Usuario
                                      SET estatus = 1
                                    WHERE id_usuario = ?");
    $stmt->bind_param("s", $id_usuario);

    if ($stmt->execute()) {
        //Registrar cambios en bitacora
        $descripcion = "Usuario activado: ".$id_usuario. ".";
        $response = registrarCambioAdmin($conex, $descripcion,$_SESSION['nomina']);

        if($response['status']==='success'){
            $conex->commit();
            $respuesta = array("success" => true, "message" => "Usuario activado");
        }else{
            $conex->rollback();
            $respuesta = $response;
        }

    } else {
        $respuesta = array("success" => false, "message" => "Error.");
    }
    $stmt->close();
    $conex->close();
    return $respuesta;
}
?>