<?php
include_once('connection.php');
session_start();

// Verificar si los datos están presentes y asignarlos de manera segura
if(isset($_POST['tipoPrueba'], $_POST['norma'], $_FILES['normaFile'], $_SESSION['nomina'], $_POST['especificaciones'], $_POST['numParte'], $_POST['descMaterial'], $_POST['cdadMaterial'], $_POST['fechaSolicitud'], $_POST['id_prueba'])) {
    $tipoPrueba = $_POST['tipoPrueba'];
    $norma = $_POST['norma'];

    //guardar los archivos de la norma
    //$normaFile = $_POST['normaFile'];
    $target_dir = "../archivos/";
    $normaFileName = basename($_FILES["normaFile"]["name"]);
    $normaFile = $target_dir . $normaFileName;

    if ($_FILES["normaFile"]["error"] > 0) {
        echo "Error: " . $_FILES["normaFile"]["error"];
    } else {
        // Intenta mover el archivo cargado a la ubicación deseada
        if (move_uploaded_file($_FILES["normaFile"]["tmp_name"], $normaFile)) {
            echo "El archivo " . htmlspecialchars($normaFileName) . " ha sido subido correctamente.";
        } else {
            echo "Hubo un error al subir el archivo.";
        }
    }

    $idUsuario            = $_SESSION['nomina'];
    //$tipoPruebaEspecial = $_POST['tipoPruebaEspecial'];
    //$otroPrueba         = $_POST['otroPrueba'];
    //$numPiezas          = $_POST['numPiezas'];
    $especificaciones = $_POST['especificaciones'];
    $numParte = $_POST['numParte'];
    $descMaterial = $_POST['descMaterial'];
    $cdadMaterial = $_POST['cdadMaterial'];
    $fechaSolicitud = $_POST['fechaSolicitud'];
    $id_prueba = $_POST['id_prueba'];
    //$tipoPruebaEspecial, $otroPrueba, $numPiezas,

    // Llamar a la función
    if(RegistrarSolicitud($tipoPrueba, $norma, $normaFile, $idUsuario, $especificaciones,  $numParte, $descMaterial, $cdadMaterial, $fechaSolicitud, $id_prueba)) {
        echo '<script>alert("Solicitud registrada exitosamente")</script>';
    } else {
        echo '<script>alert("Error al registrar la solicitud")</script>';
    }
} else {
    echo '<script>alert("Error: Faltan datos en el formulario")</script>';
}

function RegistrarSolicitud($tipoPrueba, $norma, $normaFile, $idUsuario, $especificaciones,  $numParte, $descMaterial, $cdadMaterial, $fechaSolicitud, $id_prueba)
{
    $con = new LocalConector();
    $conex = $con->conectar();

    // Consulta preparada para evitar inyección SQL
    $insertSolicitud = $conex->prepare("INSERT INTO `Prueba` (`id_prueba`, `fechaSolicitud`,  `especificaciones`, `normaNombre`, `normaArchivo`, `id_solicitante`, `id_tipoPrueba`) 
                                              VALUES (?, ?, ?, ?, ?, ?, ?)");
    $insertSolicitud->bind_param("ssssssi", $id_prueba, $fechaSolicitud, $especificaciones, $norma, $normaFile, $idUsuario, $tipoPrueba);
    $rInsertSolicitud = $insertSolicitud->execute();

    if(!$rInsertSolicitud) {
        return false;
    }

    $insertMaterial = $conex->prepare("INSERT INTO `Material` (`id_prueba`, `numDeParte`, `cantidad`, `id_descripcion`) 
                                             VALUES (?, ?, ?, ?)");
    $insertMaterial->bind_param("ssii", $id_prueba, $numParte, $cdadMaterial, $descMaterial);
    $rInsertMaterial  = $insertMaterial->execute();

    $conex->close();

    if(!$rInsertMaterial) {
        return false;
    }

    return true;
}
//bind_param(): Es un método de la clase mysqli_stmt que se utiliza para vincular parámetros a la consulta preparada.
//ssssssi": especifica el tipo de datos de los parámetros que se están vinculando(cada "s" indica que el parámetro es una cadena (string) y cada "i" indica que el parámetro es un entero (integer))
?>


