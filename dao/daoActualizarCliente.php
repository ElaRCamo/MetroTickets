<?php

include_once('connection.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['id_cliente']) && $_POST['descClienteE']){
        $descripcion = $_POST['descClienteE'];
        // Obtiene el valor del parámetro id_cliente
        $id_cliente = $_POST['id_cliente'];
        desactivarCliente($id_cliente, $descripcion);
    }else{
        $respuesta = array("success" => false, "message" => "Faltan datos");
        echo json_encode($respuesta);
    }
} else {
    $respuesta = array("success" => false, "message" => "Se esperaba REQUEST_METHOD");
    echo json_encode($respuesta);
}

function desactivarCliente($id_cliente, $descripcion)
{
    $con = new LocalConector();
    $conex = $con->conectar();

    $stmt = $conex->prepare("UPDATE Cliente
                                      SET descripcionCliente = ?
                                    WHERE id_cliente = ?");
    $stmt->bind_param("si", $descripcion, $id_cliente);

    if ($stmt->execute()) {
        $respuesta = array("success" => true, "message" => "Cliente actualizado.");
        echo json_encode($respuesta);
    } else {
        $respuesta = array("success" => false, "message" => "Error.");
        echo json_encode($respuesta);
    }
    $stmt->close();
    $conex->close();

}
?>