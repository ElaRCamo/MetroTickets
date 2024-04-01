<?php
include_once('connection.php');
require 'daoUsuario.php';

// Verificar si los datos están presentes y asignarlos de manera segura
if(isset( $_POST['numNomina'], $_POST['nombreUsuario'], $_POST['correo'], $_POST['password'])) {

    $nombreUsuario = $_POST['nombreUsuario'];
    $correo        = $_POST['correo'];
    $password      =  $_POST['password'];
    $Nomina        = $_POST['numNomina'];

    // Llamar a la función
    if(RegistrarUsuario($Nomina ,$nombreUsuario, $correo, $password)) {
        echo "Usuario registrado exitosamente";
    } else {
        echo "Error al registrar el usuario";
    }
} else {
    echo "Error: Faltan datos en el formulario";
}
function RegistrarUsuario($numNomina ,$nombreUsuario, $correo, $password)
{
    $passwordS = sha1($password);
    $Nomina = str_pad($numNomina, 8, "0", STR_PAD_LEFT);
    $resultado = Usuario($Nomina);

    if ($resultado['success']) {
        http_response_code(302); // Código de respuesta de redirección temporal
        header("Location: https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/sesion/Register.php");
        echo '<script>alert("El usuario ya existe, verifique sus datos")</script>';
        exit; // Salir para asegurar que no se envíe otro contenido
    } else {
        $con = new LocalConector();
        $conex = $con->conectar();

        $insertUsuario = "INSERT INTO `Usuario` (`id_usuario`, `nombreUsuario`, `correoElectronico`, `passwordHash`) VALUES ('$Nomina', '$nombreUsuario', '$correo', '$passwordS')";
        $rInsertUsuario = mysqli_query($conex, $insertUsuario);

        mysqli_close($conex);

        if (!$rInsertUsuario) {
            echo '<script>alert("Error al registrar el usuario")</script>';
            return 0;
        } else {
            echo '<script>alert("Usuario registrado exitosamente")</script>';
            return 1;
        }
    }
}


/*
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

    //Verificar si el usuario ya existe:
    $consP="SELECT id_usuario FROM Usuario WHERE id_usuario = '$Nomina'";
    $rsconsPro=mysqli_query($conex,$consP);

    if(mysqli_num_rows($rsconsPro) == 1){
        echo '<script>alert("El usuario ya existe, verifique sus datos")</script>';
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='1; URL=https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/sesion/Register.php'>";
        return 0;
    }
    else{

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
}*/
?>

