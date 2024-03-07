<?php

include_once('connection.php');

ContadorCliente();
echo '<script>alert("¡Dao Cliente!");</script>';
function ContadorCliente(){
    $con = new LocalConector();
    $conex = $con->conectar();

    $datos = mysqli_query($conex, "SELECT id_cliente,descripcionCliente FROM Cliente ORDER BY descripcionCliente;");



    // Verificar si la consulta fue exitosa
    if ($datos) {
        // Crear un array para almacenar los datos
        $resultados = array();

        // Iterar sobre los resultados y agregarlos al array
        while ($fila = mysqli_fetch_assoc($datos)) {
            $resultados[] = $fila;
        }

        // Convertir el array a formato JSON
        $datos_json = json_encode($resultados);

        // Imprimir el script de alerta con los datos JSON
        echo '<script>alert("Datos obtenidos:\n' . $datos_json . '");</script>';
    } else {
        // Si hay un error en la consulta, mostrar un mensaje de error
        echo "Error en la consulta: " . mysqli_error($conex);
    }







    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}
?>