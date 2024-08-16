<?php
header('Content-Type: application/json');
include_once('connection.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['descPlataformaE']) && $_POST['descPClienteE'] && $_POST['id_plataforma']){
        $descripcion = $_POST['descPlataformaE'];
        $id_cliente = $_POST['descPClienteE'];
        $id_plataforma = $_POST['id_plataforma'];
        $response = actualizarPlataforma($id_plataforma,$descripcion, $id_cliente);
    }else{
        $response = array('status' => 'error', 'message' => 'Error: Faltan datos en el formulario.');
    }
} else {
    $response = array('status' => 'error', 'message' => 'Error: Se esperaba REQUEST_METHOD');
}
echo json_encode($response);
function actualizarPlataforma($id_plataforma,$descripcion, $id_cliente)
{
    $con = new LocalConector();
    $conex = $con->conectar();

    $stmt = $conex->prepare("UPDATE Plataforma
                                      SET descripcionPlataforma = ?, id_cliente = ?
                                    WHERE id_plataforma = ?");
    $stmt->bind_param("sii", $descripcion, $id_cliente, $id_plataforma);

    if ($stmt->execute()) {
        $stmt->close();
        $conex->close();
        return array('status' => 'success', 'message' => 'Plataforma actualizada.');
    } else {
        $stmt->close();
        $conex->close();
        return array('status' => 'success', 'message' => 'Error al hacer la actualización.');
    }
}
?>