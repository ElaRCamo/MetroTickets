<?php

include_once('connection.php');
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if($_POST['inputPassword'] !== null){
        $Nomina = $_SESSION['nomina'];
        $password = $_POST['inputPassword'];

        $fotoPerfil = $_POST['inputFoto'];

        // Manejar la imagen si se ha subido
        if (isset($_FILES['fotoPerfilPU']) && $_FILES['fotoPerfilPU']['error'] === UPLOAD_ERR_OK) {
            // Directorio de destino para la carga de archivos
            $target_dir = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/usuarios/";

            // Nombre y ruta del archivo
            $fechaActual = date('Y-m-d_H-i-s');
            $archivo = $_FILES['fotoPerfilPU']['name'];
            $imgName = $fechaActual . '-' . $Nomina;

            $extension = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
            $extensionesPermitidas = array("gif", "jpeg", "jpg", "png");
            $img = $target_dir . $imgName . "." . $extension;

            // Mover el archivo al directorio de destino
            $tipo   = $_FILES['fotoPerfilPU']['type'];
            $tamano = $_FILES['fotoPerfilPU']['size'];
            $temp   = $_FILES['fotoPerfilPU']['tmp_name'];
            $moverImgFile = "../imgs/usuarios/" . $imgName. "." . $extension;
            if (in_array($extension, $extensionesPermitidas)) {
                move_uploaded_file($temp, $moverImgFile);
            }else{
                $response = array('status' => 'error', 'message' => 'Error: Extensión no permitida.');
            }
        } else {
            // Si no se sube una nueva imagen, utilizar la imagen actual
            $img = $_POST['imgActualUsuario'];
        }
        $respuesta = actualizarUsuario($Nomina,$img,$password);
    }else{
        $respuesta = array('status' => 'error', "message" => "Faltan datos en el formulario.");
    }
} else {
    $respuesta = array('status' => 'error', "message" => "Se esperaba REQUEST_METHOD");
}
echo json_encode($respuesta);
function actualizarUsuario($Nomina,$fotoPerfil,$password)
{
    $con = new LocalConector();
    $conex = $con->conectar();

    $passwordS = sha1($password);

    $stmt = $conex->prepare("UPDATE Usuario
                                      SET foto = ?, passwordHash =?
                                    WHERE id_usuario = ?");
    $stmt->bind_param("sss", $fotoPerfil,$passwordS,$Nomina);

    if ($stmt->execute()) {
        $stmt->close();
        $conex->close();
            return array('status' => 'success', 'message' => 'Perfil de usuario actualizado');
    } else {
        $stmt->close();
        $conex->close();
            return array('status' => 'error', 'message' => 'Error al acrualizar.');
    }
}
?>