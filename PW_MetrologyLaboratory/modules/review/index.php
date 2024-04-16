<?php
ob_start();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../../imgs/Grammer_Logo.ico" type="image/x-icon">
    <title>Consultar una prueba</title>

    <!--Enlace de iconos: icons8, licencia con mención -->
    <link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" >
    <!--Fuente -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!--Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/style.css">
    <!-- -Archivos de jQuery-->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <?php
        session_start();
            $nombreUser = $_SESSION['nombreUsuario'];
            $tipoUser = $_SESSION['tipoUsuario'];
            $idUsuario = $_SESSION['nomina'];
            $fotoUsuario = $_SESSION['fotoUsuario'];
        if ($tipoUser == null){
            header("Location: https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/sesion/indexSesion.php");
        }
        ?>
</head>
<body >
<?php
    # Header section
    require_once('../../header.php');
    require_once('../../navbar.php');

    # Content section
    require_once('contentReview.php');
    # Content section
    require_once('../../footer.php')
    ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Obtener el valor de id_prueba de la URL
        var urlParams = new URLSearchParams(window.location.search);
        var id_prueba = urlParams.get('id_prueba');

        // Llamar a la función resumenPrueba con el id_prueba obtenido
        if (id_prueba) {
            resumenPrueba(id_prueba);

            var titulo = document.querySelector("h1");
            if (titulo) {
                titulo.textContent = "Resumen de Solicitud " + id_prueba;
            }
        }
    });
</script>
<script src="../../js/cargarDatos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/js/general.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>
<?php
$html=ob_get_clean();
echo $html;
?>
