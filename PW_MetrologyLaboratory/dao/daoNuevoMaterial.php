<?php
include_once('connection.php');

//if(isset($_POST['descMaterialN'],$_POST['numParteN'],$_FILES['imgMaterialN'],$_POST['descMPlataformaN'] )){
   $descMaterial = $_POST['descMaterialN'];
   $numParte = $_POST['numParteN'];
   $idPlataforma = $_POST['descMPlataformaN'];



    $target_dir = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/";
   //Recogemos el archivo enviado por el formulario
    $archivo = $_FILES['imgMaterialN']['name'];
    $imgName = $numParte . "-" . str_replace(' ', '-',$archivo);
    $img =  $target_dir . $imgName;

    $tipo = $_FILES['imgMaterialN']['type'];
    $tamano = $_FILES['imgMaterialN']['size'];
    $temp = $_FILES['imgMaterialN']['tmp_name'];
    $moverImgFile = "../imgs/materials/" . $imgName;


if ($_FILES["imgMaterialN"]["error"] > 0) {
    echo "Error: " . $_FILES["imgMaterialN"]["error"];
} else {
    // mover el archivo cargado a la ubicación deseada
    if (move_uploaded_file($temp, $moverImgFile)) {
        echo "La imagen " . htmlspecialchars($imgName) . " ha sido subida correctamente.";
        nuevoMaterial($descMaterial, $numParte, $img, $idPlataforma);
    } else {
        echo "Hubo un error al subir la imagen.";
    }
}


    /*
    //Si el archivo contiene algo y es diferente de vacio
    if (isset($archivo) && $archivo != "") {
        $tipo = $_FILES['imgMaterialN']['type'];
        $tamano = $_FILES['imgMaterialN']['size'];
        $temp = $_FILES['imgMaterialN']['tmp_name'];
        //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
        if (!((strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 2000000))) {
            $respuesta = array("success" => false, "message" => "Error. La extensión o el tamaño de los archivos no es correcta.Se permiten archivos .gif, .jpg, .png. y de 200 kb como máximo.");
            echo json_encode($respuesta);
        } else {
            //Si la imagen es correcta en tamaño y tipo
            //Se intenta subir al servidor
            if (move_uploaded_file($temp, '../imgs/materials/' . $archivo)) {
                //Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
                //chmod('../imgs/materials/' . $archivo, 0777);
                //Mostramos el mensaje de que se ha subido co éxito
                //echo '<div><b>Se ha subido correctamente la imagen.</b></div>';
                //Mostramos la imagen subida
                //echo '<p><img src="../imgs/materials/' . $archivo . '"></p>';

                $respuesta = array("success" => false, "message" => "Se ha subido correctamente la imagen");
                echo json_encode($respuesta);

                $img = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/" . $numParte . $archivo;
                // Llamar a la función solo si la subida del archivo es exitosa
                nuevoMaterial($descMaterial, $numParte, $img, $idPlataforma);
            } else {
                //Si no se ha podido subir la imagen, mostramos un mensaje de error
                //echo '<div><b>Ocurrió algún error al subir el fichero. No pudo guardarse.</b></div>';
                $respuesta = array("success" => false, "message" => "Ocurrió algún error al subir el fichero. No pudo guardarse.");
                echo json_encode($respuesta);

            }
        }
    }*/
function nuevoMaterial($descMaterial,$numParte,$img,$idPlataforma){
    $con = new LocalConector();
    $conex = $con->conectar();

    $insertMaterial = $conex->prepare("INSERT INTO DescripcionMaterial (descripcionMaterial, numeroDeParte, imgMaterial, id_plataforma)
                                                    VALUES (?,?,?,?)");
    $insertMaterial->bind_param("sssi", $descMaterial,$numParte,$img,$idPlataforma);
    $resultado = $insertMaterial->execute();

    $conex->close();

    if (!$resultado) {
        echo '<script>alert("Error al registrar el material")</script>';
        return 0;
    } else {
        echo '<script>alert("Material registrado exitosamente")</script>';
        return 1;
    }
}

/*
    //Recogemos el archivo enviado por el formulario
    $archivo = $_FILES['imgMaterialN']['name'];
    //Si el archivo contiene algo y es diferente de vacio
    if (isset($archivo) && $archivo != "") {
        $tipo = $_FILES['imgMaterialN']['type'];
        $tamano = $_FILES['imgMaterialN']['size'];
        $temp = $_FILES['imgMaterialN']['tmp_name'];
        //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
        if (!((strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 2000000))) {
            $respuesta = array("success" => false, "message" => "Error. La extensión o el tamaño de los archivos no es correcta.Se permiten archivos .gif, .jpg, .png. y de 200 kb como máximo.");
            echo json_encode($respuesta);
        } else {
            //Si la imagen es correcta en tamaño y tipo
            //Se intenta subir al servidor
            if (move_uploaded_file($temp, '../imgs/materials/' . $archivo)) {
                //Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
                chmod('../imgs/materials/' . $archivo, 0777);
                //Mostramos el mensaje de que se ha subido co éxito
                //echo '<div><b>Se ha subido correctamente la imagen.</b></div>';
                //Mostramos la imagen subida
                //echo '<p><img src="../imgs/materials/' . $archivo . '"></p>';

                $respuesta = array("success" => false, "message" => "Se ha subido correctamente la imagen");
                echo json_encode($respuesta);

                $img = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/" . $numParte . $archivo;
                // Llamar a la función solo si la subida del archivo es exitosa
                nuevoMaterial($descMaterial, $numParte, $img, $idPlataforma);
            } else {
                //Si no se ha podido subir la imagen, mostramos un mensaje de error
                //echo '<div><b>Ocurrió algún error al subir el fichero. No pudo guardarse.</b></div>';
                $respuesta = array("success" => false, "message" => "Ocurrió algún error al subir el fichero. No pudo guardarse.");
                echo json_encode($respuesta);

            }
        }
    //}

   /* if ($_FILES["imgMaterialN"]["error"] > 0) {
        echo "Error: " . $_FILES["imgMaterialN"]["error"];
    } else {
        // mover el archivo cargado a la ubicación deseada
        if (move_uploaded_file($_FILES["imgMaterialN"]["tmp_name"], $moverNormaFile)) {
            echo "El archivo " . htmlspecialchars($imgFileName) . " ha sido subido correctamente.";
        } else {
            echo "Hubo un error al subir el archivo.";
        }

    // Llamar a la función
    if(nuevoMaterial($descMaterial,$numParte,$img,$idPlataforma)) {
        echo '<script>alert("Material registrado exitosamente")</script>';
    } else {
        echo '<script>alert("Error al registrar el material")</script>';
    }
    }

     Validar el tipo y tamaño del archivo
    $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
    $max_size = 10 * 1024 * 1024; // 10MB

    $nombreArchivo = $_FILES["imgMaterialN"]["name"];
    $file_type = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
    $file_size = $_FILES['imgMaterialN']['size'];

    if (!in_array(strtolower($file_type), $allowed_types)) {
        echo '<script>alert("Error: Solo se permiten archivos JPG, JPEG, PNG o GIF.")</script>';
    } elseif ($file_size > $max_size) {
        echo '<script>alert("Error: El tamaño del archivo excede el límite permitido de 10MB.")</script>';
    } else {
        // Procede con la subida del archivo
        $target_dir = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/";
        $imgFileName = $numParte;
        $img = $target_dir . $imgFileName;
        $moverNormaFile = "../imgs/materials/" . $imgFileName;

        if (move_uploaded_file($_FILES["imgMaterialN"]["tmp_name"], $moverNormaFile)) {
            // Llamar a la función solo si la subida del archivo es exitosa
            nuevoMaterial($descMaterial, $numParte, $img, $idPlataforma);
        } else {
            echo '<script>alert("Hubo un error al subir el archivo.")</script>';
        }
    }
} else {
    echo '<script>alert("Error: Faltan datos en el formulario")</script>';
}*/


?>



