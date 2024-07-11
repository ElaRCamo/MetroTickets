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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    //include_once('../../dao/daoConsultarSolicitante.php');
        //Sacar los datos de la sesión
        session_start();
        $nombreUser = $_SESSION['nombreUsuario'];
        $tipoUser = $_SESSION['tipoUsuario'];
        $idUsuario = $_SESSION['nomina'];
        $fotoUsuario = $_SESSION['fotoUsuario'];

        if ($tipoUser == null) {
            header("Location: https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/sesion/indexSesion.php");
            exit(); // Añadir exit después de header para asegurar que el script se detenga
        } else if ($tipoUser === 3) {
            echo '<div>Tu mensaje aquí</div>';
            $solicitante = 3;

            /*// Obtener la parte de la consulta de la URL actual
                        $queryString = $_SERVER['QUERY_STRING'];

                        // Obtener los parámetros de la consulta en un array asociativo
                        parse_str($queryString, $params);

                        // Verificar si existe el parámetro id_prueba y obtener su valor
                        if (isset($params['id_prueba'])) {
                            $id_prueba = $params['id_prueba'];
                            echo  $idUsuario;
                            $solicitante = 5;
                            /*
                            // Supongamos que tienes una función consultarSolicitante definida en alguna parte
                            $consultaSolicitante = consultarSolicitante($id_prueba);

                            // Verificar y manejar la respuesta de la consulta
                            if ($consultaSolicitante['status'] == 'success') {
                                $solicitante = $consultaSolicitante['id_solicitante'];
                            } else {
                                $solicitante = "No se encontró solicitante";
                            }*/

            // Comprobar si el idUsuario es diferente del solicitante
            if ($idUsuario !== $solicitante) {
                header("Location: https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/requests/requestsIndex.php");
                exit(); // Añadir exit después de header para asegurar que el script se detenga
            }
        } else {
            $id_prueba = "No aplica";
            $solicitante = "No aplica";
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
    require_once('../../footer.php');
    # Ventanas modales
    include 'modalResultados.php';
    ?>
<script>
    let id_review;
    let id_user = <?php echo json_encode($_SESSION['nomina']); ?>;
    let tipoUser = <?php echo json_encode($_SESSION['tipoUsuario']); ?>;
    //if(tipoUser === 3)
    //let esSolicitante = consultarSolicitante()

    document.addEventListener("DOMContentLoaded", function() {
        // Obtener el valor de id_prueba de la URL
        var urlParams = new URLSearchParams(window.location.search);

        id_review = urlParams.get('id_prueba');

        // Llamar a la función resumenPrueba con el id_prueba obtenido
        if (id_review) {
            resumenPrueba(id_review);
             var titulo = document.querySelector("h1");
            if (titulo) {
                titulo.textContent = "Resumen de Solicitud " + id_review;
            }

        }
    });
    // Event listener for modal shown event
    document.addEventListener('DOMContentLoaded', function() {
        $('#modalResultados').on('shown.bs.modal', function () {
            const selectEstatus = document.getElementById('estatusPruebaAdmin');

            // Initial call to cambiarResultado to set initial state
            cambiarResultado();

            // Event listener for selectEstatus change
            selectEstatus.addEventListener('change', cambiarResultado);
        });
    });

    function updatePrueba(){
        <?php if ($tipoUser== 3){ ?>
                //Solo se puede actualizar si esta en espera de aprobación o en estatus rechazado
                window.location.href = "../newRequest/newRequestIndex.php?id_update="+ id_review;

        <?php
        } else if($tipoUser== 1 || $tipoUser== 2){?>
                //Se cargan los valores que ya se definieron
                llenarEstatusPrueba();
                llenarPrioridadPrueba();
                consultarMetrologos();
                document.getElementById("observacionesAdmin").value = obs_Solicitud;
                llenarResultados();
        <?php } ?>
    }
</script>
<script src="../../js/general.js"></script>
<script src="../../js/review.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>