<?php

include_once('connection.php');


$id_cliente = $_POST["id_cliente"];
desactivarCliente($id_cliente);
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