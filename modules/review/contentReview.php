<main>
    <div class="page-header row headerLogo">
        <div class="col divTitle" id="divResSol">
            <h1 id="h1Resumen">Resumen de Solicitud </h1>
            <a onclick="reviewPDF(id_review)" class="btnPDF"><i class="las la-file-pdf"></i>Descargar solicitud en pdf</a>
            <?php global $tipoUser; if ($tipoUser== 1 || $tipoUser== 2){ ?><a onclick="updatePrueba(); actualizarTitulo();" id="updateBtnP" class="btnPDF" data-bs-toggle="modal" data-bs-target="#modalResultados"><i class="lar la-edit"></i>Responder</a> <?php } ?>
            <?php global $tipoUser; if ($tipoUser== 3){ ?><a id="updateBtnS" class="btnPDF"><i class="lar la-edit"></i>Actualizar</a><?php } ?>
        </div>
        <div class="logoRight col-sm-3">
            <div>
                <img class="logoGrammer2-img logoR img-responsive" alt="LogoGrammer" src="https://grammermx.com/Metrologia/MetroTickets/imgs\logoGrammer.png"><br>
            </div>
            <div>
                <span><small>LABORATORIO DE METROLOGÍA</small></span>
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
                            <td id="numeroPruebaR"> </td>
                            <th class="p-2 mb-2"> Fecha de Solicitud: </th>
                            <td id="fechaSolicitudR"> </td>
                        </tr>
                        <tr id="trTipoPrueba">
                            <th class="p-2 mb-2">Tipo de Prueba: </th>
                            <td id="tipoPruebaSolicitudR"></td>
                            <th class="p-2 mb-2"> Solicitante:</th>
                            <td id="solicitanteR"> </td>
                        </tr>
                        <tr>
                            <th class="p-2 mb-2">Especifícaciones / comentarios: </th>
                            <td id="observacionesSolR" colspan="3"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="divTableResume" class="table-responsive">
                <h5 id="materialRTittle"></h5>
                <table class="table table-striped" id="materialesResumen">

                    <tbody></tbody>
                </table>
            </div>
            <div id="divTablePrueba" class="table-responsive">
                <h5 id="titleTablaP">RESULTADOS</h5>
                <table class="table table-bordered table-hover table-sm table-responsive" id="resultadosTable">
                    <tbody>
                    <tr>
                        <th class="p-2 mb-2 ">Fecha Compromiso:</th>
                        <td id="fechaCompromisoR"></td>
                        <th class="p-2 mb-2 ">Metrólogo:</th>
                        <td id="metrologoR"> </td>
                    </tr>
                    <tr>
                        <th class="p-2 mb-2">Estatus: </th>
                        <td id="estatusSolicitudR" ></td>
                        <th class="p-2 mb-2 ">Prioridad:</th>
                        <td id="prioridadR"> </td>
                    </tr>
                    <tr>
                        <th class="p-2 mb-2">Observaciones:</th>
                        <td id="observacionesLabR" colspan="3"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- <div  id="divUpdate">
                <span >Ultima actualización: <span class="" id="fechaUpdateR"></span></span>
            </div> -->
        </div>
    </div>
</main>