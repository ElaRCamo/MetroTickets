<?php

include_once('connection.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_GET['id_cliente'])){
        // Obtiene el valor del parámetro id_cliente
        $id_cliente = $_GET['id_cliente'];
        desactivarCliente($id_cliente);
    }else{
        $respuesta = array("success" => false, "message" => "ID de cliente no proporcionado.");
        echo json_encode($respuesta);
    }
} else {
    $respuesta = array("success" => false, "message" => "Se esperaba REQUEST_METHOD");
    echo json_encode($respuesta);
}

function desactivarCliente($id_cliente)
{
    $con = new LocalConector();
    $conex = $con->conectar();

    $stmt = $conex->prepare("UPDATE Cliente
                                      SET estatus = 1
                                    WHERE id_cliente = ?");
    $stmt->bind_param("i", $id_cliente);

    if ($stmt->execute()) {
        $respuesta = array("success" => true, "message" => "Cliente activado");
        echo json_encode($respuesta);
    } else {
        $respuesta = array("success" => false, "message" => "Error.");
        echo json_encode($respuesta);
    }
    $stmt->close();
    $conex->close();

}
