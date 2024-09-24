<?php

function verificarCorreo($correo) {
    // Lista de correos permitidos
    $correosPermitidos = [
        'oscar.gomez@grammer.com',
        'leyda.trejo@grammer.com',
        'mireya.hernandez@grammer.com',
        'adrian.aragon@grammer.com'
    ];

    // Verificar si el correo está en la lista
    if (in_array($correo, $correosPermitidos)) {
        return $correo;
    } else {
        return false; // Correo no permitido
    }
}
?>