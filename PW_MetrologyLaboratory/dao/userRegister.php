<?php
include_once('connection.php');
include_once( 'daoUsuario.php');

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
exit;
function RegistrarUsuario($nombreUsuario, $correo, $Nomina, $password)
{
    $passwordS = sha1($password);
    $numNomina    = str_pad($Nomina, 8, "0", STR_PAD_LEFT);
    $usuarioExiste = Usuario($numNomina);
    $correoRegistrado = verificarCorreo($correo);

    if ($usuarioExiste['success']) {
        $response = array('status' => 'error', 'message' => 'El usuario ya existe, verifique sus datos.');
    }else if ($correoRegistrado) {
        $response = array('status' => 'error', 'message' => 'El correo proporcionado ya se encuentra registrado.');
    } else {
        $con = new LocalConector();
        $conex = $con->conectar();

        $insertUsuario =  $conex->prepare("INSERT INTO `Usuario` (`id_usuario`, `nombreUsuario`, `correoElectronico`, `passwordHash`) 
                               VALUES (?,?,?,?)");
        $insertUsuario->bind_param("ssss", $numNomina,$nombreUsuario,$correo,$passwordS);
        $resultado = $insertUsuario->execute();
        // Cerrar la conexión
        $conex->close();

        if(!$resultado) {
            $response = array('status' => 'error', 'message' => 'Error al registrar el usuario');
        } else {
            $response = array('status' => 'success', 'message' => 'Usuario registrado exitosamente');
        }
    }
    return $response;
}

function verificarCorreo($correo)
{
    $con = new LocalConector();
    $conexion = $con->conectar();
    $correo = mysqli_real_escape_string($conexion, $correo);

    $consP = "SELECT COUNT(id_usuario) AS existeUsuario FROM Usuario WHERE correoElectronico = '$correo'";
    $rsconsPro = mysqli_query($conexion, $consP);

    // Verificar si se encontró algún resultado
    if ($rsconsPro && mysqli_num_rows($rsconsPro) == 1) {
        $row = mysqli_fetch_assoc($rsconsPro);
        $existeUsuario = $row['existeUsuario'];
        mysqli_free_result($rsconsPro); // Liberar el resultado
        mysqli_close($conexion); // Cerrar la conexión después de usarla

        // Retornar true si no existe el usuario con el correo dado, false si existe
        $response = ($existeUsuario === '0');
    } else {
        mysqli_close($conexion); // Cerrar la conexión en caso de error
        $response = false; // Retornar false si no se pudo ejecutar la consulta
    }
    return $response;
}

?>