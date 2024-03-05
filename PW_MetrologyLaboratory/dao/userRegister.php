<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('connection.php');

function fcliente($clienteSeleccionado = '') {
    $con = new LocalConector();
    $conex = $con->conectar();


    $clienteSQL = "SELECT distinct idCliente, descripcionCliente FROM Cliente";
    $resultado = $conex->query($clienteSQL);

    // Verificar si hay resultados
    if ($resultado->num_rows > 0) {
        echo "<option value='' selected>Selecciona un cliente</option>";

        // Imprimir las opciones del select con las descripciones de clientes
        while ($fila = $resultado->fetch_assoc()) {
            $selected = ($fila['id_Cliente'] == $clienteSeleccionado) ? 'selected' : '';
            echo "<option value='{$fila['id_Cliente']}' $selected>{$fila['descripcionCliente']}</option>";
        }
    } else {
        echo "<option value=''>No se encontraron clientes</option>";
    }

    $conex->close();
}


