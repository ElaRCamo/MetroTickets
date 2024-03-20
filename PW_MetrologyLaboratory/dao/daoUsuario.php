<?php

include_once('connection.php');

/*$Nomina=$_GET['numNomina'];
$Password=$_GET['password'];
Usuario($Nomina, $Password);*/


function Usuario($Nomina, $Password){
    echo "<script>console.log('Entrando daoUsuario')</script>";
    $con = new LocalConector();
    $conexion=$con->conectar();

    $consP="SELECT id_usuario, nombreUsuario, id_tipoUsuario FROM Usuario WHERE id_usuario = '$Nomina' and passwordHash = '$Password'";
    echo "<script>console.log('.$consP.')</script>";
    $rsconsPro=mysqli_query($conexion,$consP);
    echo "<script>alert('.$rsconsPro.')</script>";

    mysqli_close($conexion);
    $userData = array();

    if(mysqli_num_rows($rsconsPro) == 1){
        $row = mysqli_fetch_assoc($rsconsPro);
        echo "<script>alert('.$row.')</script>";
        return array(
            'success' => true, // Indicador de éxito
            'tipoUsuario' => $row['tipoUsuario']
        );
    }
    else{
        return array(
            'success' => false
        );
    }
}


?>