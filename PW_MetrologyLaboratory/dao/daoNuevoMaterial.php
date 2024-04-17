<?php
include_once('connection.php');

if(isset($_POST['descMaterialN'],$_POST['numParteN'],$_POST['imgMaterialN'],$_POST['descMPlataformaN'] )){
    $descMaterial = $_POST['descMaterialN'];
    $numParte = $_POST['numParteN'];
    $idPlataforma = $_POST['descMPlataformaN'];

    //Se guarda ruta de la imagen
    $imgMaterial    = $_POST['imgMaterialN'];
    $target_dir     = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/";
    //Quitar espacios del nombre del archivo:
    $nombreArchivo  = $_FILES["imgMaterialN"]["name"];
    $imgFileName    = $idPlataforma.$descMaterial.$numParte;
    $img            = $target_dir . $imgFileName;
    $moverNormaFile = "../imgs/materials/" . $imgFileName;

    if ($_FILES["normaFile"]["error"] > 0) {
        echo "Error: " . $_FILES["imgMaterialN"]["error"];
    } else {
        // mover el archivo cargado a la ubicación deseada
        if (move_uploaded_file($_FILES["imgMaterialN"]["tmp_name"], $moverNormaFile)) {
            echo "El archivo " . htmlspecialchars($imgFileName) . " ha sido subido correctamente.";
        } else {
            echo "Hubo un error al subir el archivo.";
        }
    }

    // Llamar a la función
    if(nuevoMaterial($descMaterial,$numParte,$imgMaterial,$idPlataforma)) {
        echo '<script>alert("Material registrado exitosamente")</script>';
    } else {
        echo '<script>alert("Error al registrar el material")</script>';
    }
} else {
    echo '<script>alert("Error: Faltan datos en el formulario")</script>';
}

function nuevoMaterial($descMaterial,$numParte,$imgMaterial,$idPlataforma){
    $con = new LocalConector();
    $conex = $con->conectar();

    $insertMaterial = $conex->prepare("INSERT INTO DescripcionMaterial (descripcionMaterial, numeroDeParte, imgMaterial, id_plataforma)
                                                    VALUES (?,?,?,?)");
    $insertMaterial->bind_param("sssi", $descMaterial,$numParte,$imgMaterial,$idPlataforma);
    $resultado = $insertMaterial->execute();

    if(!$resultado) {
        echo "Los datos no se insertaron correctamente.";
        echo json_encode(array('error' => true));
        exit;
        //return false;
    } else {
        $conex->commit();
        echo json_encode(array('error' => false));
        exit;
        //return true;
    }
    // Cerrar la conexión
    $conex->close();
}

?>