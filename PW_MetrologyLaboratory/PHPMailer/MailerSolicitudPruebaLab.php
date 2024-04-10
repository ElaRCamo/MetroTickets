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
						</head>
<body style='margin-top:20px; color:#005195; font-family: 'Assistant', sans-serif;'>
    <table class='body-wrap' style='width:100%; background-color:#f6f6f6; margin:0;'>
        <tbody>
            <tr>
                <td></td>
                <td class='container' style='vertical-align:top; display:block; max-width:600px; clear:both; margin:0 auto;'>
                    <div class='content' style='max-width:600px; display:block; margin:0 auto; padding:20px;'>
                        <table class='main' style='border-radius:3px; background-color:#fff; margin:0; border:1px solid #e9e9e9;'>
                            <tbody>
                                <tr>
                                    <td id='logo' style='background-color:#005195; padding-top:4%;'>
                                        <a href='#'><img class='logoGrammer2-img img-responsive' alt='LogoGrammer' src='https://arketipo.mx/logoWhite.png' style='height:100px; width:100px; display:block; margin:auto;'></a> <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='title' style='padding:5%; text-align:center;'>
                                        <h2 class='h2'>Se ha recibido la solicitud con el <br><b>Folio: $id_prueba</b>, <br>enviada por $Solicitante.</h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='content-wrap'>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class='content-block mensaje'>
                                                        <h5 class='lead' style='text-align:center; padding:2%; margin-bottom: 2%;'>Para gestionar o responder a esta solicitud, por favor visite: <b><a  style='color:#CAC2B6;' class='link' href='https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/requests/requestIndex.php'>Solicitudes</a></b></h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class='content-block' id='attn' style='text-align:center; padding:2%; margin-bottom: 2%;'>
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

</html>
                    ";


    $contenido = $MENSAJE_LABORATORIO;
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


        //Laboratorio de Metrología
        $mail->addAddress('LaboratorioMetrologiaGrammer@arketipo.mx', 'LMGrammer');
        $mail->addBCC('extern.mariela.reyes@grammer.com', 'LMGrammer');
        $mail->addBCC('l22141412@queretaro.tecnm.mx', 'IT');

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