<?php

include_once('connection.php');

function Usuario($Nomina){
    $con = new LocalConector();
    $conexion=$con->conectar();

    $consP="SELECT id_usuario, nombreUsuario, passwordHash, id_tipoUsuario FROM Usuario WHERE id_usuario = '$Nomina'";
    $rsconsPro=mysqli_query($conexion,$consP);

    mysqli_close($conexion);

    if(mysqli_num_rows($rsconsPro) == 1){
        $row = mysqli_fetch_assoc($rsconsPro);
        return array(
            'success' => true, // Indicador de éxito
            'tipoUsuario' => $row['id_tipoUsuario'],
            'password_bd' => $row['passwordHash']
        );
    }
    else{
        return array(
            'success' => false
        );
    }
}

?>