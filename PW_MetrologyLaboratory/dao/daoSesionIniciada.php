<?php
session_start();

// Verificar si la sesión está iniciada
$sesionIniciada = isset($_SESSION['tipoUsuario']);

// Devolver la respuesta como un objeto JSON
echo json_encode(array("sesionIniciada" => $sesionIniciada));
?>
