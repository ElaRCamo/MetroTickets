<?php
include_once('connection.php');

if(isset($_POST['id_descripcion'],$_POST['descMaterialE'],$_POST['numParteN'],$_POST['descMPlataformaE'] )) {
    $id_descripcion = $_POST['id_descripcion'];
    $descMaterial = $_POST['descMaterialE'];
    $numParte = $_POST['numParteE'];
    $idPlataforma = $_POST['descMPlataformaE'];

    if(isset($_FILES['imgMaterialE']) && $_FILES['imgMaterialE']['error'] === UPLOAD_ERR_OK) {

        $fechaActual = date('Y-m-d_H-i-s');
        $target_dir = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/";
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
                actualizarMaterial($id_descripcion,$descMaterial, $numParte, $img, $idPlataforma);
            } else {
                echo "Hubo un error al subir la imagen.";
            }
        } else {
            echo "Error. La extensión o el tamaño de los archivos no es correcta. Se permiten archivos .gif, .jpg, .png y un tamaño máximo de 2 MB.";
        }
    } else {
        $img = $_POST['imagenActual'];
        actualizarMaterial($id_descripcion,$descMaterial, $numParte, $img, $idPlataforma);
    }
}else {
    echo '<script>alert("Error: Faltan datos en el formulario")</script>';
}

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


