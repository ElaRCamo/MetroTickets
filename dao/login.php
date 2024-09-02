<?php

require 'daoUsuario.php';

if(isset($_POST['iniciarSesionBtn'])){

    session_start();
    $Nomina = $_POST['numNomina'];

    if (strlen($Nomina) < 8) { //Validar los ceros (8 digitos)
        $Nomina = str_pad($Nomina, 8, "0", STR_PAD_LEFT);
    }

    $resultado = Usuario($Nomina);

    if($resultado['success']){
        $_SESSION['numNomina'] = $Nomina;
        $_SESSION['password'] = $_POST['password'];
        $_SESSION['nombreUsuario']= $resultado['nombreUsuario'];
        $_SESSION['tipoUsuario']= $resultado['tipoUsuario'];
        $_SESSION['nomina']= $resultado['idUser'];
        $_SESSION['emailUsuario']= $resultado['emailUsuario'];
        $_SESSION['fotoUsuario']= $resultado['foto'];
        $_SESSION['estatus']= $resultado['estatus'];

        $password_bd = $resultado['password_bd'];
        $tipoUsuario = $_SESSION['tipoUsuario'];
        $estatusUsuario = $_SESSION['estatus'];

        $passwordS = sha1($_POST['password']);

        if($password_bd == $passwordS){
            if($estatusUsuario == 1){
                header("Location: ../index.php");
            }else{
                echo "<script>alert('Sus credenciales estan desactivadas, debe contactar al administrador del laborattorio.')</script>";
            }
        } else {
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='1; URL=https://grammermx.com/Metrologia/MetroTickets\modules\sesion\indexSesion.php'>";
            echo "<script>alert('Contraseña incorrecta, verifique sus datos')</script>";
        }
    }else{
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='1; URL=https://grammermx.com/Metrologia/MetroTickets/modules\sesion\indexSesion.php'>";
        echo "<script>alert('El usuario no existe')</script>";
    }
}

if(isset($_POST['cerrarSesion']) || (isset($_POST['cerrarS']))){
    session_start();
    session_destroy();
    echo "<script>alert('Sesión cerrada exitosamente')</script>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='1; URL=https://grammermx.com/Metrologia/MetroTickets/modules\sesion\indexSesion.php'>";
}

?>