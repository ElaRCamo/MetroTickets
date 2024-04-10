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
                                    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
                                    <link rel='stylesheet' href='https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/css/email.css'>
                                </head>
                                <body>
                                <table class='body-wrap'><tbody><tr><td></td><td class='container'><div class='content'>
                                    <table class='main'><tbody>
                                    <tr><td id='logo'><a href='#'><img class='logoGrammer2-img img-responsive' alt='LogoGrammer' src='https://arketipo.mx/Produccion/ML\PW_MetrologyLaboratory\imgs\logoWhite.png'></a> <br>												</td></tr>
                                    <tr><td class='title'><p class='lead' >¡Hola $Solicitante!</p> <br> <h2 class='h2'>Te informamos que tu solicitud con FOLIO: <b>$id_prueba</b> ha sido recibida.</h2></td></tr>
                                    <tr><td class='content-wrap'><table><tbody><tr><td class='content-block mensaje'>
                                        <p class='lead'>Te enviaremos una notificación tan pronto como haya novedades. Si deseas consultar los detalles completos de tu solicitud, visita:
                                            <b><a  class='link' href='https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/newRequest/newRequestIndex.php'>Mis solicitudes</a></b></p>
                                    </td></tr><tr><td class='content-block' id='attn'><p class='lead'><b>Laboratorio de Metrología</b><br><b>Grammer Automotive Puebla S.A de C.V.</b></p></td></tr>
                                    </tbody></table></td></tr></tbody></table>
                                    <div class='footer'><table><tbody><tr><td class='aligncenter content-block'><a href='#>© Grammer Querétaro.</a></td></tr></tbody></table></div></div></td><td></td>
                                </tr></tbody></table>
                    </body>
                    </html>";

    $contenido = utf8_decode($MENSAJE_SOLICITANTE);
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

        //Solicitante
        $mail->addAddress($emailSolicitante, $Solicitante); //Quién recibirá correo
        $mail->addBCC('LaboratorioMetrologiaGrammer@arketipo.mx', 'LMGrammer');

        $mail->Subject = 'Confirmaci\u{00F3}n de solicitud.';
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