<?php
function registrarCambioAdmin($conexCambio,$descripcion,$id_usuario)
{
    $fecha = date('Y-m-d H:i:s');
    $rInsertQuery = true;

    echo " fadmin nomina:".$_SESSION['nomina'];
    echo "descripcion:".$descripcion;

    $insertQuery = $conexCambio->prepare("INSERT INTO CambiosAdmin (fecha, descripcion,id_admin) VALUES (?, ?, ?)");
    $insertQuery->bind_param("sss", $fecha, $descripcion, $id_usuario);
    $rInsertQuery = $rInsertQuery && $insertQuery->execute();

    if(!$rInsertQuery  ) {
        $response = array('status' => 'error', 'message' => 'Error al registrar el cambio.');
    } else {
        $response = array('status' => 'success', 'message' => 'Cambios registrados');
    }
    return $response;
}
?>