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

        // Procesar reportes usando la función modularizada
        $reportesProcesados = procesarReportes($id_prueba, $_FILES, $_POST);

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
                $estatusPiezas = array_map('trim', explode(',', $_POST['estatuss']));
            }else{
                $numsParte = "No aplica";
                $estatusPiezas = "No aplica";
            }
            $response = actualizarPrueba($id_prueba,$id_estatus,$id_prioridad, $id_metrologo, $observaciones,$fechaCompromiso,$id_admin,$tipoPrueba,$numsParte,$estatusPiezas,$reportesProcesados);
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
                $target_dir = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/files/results/";
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
        $archivoFileName = $id_prueba . "-" . str_replace(' ', '-', $nombreArchivo);
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


function actualizarPrueba($id_prueba, $id_estatus, $id_prioridad, $id_metrologo, $observaciones, $fechaCompromiso, $id_admin, $tipoPrueba, $numsParte, $estatusPiezas, $reportes) {
    $con = new LocalConector();
    $conex = $con->conectar();

    // Iniciar transacción
    $conex->begin_transaction();

    // Actualizar TablaPruebas
    $response = actualizarPruebas($conex, $id_prueba, $id_estatus, $id_prioridad, $id_metrologo, $observaciones, $fechaCompromiso);
    $stringNumParte = "";
    $stringEstatus = "";
    $stringReportes = "";
    $rGuardarPiezas = true;
    $fecha =  date('Y-m-d H:i:s');

    if ($response["status"] === "success") {
        //echo json_encode($response);
        // Verifica que los arrays tengan la misma longitud
        if (count($numsParte) === count($estatusPiezas)) {
            for ($i = 0; $i < count($estatusPiezas); $i++) {
                $numParte = $numsParte[$i];
                $estatusPieza = $estatusPiezas[$i];
                $reporte = $reportes[$i];

                // Concatenar valores a las variables string
                $stringNumParte .= $numParte . ', ';
                $stringEstatus .= $estatusPieza . ', ';
                $stringReportes .= $reporte . ', ';

                // Imprimir cada par de valores
                //echo "numParte: $numParte, estatusPieza: $estatusPieza, reporte: $reporte\n";

                // Preparar y ejecutar la consulta
                $updateMaterial = $conex->prepare("UPDATE Piezas
                                                   SET id_estatus = ?, reportePieza = ?, fechaReporte = ?
                                                   WHERE id_prueba = ? AND numParte = ?");
                $updateMaterial->bind_param("issss", $estatusPieza, $reporte, $fecha, $id_prueba, $numParte);
                $rGuardarPiezas = $rGuardarPiezas && $updateMaterial->execute();
            }

            // Eliminar la última coma y espacio de las cadenas concatenadas
            $stringNumParte = rtrim($stringNumParte, ', ');
            $stringEstatus = rtrim($stringEstatus, ', ');
            $stringReportes = rtrim($stringReportes, ', ');

        } else {
            echo "Los arrays numsParte y estatusPiezas no tienen la misma longitud.";
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

    $responseBitacora = registrarCambioBitacoora($conex, $id_prueba, $descripcion, $id_admin);

    if ($responseBitacora["status"] === "success" && $rGuardarPiezas === true) {
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

function actualizarPruebaMunsell($id_prueba, $id_estatus, $id_prioridad, $id_metrologo, $observaciones, $fechaCompromiso, $id_admin, $tipoPrueba, $nominas, $reportes) {
    echo "Prueba Munsell<br>";
    echo "ID Prueba: " . $id_prueba . "<br>";
    echo "ID Estatus: " . $id_estatus . "<br>";
    echo "ID Prioridad: " . $id_prioridad . "<br>";
    echo "ID Metrologo: " . $id_metrologo . "<br>";
    echo "Observaciones: " . $observaciones . "<br>";
    echo "Fecha Compromiso: " . $fechaCompromiso . "<br>";
    echo "ID Admin: " . $id_admin . "<br>";
    echo "Tipo Prueba: " . $tipoPrueba . "<br>";

    echo "Nominas:<br>";
    foreach ($nominas as $nomina) {
        echo "- " . $nomina . "<br>";
    }

    echo "Reportes:<br>";
    foreach ($reportes as $reporte) {
        echo "- " . $reporte . "<br>";
    }

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
                echo "nomina: $nomina,  reporte: $reporte\n";

                // Preparar y ejecutar la consulta
                $updateMaterial = $conex->prepare("UPDATE PersonalMunsell
                                                   SET reportePieza = ?, fechaReporte = ?
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
        . "id_estatus = " . $id_estatus . ", "
        . "id_prioridad = " . $id_prioridad . ", "
        . "id_metrologo = " . $id_metrologo . ", "
        . "observaciones = " . $observaciones . ", "
        . "PersonalNominas = " . $stringNominas . ", "
        . "Reportes = " . $stringReportes . ", "
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

    $rUpdateQuery = true;
    if ($fechaCompromiso !== '0000-00-00' && $id_estatus === '2') { // Estatus aprobado y sin fecha registrada
        $updateQuery = $conexPruebas->prepare("UPDATE Pruebas
                                           SET id_estatusPrueba = ?, id_prioridad = ?, id_metrologo = ?, especificacionesLab = ?, fechaCompromiso = ?
                                         WHERE id_prueba = ?");
        $updateQuery->bind_param("iissss", $id_estatus, $id_prioridad, $id_metrologo, $observaciones, $fechaCompromiso, $id_prueba);

    } else {
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