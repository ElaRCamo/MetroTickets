<?php

include_once('connection.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_GET['id_prueba'], $_POST['estatusPruebaAdmin'], $_POST['prioridadPruebaAdmin'], $_POST['metrologoAdmin'], $_POST['observacionesAdmin'])){
        $id_prueba = $_GET['id_prueba'];
        $id_estatus = $_POST['estatusPruebaAdmin'];
        $id_prioridad = $_POST['prioridadPruebaAdmin'];
        $id_metrologo = $_POST['metrologoAdmin'];
        $observaciones = $_POST['observacionesAdmin'];
        $fechaUpdate = $_POST['fechaUpdate'];
        $id_admin = $_POST['id_user'];

        //Se agrega fecha compromiso:
        $fechaCompromisoBD = consultarFechaCompromiso($id_prueba); //fecha guardada en la BD

        if($fechaCompromisoBD === '0000-00-00'){
            $fechaCompromiso = $_POST['fechaCompromiso'] ?? '0000-00-00';
        }else{
            $fechaCompromiso = $fechaCompromisoBD;
        }


        // Verificar si resultados es un string o un archivo
        $resultados = '';
        // 'resultadosAdmin' está en $_POST
        if (isset($_POST['resultadosAdmin'])) {
            $resultados = $_POST['resultadosAdmin'];
        }
        //'resultadosAdmin' está en $_FILES
        elseif (isset($_FILES['resultadosAdmin'])) {
            $target_dir = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/files/results/";
            $input_name = "resultadosAdmin";
            // Si es un archivo, obtenemos el nombre del archivo
            $resultados = subirArchivo($target_dir, $id_prueba, $input_name);
        }

        $response = actualizarPrueba($id_prueba,$id_estatus,$id_prioridad, $id_metrologo, $observaciones, $resultados, $fechaUpdate,$fechaCompromiso, $id_admin);
    }else{
        $response = array("status" => 'error', "message" => "Faltan datos en el formulario.");
    }
} else {
    $response = array("status" => 'error', "message" => "Se esperaba REQUEST_METHOD");
}
echo json_encode($response);

function actualizarPrueba($id_prueba,$id_estatus,$id_prioridad, $id_metrologo, $observaciones, $resultados, $fechaUpdate,$fechaCompromiso, $id_admin) {
    $con = new LocalConector();
    $conex = $con->conectar();

    if($resultados !== "" && $id_estatus === '4') { //Estatus completado
        $stmt = $conex->prepare("UPDATE Prueba
                                      SET id_estatusPrueba = ?, id_prioridad = ?, id_metrologo = ?, especificacionesLab = ?, rutaResultados = ?, fechaActualizacion = ?, fechaRespuesta = ?, id_administrador = ?
                                    WHERE id_prueba = ?");
        $stmt->bind_param("iisssssss", $id_estatus, $id_prioridad, $id_metrologo, $observaciones,$resultados, $fechaUpdate, $fechaUpdate, $id_admin, $id_prueba);
        $query=1;
    }else if($fechaCompromiso !== '0000-00-00' && $id_estatus === '2'){ //Estatus aprobado
        $stmt = $conex->prepare("UPDATE Prueba
                                      SET id_estatusPrueba = ?, id_prioridad = ?, id_metrologo = ?, especificacionesLab = ?, rutaResultados = ?, fechaActualizacion = ?, fechaCompromiso = ?,id_administrador = ?
                                    WHERE id_prueba = ?");
        $stmt->bind_param("iisssssss", $id_estatus, $id_prioridad, $id_metrologo, $observaciones,$resultados, $fechaUpdate, $fechaCompromiso, $id_admin, $id_prueba);
        $query=2;
    }else{
        $stmt = $conex->prepare("UPDATE Prueba
                                      SET id_estatusPrueba = ?, id_prioridad = ?, id_metrologo = ?, especificacionesLab = ?, rutaResultados = ?, fechaActualizacion = ?, id_administrador = ?
                                    WHERE id_prueba = ?");
        $stmt->bind_param("iissssss", $id_estatus, $id_prioridad, $id_metrologo, $observaciones,$resultados, $fechaUpdate, $id_admin, $id_prueba);
        $query=3;
    }

    //$response = array("status" => 'error', "message" => "fechaCompromiso: ".$fechaCompromiso." id_estatus ".$id_estatus." query=".$query);

    if ($stmt->execute()) {
        $response = array("status" => "success", "message" => "Prueba actualizada");
    } else {
        $response = array("status" => 'error', "message" => "Error.");
    }
    $stmt->close();
    $conex->close();
    return $response;
}

function consultarFechaCompromiso($id_prueba) {
    $con = new LocalConector();
    $conex = $con->conectar();

    $query = "SELECT fechaCompromiso FROM Prueba WHERE id_prueba = '$id_prueba';";
    $result = mysqli_query($conex, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['fechaCompromiso'];
    } else {
        return null;
    }
}


function subirArchivo($target_dir, $id_prueba, $input_name) {
    $archivo = '';
    // Verificar si el archivo fue subido sin errores
    if ($_FILES[$input_name]["error"] > 0) {
        $archivo = array("error" => "Error: " . $_FILES[$input_name]["error"]);
    }

    // Quitar espacios del nombre del archivo
    $nombreArchivo = $_FILES[$input_name]["name"];
    $archivoFileName = $id_prueba . "-" . str_replace(' ', '-', $nombreArchivo);
    $archivoFile = $target_dir . $archivoFileName;
    $moverNormaFile = "../files/results/" . $archivoFileName;

    // Mover el archivo cargado a la ubicación deseada
    if (move_uploaded_file($_FILES[$input_name]["tmp_name"], $moverNormaFile)) {
        $archivo = $archivoFile;
    } else {
        $archivo = array("error" => "Hubo un error al mover el archivo.");
    }
    return $archivo;
}
?>