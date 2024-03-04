<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluye el archivo connection.php
require_once('connection.php');

// Crea una instancia de LocalConector
$localConector = new LocalConector();

// Llama a la función conectar
$localConector->conectar();
?>
