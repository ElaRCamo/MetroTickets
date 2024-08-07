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
            //$response = actualizarPruebaMunsell($id_prueba,$id_estatus,$id_prioridad, $id_metrologo, $observaciones,$fechaCompromiso,$id_admin,$tipoPrueba, $nominas, $reportesProcesados);
            $response = array("status" => 'sucess', "message" => "Se ejecuta funcion actualizarPruebaMunsell");
        }else{
            if(isset($_POST['estatuss'], $_POST['piezas'])){
                $numsParte = array_map('trim', explode(',', $_POST['piezas']));
                $estatusPiezas = array_map('trim', explode(',', $_POST['estatuss']));
            }else{
                $numsParte = "No aplica";
                $estatusPiezas = "No aplica";
            }
            //$response = actualizarPrueba($id_prueba,$id_estatus,$id_prioridad, $id_metrologo, $observaciones,$fechaCompromiso,$id_admin,$tipoPrueba,$numsParte,$estatusPiezas,$reportesProcesados);
            $response = array("status" => 'sucess', "message" => "Se ejecuta funcion actualizarPrueba");
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
?>