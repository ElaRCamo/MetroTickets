<?php
include_once('connection.php');
require_once('functionsAdmin.php');
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_GET['id_cliente'])){
        // Obtiene el valor del parámetro id_cliente
        $id_cliente = $_GET['id_cliente'];
        $respuesta = desactivarCliente($id_cliente);
    }else{
        $respuesta = array("success" => false, "message" => "ID de cliente no proporcionado.");
    }
} else {
    $respuesta = array("success" => false, "message" => "Se esperaba REQUEST_METHOD");
}
echo json_encode($respuesta);
function desactivarCliente($id_cliente)
{
    $con = new LocalConector();
    $conex = $con->conectar();

    // Iniciar transacción
    $conex->begin_transaction();

    $stmt1 = $conex->prepare("UPDATE Cliente SET estatus = 0 WHERE id_cliente = ?");
    $stmt1->bind_param("i", $id_cliente);

    $stmt2 = $conex->prepare("UPDATE Plataforma P
                                    SET P.estatus = 0
                                    WHERE P.id_cliente = ?");
    $stmt2->bind_param("i", $id_cliente);

    $success = $stmt1->execute() && $stmt2->execute();

    if ($success) {
        //Registrar cambios en bitacora
        $descripcion = "Cliente desactivado: ".$id_cliente. " con sus respectivas plataformas.";
        $response =  registrarCambioAdmin($conex, $descripcion,$_SESSION['nomina']);

        if($response['status']==='success'){
            // Commit si todas las consultas se ejecutaron correctamente
            $conex->commit();
            $respuesta = array("success" => true, "message" => "Cliente y plataformas activados");
        }else{
            $conex->rollback();
            $respuesta = $response;
        }
    } else {
        // Rollback en caso de error
        $conex->rollback();
        $respuesta = array("success" => false, "message" => "Error.");
    }
    $stmt1->close();
    $stmt2->close();
    $conex->close();

    return $respuesta;
}
?>