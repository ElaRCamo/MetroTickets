<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once('connection.php');

$descripcionCliente = "";

function fcliente(){
    $con = new LocalConector();
    $conex=$con->conectar();
    $sqlCliente = "SELECT distinct descripcionCliente FROM Cliente";
    $resultado = mysqli_query($conex,$sqlCliente);

    session_start();

    if ($resultado->num_rows > 0) {
        echo "<option value=''>Selecciona un cliente (OEM)</option>";

        while ($fila = $resultado->fetch_assoc()) {
            $selected = ($_SESSION['clienteSeleccionado'] == $fila['descripcionCliente']) ? 'selected' : '';
            echo "<option value='{$fila['descripcionCliente']}' $selected>{$fila['descripcionCliente']}</option>";
        }
    } else {
        echo "<option value=''>No se encontraron clientes</option>";
    }

    // Cerrar la conexión a la base de datos
    $conex->close();
}

function fplataforma()
{
    $con = new LocalConector();
    $conex=$con->conectar();
    session_start();
    $clienteSeleccionado = $_SESSION['clienteSeleccionado'];

    $sqlCliente = "SELECT descripcionPlataforma FROM Plataforma,Cliente WHERE id_plataforma=idPlataforma and descripcionCliente='"+$clienteSeleccionado+"'";
    $resultado = mysqli_query($conex,$sqlCliente);

    if ($resultado->num_rows > 0) {
        echo "<option value=''>Selecciona la plataforma</option>";

        while ($fila = $resultado->fetch_assoc()) {
            $selected = ($_SESSION['plataformaSeleccionada'] == $fila['descripcionPlataforma']) ? 'selected' : '';
            echo "<option value='{$fila['descripcionPlataforma']}' $selected>{$fila['descripcionPlataforma']}</option>";
        }
    } else {
        echo "<option value=''>No se encontraron clientes</option>";
    }

    $conex->close();
}

