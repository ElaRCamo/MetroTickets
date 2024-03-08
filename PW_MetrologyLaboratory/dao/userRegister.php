<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('connection.php');


if(!empty($_POST["registrarseForm"])){
    if(empty($_POST['nombreUsuario'])){
        echo '<div class="alerta">Por favor introduzca su nombre</div>';
    }elseif (empty($_POST['correo'])){
        echo '<div class="alerta">Por favor introduzca su correo</div>';
    }elseif (empty($_POST['numNomina'])){
        echo '<div class="alerta">Por favor introduzca su número de nómina</div>';
    }elseif (empty($_POST['password'])){
        echo '<div class="alerta">Por favor introduzca su contraseña</div>';
    }
}

$numNomina     = $_POST['numNomina'];
$nombreUsuario = $_POST['nombreUsuario'];
$correo        = $_POST['correo'];
$password      = $_POST['password'];

RegistrarUsuario($numNomina ,$nombreUsuario, $correo, $password);

function RegistrarUsuario($numNomina ,$nombreUsuario, $correo, $password){
    $con = new LocalConector();
    $conex = $con->conectar();

    $insertUsuario = "INSERT INTO `Usuario` (`id_usuario`, `nombreUsuario`, `correoElectronico`, `passwordHash`) VALUES ('$numNomina', '$nombreUsuario', '$correo', '$password');";
    $rInsertUsuario = mysqli_query($conex,$insertUsuario);
    mysqli_close($conex);

    if(!$rInsertUsuario){
        echo '<div class="alerta">Error al registrar el usuario</div>';
    }else{
        echo '<script>alert("Usuario registrado exitosamente"); window.location.href = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/sesion/Index.php";</script>';
        exit();
    }

}



