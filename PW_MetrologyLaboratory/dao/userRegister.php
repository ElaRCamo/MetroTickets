<?php
include_once('connection.php');

$numNomina     = $_POST['numNomina'];
$nombreUsuario = $_POST['nombreUsuario'];
$correo        = $_POST['correo'];
$password      = $_POST['password'];
if($numNomina!=null && $nombreUsuario!=null && $correo != null&& $password!=null  ){
    echo '<script>alert("' . $numNomina . $nombreUsuario . $correo . $password . '")</script>';
}

RegistrarUsuario($numNomina ,$nombreUsuario, $correo, $password);

function RegistrarUsuario($numNomina ,$nombreUsuario, $correo, $password){
    $con = new LocalConector();
    $conex = $con->conectar();

    $insertUsuario = "INSERT INTO `Usuario` (`id_usuario`, `nombreUsuario`, `correoElectronico`, `passwordHash`) VALUES ('$numNomina', '$nombreUsuario', '$correo', '$password');";

    echo '<script>alert("' . $insertUsuario . '")</script>';
    $rInsertUsuario = mysqli_query($conex,$insertUsuario);
    mysqli_close($conex);

    if(!$rInsertUsuario){
        echo '<div class="alerta">Error al registrar el usuario</div>';
    }

    //echo '<script>alert("Usuario registrado exitosamente"); window.location.href = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/sesion/Index.php";</script>';
    return 1;
}

?>

