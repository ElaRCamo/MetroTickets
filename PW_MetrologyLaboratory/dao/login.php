<?php

require 'daoUsuario.php';

if(isset($_POST['iniciarSesionBtn'])){

    session_start();
    $Nomina = $_POST['numNomina'];
    $Password=$_POST['password'];

    if (strlen($Nomina) < 8) { //Validar los ceros (8 digitos)
        $Nomina = str_pad($Nomina, 8, "0", STR_PAD_LEFT);
    }

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
            header("Location: ../modules/newRequest/newRequestIndex.php");
        }
        echo "<script>alert('Acceso correcto')</script>";
    }else{
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='1; URL=https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory\modules\sesion\indexSesion.php'>";
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