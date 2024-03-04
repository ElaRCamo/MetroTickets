<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('connection.php');

$localConector = new LocalConector();
$localConector->conectar();

$nombreUsuario = $_POST['nombreUsuario'];
$correo = $_POST['correo'];
$numNomina = $_POST['numNomina'];
$password = $_POST['password'];

$query = "INSERT INTO Usuario (`id_usuario`, `nombreUsuario`, `correoElectronico`, `passwordHash`, `id_tipoUsuario`, `id_areaTrabajo`, `puesto`) 
          VALUES ('$numNomina', '$nombreUsuario','$correo' , '$password', '3', '5', 'Calidad')";

$ejecutar = mysqli_query($localConector->getConexion(), $query);

if ($ejecutar) {
    echo "Consulta ejecutada correctamente.";
} else {
    echo "Error en la consulta: " . mysqli_error($localConector->getConexion());
}

// Cerrar la conexión después de ejecutar la consulta
$localConector->cerrarConexion();
?>
