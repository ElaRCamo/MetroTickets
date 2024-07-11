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

        // Consultando las piezas ya registradas
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

        // Cerrando la declaración y la conexión
        $selectQuery->close();
        $conex->close();
    } catch (Exception $e) {
        // Manejo de errores opcional
        $id_solicitante = null;
    }

    return $id_solicitante;
}
/*header('Content-Type: application/json');

function consultarSolicitante($id_prueba)
{
    $response = array('status' => 'error', 'message' => 'Error desconocido');

    try {
        $con = new LocalConector();
        $conex = $con->conectar();

        if ($conex->connect_error) {
            throw new Exception('Error en la conexión a la base de datos: ' . $conex->connect_error);
        }

        // Consultando las piezas ya registradas
        $selectQuery = $conex->prepare("SELECT id_solicitante FROM Pruebas WHERE id_prueba = ?");
        $selectQuery->bind_param("s", $id_prueba);
        $selectQuery->execute();
        $result = $selectQuery->get_result();

        if ($result) {
            $row = $result->fetch_assoc();
            if ($row) {
                $response = array('status' => 'success', 'id_solicitante' => $row['id_solicitante']);
            } else {
                $response = array('status' => 'error', 'message' => 'No se encontró el solicitante');
            }
        } else {
            $response = array('status' => 'error', 'message' => 'Error al consultar solicitante');
        }

        // Cerrando la declaración y la conexión
        $selectQuery->close();
        $conex->close();
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }

    return $response;
}*/
?>