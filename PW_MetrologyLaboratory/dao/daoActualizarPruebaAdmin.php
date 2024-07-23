<?php

include_once('connection.php');
require_once('funcionesRequest.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_GET['id_prueba'], $_POST['estatusPruebaAdmin'], $_POST['prioridadPruebaAdmin'], $_POST['metrologoAdmin'], $_POST['observacionesAdmin'])){
        $id_prueba = $_GET['id_prueba'];
        $id_estatus = $_POST['estatusPruebaAdmin'];
        $id_prioridad = $_POST['prioridadPruebaAdmin'];
        $id_metrologo = $_POST['metrologoAdmin'];
        $observaciones = $_POST['observacionesAdmin'];
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
        $fechaResultados = '0000-00-00';
        // 'resultadosAdmin' está en $_POST
        if (isset($_POST['resultadosAdmin'])) {
            $resultados = $_POST['resultadosAdmin'];
            $fechaResultados = date('Y-m-d:H:i:s');
        }
        //'resultadosAdmin' está en $_FILES
        elseif (isset($_FILES['resultadosAdmin'])) {
            $target_dir = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/files/results/";
            $input_name = "resultadosAdmin";
            // Si es un archivo, obtenemos el nombre del archivo
            $resultados = subirArchivo($target_dir, $id_prueba, $input_name);
            $fechaResultados = date('Y-m-d:H:i:s');
        }

        $tipoPrueba = $_POST['tipoPrueba'];

        if(isset($_POST['estatuss'], $_POST['piezas']) && $tipoPrueba){
            $numsParte = array_map('trim', explode(',', $_POST['piezas']));
            $estatusPiezas = array_map('trim', explode(',', $_POST['estatuss']));
        }else{
            $numsParte = "No aplica";
            $estatusPiezas = "No aplica";
        }

        $response = actualizarPrueba($id_prueba,$id_estatus,$id_prioridad, $id_metrologo, $observaciones, $resultados,$fechaCompromiso,$id_admin,$fechaResultados,$tipoPrueba,$numsParte,$estatusPiezas);

    }else{
        $response = array("status" => 'error', "message" => "Faltan datos en el formulario.");
    }
} else {
    $response = array("status" => 'error', "message" => "Se esperaba REQUEST_METHOD");
}
echo json_encode($response);

function actualizarPrueba($id_prueba,$id_estatus,$id_prioridad, $id_metrologo, $observaciones, $resultados,$fechaCompromiso,$id_admin,$fechaResultados,$tipoPrueba,$numsParte,$estatusPiezas) {
    $con = new LocalConector();
    $conex = $con->conectar();

    // Iniciar transacción
    $conex->begin_transaction();

    if($resultados !== "" && $id_estatus === '4') { //Estatus completado
        $stmt = $conex->prepare("UPDATE Pruebas
                                      SET id_estatusPrueba = ?, id_prioridad = ?, id_metrologo = ?, especificacionesLab = ?, resultados = ?, fechaRespuesta = ?
                                    WHERE id_prueba = ?");
        $stmt->bind_param("iisssss", $id_estatus, $id_prioridad, $id_metrologo, $observaciones,$resultados,  $fechaResultados, $id_prueba);
        $query=1;
    }else if($fechaCompromiso !== '0000-00-00' && $id_estatus === '2'){ //Estatus aprobado
        $stmt = $conex->prepare("UPDATE Pruebas
                                      SET id_estatusPrueba = ?, id_prioridad = ?, id_metrologo = ?, especificacionesLab = ?, resultados = ?, fechaCompromiso = ?
                                    WHERE id_prueba = ?");
        $stmt->bind_param("iisssss", $id_estatus, $id_prioridad, $id_metrologo, $observaciones,$resultados, $fechaCompromiso,  $id_prueba);
        $query=2;
    }else{
        $stmt = $conex->prepare("UPDATE Pruebas
                                      SET id_estatusPrueba = ?, id_prioridad = ?, id_metrologo = ?, especificacionesLab = ?, resultados = ?
                                    WHERE id_prueba = ?");
        $stmt->bind_param("iissss", $id_estatus, $id_prioridad, $id_metrologo, $observaciones,$resultados, $id_prueba);
        $query=3;
    }

    $stringNumParte = '';
    $stringEstatus = '';
    $rGuardarPiezas = true;

    if($tipoPrueba !== '5'){
        // Verifica que los arrays tengan la misma longitud
        if (count($numsParte) === count($estatusPiezas)) {
            for ($i = 0; $i < count($estatusPiezas); $i++) {
                $numParte = $numsParte[$i];
                $estatusPieza = $estatusPiezas[$i];

                // Concatenar valores a las variables string
                $stringNumParte .= $numParte . ', ';
                $stringEstatus .= $estatusPieza . ', ';

                // Imprimir cada par de valores
                echo "numParte: $numParte, estatusPieza: $estatusPieza\n";

                // Preparar y ejecutar la consulta
                $updateMaterial = $conex->prepare("UPDATE Piezas
                                               SET id_estatus = ?
                                               WHERE numParte = ? AND id_prueba = ?");
                $updateMaterial->bind_param("iss", $estatusPieza, $numParte, $id_prueba);
                $rGuardarPiezas = $rGuardarPiezas && $updateMaterial->execute();
            }

            // Eliminar la última coma y espacio de las cadenas concatenadas
            $stringNumParte = rtrim($stringNumParte, ', ');
            $stringEstatus = rtrim($stringEstatus, ', ');

        } else {
            echo "Los arrays numsParte y estatusPiezas no tienen la misma longitud.";
        }
    }
    //$response = array("status" => 'error', "message" => "fechaCompromiso: ".$fechaCompromiso." id_estatus ".$id_estatus." query=".$query);

    $descripcion = "Admin actualiza la solicitud. Valores: "
        . "id_estatus = " . $id_estatus . ", "
        . "id_prioridad = " . $id_prioridad . ", "
        . "id_metrologo = " . $id_metrologo . ", "
        . "observaciones = " . $observaciones . ", "
        . "resultados = " . $resultados . ", "
        . "PiezasNumParte = " . $stringNumParte . ", "
        . "PiezasEstatus = " . $stringEstatus . ", "
        . "fechaCompromiso = " . $fechaCompromiso . ", "
        . "fechaResultados = " . $fechaResultados;

    $responseBitacora = registrarCambioBitacoora($conex,$id_prueba,$descripcion,$id_admin);

    if ($stmt->execute() && $responseBitacora["status"] === "success" && $rGuardarPiezas === true) {
        $conex->commit();
        $response = array("status" => "success", "message" => "Prueba actualizada");
    } else {
        $conex->rollback();
        $response = array("status" => 'error', "message" => "Error.");
        if($responseBitacora["status"] !== "success"){
            $response = $responseBitacora;
        }
    }
    $stmt->close();
    $conex->close();
    return $response;
}

function consultarFechaCompromiso($id_prueba) {
    $con = new LocalConector();
    $conex = $con->conectar();

    $query = "SELECT fechaCompromiso FROM Pruebas WHERE id_prueba = '$id_prueba';";
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