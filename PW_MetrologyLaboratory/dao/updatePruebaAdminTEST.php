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

        // Obtener los reportes(resultado de cada prueba) como una cadena separada por comas
        $reportes = $_POST['reportes'] ?? '';
        $reportesArray = explode(',', $reportes);// Convertir la cadena en un array

        $reportesProcesados = [];
        foreach ($reportesArray as $reporte) {
            echo "Reporte: " . htmlspecialchars($reporte) . "<br>";

            if (esArchivo($reporte)) { // solo se acepta pdf
                $target_dir = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/files/results/";

                if (isset($_FILES[$reporte])) {// Verificar que el archivo está en $_FILES
                    $reporteProcesado = subirArchivo($target_dir, $id_prueba, $reporte); // Si es un archivo, obtenemos el nombre del archivo
                } else {
                    $reporteProcesado = array("error" => "Archivo no encontrado.");
                }
            } else { // Si es un string, se queda igual
                $reporteProcesado = $reporte;
            }
            $reportesProcesados[] = $reporteProcesado;
        }

        if($tipoPrueba === 5){ //Prueba Munsell
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

    if ($response["status"] === "success") {
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
                echo "numParte: $numParte, estatusPieza: $estatusPieza, reporte: $reporte\n";

                // Preparar y ejecutar la consulta
                $updateMaterial = $conex->prepare("UPDATE Piezas
                                                   SET id_estatus = ?, reportePieza = ?, fechaReporte = NOW()
                                                   WHERE numParte = ? AND id_prueba = ?");
                $updateMaterial->bind_param("issi", $estatusPieza, $reporte, $numParte, $id_prueba);
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

    if ($id_prueba === 5) {
        $response = array('status' => 'success', 'message' => 'Datos guardados correctamente');
    } else {
        $response = array('status' => 'error', 'message' => 'Error al actualizar prueba Munsell');
    }
    return $response;
}


function actualizarPruebas($conexPruebas, $id_prueba, $id_estatus, $id_prioridad, $id_metrologo, $observaciones, $fechaCompromiso)
{
    echo "actualizarPruebas<br>";
    echo "ID Prueba: " . $id_prueba . "<br>";
    echo "ID Estatus: " . $id_estatus . "<br>";
    echo "ID Prioridad: " . $id_prioridad . "<br>";
    echo "ID Metrologo: " . $id_metrologo . "<br>";
    echo "Observaciones: " . $observaciones . "<br>";
    echo "Fecha Compromiso: " . $fechaCompromiso . "<br>";


    if ($fechaCompromiso !== '0000-00-00' && $id_estatus === '2') { //Estatus aprobado y sin fecha registrada
        $stmt = $conexPruebas->prepare("UPDATE Pruebas
                                           SET id_estatusPrueba = ?, id_prioridad = ?, id_metrologo = ?, especificacionesLab = ?, fechaCompromiso = ?
                                         WHERE id_prueba = ?");
        $stmt->bind_param("iiissi", $id_estatus, $id_prioridad, $id_metrologo, $observaciones, $fechaCompromiso, $id_prueba);

        echo "Fecha Compromiso: " . "<br>";

    } else {
        $stmt = $conexPruebas->prepare("UPDATE Pruebas
                                           SET id_estatusPrueba = ?, id_prioridad = ?, id_metrologo = ?, especificacionesLab = ?
                                         WHERE id_prueba = ?");
        $stmt->bind_param("iiisi", $id_estatus, $id_prioridad, $id_metrologo, $observaciones, $id_prueba);

        echo "Fecha Compromiso: " . $fechaCompromiso . "<br>";
    }

    if ($stmt->execute()) {
        $response = array('status' => 'success', 'message' => 'Datos guardados correctamente');
    } else {
        $response = array('status' => 'error', 'message' => 'Error al actualizar tabla Pruebas');
    }

    $stmt->close();
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

/*
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
}*/
function subirArchivo($target_dir, $id_prueba, $input_name) {
    $archivo = '';

    // Verificar si el archivo fue subido sin errores
    if ($_FILES[$input_name]["error"] > 0) {
        $archivo = array("error" => "Error: " . $_FILES[$input_name]["error"]);
    } else {
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
    }
    return $archivo;
}

// Función para determinar si el reporte es un archivo
function esArchivo($reporte): bool
{
    return (preg_match('/\.(pdf)$/i', $reporte) === 1);
}






// Verifica si 'reportes' está en $_FILES y $_POST
if (isset($_FILES['reportes']) || isset($_POST['reportes'])) {
    // Verifica si $_FILES['reportes'] está presente
    if (isset($_FILES['reportes']) && is_array($_FILES['reportes']['name'])) {
        foreach ($_FILES['reportes']['name'] as $index => $nombreArchivo) {
            if ($_FILES['reportes']['error'][$index] === UPLOAD_ERR_NO_FILE) {
                // Si no hay archivo, verifica en $_POST
                $reporte = $_POST['reportes'][$index];
                if ($reporte === "Sin resultados") {
                    $reportesProcesados[] = "Sin resultados";
                }
            } else {
                if ($_FILES['reportes']['error'][$index] > 0) {
                    $archivo = array("error" => "Error: " . $_FILES['reportes']['error'][$index]);
                } else {
                    $target_dir = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/files/results/";
                    $archivoFileName = $id_prueba . "-" . str_replace(' ', '-', $nombreArchivo);
                    $archivoFile = $target_dir . $archivoFileName;
                    $moverNormaFile = "../files/results/" . $archivoFileName;

                    if (move_uploaded_file($_FILES['reportes']['tmp_name'][$index], $moverNormaFile)) {
                        $archivo = $archivoFile;
                    } else {
                        $archivo = array("error" => "Hubo un error al mover el archivo.");
                    }
                }
                $reportesProcesados[] = $archivo;
            }
        }
    } elseif (isset($_POST['reportes']) && is_array($_POST['reportes'])) {
        // Maneja los casos donde solo hay cadenas
        foreach ($_POST['reportes'] as $reporte) {
            if ($reporte === "Sin resultados") {
                $reportesProcesados[] = "Sin resultados";
            } else {
                $reportesProcesados[] = $reporte;
            }
        }
    }
}

echo '<pre>';
print_r($reportesProcesados);
echo '</pre>';
?>
