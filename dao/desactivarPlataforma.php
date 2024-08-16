<?php
header('Content-Type: application/json');
include_once('connection.php');
require_once('functionsAdmin.php');
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['id_plataforma'])){
        // Obtiene el valor del parámetro id_cliente
        $id_plataforma = $_POST['id_plataforma'];
        $response = desactivarPlataforma($id_plataforma);
    }else{
        $response = array('status' => 'error', 'message' => 'ID de la plataforma no proporcionado.');
    }
} else {
    $response = array('status' => 'error', 'message' => 'Se esperaba REQUEST_METHOD.');
}
echo json_encode($response);

function desactivarPlataforma($id_plataforma)
{
    $con = new LocalConector();
    $conex = $con->conectar();

    $stmt = $conex->prepare("UPDATE Plataforma P
                                    SET P.estatus = 0
                                    WHERE P.id_plataforma = ?");
    $stmt->bind_param("i", $id_plataforma);


    if ($stmt->execute()) {
        //Registrar cambios en bitacora
        $descripcion = "Plataforma desactivada: ".$id_plataforma. ".";
        $response =  registrarCambioAdmin($conex, $descripcion,$_SESSION['nomina']);

        if($response['status']==='success'){
            $conex->commit();
            $respuesta = array("success" => true, "message" => "Plataforma desactivada");
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