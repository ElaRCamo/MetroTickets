<?php
include_once('connection.php');

if(isset($_POST['descClienteN'])){
    $descCliente = $_POST['descClienteN'];
    // Llamar a la función
    if(nuevoCliente($descCliente)) {
        echo '<script>alert("Cliente registrado exitosamente")</script>';
    } else {
        echo '<script>alert("Error al registrar el cliente")</script>';
    }
} else {
    echo '<script>alert("Error: Faltan datos en el formulario")</script>';
}

function nuevoCliente($descCliente){
    $con = new LocalConector();
    $conex = $con->conectar();

    $insertCliente = $conex->prepare("INSERT INTO Cliente (descripcionCliente) VALUES (?)");
    $insertCliente->bind_param("s", $descCliente);
    $resultado = $insertCliente->execute();

    if(!$resultado) {
        echo "Los datos no se insertaron correctamente.";
        echo json_encode(array('error' => true));
        exit;
        //return false;
    } else {
        $conex->commit();
        echo json_encode(array('error' => false));
        exit;
        //return true;
    }
    // Cerrar la conexión
    $conex->close();
}

?>