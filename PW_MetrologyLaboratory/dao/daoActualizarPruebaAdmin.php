<?php

include_once('connection.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_GET['id_prueba'], $_POST['estatusPruebaAdmin'], $_POST['prioridadPruebaAdmin'], $_POST['metrologoAdmin'], $_POST['observacionesAdmin'], $_POST['resultadosAdmin'])){
        $id_prueba = $_GET['id_prueba'];
        $id_estatus = $_POST['estatusPruebaAdmin'];
        $id_prioridad = $_POST['prioridadPruebaAdmin'];
        $id_metrologo = $_POST['metrologoAdmin'];
        $id_observaciones = $_POST['observacionesAdmin'];
        $id_resultados = $_POST['resultadosAdmin'];
        $fechaUpdate = $_POST['fechaUpdate'];

        actualizarPrueba($id_prueba,$id_estatus,$id_prioridad, $id_metrologo, $id_observaciones, $id_resultados, $fechaUpdate);
    }else{
        $respuesta = array("success" => false, "message" => "Faltan datos en el formulario.");
        echo json_encode($respuesta);
    }
} else {
    $respuesta = array("success" => false, "message" => "Se esperaba REQUEST_METHOD");
    echo json_encode($respuesta);
}

function actualizarPrueba($id_prueba,$id_estatus,$id_prioridad, $id_metrologo, $id_observaciones, $id_resultados, $fechaUpdate) {
    $con = new LocalConector();
    $conex = $con->conectar();

    $stmt = $conex->prepare("UPDATE Prueba
                                      SET id_estatusPrueba = ?, id_prioridad = ?, id_metrologo = ?, especificacionesLab = ?, rutaResultados = ?, fechaActualizacion = ?
                                    WHERE id_prueba = ?");
    $stmt->bind_param("iisssi", $id_estatus, $id_prioridad, $id_metrologo, $id_observaciones,$id_resultados, $fechaUpdate, $id_prueba);

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