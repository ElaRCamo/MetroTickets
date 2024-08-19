<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'Phpmailer/Exception.php';
require 'Phpmailer/PHPMailer.php';
require 'Phpmailer/SMTP.php';

include_once('../dao/connection.php');
include_once('functions.php');

session_start();
$id_prueba=$_POST['id_prueba'];
$emailSolicitante=$_POST['emailSolicitante'];
$Solicitante = $_POST['solicitante'];

emailUpdate($id_prueba,$emailSolicitante,$Solicitante);

?>