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
                                    <style>
                                        *{margin:0;padding:0;box-sizing:border-box;font-family:'Assistant',sans-serif}
                                        body{margin-top:20px;color:#005195}
                                        .body-wrap,.container,.content,.main,.footer,.content-block{box-sizing:border-box}
                                        .body-wrap{width:100%;background-color:#f6f6f6;margin:0}
                                        .container{vertical-align:top;display:block;max-width:600px;clear:both;margin:0 auto}
                                        .content{max-width:600px;display:block;margin:0 auto;padding:20px}
                                        .main{border-radius:3px;background-color:#fff;margin:0;border:1px solid #e9e9e9}
                                        .footer{width:100%;margin:0;padding:20px;color:#CAC2B6;display:flex;justify-content:center;align-items:center;height:50%}
                                        .content-block{vertical-align:top;margin:0;padding:5%;width:100%}
                                        .title{padding:5%;text-align:center}
                                        .mensaje{vertical-align:top;text-align:center;padding:2%}
                                        .logoGrammer2-img{height:100px;width:100px;display:block;margin:auto}
                                        #attn{text-align:center;padding:2%}
                                        #logo{background-color:#005195;padding-top:4%}
                                        .link{color:#CAC2B6}
                                        .aligncenter{box-sizing:border-box;font-size:12px;padding:0 0 20px;margin:0 auto}
                                        .aligncenter a{text-decoration:none;color:#82AFD7;float:none;vertical-align:middle}
                                        .lead{font-size: 1.3rem;}
                                    </style>
                                </head>
                                <body>
                                <table class='body-wrap'><tbody><tr><td></td><td class='container'><div class='content'>
                                    <table class='main'><tbody>
                                    <tr><td id='logo'><a href='#'><img class='logoGrammer2-img img-responsive' alt='LogoGrammer' src='https://arketipo.mx/logoWhite.png'></a> <br></td></tr>
                                    <tr><td class='title'><h6 class='lead' >¡Hola $Solicitante!</h6> <br> <h1 class='h1'>Te informamos que tu solicitud con <br><b>FOLIO: $id_prueba</b><br> ha sido recibida.</h1></td></tr>
                                    <tr><td class='content-wrap'><table><tbody><tr><td class='content-block mensaje'>
                                        <h6 class='lead'>Te enviaremos una notificación tan pronto como haya novedades. Si deseas consultar los detalles completos de tu solicitud, visita:
                                            <b><a  class='link' href='https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/newRequest/newRequestIndex.php'>Mis solicitudes</a></b></h6>
                                    </td></tr><tr><td class='content-block' id='attn'><h5 class='lead'><b>Laboratorio de Metrología</b><br><b>Grammer Automotive Puebla S.A de C.V.</b></h5></td></tr>
                                    </tbody></table></td></tr></tbody></table>
                                    <div class='footer'><table><tbody><tr><td class='aligncenter content-block'><a href='https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/sesion/indexSesion.php'>© Grammer Querétaro.</a></td></tr></tbody></table></div></div></td><td></td>
                                </tr></tbody></table>
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