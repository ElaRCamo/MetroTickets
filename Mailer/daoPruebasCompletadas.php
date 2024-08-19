<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'Phpmailer/Exception.php';
require 'Phpmailer/PHPMailer.php';
require 'Phpmailer/SMTP.php';
include_once('../dao/connection.php');
include_once('functions.php');

function pruebasCompletadas() {
    $con = new LocalConector();
    $conex = $con->conectar();

    $datos = mysqli_query($conex, "SELECT correoElectronico, nombreUsuario, p.id_prueba
                                   FROM Usuario u, Pruebas p
                                   WHERE id_estatusPrueba = 4
                                     AND id_tipoPrueba <> 5
                                     AND id_solicitante = id_usuario;");

    $pruebasCompletas = mysqli_fetch_all($datos, MYSQLI_ASSOC);

    foreach ($pruebasCompletas as $prueba) {
        $id_prueba = $prueba['id_prueba'];
        $emailSolicitante = $prueba['correoElectronico'];
        $Solicitante = $prueba['nombreUsuario'];

        emailUpdate($id_prueba, $emailSolicitante, $Solicitante);
    }
}

?>