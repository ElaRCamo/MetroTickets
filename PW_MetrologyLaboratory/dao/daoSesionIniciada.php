<?php
    if (!isset($_SESSION['tipoUsuario'])) {
    header("Location: https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/sesion/indexSesion.php");
    exit;
    }
?>