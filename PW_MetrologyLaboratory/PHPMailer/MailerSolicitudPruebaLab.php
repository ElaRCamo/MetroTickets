<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'Phpmailer/Exception.php';
require 'Phpmailer/PHPMailer.php';
require 'Phpmailer/SMTP.php';

include_once('Produccion/ML/PW_MetrologyLaboratory/dao/connection.php');
session_start();
$id_prueba=$_POST['id_prueba'];
$Solicitante = $_SESSION['nombreUsuario'];

emailSolicitud($id_prueba,$Solicitante);

function emailSolicitud($id_prueba,$Solicitante )
{

    $MENSAJE_LABORATORIO = "<!DOCTYPE html>
                    <html lang='en'>
                    <head>
                        <link rel='preconnect' href='https://fonts.googleapis.com'>
                        <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
                        <link href='https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap' rel='stylesheet'>
                        <meta charset='UTF-8'>
                        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                        <title>Document</title>
                        <style>
                        body{
                            font-family: 'Source Sans Pro', sans-serif;
                        }
                        table{
                            padding:5px;
                        }
                        </style>
                    </head>
                    <body>
                        <h1 style='color: green;'>Se ha recibido una nueva solicitud de <b style='font-weight: bold;'>$Solicitante</b, con FOLIO: <b style='font-weight: bold;'>$id_prueba</b>.</h1> 
                        <p></p>                
                        <p>Para administrar o responder esta solicitud, visite: <a href='https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/newRequest/newRequestIndex.php'>Solicitudes</a></p>
                        <p></p>
                        <p><b>Laboratorio de Metrología.</b></p>
                        <p><b>Grammer Automotive Puebla S.A de C.V.</b></p>
                        
                    </body>
                    </html>";


    $contenido = utf8_decode($MENSAJE_LABORATORIO);
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Para que envie msjs de todo lo que esta pasando
        //$mail->SMTPDebug =0;
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->Username = 'LaboratorioMetrologiaGrammer@arketipo.mx'; //Correo de quien envia el email
        $mail->Password = 'LMGrammer2024#';
        $mail->SMTPSecure = 'ssl';
        $mail->setFrom('LaboratorioMetrologiaGrammer@arketipo.mx', 'Laboratorio de Metrología Grammer Automotive Puebla S.A de C.V.');


        //Laboratorio de Metrología
        $mail->addAddress('LaboratorioMetrologiaGrammer@arketipo.mx', 'LMGrammer');
        $mail->addBCC('extern.mariela.reyes@grammer.com', 'IT');

        $mail->Subject = 'Nueva solicitud.';
        $mail->isHTML(true);
        $mail->Body = $contenido;

        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Correo enviado';
        }

    } catch (Exception $e) {
        echo $e;
        echo 'Mensaje: ' . $mail->ErrorInfo;
    }

}

?>