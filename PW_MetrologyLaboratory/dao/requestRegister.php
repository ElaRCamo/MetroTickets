<?php
include_once('connection.php');
session_start();

// Verificar si los datos están presentes y asignarlos de manera segura
if(isset($_POST['tipoPrueba'], $_SESSION['nomina'], $_POST['especificaciones'], $_POST['materiales'], $_POST['cantidades'], $_POST['fechaSolicitud'], $_POST['id_prueba'])) {
    // Asignar variables
    $tipoPrueba     = $_POST['tipoPrueba'];
    $id_prueba      = $_POST['id_prueba'];

    // Verificar si se requiere norma por tipo de prueba
    if($tipoPrueba == 3 || $tipoPrueba == 4 || $tipoPrueba == 5) {
        $norma = $_POST['norma'];
        // Guardar los archivos de la norma
        $target_dir     = "../archivos/"; // Ruta del directorio de destino para guardar archivos
        $nombreArchivo  = $_FILES["normaFile"]["name"];
        $normaFileName  = $id_prueba . "-" . str_replace(' ', '-', $nombreArchivo);
        $normaFile      = $target_dir . $normaFileName;
        $moverNormaFile = $target_dir . $normaFileName;

        if ($_FILES["normaFile"]["error"] > 0) {
            echo json_encode(array("error" => true, 'message' => "Error: " . $_FILES["normaFile"]["error"] ));
        } else {
            // Procesar el archivo de norma si no hay errores
            move_uploaded_file($_FILES["normaFile"]["tmp_name"], $moverNormaFile);
        }
    } else {
        // El tipo de prueba no requiere especificar norma
        $norma     = 'No aplica';
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
    RegistrarSolicitud($tipoPrueba, $norma, $normaFile, $idUsuario, $tipoPruebaEspecial, $otroPrueba, $especificaciones, $descMateriales, $cdadMateriales, $fechaSolicitud, $id_prueba);
} else {
    // Mostrar mensaje de error si faltan datos en el formulario
    echo json_encode(array("error" => true, 'message' => "<script>alert('Error: Faltan datos en el formulario')</script>"));
}


function RegistrarSolicitud($tipoPrueba, $norma, $normaFile, $idUsuario, $tipoPruebaEspecial, $otroPrueba, $especificaciones, $descMateriales, $cdadMateriales, $fechaSolicitud, $id_prueba)
{
    $con = new LocalConector();
    $conex = $con->conectar();

    // Iniciar transacción
    $conex->begin_transaction();

    $insertSolicitud = $conex->prepare("INSERT INTO `Prueba` (`id_prueba`, `fechaSolicitud`,  `especificaciones`, `normaNombre`, `normaArchivo`, `id_solicitante`, `id_tipoPrueba`, `id_pruebaEspecial`, `otroTipoEspecial`) 
                                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $insertSolicitud->bind_param("ssssssiis", $id_prueba, $fechaSolicitud, $especificaciones, $norma, $normaFile, $idUsuario, $tipoPrueba, $tipoPruebaEspecial, $otroPrueba);
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


