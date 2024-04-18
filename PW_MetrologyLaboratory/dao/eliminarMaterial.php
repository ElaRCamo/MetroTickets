<?php

include_once('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $id_cliente = $_POST["id_cliente"];

    $con = new LocalConector();
    $conex = $con->conectar();

    if (!$conex) {   // Verificar la conexión a la base de datos
        $respuesta = array("success" => false, "message" => "Error al conectar a la base de datos.");
        echo json_encode($respuesta);
        exit;
    }

    $stmt = $conex->prepare("DELETE FROM Cliente WHERE id_cliente = ?");
    $stmt->bind_param("s", $id_cliente);

    if ($stmt->execute()) {
        $respuesta = array("success" => true, "message" => "El registro se eliminó correctamente.");
        echo json_encode($respuesta);
    } else {
        $respuesta = array("success" => false, "message" => "Error al eliminar el registro.");
        echo json_encode($respuesta);
    }
    $stmt->close();
    $conex->close();

} else {
    $respuesta = array("success" => false, "message" => "Se esperaba una solicitud POST.");
    echo json_encode($respuesta);
}

?>