<?php

function isNull($nombre, $user, $pass, $email)
{
    if(strlen(trim($nombre)) < 1 || strlen(trim($user)) < 1 || strlen(trim($pass)) < 1 || strlen(trim($email)) < 1){
        return true;
    }else{
        return false;
    }
}

function isEmail($email){
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    }else{
        return false;
    }
}

function hasPassword($password)
{
    $hash = password_hash($password, PASSWORD_DEFAULT);
    return $hash;
}

/*Genera un token único cada vez que es invocada. Utiliza la combinación de las funciones mt_rand()
para generar un número aleatorio, uniqid() para obtener un identificador único basado en la hora actual,
y md5() para encriptar el resultado en un hash de 32 caracteres.*/
function generateToken()
{
    $gen = md5(uniqid(mt_rand(),false));
    return $gen;
}

function validaToken($id, $token)
{
    global $mysqli;

    $stmt = $mysqli ->prepare ("SELECT activacion FROM usuarios WHERE id = ? AND token = ? LIMIT 1");
    $stmt->bind_param("is", $id, $token);
    $stmt->execute();
    $stmt->store_result();
    $rows = $stmt->num_rows;

    $activacion = null;
    if($rows > 0){
        $stmt->bind_result($activacion);
        $stmt->fetch();

        if($activacion == 1){
            $msg = "La cuenta ya se activo anteriormente.";
        }else{
            if(activarUsuario($id)){
                $msg = 'Cuenta activada.';
            }else{
                $msg = "Error al activar cuenta.";
            }
        }
    }
}

function activarUsuario($id)
{
    global $mysqli;

    $stmt = $mysqli ->prepare ("UPDATE usuarios SET activacion=1 WHERE id= ?");
    $stmt->bind_param("s", $id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

function resultBlock($errors)
{
    if(count($errors) > 0){
        echo "<div id='error' class='alert alert-danger' role='alert'>
              <a href='#' onclick=\"showHide('error');\">[X]<\a><ul>";
        foreach ($errors as $error) {
            echo "<li>".$error."</li>";
        }
        echo "</ul>";
        echo "</div>";
    }
}
?>