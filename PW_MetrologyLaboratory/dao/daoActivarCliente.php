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

    // Iniciar transacción
    $conex->begin_transaction();

    $stmt1 = $conex->prepare("UPDATE Cliente SET estatus = 1 WHERE id_cliente = ?");
    $stmt1->bind_param("i", $id_cliente);

    $stmt2 = $conex->prepare("UPDATE Plataforma P
                                    JOIN DescripcionMaterial M ON P.id_plataforma = M.id_plataforma
                                    SET P.estatus = 1,
                                        M.estatus = 1
                                    WHERE P.id_cliente = ?");
    $stmt2->bind_param("i", $id_cliente);

    $success = $stmt1->execute() && $stmt2->execute();

    if ($success) {
        // Commit si todas las consultas se ejecutaron correctamente
        $conex->commit();
        $respuesta = array("success" => true, "message" => "Cliente desactivado");
    } else {
        // Rollback en caso de error
        $conex->rollback();
        $respuesta = array("success" => false, "message" => "Error.");
    }

    echo json_encode($respuesta);

    $stmt1->close();
    $stmt2->close();
    $conex->close();
}
?>