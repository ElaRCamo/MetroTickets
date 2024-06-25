<?php
header('Content-Type: application/json');
include_once('connection.php');
require_once __DIR__ . '/../Mailer/MailerFunctionNewEmail.php';
session_start();
$id_prueba="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el contenido de la solicitud
    $json = file_get_contents('php://input');

    // Decodificar el JSON a un objeto PHP
    $data = json_decode($json, true);

    // Verificar si la decodificación fue exitosa y si se recibió el id_prueba
    if (json_last_error() === JSON_ERROR_NONE && isset($data['id_prueba'])) {
        $id_prueba = $data['id_prueba'];

        // Validar id_prueba según la nomenclatura especificada
        if (preg_match('/^\d{4}-\d{4}$/', $id_prueba)) { //Formato del id_prueba = "YYYY-XXXX"
            try {
                $response = cancelarSolicitud($id_prueba);
                if ($response['status'] === 'success') {
                    $asunto = "Solicitud cancelada: Folio ".$id_prueba;
                    $mensaje = "Te informamos que de acuerdo con tu petición, la solicitud con<br><strong>FOLIO: $id_prueba</strong><br>ha sido exitosamente cancelada.<br>";
                    $response =  newEmail( $_SESSION['nombreUsuario'],$_SESSION['emailUsuario'], $asunto, $mensaje);
                }
            } catch (Exception $e) {
                $response = array('status' => 'error', 'message' => 'Error al procesar la solicitud: ' . $e->getMessage());
            }
        } else {
            $response = array('status' => 'error', 'message' => 'id_prueba inválido. Formato esperado: YYYY-XXXX');
        }
    } else {
        $response = array('status' => 'error', 'message' => 'JSON inválido o id_prueba no encontrado');
    }
} else {
    $response = array('status' => 'error', 'message' => 'Se esperaba REQUEST_METHOD POST');
}
echo json_encode($response);


function cancelarSolicitud($id_prueba)
{
    // Crear la conexión
    $con = new LocalConector();
    $conex = $con->conectar();

    // Preparar la sentencia
    $stmt = $conex->prepare("UPDATE Prueba SET id_estatusPrueba = 6 WHERE id_prueba = ?");
    $stmt->bind_param("s", $id_prueba);

    // Ejecutar la sentencia y verificar el resultado
    if ($stmt->execute()) {
        $response = array("status" => "success", "message" => "Solicitud exitosamente cancelada.");

    } else {
        $response = array("status" => "error", "message" => "Error al cancelar la solicitud.");
    }

    // Cerrar la sentencia y la conexión
    $stmt->close();
    $conex->close();

    // Retornar la respuesta
    return $response;
}
?>