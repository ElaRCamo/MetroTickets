<?php

function ActualizarPiezas($conexUpdate,$plataformas, $numsParte, $cdadPiezas, $revDibujos, $modMatematicos, $id_prueba)
{
    /*$con = new LocalConector();
    $conexUpdate = $con->conectar();

     //Iniciar transacción
    $conexUpdate->begin_transaction();*/

    // Consultando las piezas ya registradas
    $selectQuery = $conexUpdate->prepare("SELECT id_pieza, numParte, cantidad, id_plataforma, revisionDibujo, modMatematico FROM Piezas WHERE id_prueba = ?");
    $selectQuery->bind_param("s", $id_prueba);
    $selectQuery->execute();
    $result = $selectQuery->get_result();

    $existingPiezas = [];
    while ($row = $result->fetch_assoc()) {
        $existingPiezas[$row['numParte']] = [
            'id_pieza' => $row['id_pieza'],
            'cantidad' => $row['cantidad'],
            'id_plataforma' => $row['id_plataforma'],
            'revisionDibujo' => $row['revisionDibujo'],
            'modMatematico' => $row['modMatematico']
        ];
    }

    // Preparar los nuevos datos proporcionados por el usuario
    $newPiezas = [];
    for ($i = 0; $i < count($numsParte); $i++) {
        $numParte = $numsParte[$i];
        $plataforma = $plataformas[$i];
        $cdadPieza = $cdadPiezas[$i];
        $revDibujo = $revDibujos[$i];
        $modMatematico = $modMatematicos[$i];

        $newPiezas[$numParte] = [
            'cantidad' => $cdadPieza,
            'id_plataforma' => $plataforma,
            'revisionDibujo' => $revDibujo,
            'modMatematico' => $modMatematico
        ];
    }

    $rUpdateQuery = $rInsertQuery = $rDeleteQuery = true;

    // Actualizar o insertar nuevas piezas
    foreach ($newPiezas as $numParte => $pieza) {
        if (isset($existingPiezas[$numParte])) {
            // Si la pieza ya existe, actualizarla
            $updateQuery = $conexUpdate->prepare("UPDATE Piezas SET cantidad = ?, id_plataforma = ?, revisionDibujo = ?, modMatematico = ? WHERE id_pieza = ?");
            $updateQuery->bind_param("iissi", $pieza['cantidad'], $pieza['id_plataforma'], $pieza['revisionDibujo'], $pieza['modMatematico'], $existingPiezas[$numParte]['id_pieza']);
            $rUpdateQuery = $rUpdateQuery && $updateQuery->execute();
        } else {
            // Si la pieza no existe, insertarla
            $insertQuery = $conexUpdate->prepare("INSERT INTO Piezas (numParte, cantidad, id_plataforma, revisionDibujo, modMatematico, id_prueba) VALUES (?, ?, ?, ?, ?, ?)");
            $insertQuery->bind_param("siisss", $numParte, $pieza['cantidad'], $pieza['id_plataforma'], $pieza['revisionDibujo'], $pieza['modMatematico'], $id_prueba);
            $rInsertQuery = $rInsertQuery && $insertQuery->execute();
        }
    }

    // Eliminar piezas que ya no están en los datos proporcionados por el usuario
    foreach ($existingPiezas as $numParte => $pieza) {
        if (!isset($newPiezas[$numParte])) {
            $deleteQuery = $conexUpdate->prepare("DELETE FROM Piezas WHERE id_pieza = ?");
            $deleteQuery->bind_param("i", $pieza['id_pieza']);
            $rDeleteQuery = $rDeleteQuery && $deleteQuery->execute();
        }
    }

    if(!$rUpdateQuery || !$rInsertQuery || !$rDeleteQuery ) {
        //$conexUpdate->rollback();
        $response = array('status' => 'error', 'message' => 'Error al actualizar las piezas');
    } else {
        //$conexUpdate->commit();
        $response = array('status' => 'success', 'message' => 'Datos guardados correctamente');
    }
    //$conexUpdate->close();
    return $response;
}

function manejarSubtipoPrueba($tipoPrueba, $id_prueba, $files, $post)
{
    if ($tipoPrueba == 3) { //DIMENSIONAL
        // Manejar la imagen si se ha subido
        if (isset($files['imagenCotas'], $post['subtipoPrueba']) && $post['subtipoPrueba'] == 2 && $files['imagenCotas']['error'] === UPLOAD_ERR_OK) {
            $subtipo = $post['subtipoPrueba'];
            // Directorio de destino para la carga de files
            $target_dir = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/cotas/";

            // Nombre y ruta del archivo
            $fechaActual = date('Y-m-d_H-i-s');
            $archivo = $files['imagenCotas']['name'];
            $imgName = $fechaActual . '_' . $id_prueba;

            $extension = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
            $extensionesPermitidas = array("gif", "jpeg", "jpg", "png");
            $img = $target_dir . $imgName . "." . $extension;

            // Mover el archivo al directorio de destino
            $temp = $files['imagenCotas']['tmp_name'];
            $moverImgFile = "../imgs/cotas/" . $imgName . "." . $extension;
            if (in_array($extension, $extensionesPermitidas)) {
                move_uploaded_file($temp, $moverImgFile);
                $response = array('status' => 'success');
            } else {
                $img = 'error';
                $response = array('status' => 'error', 'message' => 'Error: Extensión no permitida.');
            }
        } else if (isset($post['subtipoPrueba']) && $post['subtipoPrueba'] == 1) {
            $response = array("status" => "success");
            $img = 'No aplica';
            $subtipo = $post['subtipoPrueba'];
        } else {
            // No se recibió ni un archivo ni un string válido
            $img = "Error";
            $subtipo = 0;
            $response = array('status' => 'error', 'message' => 'Error: Faltan datos en el formulario(img).');
        }
    } else { // El tipo de prueba no requiere especificar norma
        $response = array("status" => "success");
        $img = 'No aplica';
        $subtipo = 0;//No aplica
    }
    return array($response, $img, $subtipo);
}

function manejarNormaFile($tipoPrueba, $id_prueba, $files, $post)
{
    if ($tipoPrueba == 1 || $tipoPrueba == 2 || $tipoPrueba == 6) { // si se requiere norma por tipo de prueba

        if (isset($post['norma'], $files['normaFile']) && $files['normaFile']['error'] == UPLOAD_ERR_OK) { // verifica si el archivo ha sido cargado correctamente
            $norma = $_POST['norma'];
            // guardar los files de la norma
            $target_dir = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/files/norms/";
            // Quitar espacios del nombre del archivo:
            $nombreArchivo = $files["normaFile"]["name"];
            $normaFileName = $id_prueba . "-" . str_replace(' ', '-', $nombreArchivo);
            $normaFile = $target_dir . $normaFileName;
            $moverNormaFile = "../files/norms/" . $normaFileName;

            if ($files["normaFile"]["error"] > 0) {
                $response = array("error" => "Error: " . $files["normaFile"]["error"]);
            } else {
                // Mover el archivo cargado a la ubicación deseada
                if (move_uploaded_file($files["normaFile"]["tmp_name"], $moverNormaFile)) {
                    $response = array("status" => "success", "message" => "El archivo " . htmlspecialchars($normaFileName) . " ha sido subido correctamente.");
                } else {
                    $response = array("error" => "Hubo un error al mover el archivo.");
                }
            }
        } elseif (isset($post['norma'], $post['normaFile']) && is_string($post['normaFile'])) { // No hay archivo cargado, es un string
            $norma = $_POST['norma'];
            $response = array("status" => "success");
            $normaFile = $post['normaFile'];
        } else {
            $norma = 'error';
            $normaFile = 'error';
            $response = array("status" => "error", 'message' => "Error: Faltan datos en el formulario(pdf)");
        }
    } else { // El tipo de prueba no requiere especificar norma
        $response = array("status" => "success");
        $normaFile = 'No aplica';
        $norma = 'No aplica';
    }
    return array($response, $norma, $normaFile);
}

?>