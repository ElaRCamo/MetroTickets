<?php

include_once('connection.php');

/*$Nomina=$_GET['numNomina'];
$Password=$_GET['password'];
Usuario($Nomina, $Password);*/


function Usuario($Nomina, $Password){
    $con = new LocalConector();
    $conexion=$con->conectar();

    $consP="SELECT id_usuario, nombreUsuario, passwordHash, id_tipoUsuario FROM Usuario WHERE id_usuario = '$Nomina'";
    $rsconsPro=mysqli_query($conexion,$consP);

    mysqli_close($conexion);
    echo ($consP);
    if(mysqli_num_rows($rsconsPro) > 0){

        $rows = $rsconsPro ->fetch_assoc();
        $password_bd = $rows ['passwordHash'];
        $pass_c = sha1($Password);
        echo($password_bd == $pass_c);

        if($password_bd == $pass_c){
            $row = mysqli_fetch_assoc($rsconsPro);
            return array(
                'success' => true, // Indicador de éxito
                'tipoUsuario' => $row['id_tipoUsuario']
            );
        }
    }
    else{
        return array(
            'success' => false
        );
    }
}

?>