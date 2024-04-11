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
$emailSolicitante=$_POST['emailUsuario'];
$Solicitante = $_SESSION['nombreUsuario'];

emailSolicitud($id_prueba,$emailSolicitante,$Solicitante);

function emailSolicitud($id_prueba,$emailSolicitante,$Solicitante )
{

    $MENSAJE_SOLICITANTE = "<!DOCTYPE html>
<html lang='en'>
<head>
    <link rel='preconnect' href='https://fonts.googleapis.com'>
    <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
    <link href='https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap' rel='stylesheet'>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Document</title>
    </head>
    <body style='margin-top:20px; font-family: 'Assistant', sans-serif;'>
        <table class='body-wrap' style='width:100%; background-color:#f6f6f6; margin:0;'>
            <tbody>
                <tr>
                    <td></td>
                    <td class='container' style='vertical-align:top; display:block; max-width:600px; clear:both; margin:0 auto;'>
                        <div class='content' style='max-width:600px; display:block; margin:0 auto; padding:20px;'>
                            <table class='main' style='border-radius:3px; background-color:#fff; margin:0; border:1px solid #e9e9e9;'>
                                <tbody>
                                    <tr>
                                        <td id='logo' style='background-color:#005195; padding-top:4%; text-align:center;'>
                                            <a href='#'><img class='logoGrammer2-img img-responsive' alt='LogoGrammer' src='https://arketipo.mx/logoWhite.png' style='height:100px; width:100px; display:block; margin:auto;'></a><br>
                                            <span style='margin-top: 10px; margin-bottom: 10px; display: block; color:#fff; font-weight: bold;'>¡Hola $Solicitante!</span><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='title' style='padding:5%; text-align:center; color:#005195;'>
                                            <h2 class='h2'> 
                                            Te informamos que tu solicitud con  <strong>FOLIO: $id_prueba</strong> ha sido recibida.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='content-wrap'>
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td class='content-block mensaje' style='text-align:center; padding:2%; color:#005195; margin-bottom: 2%;'>
                                                            <h5 class='lead'>Te enviaremos una notificación tan pronto como haya novedades. Si deseas consultar los detalles completos de tu solicitud, visita:
                                                            <b><a  style='color:#CAC2B6;' class='btn btn-lg btn-primary' href='https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/requests/requestIndex.php'>Solicitudes</a></b></h5>
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
                                                <a href='https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/sesion/indexSesion.php' style='text-decoration:none; color:#82AFD7; float:none; vertical-align:middle;'>© Grammer Querétaro.</a>
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

    $contenido = $MENSAJE_SOLICITANTE;
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
        $mail->CharSet = 'UTF-8';

        //Solicitante
        $mail->addAddress($emailSolicitante, $Solicitante); //Quién recibirá correo
        $mail->addBCC('LaboratorioMetrologiaGrammer@arketipo.mx', 'LMGrammer');

        $mail->Subject = 'Confirmación de solicitud.';
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