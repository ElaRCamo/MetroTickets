<?php
include_once('connection.php');

$tipoEvaluacion = $_POST['tipoEvaluacion'];
$tipoPrueba     = $_POST['tipoPrueba'];
$norma          = $_POST['norma'];
$normaFile      = $_POST['normaFile'];
$tipoPruebaEspecial = $_POST['tipoPruebaEspecial'];
$otroPrueba         = $_POST['otroPrueba'];
$numPiezas          = $_POST['numPiezas'];
$especificaciones   = $_POST['especificaciones'];

// Para agregar material por número de parte
$numParte           = $_POST['numParte'];
$cliente            = $_POST['cliente'];
$plataforma         = $_POST['plataforma'];
$descMaterial       = $_POST['descMaterial'];
$cdadMaterial       = $_POST['cdadMaterial'];


function RegistrarSolicitud($tipoEvaluacion ,$tipoPrueba)
{
    $con = new LocalConector();
    $conex = $con->conectar();





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