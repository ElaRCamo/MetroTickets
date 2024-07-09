<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../../imgs/Grammer_Logo.ico" type="image/x-icon">
    <title>Nueva Solicitud</title>

    <!--Enlace de iconos: icons8, licencia con mención -->
    <link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" >
    <!--Fuente -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!--Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/form.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- -Archivos de jQuery-->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Tippy.js core styles -->
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css">


    <?php
        session_start();
        $nombreUser = $_SESSION['nombreUsuario'];
        $tipoUser = $_SESSION['tipoUsuario'];
        $idUsuario = $_SESSION['nomina'];
        $fotoUsuario = $_SESSION['fotoUsuario'];
        if ($tipoUser == null){
            header("Location: https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/sesion/indexSesion.php");
        }elseif($tipoUser == 2){
            echo "<script>alert('Permisos Insuficientes')</script>";
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='1; URL=https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/requests/requestsIndex.php'>";
        }
    ?>
</head>
<body onload="llenarTipoPrueba(); esActualizacionPrueba();">
    <?php
        # Header section
            require_once('../../header.php');
            require_once('../../navbar.php');

        # Content section
            require_once('contentRequest.php');
            require_once('../../footer.php');
    ?>

    <script type="text/javascript">
        let indexMaterial = 1;
        let indexPersonal = 1;
        let emailUsuario = <?php echo json_encode($_SESSION['emailUsuario']); ?>;
        let solicitante = <?php echo json_encode($_SESSION['nombreUsuario']); ?>;
        let  esActualizacion = false;
        // ¿Se va actualizar una solicitud?
        const id_update = new URLSearchParams(window.location.search).get('id_update');
        function esActualizacionPrueba(){
            if (id_update !== null && id_update !== '') {
                cualEsTipoPrueba(id_update)
                //cargarDatosPrueba(id_update);
                actualizarTituloH1(id_update);
                showButton("updateRequest");
                hideButton("submitRequest");
                esActualizacion = true;
            }else{
                hideButton("updateRequest");
            }
        }
        $(document).ready(function() {
            $(document).on('click', '[id^="addNumParte"]', function(e) {
                e.preventDefault();
                agregarPieza();
                llenarCliente(indexMaterial);
                initTooltips();
            });
            $(document).on('click', '.remove-lnk-num-parte', function(e) {
                e.preventDefault();
                var id = $(this).attr("id");
                $('#newRow' + id).remove();
            });
            $(document).on('click', '[id^="addPersonal"]', function(e) {
                e.preventDefault();
                agregarPersonal();
            });
            $(document).on('click', '.remove-lnk-personal', function(e) {
                e.preventDefault();
                var id = $(this).attr("id");
                $('#newRowPer' + id).remove();
            });
        });
    </script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <script src="../../js/general.js"></script>
    <script src="../../js/form.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>
