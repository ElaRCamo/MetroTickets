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

    <style>

        /*Ubica el logo de ? dentro del input*/
        #tooltipModelo, #tooltipCliente, #tooltipObs,#tooltipNorma,#tooltipDocNorma,#tooltipTipPrueba,
        #tooltipDibujo, #tooltipCdad , #tooltipNumP, #tooltipPlataforma{
            position: absolute;
            right: 0.5rem;
            top: 10%;
            cursor: pointer;
            color: #aaa; /* Icon color */
            max-width: 1rem;
            padding-top: 0.4rem;
        }

        /*Colores tooltip*/
        .tippy-box[data-theme~='light'] {
            background-color: #005195;
            color: #f1f4f9;
            border: 2px solid rgba(130, 175, 215, 0.1);
        }

        /*arrow*/
        /* The border */
        .tippy-box[data-theme~='light'] > .tippy-svg-arrow > svg:first-child {
            fill: #1733a1;
        }

        /* The fill */
        .tippy-box[data-theme~='light'] > .tippy-svg-arrow > svg:last-child {
            fill: #1733a1;
        }

    </style>
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
        let emailUsuario = <?php echo json_encode($_SESSION['emailUsuario']); ?>;
        let solicitante = <?php echo json_encode($_SESSION['nombreUsuario']); ?>;

        $(document).ready(function() {
            $(document).on('click', '[id^="addNumParte"]', function(e) {
                e.preventDefault();
                agregarMaterial();
                llenarCliente(indexMaterial);
            });

            $(document).on('click', '.remove-lnk', function(e) {
                e.preventDefault();
                var id = $(this).attr("id");
                $('#newRow' + id).remove();
            });
        });
    </script>
    <script src="../../js/general.js"></script>
    <script src="../../js/actualizarDatos.js"></script>
    <script src="../../js/cargarDatos.js"></script>
    <script src="../../js/insertarDatos.js"></script>
    <script src="../../js/validaciones.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <script type="text/javascript">
        let  esActualizacion = false;
        // ¿Se va actualizar una solicitud?
        const id_update = new URLSearchParams(window.location.search).get('id_update');
        function esActualizacionPrueba(){
            if (id_update !== null && id_update !== '') {
                cargarDatosPrueba(id_update);
                actualizarTituloH1(id_update);
                showButton("updateRequest");
                hideButton("submitRequest");
                esActualizacion = true;
            }else{
                hideButton("updateRequest");
            }
        }

        function actualizarTituloH1(id_update) {
            var divh1 = document.querySelector("#divh1");
            var titulo1 = divh1.querySelector("h1");
            var aviso = divh1.querySelector("span");

            if (titulo1) {
                titulo1.textContent = "Actualizar Solicitud " + id_update;
            }
            if (aviso){
                aviso.textContent = " ";
            }
        }

        tippy('#tooltipModelo'+indexMaterial, {
            trigger: 'click',
            animation: 'shift-away',
            theme: 'light',
            onShow(instance) {
                fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/varios/modeloMatematico.png')
                    .then((response) => response.blob())
                    .then((blob) => {
                        // Convert the blob into a URL
                        const url = URL.createObjectURL(blob);
                        // Create an image
                        const image = new Image();
                        image.width = 350;
                        image.height = 200;
                        image.style.display = 'block';
                        image.style.margin = '0 auto'; // Center the image
                        image.src = url;

                        // Create a container div
                        const container = document.createElement('div');
                        container.style.textAlign = 'center'; // Center align text
                        container.style.fontSize = '0.7rem'; // Smaller font size

                        /* Add text before the image
                        const textBefore = document.createElement('p');
                        textBefore.textContent = 'Aquí va texto antes de la imagen';

                        container.appendChild(textBefore);*/

                        // Add the image to the container
                        container.appendChild(image);

                        /* Add text after the image
                        const textAfter = document.createElement('p');
                        textAfter.textContent = 'Aquí va texto después de la imagen';
                        container.appendChild(textAfter);*/

                        // Update the tippy content with the container
                        instance.setContent(container);
                    })
                    .catch((error) => {
                        // Fallback if the network request failed
                        instance.setContent(`Request failed. ${error}`);
                    });
            },
            arrow: true, // Enable arrow
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>
