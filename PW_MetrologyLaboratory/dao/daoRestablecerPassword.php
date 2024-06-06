<?php
header('Content-Type: application/json');
include_once('connection.php');

if(isset($_POST['newPassword'], $_POST['token'], $_POST['id_usuario']) ){
    $token = $_POST['token'];
    $nomina = $_POST['id_usuario'];
    $tokenValido = validarToken($token, $nomina);

    if($tokenValido){
        $newPassword = $_POST['newPassword'];
        $passwordH = sha1($newPassword);
        $response = actualizarPassword($nomina, $passwordH);
    }else{
        $response = array('status' => 'error', 'message' => 'Error:No se encontró solicitud.');
    }
}else {
    $response = array('status' => 'error', 'message' => 'Error:Enlace no válido');
}

echo json_encode($response);

function validarToken($token, $nomina){
    $con = new LocalConector();
    $conexion=$con->conectar();

    $datos = mysqli_query($conexion, "SELECT tokenValido
                                            FROM restablecer_password 
                                            WHERE id_usuario = '$nomina'
                                            AND token = '$token'
                                            AND expira < NOW()");
    if ($datos) {
        $resultado = mysqli_fetch_assoc($datos);
            if ($resultado && $resultado['tokenValido'] == 1) {
                $conexion->close();
                return true;
            } else {
                $conexion->close();
                return false;
            }
    } else {
        $conexion->close();
        return array('status' => 'error', 'message' => 'Error: No se pudo consultar token.');
    }
}

function actualizarPassword($nomina, $newPassword)
{
    $con = new LocalConector();
    $conex = $con->conectar();

    $conex->begin_transaction();

    // Actualizar la contraseña
    $actPassword = $conex->prepare("UPDATE Usuario SET passwordHash = ? WHERE id_usuario = ?");
    $actPassword->bind_param("ss", $newPassword, $nomina);
    $resActPassword = $actPassword->execute();

    // Cerrar la sentencia preparada
    $actPassword->close();

    // Invalidar el token
    $actToken = $conex->prepare("UPDATE restablecer_password SET tokenValido = 0 WHERE id_usuario = ?");
    $actToken->bind_param("s", $nomina);
    $resActToken = $actToken->execute();

    // Cerrar la sentencia preparada
    $actToken->close();

    // Confirmar o hacer rollback de la transacción
    if(!$resActPassword || !$resActToken) {
        $conex->rollback();
        $conex->close();
        return array('status' => 'error', 'message' => 'Error: No se pudo actualizar la información.');
    } else {
        $conex->commit();
        $conex->close();
        return array('status' => 'success', 'message' => 'Contraseña actualizada.');
    }
}
?>