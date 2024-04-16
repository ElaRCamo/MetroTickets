
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
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$url_parts = parse_url($actual_link);// Obtener las partes de la URL
parse_str($url_parts['query'], $query_params);// Obtener los parámetros de consulta
$id_prueba = $query_params['id_prueba'];// Extraer el ID de la prueba

ob_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../../imgs/Grammer_Logo.ico" type="image/x-icon">
    <title>Prueba <?php echo $id_prueba?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!--Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>
<body >
<?php
$date = date('d-m-Y h:i A');
$css=file_get_contents("../../css/pdf.css");
include_once('../../dao/connection.php');
$con = new LocalConector();
$conex = $con->conectar();

$datosPrueba =  mysqli_query($conex,
                                "SELECT   prueba.id_prueba, 
                                                    prueba.fechaSolicitud, 
                                                    prueba.fechaRespuesta, 
                                                    prueba.descripcionEstatus,
                                                    prueba.descripcionPrioridad,
                                                    prueba.descripcionPrueba, 
                                                    prueba.especificaciones,
                                                    prueba.especificacionesLab,
                                                    prueba.normaNombre,
                                                    prueba.normaArchivo,
                                                    prueba.rutaResultados,
                                                    prueba.id_metrologo, 
                                                    prueba.nombreMetro,  
                                                    prueba.id_solicitante, 
                                                    prueba.nombreSolic,
                                                    dm.numeroDeParte, 
                                                    m.cantidad, 
                                                    dm.descripcionMaterial, 
                                                    dm.imgMaterial, 
                                                    c.descripcionCliente, 
                                                    p.descripcionPlataforma
                                                FROM   
                                                    Material m
                                                    JOIN DescripcionMaterial dm ON m.id_descripcion = dm.id_descripcion
                                                    JOIN Plataforma p ON dm.id_plataforma = p.id_plataforma
                                                    JOIN Cliente c ON p.id_cliente = c.id_cliente
                                                    JOIN EstatusMaterial em ON m.id_estatusMaterial = em.id_estatusMaterial
                                                    JOIN (
                                                        SELECT 
                                                            id_prueba, 
                                                            fechaSolicitud, 
                                                            fechaRespuesta,
                                                            descripcionEstatus,
                                                            descripcionPrioridad,
                                                            descripcionPrueba,
                                                            especificaciones,
                                                            especificacionesLab,
                                                            normaNombre,
                                                            normaArchivo,
                                                            rutaResultados,
                                                            s.id_metrologo, 
                                                            u_metro.nombreUsuario AS nombreMetro,
                                                            s.id_solicitante, 
                                                            u_solic.nombreUsuario AS nombreSolic
                                                        FROM 
                                                            Prueba s
                                                            LEFT JOIN Usuario u_metro ON s.id_metrologo = u_metro.id_usuario
                                                            LEFT JOIN Usuario u_solic ON s.id_solicitante = u_solic.id_usuario
                                                            LEFT JOIN TipoPrueba tp ON s.id_tipoPrueba = tp.id_tipoPrueba
                                                            LEFT JOIN EstatusPrueba ep ON s.id_estatusPrueba = ep.id_estatusPrueba
                                                            LEFT JOIN Prioridad p ON s.id_prioridad = p.id_prioridad
                                                        WHERE 
                                                            id_prueba = '$id_prueba'
                                                    ) AS prueba ON m.id_prueba = prueba.id_prueba;");

$resultados= mysqli_fetch_all($datosPrueba, MYSQLI_ASSOC);

?>
<main>
    <div class="page-header row headerLogo">
        <table id="tableTitle">
            <tr class="">
                <th class="">
                    <div class="col divTitle" id="divRespdf">
                        <h1>Resumen de Solicitud <?php echo $resultados[0]['id_prueba'];?></h1>
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
                <h5 id="titleTablaPDFg">DATOS GENERALES</h5>
                <table class="table table-bordered table-hover table-sm  table-responsive" id="datosGeneralesTablePDF">
                    <tbody>
                    <tr class="bg-primary">
                        <th class="">No. de solicitud: </th>
                        <td> <?php echo $resultados[0]['id_prueba'];?> </td>
                        <th class="" > Fecha de Solicitud: </th>
                        <td><?php echo $resultados[0]['fechaSolicitud'];?></td>
                    </tr>
                    <tr>
                        <th class="">Tipo de Prueba: </th>
                        <td><?php echo $resultados[0]['descripcionPrueba'];?></td>
                        <th class=""> Solicitante:</th>
                        <td><?php echo $resultados[0]['nombreSolic'];?> </td>
                    </tr>
                    <tr>
                        <th class="">Norma: </th>
                        <td><?php echo $resultados[0]['normaNombre'];?></td>
                        <th class="">Documento de la norma: </th>
                        <td><a href="<?php echo $resultados[0]['normaArchivo'];?>">Archivo pdf</a></td>
                    </tr>
                    <tr>
                        <th class="">Especifícaciones: </th>
                        <td colspan="3"><?php echo $resultados[0]['especificaciones'];?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div id="" class="table-responsive">
                <h5 id="materialPDF">MATERIAL PARA MEDICIÓN</h5>
                <table class="table table-striped" id="materialesResumenPDF">
                    <thead>
                    <tr>
                        <th>No. de Parte</th>
                        <th>Material</th>
                        <th>Cantidad</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultados as $resultado){?>
                        <tr>
                            <td><?php echo $resultado['numeroDeParte'];?> </td>
                            <td><?php echo $resultado['descripcionMaterial'];?></td>
                            <td><?php echo $resultado['cantidad'];?></td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
            <div id="" class="table-responsive">
                <h5 id="titleTablaPDF">RESULTADOS</h5>
                <table class="table table-bordered table-hover table-sm table-responsive" id="resultadosTablePDF">
                    <tbody>
                    <tr>
                        <th class="">Fecha de Respuesta:</th>
                        <td id=""><?php echo $resultados[0]['fechaRespuesta'];?></td>
                        <th class="">Metrólogo:</th>
                        <td id=""><?php echo $resultados[0]['nombreMetro'];?> </td>
                    </tr>
                    <tr>
                        <th class="">Estatus: </th>
                        <td id="" ><?php echo $resultados[0]['descripcionEstatus'];?></td>
                        <th class="">Prioridad:</th>
                        <td id=""> <?php echo $resultados[0]['descripcionPrioridad'];?></td>
                    </tr>
                    <tr>
                        <th class="">Observaciones:</th>
                        <td id="" colspan="3"><?php echo $resultados[0]['especificacionesLab'];?></td>
                    </tr>
                    <tr>
                        <th class="">Resultados:</th>
                        <td id=""  colspan="3"><?php echo $resultados[0]['rutaResultados'];?></td>
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
                <small> Laboratorio de Metrología </small><br>
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
$dompdf->stream("LM-Prueba_.$id_prueba.pdf", array("Attachment" => false));
?>
