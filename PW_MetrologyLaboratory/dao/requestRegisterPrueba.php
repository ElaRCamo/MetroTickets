<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once('connection.php');
session_start();

// Verificar si los datos están presentes y asignarlos de manera segura
if(isset($_POST['materiales'], $_POST['cantidades'], $_POST['id_prueba'])) {

    $id_prueba      = $_POST['id_prueba'];

    // Recibir los datos del formulario
    $descMateriales = $_POST['materiales'];
    $cantidades = $_POST['cantidades'];

    echo '<script>alert("$descMateriales: '.$descMateriales.'\n $cantidades: '.$cantidades.'")</script>';

    // Suponiendo que $descMateriales y $cantidades son strings separadas por comas, se converten en arrays usando explode
    //$descMateriales = explode(', ', $_POST['materiales']);
    //$cdadMateriales = explode(', ', $_POST['cantidades']);

    echo '<script>alert("descMateriales:".print_r($descMateriales, true)."\n cdadMateriales:".print_r($cdadMateriales, true))</script>';

    // Llamar a la función
    if(RegistrarSolicitud($descMateriales, $cantidades, $id_prueba)) {
        echo '<script>alert("Solicitud registrada exitosamente")</script>';
    } else {
        echo '<script>alert("Error al registrar la solicitud")</script>';
    }
} else {
    echo '<script>alert("Error: Faltan datos en el formulario")</script>';
}

function RegistrarSolicitud($descMateriales, $cdadMateriales, $id_prueba)
{
    $con = new LocalConector();
    $conex = $con->conectar();

    for ($i = 0; $i < count($descMateriales); $i++) {
        $descMaterial = $descMateriales[$i];
        $cdadMaterial = $cdadMateriales[$i];

        echo "DescMaterial: " . $descMateriales[$i] . "<br>";
        echo "CdadMaterial: " . $cdadMateriales[$i] . "<br>";

        $insertMaterial = $conex->prepare("INSERT INTO `MaterialTest` (`id_prueba`, `cantidad`, `id_descripcion`) 
                                                 VALUES (?, ?, ?)");

        $insertMaterial->bind_param("sii", $id_prueba, $cdadMaterial, $descMaterial);
        $rInsertMaterial  = $insertMaterial->execute();

        if(!$rInsertMaterial) {
            echo "Los datos no se insertaron correctamente.";
            echo json_encode(array('error' => true));
        }else{
            echo json_encode(array('error' => false));
        }

    }

    $conex->close();

    //return true;
}
//bind_param(): Es un método de la clase mysqli_stmt que se utiliza para vincular parámetros a la consulta preparada.
//ssssssi": especifica el tipo de datos de los parámetros que se están vinculando(cada "s" indica que el parámetro es una cadena (string) y cada "i" indica que el parámetro es un entero (integer))
?>
