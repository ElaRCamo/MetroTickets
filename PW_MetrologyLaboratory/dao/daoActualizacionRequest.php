<?php
include_once('connection.php');
include_once('funcionesRequest.php');
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


//bind_param(): Es un método de la clase mysqli_stmt que se utiliza para vincular parámetros a la consulta preparada.
//ssssssi": especifica el tipo de datos de los parámetros que se están vinculando(cada "s" indica que el parámetro es una cadena (string) y cada "i" indica que el parámetro es un entero (integer))
?>