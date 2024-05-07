<?php

include_once('connection.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_GET['id_prueba'], $_POST['estatusPruebaAdmin'], $_POST['prioridadPruebaAdmin'], $_POST['metrologoAdmin'], $_POST['observacionesAdmin'], $_POST['resultadosAdmin'])){
        $id_prueba = $_GET['id_prueba'];
        $id_estatus = $_POST['estatusPruebaAdmin'];
        $id_prioridad = $_POST['prioridadPruebaAdmin'];
        $id_metrologo = $_POST['metrologoAdmin'];
        $observaciones = $_POST['observacionesAdmin'];
        $resultados = $_POST['resultadosAdmin'];
        $fechaUpdate = $_POST['fechaUpdate'];
        $id_admin = $_POST['id_user'];

        actualizarPrueba($id_prueba,$id_estatus,$id_prioridad, $id_metrologo, $observaciones, $resultados, $fechaUpdate, $id_admin);
    }else{
        $respuesta = array("success" => false, "message" => "Faltan datos en el formulario.");
        echo json_encode($respuesta);
    }
} else {
    $respuesta = array("success" => false, "message" => "Se esperaba REQUEST_METHOD");
    echo json_encode($respuesta);
}

function actualizarPrueba($id_prueba,$id_estatus,$id_prioridad, $id_metrologo, $observaciones, $resultados, $fechaUpdate, $id_admin) {
    $con = new LocalConector();
    $conex = $con->conectar();

    if($resultados !== "") {
        $stmt = $conex->prepare("UPDATE Prueba
                                      SET id_estatusPrueba = ?, id_prioridad = ?, id_metrologo = ?, especificacionesLab = ?, rutaResultados = ?, fechaActualizacion = ?, fechaRespuesta = ?, id_administrador = ?
                                    WHERE id_prueba = ?");
        $stmt->bind_param("iisssssss", $id_estatus, $id_prioridad, $id_metrologo, $observaciones,$resultados, $fechaUpdate, $fechaUpdate, $id_admin, $id_prueba);
    }else{
        $stmt = $conex->prepare("UPDATE Prueba
                                      SET id_estatusPrueba = ?, id_prioridad = ?, id_metrologo = ?, especificacionesLab = ?, rutaResultados = ?, fechaActualizacion = ?, id_administrador = ?
                                    WHERE id_prueba = ?");

        $stmt->bind_param("iissssss", $id_estatus, $id_prioridad, $id_metrologo, $observaciones,$resultados, $fechaUpdate, $id_admin, $id_prueba);
    }

    if ($stmt->execute()) {
        $respuesta = array("success" => true, "message" => "Prueba actualizada");
        echo json_encode($respuesta);
    } else {
        $respuesta = array("success" => false, "message" => "Error.");
        echo json_encode($respuesta);
    }
    $stmt->close();
    $conex->close();

}

?>