<?php
include_once('connection.php');

if(isset($_POST['descPlataformaN'],$_POST['descPClienteN'] )){
    $descPlataforma = $_POST['descPlataformaN'];
    $idCliente = $_POST['descPClienteN'];
    // Llamar a la función
    if(nuevaPlataforma($descPlataforma,$idCliente)) {
        echo '<script>alert("Plataforma registrada exitosamente")</script>';
    } else {
        echo '<script>alert("Error al registrar la plataforma")</script>';
    }
} else {
    echo '<script>alert("Error: Faltan datos en el formulario")</script>';
}

function nuevaPlataforma($descPlataforma,$idCliente){
    $con = new LocalConector();
    $conex = $con->conectar();

    $insertPlataforma = $conex->prepare("INSERT INTO Plataforma (descripcionPlataforma, id_cliente) VALUES (?,?)");
    $insertPlataforma->bind_param("si", $descPlataforma,$idCliente);
    $resultado = $insertPlataforma->execute();

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