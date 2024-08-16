<?php
include_once('connection.php');
include_once ('funcionesRequest.php');
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['id_prueba'], $_POST['id_tipoPrueba'])){

        $id_prueba = $_POST['id_prueba'];
        $id_tipoPrueba = $_POST['id_tipoPrueba'];

        $respuesta = finalizarSolicitud($id_prueba, $id_tipoPrueba);

    }else{
        $respuesta = array("status" => "error", "message" => "Faltan datos en el formulario.");
    }
} else {
    $respuesta = array("status" => "error", "message" => "Se esperaba REQUEST_METHOD");
}
echo json_encode($respuesta);

function finalizarSolicitud($id_prueba, $id_tipoPrueba)
{
    $con = new LocalConector();
    $conex = $con->conectar();

    // Iniciar transacción
    $conex->begin_transaction();

    $stmt = $conex->prepare("UPDATE Pruebas
                                      SET id_estatusPrueba = 9
                                    WHERE id_prueba = ?");
    $stmt->bind_param("s", $id_prueba);

    $updatePrueba = $stmt->execute();

    if($updatePrueba && $id_tipoPrueba !== '5'){
        $updatePiezas = $conex->prepare("UPDATE Piezas
                                                  SET id_estatus = 2
                                                WHERE id_prueba = ?");
        $updatePiezas->bind_param("s", $id_prueba);

        if($updatePiezas ->execute()){
            $descripcion = "Se finaliza la prueba y se actualiza el estatus de piezas.";
            $response = registrarCambioBitacoora($conex, $id_prueba, $descripcion, $_SESSION["nomina"]);
        }else{
            $response = array("status" => "error", "message" => "Error al actualizar piezas.");
        }
    }elseif($updatePrueba && $id_tipoPrueba === '5'){
        $descripcion = "Se finaliza la prueba.";
        $response = registrarCambioBitacoora($conex, $id_prueba, $descripcion, $_SESSION["nomina"]);
    }else {
        $response = array("status" => "error", "message" => "Error al actualizar los datos.");
    }

    if($response['status']==='success'){
        $conex->commit();
        $respuesta = array("status" => "success", "message" => "Prueba finalizada exitosamente.");
    }else{
        $conex->rollback();
        $respuesta = $response;
    }
    $stmt->close();
    $conex->close();
    return $respuesta;
}