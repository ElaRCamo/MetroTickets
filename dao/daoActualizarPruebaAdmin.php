<?php

include_once('connection.php');
require_once('funcionesRequest.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['id_prueba'], $_POST['estatusPruebaAdmin'], $_POST['prioridadPruebaAdmin'], $_POST['metrologoAdmin'], $_POST['observacionesAdmin'])) {
        $id_prueba = $_POST['id_prueba'];
        $id_estatus = $_POST['estatusPruebaAdmin'];
        $id_prioridad = $_POST['prioridadPruebaAdmin'];
        $id_metrologo = $_POST['metrologoAdmin'];
        $observaciones = $_POST['observacionesAdmin'];
        $id_admin = $_POST['id_user'];
        $tipoPrueba = $_POST['tipoPrueba'];

        //Se agrega fecha compromiso:
        $fechaCompromisoBD = consultarFechaCompromiso($id_prueba); //fecha guardada en la BD

        if ($fechaCompromisoBD === '0000-00-00') {//Si no hay fecha asignada, se actualiza
            $fechaCompromiso = $_POST['fechaCompromiso'] ?? '0000-00-00';
        } else {
            $fechaCompromiso = $fechaCompromisoBD;//Se queda igual
        }

        $reportesProcesados = procesarReportes($id_prueba, $_FILES, $_POST);
        if(todosContienenURL($reportesProcesados)){ //Si ya se tiene todos los reportes, se asegura el estatus de la prueba a "Completado"
            $id_estatus = 4;
        }

        if($tipoPrueba === '5'){ //Prueba Munsell
            if(isset($_POST['nominas'])){
                $nominas = array_map('trim', explode(',', $_POST['nominas']));
            }else{
                $nominas = "No aplica";
            }
            $response = actualizarPruebaMunsell($id_prueba,$id_estatus,$id_prioridad, $id_metrologo, $observaciones,$fechaCompromiso,$id_admin,$tipoPrueba, $nominas, $reportesProcesados);
        }else{
            if(isset($_POST['estatuss'], $_POST['piezas'])){
                $numsParte = array_map('trim', explode(',', $_POST['piezas']));
                $estatussPiezas = array_map('trim', explode(',', $_POST['estatuss']));
            }else{
                $numsParte = "No aplica";
                $estatussPiezas = "No aplica";
            }
            $response = actualizarPrueba($id_prueba,$id_estatus,$id_prioridad, $id_metrologo, $observaciones,$fechaCompromiso,$id_admin,$tipoPrueba,$numsParte,$estatussPiezas,$reportesProcesados);
        }
    }else{
        $response = array("status" => 'error', "message" => "Faltan datos en el formulario.");
    }
} else {
    $response = array("status" => 'error', "message" => "Se esperaba REQUEST_METHOD");
}
echo json_encode($response);


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

// Función para procesar reportes
function procesarReportes($id_prueba,$files, $postData) {
    $reportesProcesados = [];

    // Procesar archivos
    if (isset($files['reportes'])) {
        foreach ($files['reportes']['name'] as $index => $name) {
            // Verifica si el archivo se cargó correctamente
            if ($files['reportes']['error'][$index] == UPLOAD_ERR_OK) {
                $target_dir = "https://grammermx.com/Metrologia/MetroTickets/files/results/";
                $reporteProcesado = subirArchivo($target_dir, $id_prueba, $files['reportes'], $index);

                // Guarda el nombre del archivo en el array con el índice correspondiente
                $reportesProcesados[$index] = $reporteProcesado;
            }
        }
    }

    // Procesar cadenas
    if (isset($postData['reportes'])) {
        foreach ($postData['reportes'] as $index => $value) {
            // Verifica si el valor es una cadena y si no está vacío
            if (is_string($value) && !empty($value)) {
                if (!isset($reportesProcesados[$index])) {
                    $reportesProcesados[$index] = htmlspecialchars($value);
                }
            }
        }
    }

    // Imprimir resultados
    /*
    for ($i = 0; $i < count($reportesProcesados); $i++) {
        if (isset($reportesProcesados[$i])) {
            echo "Índice $i: " . $reportesProcesados[$i] . "<br>";
        } else {
            // Agrega "Sin resultados" si no hay ningún archivo o cadena para ese índice
            echo "Índice $i: Sin resultados<br>";
        }
    }*/

    return $reportesProcesados;
}
function subirArchivo($target_dir, $id_prueba, $fileArray, $index) {

    // Verificar si el archivo fue subido sin errores
    if ($fileArray["error"][$index] > 0) {
        $archivo = array("error" => "Error: " . $fileArray["error"][$index]);
    } else {
        // Quitar espacios del nombre del archivo
        $nombreArchivo = $fileArray["name"][$index];
        $archivoFileName = $id_prueba . "-" . str_replace([' ', ',', '$', '%', '&', '/', '?'], '-', $nombreArchivo);
        $archivoFile = $target_dir . $archivoFileName;
        $moverNormaFile = "../files/results/" . $archivoFileName;

        // Mover el archivo cargado a la ubicación deseada
        if (move_uploaded_file($fileArray["tmp_name"][$index], $moverNormaFile)) {
            $archivo = $archivoFile;
        } else {
            $archivo = array("error" => "Hubo un error al mover el archivo.");
        }
    }
    return $archivo;
}


function actualizarPrueba($id_prueba, $id_estatus, $id_prioridad, $id_metrologo, $observaciones, $fechaCompromiso, $id_admin, $tipoPrueba, $numsParte, $estatussPiezas, $reportes) {
    $con = new LocalConector();
    $conex = $con->conectar();

    // Iniciar transacción
    $conex->begin_transaction();

    // Actualizar TablaPruebas
    $response = actualizarPruebas($conex, $id_prueba, $id_estatus, $id_prioridad, $id_metrologo, $observaciones, $fechaCompromiso);
    $stringNumParte = "";
    $stringEstatus = "";
    $stringReportes = "";

    if ($response["status"] === "success") {
        // Verifica que los arrays tengan la misma longitud
        if (count($numsParte) === count($estatussPiezas)) {
            for ($i = 0; $i < count($estatussPiezas); $i++) {
                $numParte = $numsParte[$i];
                $estatusPieza = $estatussPiezas[$i];
                $reporte = $reportes[$i];

                // Concatenar valores a las variables string
                $stringNumParte .= $numParte . ', ';
                $stringEstatus .= $estatusPieza . ', ';
                $stringReportes .= $reporte . ', ';
            }

            // Eliminar la última coma y espacio de las cadenas concatenadas
            $stringNumParte = rtrim($stringNumParte, ', ');
            $stringEstatus = rtrim($stringEstatus, ', ');
            $stringReportes = rtrim($stringReportes, ', ');

            $response = ActualizarPiezas($conex, $numsParte, $estatussPiezas, $reportes, $id_prueba);

        } else {
            $response = array("status" => "error", "message" => "Los arrays numsParte y estatusPiezas no tienen la misma longitud.");
        }
    }

    // Descripción de la bitácora
    $descripcion = "Admin actualiza la solicitud. Valores: "
        . "id_estatus = " . $id_estatus . ", "
        . "id_prioridad = " . $id_prioridad . ", "
        . "id_metrologo = " . $id_metrologo . ", "
        . "observaciones = " . $observaciones . ", "
        . "PiezasNumParte = " . $stringNumParte . ", "
        . "PiezasEstatus = " . $stringEstatus . ", "
        . "Reportes = " . $stringReportes . ", "
        . "fechaCompromiso = " . $fechaCompromiso;

    if ($response["status"] === "success") {
        $responseBitacora = registrarCambioBitacoora($conex, $id_prueba, $descripcion, $id_admin);
        if ($responseBitacora["status"] === "success") {
            $conex->commit();
            $response = array("status" => "success", "message" => "Prueba actualizada");
        } else {
            $conex->rollback();
            $response = $responseBitacora;
        }
    }

    $conex->close();
    return $response;
}

function todosContienenURL($reportes) {
    // Expresión regular para validar URLs
    $urlPattern = '/\bhttps?:\/\/\S+/i';

    // Iterar sobre cada elemento de $reportes
    foreach ($reportes as $reporte) {
        // Si algún elemento no contiene una URL válida, retornar false
        if (!preg_match($urlPattern, $reporte)) {
            return false;
        }
    }

    // Si todos los elementos contienen una URL válida, retornar true
    return true;
}

function ActualizarPiezas($conexUpdate, $numsParte, $estatussPiezas, $reportes, $id_prueba)
{
    $fecha = date('Y-m-d H:i:s');

    // Consultando las piezas ya registradas
    $selectQuery = $conexUpdate->prepare("SELECT numParte, id_estatus, reportePieza FROM Piezas WHERE id_prueba = ?");
    $selectQuery->bind_param("s", $id_prueba);
    $selectQuery->execute();
    $result = $selectQuery->get_result();

    $existingPiezas = [];
    while ($row = $result->fetch_assoc()) {
        $existingPiezas[$row['numParte']] = [
            'id_estatus' => $row['id_estatus'],
            'reporte' => $row['reportePieza']
        ];
    }

    // Preparar los nuevos datos proporcionados por el usuario
    $newPiezas = [];
    for ($i = 0; $i < count($numsParte); $i++) {
        $numParte = $numsParte[$i];
        $estatusPieza = $estatussPiezas[$i];
        $reporte = $reportes[$i];

        $newPiezas[$numParte] = [
            'estatusPieza' => $estatusPieza,
            'reportePieza' => $reporte,
        ];
    }

    $rUpdateQuery = true;

    foreach ($newPiezas as $numParte => $pieza) {
        $estatusPieza = $pieza['estatusPieza'];
        $reporte = $pieza['reportePieza'];

        if (isset($existingPiezas[$numParte])) {
            $existingPieza = $existingPiezas[$numParte];

            //echo "\n"."existente reporte: ".$existingPieza['reporte']."\n";
            //echo "existente estatus: ".$existingPieza['id_estatus']."\n";
            //echo "nuevo reporte: ".$pieza['reportePieza']."\n";
            //echo "nuevo estatus: ".$pieza['estatusPieza']."\n";

            if ($pieza['reportePieza'] !== "Sin resultados") { // Se carga un nuevo reporte (se actualiza si ya se tiene uno)
                if ($estatusPieza !== 6 && $estatusPieza !== 5) {
                    $estatusPieza = 5;
                }
                $updateQuery = $conexUpdate->prepare("UPDATE Piezas
                                                         SET id_estatus = ?, reportePieza = ?, fechaReporte = ?
                                                       WHERE id_prueba = ? AND numParte = ?");
                $updateQuery->bind_param("issss", $estatusPieza, $reporte, $fecha, $id_prueba, $numParte);
                $rUpdateQuery = $rUpdateQuery && $updateQuery->execute();
                //echo ("query 1");
            } else {//en las demas opciones no se adjunta reporte

                //Opcion 1
                //se pone estatus 2 o 5 pero no se adjunta reporte
                //$pieza['estatusPieza'] debe ser 2 o 5
                //$existingPieza['reporte'] debe ser igual a "Sin resultados" y $existingPieza['reporte'] debe ser diferente de "Sin resultados"
                //el estatus se actualiza a 3
                if (($pieza['estatusPieza'] == 2 || $pieza['estatusPieza'] == 5) &&
                    $existingPieza['reporte'] === "Sin resultados") {

                    $estatusPieza = 3; // Actualiza el estatus a 3
                    $updateQuery = $conexUpdate->prepare("UPDATE Piezas
                                                             SET id_estatus = ?
                                                           WHERE id_prueba = ? AND numParte = ?");
                    $updateQuery->bind_param("sss", $estatusPieza, $id_prueba, $numParte);
                    $rUpdateQuery = $rUpdateQuery && $updateQuery->execute();
                    //echo ("query 2");

                    //Opcion 2
                    //Ya tiene un estatus de completado/pendiente por recoger y no se adjunta nuevo reporte: Se queda el mismo reporte
                    //no se actualiza el reporte, solo el estatus
                    // se debe cumplir que $existingPieza['id_estatus'] sea 2 o sea 5 y que $existingPieza['reporte'] sea diferente de "Sin resultados"
                    // ademas el $pieza['estatusPieza'] debe ser 2 o debe ser 5
                } elseif (($existingPieza['id_estatus'] == 2 || $existingPieza['id_estatus'] == 5) &&
                    $existingPieza['reporte'] !== "Sin resultados" &&
                    ($pieza['estatusPieza'] == 2 || $pieza['estatusPieza'] == 5)) {

                    $updateQuery = $conexUpdate->prepare("UPDATE Piezas
                                                             SET id_estatus = ?
                                                           WHERE id_prueba = ? AND numParte = ?");
                    $updateQuery->bind_param("sss", $estatusPieza, $id_prueba, $numParte);
                    $rUpdateQuery = $rUpdateQuery && $updateQuery->execute();
                    //echo ("query 3");

                    //Opcion 3
                    //se cambia un estatus diferente a 2/5 (se quiere borrar el reporte existente)
                    //se actualiza estatus, reporte y fecha
                    //se debe cumplir que $pieza['estatusPieza'] NO debe ser 2 ni 5
                } elseif ($pieza['estatusPieza'] != 2 && $pieza['estatusPieza'] != 5) {

                    $updateQuery = $conexUpdate->prepare("UPDATE Piezas
                                                             SET id_estatus = ?, reportePieza = 'Sin resultados', fechaReporte = ?
                                                           WHERE id_prueba = ? AND numParte = ?");
                    $updateQuery->bind_param("ssss", $estatusPieza, $fecha, $id_prueba, $numParte);
                    $rUpdateQuery = $rUpdateQuery && $updateQuery->execute();
                    //echo ("query 4");
                }
            }
        }
    }

    if (!$rUpdateQuery) {
        $response = array('status' => 'error', 'message' => 'Error al actualizar las piezas');
    } else {
        $response = array('status' => 'success', 'message' => 'Datos guardados correctamente');
    }

    return $response;
}


function actualizarPruebaMunsell($id_prueba, $id_estatus, $id_prioridad, $id_metrologo, $observaciones, $fechaCompromiso, $id_admin, $tipoPrueba, $nominas, $reportes) {

    $con = new LocalConector();
    $conex = $con->conectar();

    // Iniciar transacción
    $conex->begin_transaction();

    // Actualizar TablaPruebas
    $response = actualizarPruebas($conex, $id_prueba, $id_estatus, $id_prioridad, $id_metrologo, $observaciones, $fechaCompromiso);
    $stringNominas = "";
    $stringReportes = "";
    $rGuardarReportes = true;
    $fecha =  date('Y-m-d H:i:s');

    if ($response["status"] === "success") {
        //echo json_encode($response);
        // Verifica que los arrays tengan la misma longitud
        if (count($nominas) === count($reportes)) {
            for ($i = 0; $i < count($nominas); $i++) {
                $nomina = $nominas[$i];
                $reporte = $reportes[$i];

                // Concatenar valores a las variables string
                $stringNominas .= $nomina . ', ';
                $stringReportes .= $reporte . ', ';

                // Imprimir cada par de valores
                //echo "nomina: $nomina,  reporte: $reporte\n";

                // Preparar y ejecutar la consulta
                $updateMaterial = $conex->prepare("UPDATE PersonalMunsell
                                                           SET reportePersonal = ?, fechaReporte = ?
                                                           WHERE id_prueba = ? AND nomina = ?");
                $updateMaterial->bind_param("ssss", $reporte, $fecha, $id_prueba, $nomina);
                $rGuardarReportes = $rGuardarReportes && $updateMaterial->execute();
            }

            // Eliminar la última coma y espacio de las cadenas concatenadas
            $stringNominas = rtrim($stringNominas, ', ');
            $stringReportes = rtrim($stringReportes, ', ');
        } else {
            echo "Los arrays numsParte y estatusPiezas no tienen la misma longitud.";
        }
    }

    // Descripción de la bitácora
    $descripcion = "Admin actualiza la solicitud. Valores: "
        . "id_estatus      = " . $id_estatus . ", "
        . "id_prioridad    = " . $id_prioridad . ", "
        . "id_metrologo    = " . $id_metrologo . ", "
        . "observaciones   = " . $observaciones . ", "
        . "PersonalNominas = " . $stringNominas . ", "
        . "Reportes        = " . $stringReportes . ", "
        . "fechaCompromiso = " . $fechaCompromiso;

    $responseBitacora = registrarCambioBitacoora($conex, $id_prueba, $descripcion, $id_admin);

    if ($responseBitacora["status"] === "success" && $rGuardarReportes === true) {
        $conex->commit();
        $response = array("status" => "success", "message" => "Prueba actualizada");
    } else {
        $conex->rollback();
        $response = array("status" => 'error', "message" => "Error.");
        if ($responseBitacora["status"] !== "success") {
            $response = $responseBitacora;
        }
    }

    $conex->close();
    return $response;
}


function actualizarPruebas($conexPruebas, $id_prueba, $id_estatus, $id_prioridad, $id_metrologo, $observaciones, $fechaCompromiso)
{
    echo ("estatus prueba: ".$id_estatus."-");
    $fechaHoy = date("Y-m-d");
    echo $fechaHoy."-";

    $rUpdateQuery = true;
    if ($id_estatus === '4'){//estatus completado
        echo "query 2";
        $updateQuery = $conexPruebas->prepare("UPDATE Pruebas
                                           SET id_estatusPrueba = ?, id_prioridad = ?, id_metrologo = ?, especificacionesLab = ?, fechaRespuesta = ?
                                         WHERE id_prueba = ?");
        $updateQuery->bind_param("iissss", $id_estatus, $id_prioridad, $id_metrologo, $observaciones, $fechaHoy, $id_prueba);

    }else if ($fechaCompromiso !== '0000-00-00' && $id_estatus === '2') { // Estatus aprobado y sin fechaCompromiso registrada
        echo "query 1";
        $updateQuery = $conexPruebas->prepare("UPDATE Pruebas
                                           SET id_estatusPrueba = ?, id_prioridad = ?, id_metrologo = ?, especificacionesLab = ?, fechaCompromiso = ?
                                         WHERE id_prueba = ?");
        $updateQuery->bind_param("iissss", $id_estatus, $id_prioridad, $id_metrologo, $observaciones, $fechaCompromiso, $id_prueba);

    } else {
        echo "query 3";
        $updateQuery = $conexPruebas->prepare("UPDATE Pruebas
                                           SET id_estatusPrueba = ?, id_prioridad = ?, id_metrologo = ?, especificacionesLab = ?
                                         WHERE id_prueba = ?");
        $updateQuery->bind_param("iisss", $id_estatus, $id_prioridad, $id_metrologo, $observaciones, $id_prueba);
    }

    $rUpdateQuery = $rUpdateQuery && $updateQuery->execute();

    if ($rUpdateQuery) {
        $response = array('status' => 'success', 'message' => 'Datos guardados correctamente');
    } else {
        $response = array('status' => 'error', 'message' => 'Error al actualizar tabla Pruebas');
    }

    return $response;
}
?>