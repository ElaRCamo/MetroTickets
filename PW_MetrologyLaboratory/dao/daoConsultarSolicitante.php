<?php
include_once('connection.php');

function consultarSolicitante($id_prueba)
{
    try {
        $con = new LocalConector();
        $conex = $con->conectar();

        if ($conex->connect_error) {
            throw new Exception('Error en la conexión a la base de datos: ' . $conex->connect_error);
        }
        $selectQuery = $conex->prepare("SELECT id_solicitante FROM Pruebas WHERE id_prueba = ?");
        $selectQuery->bind_param("s", $id_prueba);
        $selectQuery->execute();
        $result = $selectQuery->get_result();

        $id_solicitante = null;
        if ($result) {
            $row = $result->fetch_assoc();
            if ($row) {
                $id_solicitante = $row['id_solicitante'];
            }
        }

        $selectQuery->close();
        $conex->close();
    } catch (Exception $e) {
        // Manejo de errores
        $id_solicitante = null;
    }

    echo $id_solicitante;
}
?>