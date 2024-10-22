<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'Phpmailer/Exception.php';
require 'Phpmailer/PHPMailer.php';
require 'Phpmailer/SMTP.php';

include_once('Produccion/ML/PW_MetrologyLaboratory/dao/connection.php');

$nombreUsuario = $_POST['nombre'];
$nomina=$_POST['id'];
$email=$_POST['correo'];


emailNuevoUsuario($nombreUsuario,$nomina,$email);

function emailNuevoUsuario($nombreUsuario,$nomina,$email)
{

    $MENSAJE = "<!DOCTYPE html>
<html lang='en'>
<head>
    <link rel='preconnect' href='https://fonts.googleapis.com'>
    <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
    <link href='https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap' rel='stylesheet'>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Confirmación de solicitud</title>
    <style>body {font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;}</style>
    </head>
    <body style='margin-top:20px; text-align:center;'>
        <table class='body-wrap' style='width:100%; background-color:#f6f6f6; margin:0; text-align:center;'>
            <tbody>
                <tr>
                    <td></td>
                    <td class='container' style='vertical-align:top; display:block; max-width:600px; clear:both; margin:0 auto; text-align:center;'>
                        <div class='content' style='max-width:500px; display:block; margin:0 auto; padding:20px;'>
                            <table class='main' style='border-radius:3px; background-color:#fff; margin:0; border:1px solid #e9e9e9;'>
                                <tbody>
                                    <tr>
                                        <td id='logo' style='background-color:#005195; padding-top:3%; padding-bottom:3%; text-align:center;'>
                                             <a href='https://grammermx.com/Metrologia/MetroTickets/modules/sesion/indexSesion.php'>
                                             <img class='logoGrammer2-img' alt='LogoGrammer' src='https://grammermx.com/Metrologia/MetroTickets/imgs/logoWhite.png' style='height:100px; width:100px; display:block; margin:auto;'></a><br>
                                             <h4 style='padding-top:3%; display: block; color:#fff; font-weight: bold;'>¡Hola $nombreUsuario!</h4><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='title' style='padding:5%; text-align:center; color:#005195;'>
                                            <h2 class='h2'> 
                                            ¡Te damos la bienvenida al portal del Laboratorio de Metrología Grammer Automotive Puebla S.A de C.V.!
                                            <br>A partir de este momento puedes hacer solicitudes a través de nuestra página web.
                                        </td>
                                    </tr>
                                    <tr style='text-align:center;'>
                                        <td class='content-wrap' style='text-align:center;'>
                                            <table style='text-align:center;'>
                                                <tbody style='text-align:center;'>
                                                    <tr  style='text-align:center;'>
                                                        <td class='content-block mensaje' style='text-align:center; padding:2%; color:#005195; margin-bottom: 2%; font-size: 1.2rem;'>
                                                            <h4 class='lead'> ¡Esperamos saber pronto de ti! Para iniciar sesión, da clic en el enlace: <br>
                                                            <b><a  style='color:#CAC2B6;' class='btn btn-lg btn-primary' href='https://grammermx.com/Metrologia/MetroTickets/modules/sesion/indexSesion.php'>Iniciar sesión </a></b></h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class='content-block' id='attn' style='text-align:center; padding:2%; margin-bottom: 2%; color:#005195;'>
                                                            <h4 class='lead'><b>Laboratorio de Metrología</b><br><b>Grammer Automotive Puebla S.A de C.V.</b></h4>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class='footer' style='width:100%; margin:0; padding:20px; color:#CAC2B6; display:flex; justify-content:center; align-items:center; height:50%;'>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class='aligncenter content-block' style='box-sizing:border-box; font-size:12px; padding:0 0 20px; margin:0 auto;'>
                                                <a href='https://grammermx.com/Metrologia/MetroTickets/modules/sesion/indexSesion.php' style='text-decoration:none; color:#82AFD7; float:none; vertical-align:middle;'>© Grammer Querétaro.</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </body>
    </html>";

    //$css=file_get_contents("Produccion/ML/PW_MetrologyLaboratory/css/style.css");
    //$MENSAJE = "<style>" . $css . "</style>" . $MENSAJE;
    $contenido = $MENSAJE;
    $mail = new PHPMailer(true);

    try {
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER; //Para que envie msjs de todo lo que esta pasando
        $mail->SMTPDebug =0;
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->Username = 'tickets_metrologia@grammermx.com'; //Correo de quien envia el email
        $mail->Password = 'LMGrammer2024#';
        $mail->SMTPSecure = 'ssl';
        $mail->setFrom('tickets_metrologia@grammermx.com', 'Laboratorio de Metrología Grammer Automotive Puebla S.A de C.V.');
        $mail->CharSet = 'UTF-8';

        //Solicitante
        $mail->addAddress($email, $nombreUsuario); //Quién recibirá correo
        $mail->addBCC('tickets_metrologia@grammermx.com', 'LMGrammer');
        $mail->addBCC('extern.mariela.reyes@grammer.com', 'TI');

        $mail->Subject = 'Actualización de solicitud.';
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