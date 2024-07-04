<?php
include_once('connection.php');
session_start();

// Verificar si los datos están presentes y asignarlos de manera segura
if(isset($_POST['tipoPrueba'], $_SESSION['nomina'], $_POST['especificaciones'], $_POST['plataformas'], $_POST['numsParte'],$_POST['cantidades'], $_POST['revDibujos'],$_POST['modMatematicos'],$_POST['fechaSolicitud'], $_POST['id_prueba'])) {
    // Asignar variables
    $tipoPrueba     = $_POST['tipoPrueba'];
    $id_prueba      = $_POST['id_prueba'];
    $norma          = $_POST['norma'];


    if($tipoPrueba == 1 || $tipoPrueba == 2 || $tipoPrueba == 6) {//si se requiere norma por tipo de prueba
        if (isset($_FILES['normaFile']) && $_FILES['normaFile']['error'] == UPLOAD_ERR_OK) { //verifica si el archivo ha sido cargado correctamente.
            //guardar los files de la norma
            $target_dir = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/files/norms/";
            //Quitar espacios del nombre del archivo:
            // Verificar si se requiere norma por tipo de prueba
            $nombreArchivo = $_FILES["normaFile"]["name"];
            $normaFileName = $id_prueba . "-" . str_replace(' ', '-', $nombreArchivo);
            $normaFile = $target_dir . $normaFileName;
            $moverNormaFile = "../files/norms/" . $normaFileName;

            if ($_FILES["normaFile"]["error"] > 0) {
                $response = array("error" => "Error: " . $_FILES["normaFile"]["error"]);
            } else {
                // Mover el archivo cargado a la ubicación deseada
                if (move_uploaded_file($_FILES["normaFile"]["tmp_name"], $moverNormaFile)) {
                    $response = array("message" => "El archivo " . htmlspecialchars($normaFileName) . " ha sido subido correctamente.");
                } else {
                    $response = array("error" => "Hubo un error al mover el archivo.");
                }
            }
        }elseif (isset($_POST['normaFile']) && is_string($_POST['normaFile'])) {// No hay archivo cargado, es un string
            $normaFile = $_POST['normaFile'];
        }else{
            $normaFile = 'error';
            $response = array("status" => "error", 'message' => "Error: Faltan datos en el formulario");
        }
    } else{ //El tipo de prueba no requiere especificar norma
        $normaFile = 'No aplica';
    }

    // Asignar otras variables
    $idUsuario            = $_SESSION['nomina'];
    $especificaciones     = $_POST['especificaciones'];
    $fechaSolicitud       = $_POST['fechaSolicitud'];

    // Convertir materiales y cantidades en arrays
    $descMateriales = explode(', ', $_POST['materiales']);
    $cdadMateriales = explode(', ', $_POST['cantidades']);

    // Llamar a la función para registrar la solicitud
    RegistrarSolicitud($tipoPrueba, $norma, $normaFile, $idUsuario, $especificaciones, $descMateriales, $cdadMateriales, $fechaSolicitud, $id_prueba);
} else {
    // Mostrar mensaje de error si faltan datos en el formulario
    echo json_encode(array("error" => true, 'message' => "<script>alert('Error: Faltan datos en el formulario')</script>"));
}

function manejarNormaFile($tipoPrueba, $id_prueba, $files, $post) {
    $response = array();
    $normaFile = '';

    if ($tipoPrueba == 1 || $tipoPrueba == 2 || $tipoPrueba == 6) { // si se requiere norma por tipo de prueba
        if (isset($files['normaFile']) && $files['normaFile']['error'] == UPLOAD_ERR_OK) { // verifica si el archivo ha sido cargado correctamente
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
        } elseif (isset($post['normaFile']) && is_string($post['normaFile'])) { // No hay archivo cargado, es un string
            $response = array("status" => "success");
            $normaFile = $post['normaFile'];
        } else {
            $normaFile = 'error';
            $response = array("status" => "error", 'message' => "Error: Faltan datos en el formulario");
        }
    } else { // El tipo de prueba no requiere especificar norma
        $response = array("status" => "success");
        $normaFile = 'No aplica';
    }
    return array($response, $normaFile);
}



function RegistrarSolicitud($tipoPrueba, $norma, $normaFile, $idUsuario, $especificaciones, $descMateriales, $cdadMateriales, $fechaSolicitud, $id_prueba)
{
    $con = new LocalConector();
    $conex = $con->conectar();

    // Iniciar transacción
    $conex->begin_transaction();

    $insertSolicitud = $conex->prepare("INSERT INTO `Prueba` (`id_prueba`, `fechaSolicitud`,  `especificaciones`, `normaNombre`, `normaArchivo`, `id_solicitante`, `id_tipoPrueba`) 
                                              VALUES (?, ?, ?, ?, ?, ?, ?)");
    $insertSolicitud->bind_param("ssssssi", $id_prueba, $fechaSolicitud, $especificaciones, $norma, $normaFile, $idUsuario, $tipoPrueba);
    $rInsertSolicitud = $insertSolicitud->execute();

    $rInsertMaterial = true;

    for ($i = 0; $i < count($descMateriales); $i++) {
        $descMaterial = $descMateriales[$i];
        $cdadMaterial = $cdadMateriales[$i];

        $insertMaterial = $conex->prepare("INSERT INTO `Material` (`id_prueba`, `cantidad`, `id_descripcion`) 
                                                 VALUES (?, ?, ?)");

        $insertMaterial->bind_param("sii", $id_prueba, $cdadMaterial, $descMaterial);
        $rInsertMaterial = $rInsertMaterial && $insertMaterial->execute();
    }
    // Confirmar o hacer rollback de la transacción
    if(!$rInsertSolicitud || !$rInsertMaterial) {
        $conex->rollback();
        $conex->close();
        echo json_encode(array('error' => true, 'message' => 'Error en RegistrarSolicitud'));
        exit;
        //return false;
    } else {
        $conex->commit();
        $conex->close();
        echo json_encode(array('error' => false, 'message' => 'Datos insertados correctamente'));
        exit;
        //return true;
    }

}

//bind_param(): Es un método de la clase mysqli_stmt que se utiliza para vincular parámetros a la consulta preparada.
//ssssssi": especifica el tipo de datos de los parámetros que se están vinculando(cada "s" indica que el parámetro es una cadena (string) y cada "i" indica que el parámetro es un entero (integer))
?>