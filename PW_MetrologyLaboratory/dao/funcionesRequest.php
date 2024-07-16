<?php
function RegistrarSolicitudMunsell($tipoPrueba, $norma, $normaFile, $idUsuario, $especificaciones, $imagenCotas,$subtipo, $fechaSolicitud, $id_prueba,$nominas,$nombres,$areas)
{
    $con = new LocalConector();
    $conex = $con->conectar();

    // Iniciar transacción
    $conex->begin_transaction();

    $insertSolicitud = $conex->prepare("INSERT INTO `Pruebas` (`id_prueba`, `fechaSolicitud`,  `especificaciones`, `normaNombre`, `normaArchivo`,`id_solicitante`, `id_tipoPrueba`, `id_subtipo`, `imagenCotas`) 
                                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $insertSolicitud->bind_param("ssssssiis", $id_prueba, $fechaSolicitud, $especificaciones, $norma, $normaFile, $idUsuario, $tipoPrueba, $subtipo, $imagenCotas);
    $rInsertSolicitud = $insertSolicitud->execute();

    $rGuardarObjetos = true;

    //Registrar Personal
    for ($i = 0; $i < count($nominas); $i++) {
        $nomina = $nominas[$i];
        $nombre = $nombres[$i];
        $area = $areas[$i];

        $insertMaterial = $conex->prepare("INSERT INTO `PersonalMunsell` (`id_prueba`, `nomina`, `nombre`, `area`) 
                                                     VALUES (?, ?, ?, ?)");

        $insertMaterial->bind_param("ssss", $id_prueba, $nomina, $nombre, $area);
        $rGuardarObjetos = $rGuardarObjetos && $insertMaterial->execute();
    }

    // Confirmar o hacer rollback de la transacción
    if (!$rInsertSolicitud || !$rGuardarObjetos) {
        $conex->rollback();
        $response = array('status' => 'error', 'message' => 'Error en Registrar Solicitud');
    } else {
        $conex->commit();
        $response = array('status' => 'success', 'message' => 'Datos guardados correctamente');
    }
    $conex->close();
    return $response;
}

function ActualizarSolicitudMunsell($tipoPrueba, $norma, $normaFile, $idUsuario, $especificaciones, $imagenCotas,$subtipo, $fechaSolicitud, $id_prueba,$nominas,$nombres,$areas)
{
    $con = new LocalConector();
    $conex = $con->conectar();

    // Iniciar transacción
    $conex->begin_transaction();

    // Preparar la consulta de actualización
    $updateSolicitud = $conex->prepare("UPDATE `Pruebas` 
                                                SET `fechaSolicitud` = ?, 
                                                    `especificaciones` = ?, 
                                                    `normaNombre` = ?, 
                                                    `normaArchivo` = ?, 
                                                    `id_solicitante` = ?, 
                                                    `id_tipoPrueba` = ?, 
                                                    `id_subtipo` = ?, 
                                                    `imagenCotas` = ? 
                                                WHERE `id_prueba` = ?");
    $updateSolicitud->bind_param("sssssiiss", $fechaSolicitud, $especificaciones, $norma, $normaFile, $idUsuario, $tipoPrueba, $subtipo, $imagenCotas, $id_prueba);
    $rUpdateSolicitud = $updateSolicitud->execute();

    // Actualizar Personal
    $response = ActualizarPersonal($conex, $id_prueba,$nominas, $nombres, $areas);

    if($response['status']==='success'){
        $rGuardarObjetos = true;

        //Registrar cambios en bitacora
        $descripcion = "Usuario actualiza solicitud.";
        $response =  registrarCambioBitacoora($conex,$id_prueba,$descripcion,$idUsuario);

        if($response['status']==='success'){
            $rGuardarBitacora = true;
        }else{
            $rGuardarBitacora = false;
        }
    }else{
        $rGuardarObjetos = false;
        $rGuardarBitacora = false;
    }

    // Confirmar o hacer rollback de la transacción
    if(!$rUpdateSolicitud || !$rGuardarObjetos || !$rGuardarBitacora) {
        $conex->rollback();
        if(!$rUpdateSolicitud){
            $response = array('status' => 'error', 'message' => 'Error en Actualizar la Solicitud');
        }
    } else {
        $conex->commit();
        //$response = array('status' => 'success', 'message' => 'Datos guardados correctamente');
    }
    $conex->close();
    return $response;
}

function ActualizarPersonal($conexUpdate, $id_prueba,$nominas, $nombres, $areas)
{
    // Consultando las piezas ya registradas
    $selectQuery = $conexUpdate->prepare("SELECT id_personal, nomina, nombre, area FROM PersonalMunsell WHERE id_prueba = ?");
    $selectQuery->bind_param("s", $id_prueba);
    $selectQuery->execute();
    $result = $selectQuery->get_result();

    $existingPersonal = [];
    while ($row = $result->fetch_assoc()) {
        $existingPersonal[$row['nomina']] = [
            'id_personal' => $row['id_personal'],
            'nombre' => $row['nombre'],
            'area' => $row['area']
        ];
    }

    // Preparar los nuevos datos proporcionados por el usuario
    $newPersonal = [];
    for ($i = 0; $i < count($nominas); $i++) {
        $nomina = $nominas[$i];
        $nombre = $nombres[$i];
        $area = $areas[$i];

        $newPersonal[$nomina] = [
            'nombre' => $nombre,
            'area' => $area
        ];
    }

    $rUpdateQuery = $rInsertQuery = $rDeleteQuery = true;

    // Actualizar o insertar nuevo personal
    foreach ($newPersonal as $nomina => $personal) {
        if (isset($existingPiezas[$nomina])) {
            // Si la pieza ya existe, actualizarla
            $updateQuery = $conexUpdate->prepare("UPDATE PersonalMunsell SET nombre = ?, area = ?, nomina = ?  WHERE id_personal = ?");
            $updateQuery->bind_param("sssi", $personal['nombre'], $personal['area'], $personal['nomina'], $existingPersonal[$nomina]['id_personal']);
            $rUpdateQuery = $rUpdateQuery && $updateQuery->execute();
        } else {
            // Si la pieza no existe, insertarla
            $insertQuery = $conexUpdate->prepare("INSERT INTO PersonalMunsell (id_prueba, nombre, area, nomina) VALUES (?, ?, ?, ?)");
            echo "nomina:".$nomina;
            $insertQuery->bind_param("ssss", $id_prueba, $personal['nombre'], $personal['area'], $nomina);
            $rInsertQuery = $rInsertQuery && $insertQuery->execute();
        }
    }

    // Eliminar piezas que ya no están en los datos proporcionados por el usuario
    foreach ($existingPersonal as $nomina => $personal) {
        if (!isset($newPersonal[$nomina])) {
            $deleteQuery = $conexUpdate->prepare("DELETE FROM PersonalMunsell WHERE id_personal = ?");
            $deleteQuery->bind_param("i", $personal['id_personal']);
            $rDeleteQuery = $rDeleteQuery && $deleteQuery->execute();
        }
    }

    if(!$rUpdateQuery || !$rInsertQuery || !$rDeleteQuery ) {
        $response = array('status' => 'error', 'message' => 'Error al actualizar el personal');
    } else {
        $response = array('status' => 'success', 'message' => 'Datos guardados correctamente');
    }
    return $response;
}

function manejarSubtipoPrueba($tipoPrueba, $id_prueba, $files, $post)
{
    if ($tipoPrueba == 3) { //DIMENSIONAL
        // Manejar la imagen si se ha subido
        if (isset($files['imagenCotas'], $post['subtipoPrueba']) && $post['subtipoPrueba'] == 2 && $files['imagenCotas']['error'] === UPLOAD_ERR_OK) {
            $subtipo = $post['subtipoPrueba'];
            // Directorio de destino para la carga de files
            $target_dir = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/cotas/";

            // Nombre y ruta del archivo
            $fechaActual = date('Y-m-d_H-i-s');
            $archivo = $files['imagenCotas']['name'];
            $imgName = $fechaActual . '_' . $id_prueba;

            $extension = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
            $extensionesPermitidas = array("gif", "jpeg", "jpg", "png");
            $img = $target_dir . $imgName . "." . $extension;

            // Mover el archivo al directorio de destino
            $temp = $files['imagenCotas']['tmp_name'];
            $moverImgFile = "../imgs/cotas/" . $imgName . "." . $extension;
            if (in_array($extension, $extensionesPermitidas)) {
                move_uploaded_file($temp, $moverImgFile);
                $response = array('status' => 'success');
            } else {
                $img = 'error';
                $response = array('status' => 'error', 'message' => 'Error: Extensión no permitida.');
            }
        } else if (isset($post['subtipoPrueba']) && $post['subtipoPrueba'] == 1) {
            $response = array("status" => "success");
            $img = 'No aplica';
            $subtipo = $post['subtipoPrueba'];
        } else {
            // No se recibió ni un archivo ni un string válido
            $img = "Error";
            $subtipo = 0;
            $response = array('status' => 'error', 'message' => 'Error: Faltan datos en el formulario(img).');
        }
    } else { // El tipo de prueba no requiere especificar norma
        $response = array("status" => "success");
        $img = 'No aplica';
        $subtipo = 0;//No aplica
    }
    return array($response, $img, $subtipo);
}

function manejarNormaFile($tipoPrueba, $id_prueba, $files, $post)
{

    if ($tipoPrueba == 1 || $tipoPrueba == 2 || $tipoPrueba == 6) { // si se requiere norma por tipo de prueba

        if (isset($post['norma'], $files['normaFile']) && $files['normaFile']['error'] == UPLOAD_ERR_OK) { // verifica si el archivo ha sido cargado correctamente
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
                    $response = array("status" => "success", "message" => "El archivo " . htmlspecialchars($normaFileName) . " ha sido subido correctamente.");
                } else {
                    $response = array("error" => "Hubo un error al mover el archivo.");
                }
            }
        } elseif (isset($post['norma'], $post['normaFile']) && is_string($post['normaFile'])) { // No hay archivo cargado, es un string
            $norma = $_POST['norma'];
            $response = array("status" => "success");
            $normaFile = $post['normaFile'];
        } else {
            $norma = 'error';
            $normaFile = 'error';
            $response = array("status" => "error", 'message' => "Error: Faltan datos en el formulario(pdf)");
        }
    } else { // El tipo de prueba no requiere especificar norma
        $response = array("status" => "success");
        $normaFile = 'No aplica';
        $norma = 'No aplica';
    }
    return array($response, $norma, $normaFile);
}

function registrarCambioBitacoora($conexCambio,$id_prueba,$descripcion,$id_usuario)
{
    $fecha = date('Y-m-d H:i:s');
    $rInsertQuery = true;
    // Si la pieza no existe, insertarla
    $insertQuery = $conexCambio->prepare("INSERT INTO BitacoraCambios (id_prueba, fecha, descripcion,id_usuario) VALUES (?, ?, ?, ?)");
    $insertQuery->bind_param("ssss", $id_prueba, $fecha, $descripcion, $id_usuario);
    $rInsertQuery = $rInsertQuery && $insertQuery->execute();

    if(!$rInsertQuery  ) {
        $response = array('status' => 'error', 'message' => 'Error al actualizar la bitacora');
    } else {
        $response = array('status' => 'success', 'message' => 'Cambios registrados');
    }
    return $response;
}
?>