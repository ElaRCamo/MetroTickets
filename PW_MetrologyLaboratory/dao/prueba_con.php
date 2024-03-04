<?php
// Incluye el archivo connection.php
require_once('connection.php');

// Crea una instancia de LocalConector
$localConector = new LocalConector();

// Llama a la función conectar
$localConector->conectar();
?>
