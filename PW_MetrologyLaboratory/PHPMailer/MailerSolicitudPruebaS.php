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
                                <html lang='es'>
                                <head>
                                    <link rel='preconnect' href='https://fonts.googleapis.com'>
                                    <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
                                    <link href='https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap' rel='stylesheet'>
                                    <meta charset='UTF-8'>
                                    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                                    <title>Document</title>
                                </head>
                                <body>
                                     <table class='body-wrap' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;' bgcolor='#f6f6f6'>
                                            <tbody>
                                            <tr style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;'>
                                                <td style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;' valign='top'></td>
                                                <td class='container' width='600' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;'
                                                    valign='top'>
                                                    <div class='content' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;'>
                                                        <table class='main' width='100%' cellpadding='0' cellspacing='0' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;'
                                                               bgcolor='#fff'>
                                                            <tbody>
                                                            <tr style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;'>
                                                                <td class='' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #005195; margin: 0; padding: 20px;'
                                                                    align='center' bgcolor='#71b6f9' valign='top'>
                                                                    <a href='#' style='font-size:32px;color:#fff; text-decoration:none;'>GRAMMER</a> <br>
                                                                    <span style='margin-top: 10px;display: block;'>¡Hola $Solicitante!</span>
                                                                </td>
                                                            </tr>
                                                            <tr style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;'>
                                                                <td class='content-wrap' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;' valign='top'>
                                                                    <table width='100%' cellpadding='0' cellspacing='0' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;'>
                                                                        <tbody>
                                                                        <tr style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;'>
                                                                            <td class='content-block' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; text-align:center; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;' valign='top'>
                                                                                Te informamos que tu solicitud con  <strong style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;'>
                                                                                FOLIO: $id_prueba</strong> ha sido recibida.
                                                                            </td>
                                                                        </tr>
                                                                        <tr style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;'>
                                                                            <td class='content-block' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; text-align:center;box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;' valign='top'>
                                                                                Te enviaremos una notificación tan pronto como haya novedades. Si deseas consultar los detalles completos de tu solicitud, visita:
                                                                            </td>
                                                                        </tr>
                                                                        <tr style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;'>
                                                                            <td class='content-block' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; text-align:center; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;' valign='top'>
                                                                                <a href='https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/newRequest/newRequestIndex.php' class='btn-primary' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #005195; margin: 0; border-color: #005195; border-style: solid; border-width: 8px 16px;'>
                                                                                    Mis solicitudes </a>
                                                                            </td>
                                                                        </tr>
                                                                        <tr style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; text-align:center; box-sizing: border-box; font-size: 14px; margin: 0;'>
                                                                            <td class='content-block' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;' valign='top'>
                                                                                Laboratorio de Metrología<br><b>Grammer Automotive Puebla S.A de C.V.</b>
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                        <div class='footer' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #CAC2B6; margin: 0; padding: 20px;'>
                                                            <table width='100%' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;'>
                                                                <tbody>
                                                                <tr style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;'>
                                                                    <td class='aligncenter content-block' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #CAC2B6; text-align: center; margin: 0; padding: 0 0 20px;' align='center' valign='top'><a href='#' style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;'>© Grammer Querétaro.</a>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style='font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;' valign='top'></td>
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