<?php
include_once('connection.php');

if(isset($_POST['descMaterialN'],$_POST['numParteN'],$_FILES['imgMaterialN'],$_POST['descMPlataformaN'] )) {
    $descMaterial = $_POST['descMaterialN'];
    $numParte = $_POST['numParteN'];
    $idPlataforma = $_POST['descMPlataformaN'];

    if ($_FILES["imgMaterialN"]["error"] > 0) {
        echo "Error: " . $_FILES["imgMaterialN"]["error"];
    } else {
        $target_dir = "../imgs/materials/";
        $archivo = $_FILES['imgMaterialN']['name'];
        $imgName = $numParte . "-" . str_replace(' ', '-', $archivo);
        $img = $target_dir . $imgName;

        $tipo = $_FILES['imgMaterialN']['type'];
        $tamano = $_FILES['imgMaterialN']['size'];
        $temp = $_FILES['imgMaterialN']['tmp_name'];
        $moverImgFile = "../imgs/materials/" . $imgName;

        $extension = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
        $extensionesPermitidas = array("gif", "jpeg", "jpg", "png");

        if (in_array($extension, $extensionesPermitidas)) {
            if ($tamano < 2000000) { // Verifica el tamaño máximo del archivo (2MB)
                if (move_uploaded_file($temp, $moverImgFile)) {
                    echo "La imagen " . htmlspecialchars($imgName) . " ha sido subida correctamente.";
                    nuevoMaterial($descMaterial, $numParte, $img, $idPlataforma);
                } else {
                    echo "Hubo un error al subir la imagen.";
                }
            } else {
                echo "Error. El tamaño del archivo excede el límite de 2 MB.";
            }
        } else {
            echo "Error. La extensión del archivo no es válida. Se permiten archivos .gif, .jpg, .jpeg y .png.";
        }
    }
} else {
    echo '<script>alert("Error: Faltan datos en el formulario")</script>';
}

function nuevoMaterial($descMaterial, $numParte, $img, $idPlataforma){
    $con = new LocalConector();
    $conex = $con->conectar();

    if ($conex) {
        $insertMaterial = $conex->prepare("INSERT INTO DescripcionMaterial (descripcionMaterial, numeroDeParte, imgMaterial, id_plataforma)
                                            VALUES (?,?,?,?)");
        $insertMaterial->bind_param("sssi", $descMaterial, $numParte, $img, $idPlataforma);
        $resultado = $insertMaterial->execute();

        if (!$resultado) {
            echo "Los datos no se insertaron correctamente.";
            echo json_encode(array('error' => true));
            exit;
        } else {
            echo json_encode(array('error' => false));
            exit;
        }
    } else {
        echo "Error de conexión a la base de datos.";
    }
}
?>




