<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once('connection.php');

function fcliente(){
    $con = new LocalConector();
    $conex=$con->conectar();
    $sqlCliente = "SELECT distinct descripcionCliente FROM Cliente";
    $resultado = mysqli_query($conex,$sqlCliente);

    if ($resultado->num_rows > 0) {
        echo "<option value=''>Selecciona un cliente (OEM)</option>";

        while ($fila = $resultado->fetch_assoc()) {
            $selected = ($fila['descripcionCliente'] == $resultado) ? 'selected' : '';
            echo "<option value='{$fila['descripcionCliente']}' $selected>{$fila['descripcionCliente']}</option>";
        }
    } else {
        echo "<option value=''>No se encontraron clientes</option>";
    }

    // Cerrar la conexión a la base de datos
    $conex->close();
}

