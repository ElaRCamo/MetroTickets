<?php

include_once('connection.php');
include_once('..\Mailer\MailerRecuperarPassword.php');


if(isset($_POST['correoRecuperacion']) ){

    $correo = $_POST['correoRecuperacion'];
    $user = consultarIdUsuario($correo);

    if ($user) {
        $userId = $user['id_usuario'];
        $tokenResponse = generarToken($userId);

        if ($tokenResponse['status'] === 'success') {
            $token = $tokenResponse['token'];
            $enlace = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/sesion/restablecerPassword.php?token=$token";
            $mensaje = "Hola, para restablecer tu contraseña haz clic en el siguiente enlace: $enlace";
            $asunto = "Recuperar contraseña";

            // Enviar el correo electrónico
            $correoResponse = emailRecuperarPassword($correo, $asunto, $mensaje);

            // Combinar la respuesta del correo con la respuesta final
            if ($correoResponse['status'] === 'success') {
                $response = array('status' => 'success', 'message' => 'Se ha enviado un correo para recuperar tu contraseña.');
            } else {
                $response = $correoResponse;
            }
        } else {
            $response = $tokenResponse; // Retorna el error de generación del token
        }
    } else {
        $response = array('status' => 'error', 'message' => 'Correo electrónico no registrado');
    }
} else {
    $response = array('status' => 'error', 'message' => 'Error: Faltan datos en el formulario');
}

echo json_encode($response);

function consultarIdUsuario($correo){
    $con = new LocalConector();
    $conexion=$con->conectar();

    $datos = mysqli_query($conexion, "SELECT id_usuario
                                            FROM Usuario 
                                            WHERE correoElectronico = '$correo';");

    if ($datos) {
        $resultado = mysqli_fetch_assoc($datos);
        $conexion->close();
        return $resultado; // Retorna un array asociativo con los datos del usuario
    } else {
        $conexion->close();
        return null;
    }

}

function generarToken($userId) {
    // Conectar a la base de datos para guardar el token
    $con = new LocalConector();
    $conexion = $con->conectar();

    $token = bin2hex(random_bytes(16));
    $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));

    // Guardar el token en la base de datos
    $stmt = $conexion->prepare('INSERT INTO restablecer_password (user_id, token, expira) VALUES (?, ?, ?)');
    $stmt->bind_param('iss', $userId, $token, $expira);

    if ($stmt->execute()) {
        $stmt->close();
        $conexion->close();
        return array('status' => 'success', 'token' => $token);
    } else {
        $stmt->close();
        $conexion->close();
        return array('status' => 'error', 'message' => 'Error: No se ha podido generar el token.');
    }
}

?>


?>
