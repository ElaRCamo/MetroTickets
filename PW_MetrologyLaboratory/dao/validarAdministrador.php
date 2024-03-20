<?php
session_start();
require_once('daoUsuario.php');

if (!isset($_SESSION["numNomina"]) || !isset($_SESSION["password"])) {
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='1; URL=https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/sesion/indexSesion.php'>";
    session_destroy();
} else {
    $Nomina = $_SESSION["numNomina"];
    $Password = $_SESSION["password"];

    $resultado = Usuario($Nomina, $Password);

    if($resultado['success']){
        $tipoUsuario = $resultado['tipoUsuario'];
        if($tipoUsuario == 1){
            // No hacemos ninguna redirección para el tipo de usuario 1
            echo "<script>alert('Acceso correcto')</script>";
        } elseif ($tipoUsuario == 2){
            header("Location: ../modules/requests/requestsIndex.php");
        } elseif ($tipoUsuario == 3){
            header("Location: ../modules/newRequest/newRequestIndex.php");
        }
    } else {
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='1; URL=https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/sesion/indexSesion.php'>";
        echo "<script>alert('Acceso Denegado')</script>";
    }
}
?>