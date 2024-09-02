<?php
require 'daoUsuario.php';

if(isset($_POST['iniciarSesionBtn'])){

    session_start();
    $Nomina = $_POST['numNomina'];

    if (strlen($Nomina) < 8) { // Validar los ceros (8 dígitos)
        $Nomina = str_pad($Nomina, 8, "0", STR_PAD_LEFT);
    }

    $resultado = Usuario($Nomina);

    if($resultado['success']){
        $_SESSION['numNomina'] = $Nomina;
        $_SESSION['password'] = $_POST['password'];
        $_SESSION['nombreUsuario'] = $resultado['nombreUsuario'];
        $_SESSION['tipoUsuario'] = $resultado['tipoUsuario'];
        $_SESSION['nomina'] = $resultado['idUser'];
        $_SESSION['emailUsuario'] = $resultado['emailUsuario'];
        $_SESSION['fotoUsuario'] = $resultado['foto'];
        $_SESSION['estatus'] = $resultado['estatus'];

        $password_bd = $resultado['password_bd'];
        $tipoUsuario = $_SESSION['tipoUsuario'];
        $estatusUsuario = $_SESSION['estatus'];

        $passwordS = sha1($_POST['password']);

        if($password_bd == $passwordS){
            if($estatusUsuario == 1){
                header("Location: ../index.php");
            }else{
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Credenciales desactivadas',
                        text: 'Sus credenciales están desactivadas, debe contactar al administrador del laboratorio.',
                    }).then(function() {
                        window.location.href = 'https://grammermx.com/Metrologia/MetroTickets/modules/sesion/indexSesion.php';
                    });
                </script>";
            }
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Contraseña incorrecta',
                    text: 'Contraseña incorrecta, verifique sus datos.',
                }).then(function() {
                    window.location.href = 'https://grammermx.com/Metrologia/MetroTickets/modules/sesion/indexSesion.php';
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Usuario no encontrado',
                text: 'El usuario no existe.',
            }).then(function() {
                window.location.href = 'https://grammermx.com/Metrologia/MetroTickets/modules/sesion/indexSesion.php';
            });
        </script>";
    }
}

if(isset($_POST['cerrarSesion']) || (isset($_POST['cerrarS']))){
    session_start();
    session_destroy();
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Sesión finalizada',
            text: 'Sesión cerrada exitosamente.',
        }).then(function() {
            window.location.href = 'https://grammermx.com/Metrologia/MetroTickets/modules/sesion/indexSesion.php';
        });
    </script>";
}

?>