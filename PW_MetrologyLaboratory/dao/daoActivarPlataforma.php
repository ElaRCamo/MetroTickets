<?php
include_once('connection.php');
require_once('functionsAdmin.php');
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_GET['id_plataforma'])){
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
    $conex->begin_transaction();

    $stmt = $conex->prepare("UPDATE Plataforma P
                                    SET P.estatus = 1
                                    WHERE P.id_plataforma = ?");
    $stmt->bind_param("i", $id_plataforma);

    if ($stmt->execute()) {
        //Registrar cambios en bitacora
        $descripcion = "Plataforma activada: ".$id_plataforma. ".";
        $response =  registrarCambioAdmin($conex, $descripcion,$_SESSION['nomina']);

        if($response['status']==='success'){
            $conex->commit();
            $respuesta = array("success" => true, "message" => "Plataforma activada");
        }else{
            $conex->rollback();
            $respuesta = $response;
        }
    } else {
        $respuesta = array("success" => false, "message" => "Error.");
    }
    $stmt->close();
    $conex->close();
    echo json_encode($respuesta);
}
?>