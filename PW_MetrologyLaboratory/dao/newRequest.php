<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once('connection.php');

session_start(); // Mueve la sesión al inicio del archivo

function fcliente(){
    $con = new LocalConector();
    $conex = $con->conectar();
    $sqlCliente = "SELECT distinct descripcionCliente FROM Cliente";
    $resultado = mysqli_query($conex, $sqlCliente);

    if ($resultado->num_rows > 0) {
        echo "<option value=''>Selecciona un cliente (OEM)</option>";
        while ($fila = $resultado->fetch_assoc()) {
            $selected = (isset($_SESSION['clienteSeleccionado']) && $_SESSION['clienteSeleccionado'] == $fila['descripcionCliente']) ? 'selected' : '';
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
    $conex = $con->conectar();

    // Verificar si la variable de sesión está definida
    if (isset($_SESSION['clienteSeleccionado'])) {
        $clienteSeleccionado = $_SESSION['clienteSeleccionado'];
        $sqlPlataforma = "SELECT descripcionPlataforma FROM Plataforma, Cliente WHERE descripcionCliente = '$clienteSeleccionado' AND id_plataforma = idPlataforma;";
        $resultado = mysqli_query($conex, $sqlPlataforma);

        if ($resultado->num_rows > 0) {
            echo "<option value=''>Selecciona la plataforma</option>";
            while ($fila = $resultado->fetch_assoc()) {
                $selected = (isset($_SESSION['plataformaSeleccionada']) && $_SESSION['plataformaSeleccionada'] == $fila['descripcionPlataforma']) ? 'selected' : '';
                echo "<option value='{$fila['descripcionPlataforma']}' $selected>{$fila['descripcionPlataforma']}</option>";
            }
        } else {
            echo "<option value=''>No se encontraron plataformas</option>";
        }
    } else {
        echo "<option value=''>Primero selecciona un cliente</option>";
    }

    $conex->close();
}
?>


