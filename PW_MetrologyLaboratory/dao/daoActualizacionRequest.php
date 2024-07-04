<?php
include_once('connection.php');
session_start();

// Verificar si los datos están presentes y asignarlos de manera segura
if(isset($_POST['tipoPrueba'], $_SESSION['nomina'], $_POST['especificaciones'], $_POST['materiales'], $_POST['cantidades'], $_POST['fechaSolicitud'], $_POST['id_prueba'])) {
    // Asignar variables
    $tipoPrueba     = $_POST['tipoPrueba'];
    $id_prueba      = $_POST['id_prueba'];
    $norma          = $_POST['norma'];

    if($tipoPrueba == 3 || $tipoPrueba == 4 || $tipoPrueba == 5){ //si se requiere norma por tipo de prueba
        //guardar los archivos de la norma
        $target_dir     = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/";
        //Quitar espacios del nombre del archivo:
        // Verificar si se requiere norma por tipo de prueba
        $nombreArchivo  = $_FILES["normaFile"]["name"];
        $normaFileName  = $id_prueba . "-" . str_replace(' ', '-', $nombreArchivo);
        $normaFile      = $target_dir . $normaFileName;
        $moverNormaFile = $target_dir . $normaFileName;

        if ($_FILES["normaFile"]["error"] > 0) {
            echo json_encode(array("error" => true, 'message' => "Error: " . $_FILES["normaFile"]["error"] ));
            $response = array( "error" => "Error: " . $_FILES["normaFile"]["error"] );
        } else {
            // mover el archivo cargado a la ubicación deseada
            move_uploaded_file(from: $_FILES["normaFile"]["tmp_name"], to: $moverNormaFile);
            $response = array("message" => "El archivo " . htmlspecialchars($normaFileName) . " ha sido subido correctamente.");
        }
    }else{ //El tipo de prueba no requiere especificar norma
        $normaFile = 'No aplica';
    }

    // Asignar otras variables
    $idUsuario            = $_SESSION['nomina'];
    $tipoPruebaEspecial   = ($_POST['tipoPrueba'] != 5) ?  5 : $_POST['tipoPruebaEspecial'] ;
    $otroPrueba           = ($tipoPruebaEspecial  != 4) ? 'No aplica' : $_POST['otroPrueba'] ;
    $especificaciones     = $_POST['especificaciones'];
    $fechaSolicitud       = $_POST['fechaSolicitud'];

    // Convertir materiales y cantidades en arrays
    $descMateriales = explode(', ', $_POST['materiales']);
    $cdadMateriales = explode(', ', $_POST['cantidades']);

    // Llamar a la función para registrar la solicitud
    ActualizarSolicitud($tipoPrueba, $norma, $normaFile, $idUsuario, $tipoPruebaEspecial, $otroPrueba, $especificaciones, $descMateriales, $cdadMateriales, $fechaSolicitud, $id_prueba);
} else {
    // Mostrar mensaje de error si faltan datos en el formulario
    echo json_encode(array("error" => true, 'message' => "<script>alert('Error: Faltan datos en el formulario')</script>"));
}


function ActualizarSolicitud($tipoPrueba, $norma, $normaFile, $idUsuario, $tipoPruebaEspecial, $otroPrueba, $especificaciones, $descMateriales, $cdadMateriales, $fechaSolicitud, $id_prueba)
{
    $con = new LocalConector();
    $conex = $con->conectar();

    // Iniciar transacción
    $conex->begin_transaction();

    $updateSolicitud = $conex->prepare("UPDATE `Pruebas` 
                                                 SET `fechaSolicitud` = ?, `especificaciones` = ?, `normaNombre` = ?, `normaArchivo` = ?, `id_solicitante` = ?, 
                                                     `id_tipoPrueba` = ?, `id_pruebaEspecial` = ?, `otroTipoEspecial` = ? 
                                               WHERE `id_prueba` = ?");
    $updateSolicitud->bind_param("sssssiiss", $fechaSolicitud, $especificaciones, $norma, $normaFile, $idUsuario, $tipoPrueba, $tipoPruebaEspecial, $otroPrueba, $id_prueba);
    $rUpdateSolicitud = $updateSolicitud->execute();

    // Consultando los materiales ya registrados
    $selectQuery = $conex->prepare("SELECT id_material, id_descripcion, cantidad, id_estatusMaterial FROM Material WHERE id_prueba = ?");
    $selectQuery->bind_param("s", $id_prueba);
    $selectQuery->execute();
    $result = $selectQuery->get_result();

    $existingMaterials = [];
    while ($row = $result->fetch_assoc()) {
        $existingMaterials[$row['id_descripcion']] = [
                                                        'id_material' => $row['id_material'],
                                                        'cantidad' => $row['cantidad'],
                                                        'id_estatusMaterial' => $row['id_estatusMaterial']
        ];
    }

    // Preparar los nuevos datos proporcionados por el usuario
    $newMaterials = [];
    for ($i = 0; $i < count($descMateriales); $i++) {
        $descMaterial = $descMateriales[$i];
        $cdadMaterial = $cdadMateriales[$i];
        $newMaterials[$descMaterial] = $cdadMaterial;
    }

    // Comparar y actualizar la base de datos
    $rUpdateMaterial = true;

    // Actualizar o insertar nuevos registros
    foreach ($newMaterials as $descMaterial => $cdadMaterial) {
        if (array_key_exists($descMaterial, $existingMaterials)) {
            // Actualizar si la cantidad es diferente
            if ($existingMaterials[$descMaterial]['cantidad'] != $cdadMaterial) {
                $updateMaterial = $conex->prepare("UPDATE `Material` SET `cantidad` = ? WHERE `id_prueba`= ? AND `id_material` = ?");
                $updateMaterial->bind_param("isi", $cdadMaterial, $id_prueba, $existingMaterials[$descMaterial]['id_material']);
                $rUpdateMaterial = $rUpdateMaterial && $updateMaterial->execute();
            }
        } else {
            // Insertar nuevo material
            $insertMaterial = $conex->prepare("INSERT INTO `Material` (`id_prueba`, `id_descripcion`, `cantidad`) VALUES (?, ?, ?)");
            $insertMaterial->bind_param("ssi", $id_prueba, $descMaterial, $cdadMaterial);
            $rUpdateMaterial = $rUpdateMaterial && $insertMaterial->execute();
        }
    }

    // Eliminar materiales que ya no están en la lista proporcionada por el usuario
    foreach ($existingMaterials as $descMaterial => $data) {
        if (!array_key_exists($descMaterial, $newMaterials)) {
            $deleteMaterial = $conex->prepare("DELETE FROM `Material` WHERE `id_prueba` = ? AND `id_material` = ?");
            $deleteMaterial->bind_param("si", $id_prueba, $data['id_material']);
            $rUpdateMaterial = $rUpdateMaterial && $deleteMaterial->execute();
        }
    }

    // Confirmar o hacer rollback de la transacción
    if(!$rUpdateSolicitud || !$rUpdateMaterial) {
        $conex->rollback();
        $conex->close();
        echo json_encode(array('error' => true, 'message' => 'Error al actualizar la prueba'));
        exit;
    } else {
        $conex->commit();
        $conex->close();
        echo json_encode(array('error' => false, 'message' => 'Datos actualizadoa correctamente'));
        exit;
    }
}
?>