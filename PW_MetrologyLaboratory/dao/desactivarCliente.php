<?php

include_once('connection.php');

// Verifica si el parámetro id_cliente se ha enviado en la URL
if(isset($_GET['id_cliente'])) {
    // Obtiene el valor del parámetro id_cliente
    $id_cliente = $_GET['id_cliente'];

    // Puedes usar $id_cliente en tus operaciones de PHP
    echo "El ID del cliente es: " . $id_cliente;
} else {
    echo "No se ha proporcionado un ID de cliente";
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