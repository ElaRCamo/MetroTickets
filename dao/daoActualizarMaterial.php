<?php
header('Content-Type: application/json');
include_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los datos del formulario
    $id_descripcion = $_POST['id_descripcion'];
    $descMaterial = $_POST['descMaterialE'];
    $numParte = $_POST['numParteE'];
    $idPlataforma = $_POST['descMPlataformaE'];

    // Manejar la imagen si se ha subido
    if (isset($_FILES['imgMaterialE']) && $_FILES['imgMaterialE']['error'] === UPLOAD_ERR_OK) {
        // Directorio de destino para la carga de files
        $target_dir = "https://grammermx.com/Metrologia/MetroTickets/imgs/materials/";

        // Nombre y ruta del archivo
        $fechaActual = date('Y-m-d_H-i-s');
        $archivo = $_FILES['imgMaterialE']['name'];
        $imgName = $fechaActual . '-' . $numParte . '-' . str_replace(' ', '-', $descMaterial);

        $extension = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
        $extensionesPermitidas = array("gif", "jpeg", "jpg", "png");
        $img = $target_dir . $imgName . "." . $extension;

        // Mover el archivo al directorio de destino
        $tipo   = $_FILES['imgMaterialE']['type'];
        $tamano = $_FILES['imgMaterialE']['size'];
        $temp   = $_FILES['imgMaterialE']['tmp_name'];
        $moverImgFile = "../imgs/materials/" . $imgName. "." . $extension;
        if (in_array($extension, $extensionesPermitidas)) {
            move_uploaded_file($temp, $moverImgFile);
        }else{
            $response = array('status' => 'error', 'message' => 'Error: Extensión no permitida.');
        }
    } else {
        // Si no se sube una nueva imagen, utilizar la imagen actual
        $img = $_POST['imagenActual'];
    }

    $response = actualizarMaterial($id_descripcion, $descMaterial, $numParte, $img, $idPlataforma);

} else {
    // Si no se recibe una solicitud POST, mostrar un mensaje de error
    $response = array('status' => 'error', 'message' => 'Error: Se esperaba una solicitud POST.');
}
echo json_encode($response);

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
        return array('status' => 'error', 'message' => 'Error: Los datos no se insertaron correctamente.');
    } else {
        return array('status' => 'success', 'message' => 'Material registrado exitosamente');
    }
}
?>