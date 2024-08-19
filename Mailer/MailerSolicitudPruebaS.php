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

    $MENSAJE_SOLICITANTE = "
<!DOCTYPE html>
<html lang='en'>
<head>
    <link rel='preconnect' href='https://fonts.googleapis.com'>
    <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
    <link href='https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap' rel='stylesheet'>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Confirmación de solicitud</title>
</head>
<body>
    <table class='body-wrap'>
        <tbody>
            <tr>
                <td></td>
                <td class='container'>
                    <div class='content'>
                        <table class='main'>
                            <tbody>
                                <tr>
                                    <td id='logo'>
                                        <a href='https://grammermx.com/Metrologia/MetroTickets/modules/sesion/indexSesion.php'></a><br>
                                        <h4>¡Hola $Solicitante!</h4><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='title'>
                                        <h2 class='h2'> 
                                        Te informamos que tu solicitud con <br><strong>FOLIO: $id_prueba</strong><br> ha sido recibida.
                                    </td>
                                </tr>
                                <tr>
                                    <td class='content-wrap'>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class='content-block mensaje'>
                                                        <h4 class='lead'>Te enviaremos una notificación tan pronto como haya novedades. <br>Si deseas consultar los detalles completos de tu solicitud, visita:<br>
                                                        <b><a class='btn btn-lg btn-primary' href='https://grammermx.com/Metrologia/MetroTickets/modules/review/index.php?id_prueba=$id_prueba'>Solicitud $id_prueba</a></b></h4>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class='content-block' id='attn'>
                                                        <h4 class='lead'><b>Laboratorio de Metrología</b><br><b>Grammer Automotive Puebla S.A de C.V.</b></h4>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class='footer'>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class='aligncenter content-block'>
                                            <a href='https://grammermx.com/Metrologia/MetroTickets/modules/sesion/indexSesion.php'>© Grammer Querétaro.</a>
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
</html>
";

    $css=file_get_contents("Metrologia/MetroTickets/Mailer/style.css");
    $MENSAJE_SOLICITANTE = "<style>" . $css . "</style>" . $MENSAJE_SOLICITANTE;
    $contenido = $MENSAJE_SOLICITANTE;
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
        $mail->addAddress($emailSolicitante, $Solicitante); //Quién recibirá correo
        $mail->addBCC('tickets_metrologia@grammermx.com', 'LMGrammer');
        $mail->addBCC('extern.mariela.reyes@grammer.com', 'TI');

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