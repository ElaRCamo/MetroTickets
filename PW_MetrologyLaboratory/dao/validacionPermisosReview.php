<?php
require_once('daoConsultarSolicitante.php');

session_start();
$nombreUser = $_SESSION['nombreUsuario'];
$tipoUser = $_SESSION['tipoUsuario'];
$idUsuario = $_SESSION['nomina'];
$fotoUsuario = $_SESSION['fotoUsuario'];

$solicitante = "No aplica";

if ($tipoUser == null) {
    header("Location: https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/sesion/indexSesion.php");
    exit();
} else if ($tipoUser == 3) {
    // Obtener la parte de la consulta de la URL actual
    $queryString = $_SERVER['QUERY_STRING'];

    // Obtener los parámetros de la consulta en un array asociativo
    parse_str($queryString, $params);

    // Verificar si existe el parámetro id_prueba y obtener su valor
    if (isset($params['id_prueba'])) {
        $id_prueba = $params['id_prueba'];

        $consultaSolicitante = consultarSolicitante($id_prueba);

        // Verificar y manejar la respuesta de la consulta
        if ($consultaSolicitante['status'] == 'success') {
            $solicitante = $consultaSolicitante['id_solicitante'];
        } else {
            $solicitante = "No se encontró solicitante";
        }
    }
}

if ($idUsuario !== $solicitante) {
    header("Location: https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/requests/requestsIndex.php");
    exit();
}
?>