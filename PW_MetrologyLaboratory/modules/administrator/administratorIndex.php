<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../../imgs/Grammer_Logo.ico" type="image/x-icon">
    <title>Administrador</title>

    <!--Enlace de iconos: icons8, licencia con mención -->
    <link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" >
    <!--Fuente -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- -Archivos de jQuery-->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <!-- DataTable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.js" />
    <!-- Custom CSS-->
    <link rel="stylesheet" href="../../css/style.css"/>
    <link rel="stylesheet" href="../../css/administrator.css">
    <?php
        session_start();
        $nombreUser = $_SESSION['nombreUsuario'];
        $tipoUser = $_SESSION['tipoUsuario'];
        $idUsuario = $_SESSION['nomina'];
        $fotoUsuario = $_SESSION['fotoUsuario'];
        if ($tipoUser == null){
            header("Location: https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/sesion/indexSesion.php");
        }elseif($tipoUser == 3){
            echo "<script>alert('Permisos Insuficientes')</script>";
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='1; URL=https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/requests/requestsIndex.php'>";
        }
    ?>
</head>
<body>
    <?php
        # Header section
            require_once('../../header.php');
            //require_once('../../navbar.php');
        # Content section
            require_once('contentAdministrator.php');
        # Content section
            require_once('../../footer.php');
        # Ventanas modales
            include 'clientes.php';
            include 'plataformas.php';
            include 'materiales.php';
            include 'usuarios.php';
    ?>
    <script>
        window.addEventListener("load",async () => {
            await initDataTableClientes();
            await initDataTablePlataformas();
            await initDataTableUsuarios();
        })
    </script>
    <script src="../../js/administrator.js"></script>
    <script src="../../js/general.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <!-- Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- DataTable -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
</body>
</html>