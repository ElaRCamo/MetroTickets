<?php

require 'daoUsuario.php';

if(isset($_POST['iniciarSesionBtn'])){

    session_start();
    $Nomina = $_POST['numNomina'];
    $Password=$_POST['password'];

    if (strlen($Nomina) == 1) { $Nomina = "0000000".$Nomina; }
    if (strlen($Nomina) == 2) { $Nomina = "000000".$Nomina; }
    if (strlen($Nomina) == 3) { $Nomina = "00000".$Nomina; }
    if (strlen($Nomina) == 4) { $Nomina = "0000".$Nomina; }
    if (strlen($Nomina) == 5) { $Nomina = "000".$Nomina; }
    if (strlen($Nomina) == 6) { $Nomina = "00".$Nomina; }
    if (strlen($Nomina) == 7) { $Nomina = "0".$Nomina; }

    $resultado = Usuario($Nomina, $Password);

    if($resultado['success']){
        $_SESSION['numNomina'] = $Nomina;
        $_SESSIOM['password'] = $Password;
        $tipoUsuario = $resultado['tipoUsuario'];

        if($tipoUsuario == 1){
            header("Location: ../index.php");
        }elseif ($tipoUsuario == 2){
            header("Location: ../modules/requests/requestsIndex.php");
        }elseif ($tipoUsuario == 3){
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='1; URL=../modules/newRequest/newRequestIndex.php'>";
        }
        echo "<script>alert('Acceso correcto')</script>";
    }else{
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='1; URL=../modules/sesion/indexSesion.php'>";
        echo "<script>alert('Acceso Denegado')</script>";
    }
}

if(isset($_POST['cerrarSesion']) || (isset($_POST['cerrarS']))){
    session_start();
    session_destroy();
    echo "<script>alert('Sesión cerrada exitosamente')</script>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='1; URL=https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory\index.php'>";
}

?>