<?php
include_once('connection.php');
session_start();
header('Content-Type: application/json');


// Verificar si los datos están presentes y asignarlos de manera segura
if(isset($_POST['tipoPrueba'], $_SESSION['nomina'], $_POST['especificaciones'], $_POST['fechaSolicitud'], $_POST['id_prueba'], $_POST['actualizacion'])) {
    // Asignar variables
    $esActualizacion =  $_POST['actualizacion'];
    $tipoPrueba     = $_POST['tipoPrueba'];
    $id_prueba      = $_POST['id_prueba'];
    $idUsuario            = $_SESSION['nomina'];
    $especificaciones     = $_POST['especificaciones'];
    $fechaSolicitud       = $_POST['fechaSolicitud'];

    list($response, $norma, $normaFile) = manejarNormaFile($tipoPrueba, $id_prueba, $_FILES, $_POST);

    if($response['status']==='success'){
        list($response,$imagenCotas,$subtipo) = manejarSubtipoPrueba($tipoPrueba,$id_prueba,$_FILES, $_POST);
        if($response['status']==='success'){
            if($tipoPrueba == 5 && (isset( $_POST['nominas'],$_POST['nombres'],$_POST['areas']))) { //MUNSELL
                // Convertir los datos del personal en arrays
                $nominas  = explode(', ', $_POST['nominas']);
                $nombres  = explode(', ', $_POST['nombres']);
                $areas    = explode(', ', $_POST['areas']);
                // Llamar a la función para registrar la solicitud
                $response = RegistrarSolicitudMunsell($tipoPrueba, $norma, $normaFile, $idUsuario, $especificaciones, $imagenCotas,$subtipo, $fechaSolicitud, $id_prueba,$nominas,$nombres,$areas);

            }else if(isset( $_POST['plataformas'],$_POST['numsParte'],$_POST['cantidades'],$_POST['revDibujos'],$_POST['modMatematicos'])){
                // Convertir los datos de las piezas en arrays
                $plataformas    = explode(', ', $_POST['plataformas']);
                $numsParte      = explode(', ', $_POST['numsParte']);
                $cdadPiezas     = explode(', ', $_POST['cantidades']);
                $revDibujos     = explode(', ', $_POST['revDibujos']);
                $modMatematicos = explode(', ', $_POST['modMatematicos']);

                if($esActualizacion){
                    // Llamar a la función para actualizar la solicitud
                    $response = ActualizarSolicitud($tipoPrueba, $norma, $normaFile, $idUsuario, $especificaciones, $imagenCotas,$subtipo,$plataformas,$numsParte, $cdadPiezas, $revDibujos,$modMatematicos, $fechaSolicitud, $id_prueba);
                }else{
                    // Llamar a la función para registrar la solicitud
                    $response = RegistrarSolicitud($tipoPrueba, $norma, $normaFile, $idUsuario, $especificaciones, $imagenCotas,$subtipo,$plataformas,$numsParte, $cdadPiezas, $revDibujos,$modMatematicos, $fechaSolicitud, $id_prueba);
                }

            }else {
                // Mostrar mensaje de error si faltan datos en el formulario
                $response = array("status" => "error", 'message' => "Error: Faltan datos en el formulario(objs).");
            }
        }
    }
} else {
    // Mostrar mensaje de error si faltan datos en el formulario
    $response = array("status" => "error", 'message' => "Error: Faltan datos en el formulario");
}
echo json_encode($response);
exit;


function RegistrarSolicitud($tipoPrueba, $norma, $normaFile, $idUsuario, $especificaciones, $imagenCotas,$subtipo,$plataformas,$numsParte, $cdadPiezas, $revDibujos,$modMatematicos, $fechaSolicitud, $id_prueba)
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
        $rGuardarObjetos = $rGuardarObjetos && $insertMaterial->execute();
    }

    // Confirmar o hacer rollback de la transacción
    if(!$rInsertSolicitud || !$rGuardarObjetos) {
        $conex->rollback();
        $response = array('status' => 'error', 'message' => 'Error en Registrar Solicitud');
    } else {
        $conex->commit();
        $response = array('status' => 'success', 'message' => 'Datos guardados correctamente');
    }
    $conex->close();
    return $response;
}


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


function ActualizarSolicitud($tipoPrueba, $norma, $normaFile, $idUsuario, $especificaciones, $imagenCotas,$subtipo,$plataformas,$numsParte, $cdadPiezas, $revDibujos,$modMatematicos, $fechaSolicitud, $id_prueba)
{
    $con = new LocalConector();
    $conex = $con->conectar();

    // Iniciar transacción
    $conex->begin_transaction();

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
    $updateSolicitud->bind_param("ssssssiis", $fechaSolicitud, $especificaciones, $norma, $normaFile, $idUsuario, $tipoPrueba, $subtipo, $imagenCotas, $id_prueba);
    $rUpdateSolicitud = $updateSolicitud->execute();

    // Actualizar Piezas
    $response = ActualizarPiezas($conex, $plataformas, $numsParte, $cdadPiezas, $revDibujos, $modMatematicos, $id_prueba);
    if($response['status']==='success'){
        $rGuardarObjetos = true;
    }else{
        $rGuardarObjetos = false;
    }

    // Confirmar o hacer rollback de la transacción
    if(!$rUpdateSolicitud || !$rGuardarObjetos) {
        $conex->rollback();
        if(!$rUpdateSolicitud){
            $response = array('status' => 'error', 'message' => 'Error en Actualizar la Solicitud');
        }
    } else {
        $conex->commit();
        $response = array('status' => 'success', 'message' => 'Datos guardados correctamente');
    }
    $conex->close();
    return $response;
}


function ActualizarPiezas($conex,$plataformas, $numsParte, $cdadPiezas, $revDibujos, $modMatematicos, $id_prueba)
{
    /*$con = new LocalConector();
    $conex = $con->conectar();

     //Iniciar transacción
    $conex->begin_transaction();*/

    // Consultando las piezas ya registradas
    $selectQuery = $conex->prepare("SELECT id_pieza, numParte, cantidad, id_plataforma, revisionDibujo, modMatematico FROM Piezas WHERE id_prueba = ?");
    $selectQuery->bind_param("s", $id_prueba);
    $selectQuery->execute();
    $result = $selectQuery->get_result();

    $existingPiezas = [];
    while ($row = $result->fetch_assoc()) {
        $existingPiezas[$row['numParte']] = [
            'id_pieza' => $row['id_pieza'],
            'cantidad' => $row['cantidad'],
            'id_plataforma' => $row['id_plataforma'],
            'revisionDibujo' => $row['revisionDibujo'],
            'modMatematico' => $row['modMatematico']
        ];
    }

    // Preparar los nuevos datos proporcionados por el usuario
    $newPiezas = [];
    for ($i = 0; $i < count($numsParte); $i++) {
        $numParte = $numsParte[$i];
        $plataforma = $plataformas[$i];
        $cdadPieza = $cdadPiezas[$i];
        $revDibujo = $revDibujos[$i];
        $modMatematico = $modMatematicos[$i];

        $newPiezas[$numParte] = [
            'cantidad' => $cdadPieza,
            'id_plataforma' => $plataforma,
            'revisionDibujo' => $revDibujo,
            'modMatematico' => $modMatematico
        ];
    }

    $rUpdateQuery = $rInsertQuery = $rDeleteQuery = true;

    // Actualizar o insertar nuevas piezas
    foreach ($newPiezas as $numParte => $pieza) {
        if (isset($existingPiezas[$numParte])) {
            // Si la pieza ya existe, actualizarla
            $updateQuery = $conex->prepare("UPDATE Piezas SET cantidad = ?, id_plataforma = ?, revisionDibujo = ?, modMatematico = ? WHERE id_pieza = ?");
            $updateQuery->bind_param("iissi", $pieza['cantidad'], $pieza['id_plataforma'], $pieza['revisionDibujo'], $pieza['modMatematico'], $existingPiezas[$numParte]['id_pieza']);
            $rUpdateQuery = $rUpdateQuery && $updateQuery->execute();
        } else {
            // Si la pieza no existe, insertarla
            $insertQuery = $conex->prepare("INSERT INTO Piezas (numParte, cantidad, id_plataforma, revisionDibujo, modMatematico, id_prueba) VALUES (?, ?, ?, ?, ?, ?)");
            $insertQuery->bind_param("siisss", $numParte, $pieza['cantidad'], $pieza['id_plataforma'], $pieza['revisionDibujo'], $pieza['modMatematico'], $id_prueba);
            $rInsertQuery = $rInsertQuery && $insertQuery->execute();
        }
    }

    // Eliminar piezas que ya no están en los datos proporcionados por el usuario
    foreach ($existingPiezas as $numParte => $pieza) {
        if (!isset($newPiezas[$numParte])) {
            $deleteQuery = $conex->prepare("DELETE FROM Piezas WHERE id_pieza = ?");
            $deleteQuery->bind_param("i", $pieza['id_pieza']);
            $rDeleteQuery = $rDeleteQuery && $deleteQuery->execute();
        }
    }

    // Confirmar o hacer rollback de la transacción
    if(!$rUpdateQuery || !$rInsertQuery || !$rDeleteQuery ) {
        //$conex->rollback();
       /* if(!$rUpdateQuery ) {

        }if(!$rInsertQuery || $rDeleteQuery ) {

        }if(!$rUpdateQuery || !$rInsertQuery || $rDeleteQuery ) {

        }*/
        $response = array('status' => 'error', 'message' => 'Error al actualizar las piezas');
    } else {
        //$conex->commit();
        $response = array('status' => 'success', 'message' => 'Datos guardados correctamente');
    }
    //$conex->close();
    return $response;
}
//bind_param(): Es un método de la clase mysqli_stmt que se utiliza para vincular parámetros a la consulta preparada.
//ssssssi": especifica el tipo de datos de los parámetros que se están vinculando(cada "s" indica que el parámetro es una cadena (string) y cada "i" indica que el parámetro es un entero (integer))

?>