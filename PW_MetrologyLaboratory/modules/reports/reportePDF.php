
<?php
header_remove();
session_start();

if (!isset($_SESSION['tipoUsuario'])){
    header("Location: https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/sesion/indexSesion.php");
}else{
    if($_SESSION['tipoUsuario']=="ok"){
        $nombreUser = $_SESSION['nombreUsuario'];
    }
}

include_once('../../dao/funtions.php');
// Obtener los parámetros directamente desde $_GET
$tipoReporte = filter_input(INPUT_GET, 'tipo', FILTER_SANITIZE_STRING);
$anio = filter_input(INPUT_GET, 'anio', FILTER_SANITIZE_NUMBER_INT);
$mes = filter_input(INPUT_GET, 'mes', FILTER_SANITIZE_NUMBER_INT);
$mes = (int)$mes;
if (!$tipoReporte || !$anio || !$mes) {
    die('Faltan parámetros o son inválidos.');
}

ob_start();
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
<?php
$date = date('d-m-Y');
$css=file_get_contents("../../css/pdf.css");
include_once('../../dao/connection.php');
$con = new LocalConector();
$conex = $con->conectar();

$datosPrueba =  mysqli_query($conex,
                                " ");

$resultados= mysqli_fetch_all($datosPrueba, MYSQLI_ASSOC);

?>
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
                        <img class="logoGrammer2-img logoR" alt="LogoGrammer" src="https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/logoGrammer.png"><br>
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
                        <td> <?php echo "17";?> </td>
                        <th class="" > Tiempo de respuesta </th>
                        <td><?php echo "14.8 días/prueba";?></td>
                    </tr>
                    <tr>
                        <th class="">Pruebas pendientes </th>
                        <td><?php echo "2";?></td>
                        <th class=""> Eficiencia operativa</th>
                        <td><?php echo "0.5 pruebas/dia";?> </td>
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
                        <tr>
                            <td>Kevin Perez</td>
                            <td>"20"</td>
                        </tr>
                        <tr>
                            <td>Paola Gonzalez</td>
                            <td>"16"</td>
                        </tr>
                        <tr>
                            <td>Luisa Sánchez</td>
                            <td>"17"</td>
                        </tr>
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
                <small> <a href="https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/sesion/indexSesion.php">Laboratorio de Metrología </a></small><br>
                <small> laboratoriometrologia@arketipo.com.mx </small><br>
                <strong><small>GRAMMER AUTOMOTIVE PUEBLA S. A. DE C. V.</small></strong>
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
