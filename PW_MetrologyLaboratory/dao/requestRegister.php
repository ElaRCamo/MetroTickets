<?php
include_once('connection.php');
session_start();
header('Content-Type: application/json');

// Verificar si los datos están presentes y asignarlos de manera segura
if(isset($_POST['tipoPrueba'], $_SESSION['nomina'], $_POST['especificaciones'], $_POST['plataformas'], $_POST['numsParte'],$_POST['cantidades'], $_POST['revDibujos'],$_POST['modMatematicos'],$_POST['fechaSolicitud'], $_POST['id_prueba'])) {
    // Asignar variables
    $tipoPrueba     = $_POST['tipoPrueba'];
    $id_prueba      = $_POST['id_prueba'];
    $idUsuario            = $_SESSION['nomina'];
    $especificaciones     = $_POST['especificaciones'];
    $fechaSolicitud       = $_POST['fechaSolicitud'];

    list($response, $norma, $normaFile) = manejarNormaFile($tipoPrueba, $id_prueba, $_FILES, $_POST);

    if($response['status']==='success'){
        // Convertir los datos de las piezas en arrays
        $plataformas    = explode(', ', $_POST['plataformas']);
        $numsParte      = explode(', ', $_POST['numsParte']);
        $cdadPiezas     = explode(', ', $_POST['cantidades']);
        $revDibujos     = explode(', ', $_POST['revDibujos']);
        $modMatematicos = explode(', ', $_POST['modMatematicos']);

        // Llamar a la función para registrar la solicitud
        $response = RegistrarSolicitud($tipoPrueba, $norma, $normaFile, $idUsuario, $especificaciones, $plataformas,$numsParte, $cdadPiezas, $revDibujos,$modMatematicos, $fechaSolicitud, $id_prueba);
    }

} else {
    // Mostrar mensaje de error si faltan datos en el formulario
    $response = array("status" => "error", 'message' => "Error: Faltan datos en el formulario");
}
echo json_encode($response);
exit;


function RegistrarSolicitud($tipoPrueba, $norma, $normaFile, $idUsuario, $especificaciones, $plataformas,$numsParte, $cdadPiezas, $revDibujos,$modMatematicos, $fechaSolicitud, $id_prueba)
{
    $con = new LocalConector();
    $conex = $con->conectar();

    // Iniciar transacción
    $conex->begin_transaction();

    $insertSolicitud = $conex->prepare("INSERT INTO `Pruebas` (`id_prueba`, `fechaSolicitud`,  `especificaciones`, `normaNombre`, `normaArchivo`,`id_solicitante`, `id_tipoPrueba`) 
                                              VALUES (?, ?, ?, ?, ?, ?, ?)");
    $insertSolicitud->bind_param("ssssssi", $id_prueba, $fechaSolicitud, $especificaciones, $norma, $normaFile, $idUsuario, $tipoPrueba);
    $rInsertSolicitud = $insertSolicitud->execute();

    $rInsertMaterial = true;

    //Registrar Piezas
    for ($i = 0; $i < count($cdadPiezas); $i++) {
        $numParte      = $numsParte[$i];
        $plataforma    = $plataformas[$i];
        $cdadPieza     = $cdadPiezas[$i];
        $revDibujo     = $revDibujos[$i];
        $modMatematico = $modMatematicos[$i];

        $insertMaterial = $conex->prepare("INSERT INTO `Piezas` (`id_prueba`, `numParte`,`cantidad`, `id_plataforma`,`revisionDibujo`, `modMatematico`) 
                                                 VALUES (?, ?, ?, ?, ?, ?)");

        $insertMaterial->bind_param("ssiiss", $id_prueba, $numParte,$cdadPieza, $plataforma,$revDibujo,$modMatematico);
        $rInsertMaterial = $rInsertMaterial && $insertMaterial->execute();
    }

    // Confirmar o hacer rollback de la transacción
    if(!$rInsertSolicitud || !$rInsertMaterial) {
        $conex->rollback();
        $response = array('status' => 'error', 'message' => 'Error en RegistrarSolicitud');
    } else {
        $conex->commit();
        $response = array('status' => 'success', 'message' => 'Datos guardados correctamente');
    }
    $conex->close();
    return $response;
}

function manejarNormaFile($tipoPrueba, $id_prueba, $files, $post) {

    if ($tipoPrueba == 1 || $tipoPrueba == 2 || $tipoPrueba == 6) { // si se requiere norma por tipo de prueba

        if (isset($files['norma'],  $files['normaFile']) && $files['normaFile']['error'] == UPLOAD_ERR_OK) { // verifica si el archivo ha sido cargado correctamente
            $norma = $_POST['norma'];
            // guardar los files de la norma
            $target_dir = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/files/norms/";
            // Quitar espacios del nombre del archivo:
            $nombreArchivo = $files["normaFile"]["name"];
            $normaFileName = $id_prueba . "-" . str_replace(' ', '-', $nombreArchivo);
            $normaFile = $target_dir . $normaFileName;
            $moverNormaFile = "../files/norms/" . $normaFileName;

            if ($files["normaFile"]["error"] > 0) {
                $response = array("error" => "Error: " . $files["normaFile"]["error"]);
            } else {
                // Mover el archivo cargado a la ubicación deseada
                if (move_uploaded_file($files["normaFile"]["tmp_name"], $moverNormaFile)) {
                    $response = array("status" => "success","message" => "El archivo " . htmlspecialchars($normaFileName) . " ha sido subido correctamente.");
                } else {
                    $response = array("error" => "Hubo un error al mover el archivo.");
                }
            }
        } elseif (isset($files['norma'], $post['normaFile']) && is_string($post['normaFile'])) { // No hay archivo cargado, es un string
            $norma = $_POST['norma'];
            $response = array("status" => "success");
            $normaFile = $post['normaFile'];
        } else {
            $norma = 'error';
            $normaFile = 'error';
            $response = array("status" => "error", 'message' => "Error: Faltan datos en el formulario");
        }
    } else { // El tipo de prueba no requiere especificar norma
        $response = array("status" => "success");
        $normaFile = 'No aplica';
        $norma = 'No aplica';
    }
    return array($response, $norma, $normaFile);
}

//bind_param(): Es un método de la clase mysqli_stmt que se utiliza para vincular parámetros a la consulta preparada.
//ssssssi": especifica el tipo de datos de los parámetros que se están vinculando(cada "s" indica que el parámetro es una cadena (string) y cada "i" indica que el parámetro es un entero (integer))
?>