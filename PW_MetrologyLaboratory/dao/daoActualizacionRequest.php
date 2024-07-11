<?php
include_once('connection.php');
include_once('funcionesRequest.php');
session_start();
header('Content-Type: application/json');


// Verificar si los datos están presentes y asignarlos de manera segura
if(isset($_POST['tipoPrueba'], $_SESSION['nomina'], $_POST['especificaciones'], $_POST['fechaSolicitud'], $_POST['id_prueba'])) {
    // Asignar variables
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

                // Llamar a la función para actualizar la solicitud
                $response = ActualizarSolicitud($tipoPrueba, $norma, $normaFile, $idUsuario, $especificaciones, $imagenCotas,$subtipo,$plataformas,$numsParte, $cdadPiezas, $revDibujos,$modMatematicos, $fechaSolicitud, $id_prueba);

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


function ActualizarPiezas($conexUpdate,$plataformas, $numsParte, $cdadPiezas, $revDibujos, $modMatematicos, $id_prueba)
{
    /*$con = new LocalConector();
    $conexUpdate = $con->conectar();

     //Iniciar transacción
    $conexUpdate->begin_transaction();*/

    // Consultando las piezas ya registradas
    $selectQuery = $conexUpdate->prepare("SELECT id_pieza, numParte, cantidad, id_plataforma, revisionDibujo, modMatematico FROM Piezas WHERE id_prueba = ?");
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
            $updateQuery = $conexUpdate->prepare("UPDATE Piezas SET cantidad = ?, id_plataforma = ?, revisionDibujo = ?, modMatematico = ? WHERE id_pieza = ?");
            $updateQuery->bind_param("iissi", $pieza['cantidad'], $pieza['id_plataforma'], $pieza['revisionDibujo'], $pieza['modMatematico'], $existingPiezas[$numParte]['id_pieza']);
            $rUpdateQuery = $rUpdateQuery && $updateQuery->execute();
        } else {
            // Si la pieza no existe, insertarla
            $insertQuery = $conexUpdate->prepare("INSERT INTO Piezas (numParte, cantidad, id_plataforma, revisionDibujo, modMatematico, id_prueba) VALUES (?, ?, ?, ?, ?, ?)");
            $insertQuery->bind_param("siisss", $numParte, $pieza['cantidad'], $pieza['id_plataforma'], $pieza['revisionDibujo'], $pieza['modMatematico'], $id_prueba);
            $rInsertQuery = $rInsertQuery && $insertQuery->execute();
        }
    }

    // Eliminar piezas que ya no están en los datos proporcionados por el usuario
    foreach ($existingPiezas as $numParte => $pieza) {
        if (!isset($newPiezas[$numParte])) {
            $deleteQuery = $conexUpdate->prepare("DELETE FROM Piezas WHERE id_pieza = ?");
            $deleteQuery->bind_param("i", $pieza['id_pieza']);
            $rDeleteQuery = $rDeleteQuery && $deleteQuery->execute();
        }
    }

    if(!$rUpdateQuery || !$rInsertQuery || !$rDeleteQuery ) {
        //$conexUpdate->rollback();
        $response = array('status' => 'error', 'message' => 'Error al actualizar las piezas');
    } else {
        //$conexUpdate->commit();
        $response = array('status' => 'success', 'message' => 'Datos guardados correctamente');
    }
    //$conexUpdate->close();
    return $response;
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
//bind_param(): Es un método de la clase mysqli_stmt que se utiliza para vincular parámetros a la consulta preparada.
//ssssssi": especifica el tipo de datos de los parámetros que se están vinculando(cada "s" indica que el parámetro es una cadena (string) y cada "i" indica que el parámetro es un entero (integer))
?>