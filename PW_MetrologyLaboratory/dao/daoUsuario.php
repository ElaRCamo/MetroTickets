<?php

include_once('connection.php');

/*$Nomina=$_GET['numNomina'];
$Password=$_GET['password'];
Usuario($Nomina, $Password);*/


function Usuario($Nomina, $Password){
    $con = new LocalConector();
    $conexion=$con->conectar();
    $consP="SELECT id_usuario, nombreUsuario FROM Usuario WHERE id_usuario = '$Nomina' and passwordHash = '$Password'";
    $rsconsPro=mysqli_query($conexion,$consP);
    mysqli_close($conexion);
    $userData = array();

    if(mysqli_num_rows($rsconsPro) == 1){
        return 1;
    }
    else{
        return 0;
    }
}


?>