<?php

include_once('../dao/connection.php');
include_once('functions.php');

session_start();
$id_prueba=$_POST['id_prueba'];
$emailSolicitante=$_POST['emailSolicitante'];
$Solicitante = $_POST['solicitante'];

emailUpdate($id_prueba,$emailSolicitante,$Solicitante);

?>