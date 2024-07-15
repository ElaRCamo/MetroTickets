
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
$date = date('d-m-Y');
$css=file_get_contents("../../css/pdf.css");
include_once('../../dao/connection.php');

// Crear una nueva instancia de la conexión
$con = new LocalConector();
$conex = $con->conectar();

$queryTipoPrueba = "SELECT id_tipoPrueba FROM Pruebas WHERE id_prueba = '$id_prueba'";
// Ejecutar la consulta
$resultado = $conex->query($queryTipoPrueba);
    // Obtener la fila del resultado
    $fila = $resultado->fetch_assoc();
    // Asignar el id_tipoPrueba a una variable
    $id_tipoPrueba = $fila['id_tipoPrueba'];


$queryDatosMunsell = "SELECT   prueba.id_prueba, 
                                                    prueba.fechaSolicitud, 
                                                    prueba.fechaRespuesta, 
                                                    prueba.fechaCompromiso,
                                                    prueba.descripcionEstatus,
                                                    prueba.descripcionPrioridad,
                                                    prueba.descripcionPrueba, 
                                                    prueba.id_tipoPrueba,
                                                    prueba.especificaciones,
                                                    prueba.especificacionesLab,
                                                    prueba.resultados,
                                                    prueba.id_metrologo, 
                                                    prueba.nombreMetro,  
                                                    prueba.id_solicitante, 
                                                    prueba.nombreSolic,
                                                    pm.nomina,
                                                    pm.nombre,
                                                    pm.area
                                                FROM   
                                                    PersonalMunsell pm
                                                    JOIN (
                                                        SELECT 
                                                            id_prueba, 
                                                            fechaSolicitud, 
                                                            fechaRespuesta,
                                                            fechaCompromiso,
                                                            descripcionEstatus,
                                                            descripcionPrioridad,
                                                            s.id_tipoPrueba, 
                                                            descripcionPrueba,
                                                            especificaciones,
                                                            especificacionesLab,
                                                            resultados,
                                                            s.id_metrologo, 
                                                            u_metro.nombreUsuario AS nombreMetro,
                                                            s.id_solicitante, 
                                                            u_solic.nombreUsuario AS nombreSolic
                                                        FROM 
                                                            Pruebas s
                                                            LEFT JOIN Usuario u_metro ON s.id_metrologo = u_metro.id_usuario
                                                            LEFT JOIN Usuario u_solic ON s.id_solicitante = u_solic.id_usuario
                                                            LEFT JOIN TipoPrueba tp ON s.id_tipoPrueba = tp.id_tipoPrueba
                                                            LEFT JOIN SubtipoPrueba sp ON s.id_subtipo = sp.id_subtipo
                                                            LEFT JOIN EstatusPrueba ep ON s.id_estatusPrueba = ep.id_estatusPrueba
                                                            LEFT JOIN Prioridad p ON s.id_prioridad = p.id_prioridad
                                                        WHERE 
                                                            id_prueba = '$id_prueba'
                                                    ) AS prueba ON pm.id_prueba = prueba.id_prueba;";

$queryDatosPrueba = "SELECT   prueba.id_prueba, 
                                                    prueba.fechaSolicitud, 
                                                    prueba.fechaRespuesta, 
                                                    prueba.descripcionEstatus,
                                                    prueba.descripcionPrioridad,
                                                    prueba.descripcionPrueba, 
                                                    prueba.id_tipoPrueba,
                                                    prueba.id_subtipo,
                                                    prueba.descripcion, 
                                                    prueba.imagenCotas,
                                                    prueba.especificaciones,
                                                    prueba.especificacionesLab,
                                                    prueba.normaNombre,
                                                    prueba.normaArchivo,
                                                    prueba.resultados,
                                                    prueba.id_metrologo, 
                                                    prueba.nombreMetro,  
                                                    prueba.id_solicitante, 
                                                    prueba.nombreSolic,
                                                    m.numParte, 
                                                    m.cantidad, 
                                                    c.descripcionCliente, 
                                                    p.descripcionPlataforma,
                                                    m.revisionDibujo,
                                                    m.modMatematico,
                                                    em.descripcionEstatus AS estatusMaterial
                                                FROM   
                                                    Piezas m
                                                    JOIN Plataforma p ON m.id_plataforma = p.id_plataforma
                                                    JOIN Cliente c ON p.id_cliente = c.id_cliente
                                                    JOIN EstatusPiezas em ON m.id_estatus = em.id_estatus
                                                    JOIN (
                                                        SELECT 
                                                            id_prueba, 
                                                            fechaSolicitud, 
                                                            fechaRespuesta,
                                                            descripcionEstatus,
                                                            descripcionPrioridad,
                                                            s.id_tipoPrueba,
                                                            s.id_subtipo,
                                                            descripcion, 
                                                            imagenCotas,
                                                            descripcionPrueba,
                                                            especificaciones,
                                                            especificacionesLab,
                                                            normaNombre,
                                                            normaArchivo,
                                                            resultados,
                                                            s.id_metrologo, 
                                                            u_metro.nombreUsuario AS nombreMetro,
                                                            s.id_solicitante, 
                                                            u_solic.nombreUsuario AS nombreSolic
                                                        FROM 
                                                            Pruebas s
                                                            LEFT JOIN Usuario u_metro ON s.id_metrologo = u_metro.id_usuario
                                                            LEFT JOIN Usuario u_solic ON s.id_solicitante = u_solic.id_usuario
                                                            LEFT JOIN TipoPrueba tp ON s.id_tipoPrueba = tp.id_tipoPrueba
                                                            LEFT JOIN SubtipoPrueba sp ON s.id_subtipo = sp.id_subtipo
                                                            LEFT JOIN EstatusPrueba ep ON s.id_estatusPrueba = ep.id_estatusPrueba
                                                            LEFT JOIN Prioridad p ON s.id_prioridad = p.id_prioridad
                                                        WHERE 
                                                            id_prueba = '$id_prueba'
                                                    ) AS prueba ON m.id_prueba = prueba.id_prueba;";

if($id_tipoPrueba === '5'){
    $queryEjecutar = $queryDatosMunsell;
}else{
    $queryEjecutar = $queryDatosPrueba;
}
$datosPrueba =  mysqli_query($conex, $queryEjecutar);

$resultados= mysqli_fetch_all($datosPrueba, MYSQLI_ASSOC);
// Cerrar la conexión
$conex->close();
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

                    <!-- Mostrar imagen cotas para tipo DIMENSIONAL -->
                    <?php
                    $tipoPrueba = $resultados[0]['id_tipoPrueba'];
                    $subtipoPrueba = $resultados[0]['id_subtipo'];
                    $descSubtipo = $resultados[0]['descripcion'];
                    $imagen = $resultados[0]['imagenCotas'];

                    if ($tipoPrueba === '3'): // dimensional ?>
                        <tr>
                            <th class="">Subtipo: </th>
                            <td><?php echo $descSubtipo; ?></td>
                            <th class="">Imagen Cotas: </th>
                            <td>
                                <?php if ($subtipoPrueba === '2'): ?>
                                    <a href="<?php echo $imagen; ?>">Consultar imagen</a>
                                <?php elseif ($subtipoPrueba === '1'): ?>
                                    <a href="#">No aplica</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <!-- Mostrar norma solo para los tipos de prueba que correspondan -->
                    <?php
                    if ($tipoPrueba === '1' || $tipoPrueba === '2' || $tipoPrueba === '6'): // IDL/IFD | SOFTNESS | OTRO
                        ?>
                        <tr>
                            <th class="">Norma: </th>
                            <td><?php echo $resultados[0]['normaNombre'];?></td>
                            <th class="">Documento (norma): </th>
                            <td>
                                <?php
                                $urlCompleta = $resultados[0]['normaArchivo'];
                                if($urlCompleta != 'No aplica' && $urlCompleta != 'Ningún archivo seleccionado'){
                                    $nombreArchivo = substr($urlCompleta, strrpos($urlCompleta, '/') + 1);
                                    $numeroReferencia = explode('-', $nombreArchivo)[1];
                                    $nombreArchivoSinPDF = substr($nombreArchivo, 0, strrpos($nombreArchivo, '.')); // Eliminar la extensión .pdf
                                    $nombreArchivoMostrado = substr($nombreArchivoSinPDF, strlen($numeroReferencia) + 1);
                                    echo '<a href="' . $urlCompleta . '">' . $nombreArchivoMostrado . '</a>';
                                } else {
                                    echo $urlCompleta;
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <tr>
                        <th class="">Especifícaciones/ Comentarios: </th>
                        <td colspan="3"><?php echo $resultados[0]['especificaciones'];?></td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Mostrar tabla para Munsell -->
            <?php
            if ($tipoPrueba === '5'):
            ?>
            <div id="" class="table-responsive">
                <h5 id="materialPDF">PIEZAS PARA MEDICIÓN</h5>
                <table class="table table-striped" id="materialesResumenPDF">
                    <thead>
                    <tr>
                        <th>No. Nómina</th>
                        <th>Nombre</th>
                        <th>Área</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultados as $resultado){?>
                        <tr>
                            <td><?php echo $resultado['nomina'];?> </td>
                            <td><?php echo $resultado['nombre'];?></td>
                            <td><?php echo $resultado['area'];?></td>
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
                        <td id=""  colspan="3"><?php echo $resultados[0]['resultados'];?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <?php  //Otro tipo de prueba
            else:
                ?>
                <div id="" class="table-responsive">
                    <h5 id="materialPDF">PIEZAS PARA MEDICIÓN</h5>
                    <table class="table table-striped" id="materialesResumenPDF">
                        <thead>
                        <tr>
                            <th>No. de Parte</th>
                            <th>Cantidad</th>
                            <th>Cliente</th>
                            <th>Plataforma</th>
                            <th>Revisión de Dibujo</th>
                            <th>Modelo Matemático</th>
                            <th>Estatus</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($resultados as $resultado){?>
                            <tr>
                                <td><?php echo $resultado['numParte'];?> </td>
                                <td><?php echo $resultado['cantidad'];?></td>
                                <td><?php echo $resultado['descripcionCliente'];?></td>
                                <td><?php echo $resultado['descripcionPlataforma'];?></td>
                                <td><?php echo $resultado['revisionDibujo'];?></td>
                                <td><?php echo $resultado['modMatematico'];?></td>
                                <td><?php echo $resultado['estatusMaterial'];?></td>
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
                            <td id=""  colspan="3"><?php echo $resultados[0]['resultados'];?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
            <!--div  id="divUpdate">
                <span >Ultima actualización: <span class="" id="fechaUpdateR"><php echo $resultados[0]['fechaActualizacion'];?></span></span>
            </div> -->
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
$dompdf->stream("LM-Prueba_$id_prueba.pdf", array("Attachment" => false));
?>
