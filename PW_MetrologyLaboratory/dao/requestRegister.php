<?php
include_once('connection.php');
session_start();
$idUsuario      = $_SESSION['nomina'];
$tipoPrueba     = $_POST['tipoPrueba'];
$norma          = $_POST['norma'];
$normaFile      = $_POST['normaFile'];
//$tipoPruebaEspecial = $_POST['tipoPruebaEspecial'];
//$otroPrueba         = $_POST['otroPrueba'];
//$numPiezas          = $_POST['numPiezas'];
$especificaciones   = $_POST['especificaciones'];

// Para agregar material por número de parte
$numParte           = $_POST['numParte'];
$descMaterial       = $_POST['descMaterial'];
$cdadMaterial       = $_POST['cdadMaterial'];
$id_prueba          = $_POST['id_prueba'];
$fechaSolicitud     = $_POST['fechaSolicitud'];
//$tipoPruebaEspecial, $otroPrueba, $numPiezas,

RegistrarSolicitud($tipoPrueba, $norma, $normaFile, $idUsuario, $especificaciones,  $numParte, $descMaterial, $cdadMaterial, $fechaSolicitud, $id_prueba);
echo '<script>alert("RegistrarSolicitud: ".$idUsuario.")"</script>';
function RegistrarSolicitud($tipoPrueba, $norma, $normaFile, $idUsuario, $especificaciones,  $numParte, $descMaterial, $cdadMaterial, $fechaSolicitud, $id_prueba)
{
    $con = new LocalConector();
    $conex = $con->conectar();

    $insertSolicitud = "INSERT INTO `Prueba` (`id_prueba`, `fechaSolicitud`,  `especificaciones`, `normaNombre`, `normaArchivo`, `id_solicitante`, `id_tipoPrueba`) 
                        VALUES ('$id_prueba', '$fechaSolicitud',  '$especificaciones', '$norma', '$normaFile', $idUsuario, '$tipoPrueba');";
    $rInsertSolicitud = mysqli_query($conex,$insertSolicitud);
    $insertMaterial = "INSERT INTO `Material` (`id_prueba`, `numDeParte`, `cantidad`, `id_descripcion`) 
                        VALUES ('$id_prueba', '$numParte ', '$cdadMaterial', '$descMaterial');";
    $rInsertMaterial  = mysqli_query($conex,$insertMaterial);
    mysqli_close($conex);

    if(!$rInsertSolicitud && $rInsertMaterial){
        echo '<script>alert("Error al registrar la solicitud")</script>';
        return 0;
    }else{
        echo '<script>alert("Solicitud registrada exitosamente")</script>';
        return 1;
    }
}
?>
/*
include('php/conexion.php');
if (isset($_POST['nombres'])) {
    foreach ($_POST['nombres'] as $indice => $nombre) {
        $apellido = $_POST['apellidos'][$indice];
        $consulta_sql = "INSERT INTO usuarios SET nombre='$nombre', apellido='$apellido'";

        mysqli_query($cnx, $consulta_sql);
    }
}
header("Location: index.php");
/*


/*
INSERT INTO `SolicitudPrueba` (`id_prueba`, `fechaSolicitud`, `fechaRespuesta`, `ubicacionArchivos`, `especificaciones`, `normaNombre`, `normaArchivo`, `id_estatusPrueba`, `id_administrador`, `id_solicitante`, `id_metrologo`, `id_tipoPrueba`, `id_prioridad`)
VALUES ('2024-0001', '2024-03-11', '2024-03-12', '', '', '', '', '3', '00030293', '00042563', '00030298', '1', '3');
*/