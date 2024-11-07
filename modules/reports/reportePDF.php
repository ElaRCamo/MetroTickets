<?php
header_remove();
session_start();

if (!isset($_SESSION['tipoUsuario'])){
    header("Location: https://grammermx.com/Metrologia/MetroTickets/modules/sesion/indexSesion.php");
    exit();
} else {
    if ($_SESSION['tipoUsuario'] == "ok") {
        $nombreUser = $_SESSION['nombreUsuario'];
    }
}

include_once('../../dao/funtions.php');
$anio = filter_input(INPUT_GET, 'anio', FILTER_SANITIZE_NUMBER_INT);
$mes = filter_input(INPUT_GET, 'mes', FILTER_SANITIZE_NUMBER_INT);
if (!$anio || !$mes) {
    die('Faltan parámetros o son inválidos.');
}

ob_start();

include_once('../../dao/connection.php');
$con = new LocalConector();
$conex = $con->conectar();

$pruebasRealizadas = 0;
$pruebasPendientes = 0;
$tiempoPromedioRespuestaDias = 0.0;
$eficienciaOperativa = 0.0;

try {
    mysqli_begin_transaction($conex);

    // Consulta para obtener Pruebas Realizadas
    $consultaRealizadas = "SELECT COUNT(*) as pruebasRealizadas FROM Pruebas WHERE MONTH(fechaRespuesta) = ? AND YEAR(fechaRespuesta) = ?";
    $stmt = mysqli_prepare($conex, $consultaRealizadas);
    mysqli_stmt_bind_param($stmt, "ii", $mes, $anio);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $pruebasRealizadas);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Consulta para obtener Pruebas Pendientes
    $consultaPendientes = "SELECT COUNT(*) as pruebasPendientes FROM Pruebas WHERE id_estatusPrueba NOT IN (4, 9, 5)";
    $stmt = mysqli_prepare($conex, $consultaPendientes);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $pruebasPendientes);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Consulta para obtener Tiempo Promedio de Respuesta
    $consultaTiempoRespuesta = "SELECT ROUND(AVG(TIMESTAMPDIFF(DAY, fechaSolicitud, fechaRespuesta)), 1) AS tiempoPromedioRespuestaDias
                                FROM Pruebas
                                WHERE MONTH(fechaRespuesta) = ? AND YEAR(fechaRespuesta) = ? AND id_estatusPrueba IN (4,9)";
    $stmt = mysqli_prepare($conex, $consultaTiempoRespuesta);
    mysqli_stmt_bind_param($stmt, "ii", $mes, $anio);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $tiempoPromedioRespuestaDias);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Consulta para obtener Eficiencia Operativa
    $consultaEficiencia = "SELECT ROUND(COUNT(*) / DAY(LAST_DAY(STR_TO_DATE(CONCAT(?, '-', ?, '-01'), '%Y-%m-%d'))), 2) AS eficienciaOperativa
                           FROM Pruebas
                           WHERE MONTH(fechaRespuesta) = ? AND YEAR(fechaRespuesta) = ? AND id_estatusPrueba IN (4, 9)";
    $stmt = mysqli_prepare($conex, $consultaEficiencia);
    mysqli_stmt_bind_param($stmt, "iiii", $anio, $mes, $mes, $anio);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $eficienciaOperativa);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);


    // Consulta para obtener Pruebas atendidas por metrologo
    $consultaPruebasPorMetrologo  = "SELECT u.nombreUsuario, COUNT(id_prueba) as pruebasRealizadas 
                            FROM Pruebas p, Usuario u 
                            WHERE MONTH(fechaRespuesta) = ? 
                            AND YEAR(fechaRespuesta) = ?
                            AND id_estatusPrueba IN (4, 9) 
                            AND p.id_metrologo = u.id_usuario 
                            GROUP BY p.id_metrologo;";
    $stmt = mysqli_prepare($conex, $consultaPruebasPorMetrologo);
    mysqli_stmt_bind_param($stmt, "ii", $mes, $anio);
    mysqli_stmt_execute($stmt);
    $resultadoMetrologos = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    mysqli_commit($conex);

} catch (Exception $e) {
    mysqli_rollback($conex);
    die('Error en la transacción: ' . $e->getMessage());
}

$date = date('d-m-Y');
$css = file_get_contents("../../css/pdf.css");
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../../imgs/Grammer_Logo.ico" type="image/x-icon">
    <title>Reporte <?php echo obtenerNombreMes($mes).' '; echo $anio?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!--Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>
<body >

<main>
    <div class="page-header row headerLogo">
        <table id="tableTitle">
            <tr class="">
                <th class="">
                    <div class="col divTitle" id="divRespdf">
                        <h1>Reporte <?php echo obtenerNombreMes($mes).' '; echo $anio?></h1>
                        <h6>LABORATORIO DE METROLOGÍA</h6>
                        <?php echo "<small>Fecha: $date</small>";?>
                    </div>
                </th>
                <td>
                    <div class="col">
                        <img class="logoGrammer2-img logoR" alt="LogoGrammer" src="https://grammermx.com/Metrologia/MetroTickets/imgs/logoGrammer.png"><br>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="container-fluid" id="containerPruebaPDF" >
        <div class="row">
            <div class="table-responsive">
                <h5 id="titleTablaPDFg">ESTADÍSTICAS</h5>
                <table class="table table-bordered table-hover table-sm  table-responsive" id="datosGeneralesTablePDF">
                    <tbody>
                    <tr class="bg-primary">
                        <th class="">Pruebas realizadas: </th>
                        <td> <?php echo $pruebasRealizadas;?> </td>
                        <th class="" > Tiempo de respuesta </th>
                        <td><?php echo $tiempoPromedioRespuestaDias ." días/prueba";?></td>
                    </tr>
                    <tr>
                        <th class="">Pruebas pendientes </th>
                        <td><?php echo $pruebasPendientes;?></td>
                        <th class=""> Eficiencia operativa</th>
                        <td><?php echo $eficienciaOperativa." pruebas/dia";?> </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div id="" class="table-responsive">
                <h5 id="materialPDF">PRUEBAS POR METRÓLOGO</h5>
                <table class="table table-striped" id="materialesResumenPDF">
                    <thead>
                    <tr>
                        <th>Metrólogo</th>
                        <th>Pruebas atendidas</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($fila = mysqli_fetch_assoc($resultadoMetrologos)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($fila['nombreUsuario']); ?></td>
                            <td><?php echo htmlspecialchars($fila['pruebasRealizadas']); ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <div id="" class="table-responsive">
                <h5 id="titleTablaPDF">PRUEBAS SOLICITADAS</h5>
                <table class="table table-bordered table-hover table-sm table-responsive" id="resultadosTablePDF">
                    <thead>
                    <tr>
                        <th>Tipo de prueba</th>
                        <th>Núm. de pruebas</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Extracción</td>
                            <td>"20"</td>
                        </tr>
                        <tr>
                            <td>Compresión</td>
                            <td>"16"</td>
                        </tr>
                        <tr>
                            <td>Otra</td>
                            <td>"17"</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<footer class="footer_section">
    <div class="container-fluid">
        <div class="row" >
            <div class="col-sm-4 text-center">
                <small> <a href="https://grammermx.com/Metrologia/MetroTickets/modules/sesion/indexSesion.php">Laboratorio de Metrología </a></small><br>
                <small> metrotickets@arketipo.com.mx </small><br>
                <strong><small>LABORATORIO DE METROLOGÍA</small></strong>
            </div>
        </div>
    </div>
</footer>
</body>
</html>

<?php
$html=ob_get_clean();
//echo $html;

// Incorpora los estilos CSS al HTML
$html = "<style>" . $css . "</style>" . $html;

require_once '../../librerias/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();

$options = $dompdf -> getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);

$dompdf->setPaper('letter');

$dompdf->render();
/*
$f = null;
$l = null;
if(headers_sent($f,$l)){
    echo $f,'<br/>',$l,'<br/>';
    die('se detecto linea');
}*/
$dompdf->stream("LM-Preporte_" . obtenerNombreMes($mes) . $anio . ".pdf", array("Attachment" => false));

?>
