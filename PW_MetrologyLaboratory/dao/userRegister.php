<?php
include_once('connection.php');
require 'daoUsuario.php';
header('Content-Type: application/json');

if(isset($_POST['nombreUsuario'], $_POST['correo'], $_POST['numNomina'], $_POST['password'])) {

    $nombreUsuario = $_POST['nombreUsuario'];
    $correo        = $_POST['correo'];
    $Nomina        = $_POST['numNomina'];
    $password      = $_POST['password'];

    $response = RegistrarUsuario($nombreUsuario, $correo, $Nomina, $password);

} else {
    $response = array('status' => 'error', 'message' => 'Error: Faltan datos en el formulario');
}

echo json_encode($response);
function RegistrarUsuario($nombreUsuario, $correo, $Nomina, $password)
{
    $passwordS = sha1($password);
    $Nomina    = str_pad($Nomina, 8, "0", STR_PAD_LEFT);
    $resultado = Usuario($Nomina);

    if ($resultado['success']) {
        return array('status' => 'error', 'message' => 'El usuario ya existe, verifique sus datos');
    } else {
        $con = new LocalConector();
        $conex = $con->conectar();

        $insertUsuario = "INSERT INTO `Usuario` (`id_usuario`, `nombreUsuario`, `correoElectronico`, `passwordHash`) 
                               VALUES ('$Nomina', '$nombreUsuario', '$correo', '$passwordS')";
        $rInsertUsuario = mysqli_query($conex, $insertUsuario);

        mysqli_close($conex);

        if (!$rInsertUsuario) {
            return array('status' => 'error', 'message' => 'Error al registrar el usuario');
        } else {
            return array('status' => 'success', 'message' => 'Usuario registrado exitosamente');
        }
    }
}
?>