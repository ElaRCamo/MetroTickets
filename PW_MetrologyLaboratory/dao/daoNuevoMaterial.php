<?php
include_once('connection.php');

if(isset($_POST['descMaterialN'],$_POST['numParteN'],$_FILES['imgMaterialN'],$_POST['descMPlataformaN'] )){
    $descMaterial = $_POST['descMaterialN'];
    $numParte = $_POST['numParteN'];
    $idPlataforma = $_POST['descMPlataformaN'];

    /*//Se guarda ruta de la imagen
    $imgMaterial    = $_POST['imgMaterialN'];
    $target_dir     = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/";
    //Quitar espacios del nombre del archivo:
    $nombreArchivo  = $_FILES["imgMaterialN"]["name"];
    $imgFileName    = $numParte. "-" . str_replace(' ', '-', $nombreArchivo);
    $imgFileName    = str_replace(' ', '-', $imgFileName);
    $img            = $target_dir . $imgFileName;
    $moverNormaFile = "../imgs/materials/" . $imgFileName;

    if ($_FILES["imgMaterialN"]["error"] > 0) {
        echo "Error: " . $_FILES["imgMaterialN"]["error"];
    } else {
        // mover el archivo cargado a la ubicación deseada
        if (move_uploaded_file($_FILES["imgMaterialN"]["tmp_name"], $moverNormaFile)) {
            echo "El archivo " . htmlspecialchars($imgFileName) . " ha sido subido correctamente.";
        } else {
            echo "Hubo un error al subir el archivo.";
        }


    // Llamar a la función
    if(nuevoMaterial($descMaterial,$numParte,$imgMaterial,$idPlataforma)) {
        echo '<script>alert("Material registrado exitosamente")</script>';
    } else {
        echo '<script>alert("Error al registrar el material")</script>';
    }
    }*/

    // Validar el tipo y tamaño del archivo
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
}

function nuevoMaterial($descMaterial,$numParte,$imgMaterial,$idPlataforma){
    $con = new LocalConector();
    $conex = $con->conectar();

    $insertMaterial = $conex->prepare("INSERT INTO DescripcionMaterial (descripcionMaterial, numeroDeParte, imgMaterial, id_plataforma)
                                                    VALUES (?,?,?,?)");
    $insertMaterial->bind_param("sssi", $descMaterial,$numParte,$imgMaterial,$idPlataforma);
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

?>