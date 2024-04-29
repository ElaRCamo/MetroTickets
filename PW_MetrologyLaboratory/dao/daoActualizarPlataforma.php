<?php

include_once('connection.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['descPlataformaE']) && $_POST['descPClienteE'] && $_POST['id_plataforma']){
        $descripcion = $_POST['descPlataformaE'];
        $id_cliente = $_POST['descPClienteE'];
        $id_plataforma = $_POST['id_plataforma'];
        actualizarPlataforma($id_plataforma,$descripcion, $id_cliente);
    }else{
        $respuesta = array("success" => false, "message" => "Faltan datos");
        echo json_encode($respuesta);
    }
} else {
    $respuesta = array("success" => false, "message" => "Se esperaba REQUEST_METHOD");
    echo json_encode($respuesta);
}

function actualizarPlataforma($id_plataforma,$descripcion, $id_cliente)
{
    $con = new LocalConector();
    $conex = $con->conectar();

    $stmt = $conex->prepare("UPDATE Plataforma
                                      SET descripcionPlataforma = ?, id_cliente = ?
                                    WHERE id_plataforma = ?");
    $stmt->bind_param("sii", $descripcion, $id_cliente, $id_plataforma);

    if ($stmt->execute()) {
        $respuesta = array("success" => true, "message" => "Plataforma actualizada.");
        echo json_encode($respuesta);
    } else {
        $respuesta = array("success" => false, "message" => "Error.");
        echo json_encode($respuesta);
    }
    $stmt->close();
    $conex->close();

}
?>