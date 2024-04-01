<?php
include_once('connection.php');

$numNomina     = $_POST['numNomina'];
$nombreUsuario = $_POST['nombreUsuario'];
$correo        = $_POST['correo'];
$password      = $_POST['password'];

RegistrarUsuario($numNomina ,$nombreUsuario, $correo, $password);
function RegistrarUsuario($numNomina ,$nombreUsuario, $correo, $password){
    $con = new LocalConector();
    $conex = $con->conectar();

    $passwordS = sha1($password);
    $Nomina = str_pad($numNomina, 8, "0", STR_PAD_LEFT);

    $insertUsuario = "INSERT INTO `Usuario` (`id_usuario`, `nombreUsuario`, `correoElectronico`, `passwordHash`) VALUES ('$Nomina', '$nombreUsuario', '$correo', '$passwordS')";
    $rInsertUsuario = mysqli_query($conex,$insertUsuario);
    mysqli_close($conex);

    if(!$rInsertUsuario){
        echo '<script>alert("Error al registrar el usuario")</script>';
        return 0;
    }else{
        echo '<script>alert("Usuario registrado exitosamente")</script>';
        return 1;
    }
}
?>

