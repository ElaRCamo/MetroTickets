<?php

include_once('connection.php');

$inputJSON = file_get_contents('php://input');
// Decodifica los datos JSON en un array asociativo
$input = json_decode($inputJSON, TRUE);

// Verifica si el id_cliente está presente en los datos recibidos
if(isset($input["id_cliente"])){
    $id_cliente = $input["id_cliente"];
    desactivarCliente($id_cliente);
} else {
    // Si el id_cliente no está presente en los datos recibidos, envía una respuesta de error
    $respuesta = array("success" => false, "message" => "ID de cliente no proporcionado.");
    echo json_encode($respuesta);
}

function desactivarCliente($id_cliente)
{
    $con = new LocalConector();
    $conex = $con->conectar();

    $stmt = $conex->prepare("UPDATE Cliente
                                      SET estatus = 0
                                    WHERE id_cliente = ?");
    $stmt->bind_param("i", $id_cliente);

    if ($stmt->execute()) {
        $respuesta = array("success" => true, "message" => "Cliente desactivado");
        echo json_encode($respuesta);
    } else {
        $respuesta = array("success" => false, "message" => "Error al eliminar el registro.");
        echo json_encode($respuesta);
    }
    $stmt->close();
    $conex->close();

}

?>