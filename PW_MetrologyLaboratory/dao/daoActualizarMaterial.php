<?php
include_once('connection.php');

if(isset($_POST['id_descripcion'],$_POST['descMaterialE'],$_POST['numParteE'],$_POST['descMPlataformaE'])) {
    $id_descripcion = $_POST['id_descripcion'];
    $descMaterial = $_POST['descMaterialE'];
    $numParte = $_POST['numParteE']; // Aquí debería ser 'numParteN' según el formulario HTML
    $idPlataforma = $_POST['descMPlataformaE'];

    // Verificar si los campos no están vacíos
    if(empty($id_descripcion) || empty($descMaterial) || empty($numParte) || empty($idPlataforma)) {
        echo "Error: Todos los campos son requeridos.";
    } else {
        if(isset($_FILES['imgMaterialE']) && $_FILES['imgMaterialE']['error'] === UPLOAD_ERR_OK) {
            $fechaActual = date('Y-m-d_H-i-s');
            $target_dir = "../imgs/materials/";
            $archivo = $_FILES['imgMaterialE']['name'];
            $imgName = $fechaActual . '-' . $numParte . '-' . str_replace(' ', '-', $descMaterial);
            $img = $target_dir . $imgName;

            $tipo = $_FILES['imgMaterialE']['type'];
            $tamano = $_FILES['imgMaterialE']['size'];
            $temp = $_FILES['imgMaterialE']['tmp_name'];
            $moverImgFile = "../imgs/materials/" . $imgName;

            $extension = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
            $extensionesPermitidas = array("gif", "jpeg", "jpg", "png");

            if (in_array($extension, $extensionesPermitidas)) {
                if (move_uploaded_file($temp, $moverImgFile)) {
                    echo "La imagen " . htmlspecialchars($imgName) . " ha sido subida correctamente.";
                    // Llamar a la función actualizarMaterial()
                    actualizarMaterial($id_descripcion,$descMaterial, $numParte, $img, $idPlataforma);
                } else {
                    echo "Hubo un error al subir la imagen.";
                }
            } else {
                echo "Error: La extensión o el tamaño de los archivos no es correcta. Se permiten archivos .gif, .jpg, .png y un tamaño máximo de 2 MB.";
            }
        } else {
            // Si no se sube una nueva imagen, utilizar la imagen actual
            $img = $_POST['imagenActual'];
            actualizarMaterial($id_descripcion,$descMaterial, $numParte, $img, $idPlataforma);
        }
    }
} else {
    echo '<script>alert("Error: Faltan datos en el formulario")</script>';
}
//actualizarMaterial(131,"Test93/4","12345","https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/2024-04-22_19-05-12-12345678-Material65555",1);
function actualizarMaterial($id_descripcion,$descMaterial,$numParte,$img,$idPlataforma){
    $con = new LocalConector();
    $conex = $con->conectar();

    $insertMaterial = $conex->prepare("UPDATE DescripcionMaterial 
                                                SET descripcionMaterial = ?, numeroDeParte = ?, imgMaterial = ?, id_plataforma = ?
                                             WHERE id_descripcion = ?");
    $insertMaterial->bind_param("sssii", $descMaterial,$numParte,$img,$idPlataforma,$id_descripcion);
    $resultado = $insertMaterial->execute();

    $conex->close();

    if (!$resultado) {
        echo "Los datos no se insertaron correctamente.";
        echo json_encode(array('error' => true));
    } else {
        echo json_encode(array('error' => false));
    }
    exit;
}
?>


