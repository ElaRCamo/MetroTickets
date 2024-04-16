
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
</head>
<body >
<?php
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
        <div class="col divTitle" id="divResSol">
            <h1>Resumen de Solicitud <?php echo $resultados[0]['id_prueba'];?></h1>
        </div>
        <div class="logoRight col-sm-3">
            <div>
                <img class="logoGrammer2-img logoR img-responsive" alt="LogoGrammer" src="https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/logoGrammer.png"><br>
            </div>
            <div>
                <span><small>GRAMMER AUTOMOTIVE PUEBLA S. A. DE C. V.</small></span>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="containerPruebaR" >
        <div class="row">
            <div id="divTablePrueba" class="table-responsive">
                <h5 id="titleTablaP">DATOS GENERALES</h5>
                <table class="table table-bordered table-hover table-sm  table-responsive" id="datosGeneralesTable">
                    <tbody>
                    <tr class="bg-primary">
                        <th class="p-2 mb-2">No. de solicitud: </th>
                        <td id="numeroPruebaR"> <?php echo $resultados[0]['id_prueba'];?> </td>
                        <th class="p-2 mb-2" > Fecha de Solicitud: </th>
                        <td id="fechaSolicitudR"><?php echo $resultados[0]['fechaSolicitud'];?></td>
                    </tr>
                    <tr>
                        <th class="p-2 mb-2">Tipo de Prueba: </th>
                        <td id="tipoPruebaSolicitudR" ><?php echo $resultados[0]['descripcionPrueba'];?></td>
                        <th class="p-2 mb-2"> Solicitante:</th>
                        <td id="solicitanteR"><?php echo $resultados[0]['nombreSolic'];?> </td>
                    </tr>
                    <tr>
                        <th class="p-2 mb-2">Norma: </th>
                        <td id="normaNombreR"><?php echo $resultados[0]['normaNombre'];?></td>
                        <th class="p-2 mb-2">Documento de la norma: </th>
                        <td><a id="archivoNormaR" href="<?php echo $resultados[0]['normaArchivo'];?>">Archivo pdf</a></td>
                    </tr>
                    <tr>
                        <th class="p-2 mb-2">Especifícaciones: </th>
                        <td id="observacionesSolR" colspan="3"><?php echo $resultados[0]['especificaciones'];?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div id="divTableResume" class="table-responsive">
                <h5 id="materialRTittle">MATERIAL PARA MEDICIÓN</h5>
                <table class="table table-striped" id="materialesResumen">
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
            <div id="divTablePrueba" class="table-responsive">
                <h5 id="titleTablaP">RESULTADOS</h5>
                <table class="table table-bordered table-hover table-sm table-responsive" id="resultadosTable">
                    <tbody>
                    <tr>
                        <th class="p-2 mb-2 ">Fecha de Respuesta:</th>
                        <td id="fechaRespuestaR"><?php echo $resultados[0]['fechaRespuesta'];?></td>
                        <th class="p-2 mb-2 ">Metrólogo:</th>
                        <td id="metrologoR"><?php echo $resultados[0]['nombreMetro'];?> </td>
                    </tr>
                    <tr>
                        <th class="p-2 mb-2">Estatus: </th>
                        <td id="estatusSolicitudR" ><?php echo $resultados[0]['descripcionEstatus'];?></td>
                        <th class="p-2 mb-2 ">Prioridad:</th>
                        <td id="prioridadR"> <?php echo $resultados[0]['descripcionPrioridad'];?></td>
                    </tr>
                    <tr>
                        <th class="p-2 mb-2">Observaciones:</th>
                        <td id="observacionesLabR" colspan="3"><?php echo $resultados[0]['especificacionesLab'];?></td>
                    </tr>
                    <tr>
                        <th class="p-2 mb-2">Resultados:</th>
                        <td id="rutaResultadosR"  colspan="3"><?php echo $resultados[0]['rutaResultados'];?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/js/general.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>

<?php
$html=ob_get_clean();
//echo $html;

require_once '../../librerias/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();

$options = $dompdf -> getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);

$dompdf->setPaper('letter');

$dompdf->render();

$f = null;
$l = null;
if(headers_sent($f,$l)){
    echo $f,'<br/>',$l,'<br/>';
    die('se detecto linea');
}
$dompdf->stream("reporte_solicitud.pdf", array("Attachment" => false));
?>
