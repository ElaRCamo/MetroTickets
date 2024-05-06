<?php
include_once('connection.php');
session_start();

// Verificar si los datos están presentes y asignarlos de manera segura
if(isset($_POST['tipoPrueba'], $_POST['norma'], $_SESSION['nomina'], $_POST['especificaciones'], $_POST['materiales'], $_POST['cantidades'], $_POST['fechaSolicitud'], $_POST['id_prueba'])) {
    $tipoPrueba     = $_POST['tipoPrueba'];
    $id_prueba      = $_POST['id_prueba'];

    if($tipoPrueba == 3 || $tipoPrueba == 4 || $tipoPrueba == 5){ //si se requiere norma por tipo de prueba
        $norma          = $_POST['norma'];
        //guardar los archivos de la norma
        $target_dir     = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/";
        //Quitar espacios del nombre del archivo:
        $nombreArchivo  = $_FILES["normaFile"]["name"];
        $normaFileName  = $id_prueba . "-" . str_replace(' ', '-', $nombreArchivo);
        $normaFile      = $target_dir . $normaFileName;
        $moverNormaFile = "../archivos/" . $normaFileName;

        if ($_FILES["normaFile"]["error"] > 0) {
            echo json_encode(array("error" => "Error: " . $_FILES["normaFile"]["error"] ));
            //$response = array( "error" => "Error: " . $_FILES["normaFile"]["error"] );
        } else {
            // mover el archivo cargado a la ubicación deseada
            move_uploaded_file($_FILES["normaFile"]["tmp_name"], $moverNormaFile);
                //$response = array("message" => "El archivo " . htmlspecialchars($normaFileName) . " ha sido subido correctamente.");
            /*else {
                echo json_encode(array("error" => "Hubo un error al subir el archivo."));
                //$response = array("error" => "Hubo un error al subir el archivo.");
            }*/
        }
    }else{ //El tipo de prueba no requiere especificar norma
        $norma     = 'No aplica';
        $normaFile = 'No aplica';
    }

    $idUsuario            = $_SESSION['nomina'];
    $tipoPruebaEspecial   = ($_POST['tipoPrueba'] != 5) ?  5 : $_POST['tipoPruebaEspecial'] ;
    $otroPrueba           = ($tipoPruebaEspecial  != 4) ? 'No aplica' : $_POST['otroPrueba'] ;
    $especificaciones     = $_POST['especificaciones'];
    $fechaSolicitud       = $_POST['fechaSolicitud'];

    // materiales y cantidades son strings separadas por comas, asi que se convierten en arrays usando explode
    $descMateriales = explode(', ', $_POST['materiales']);
    $cdadMateriales = explode(', ', $_POST['cantidades']);

    RegistrarSolicitud($tipoPrueba, $norma, $normaFile, $idUsuario,$tipoPruebaEspecial, $otroPrueba, $especificaciones, $descMateriales, $cdadMateriales, $fechaSolicitud, $id_prueba);

} else {
    //$response = array("error" => "<script>alert('Error: Faltan datos en el formulario')</script>");
    echo json_encode(array("error" => "<script>alert('Error: Faltan datos en el formulario')</script>"));

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


