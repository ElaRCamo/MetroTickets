<main>
    <div class="page-header row headerLogo">
        <div class="col divTitle" id="divResSol">
            <h1>Resumen de Solicitud </h1>
            <button type="button" class="btnPDF" onclick="descargarPDF()">Descargar solicitud en pdf</button>
        </div>
        <div class="logoRight col-sm-3">
            <div>
                <img class="logoGrammer2-img logoR img-responsive" alt="LogoGrammer" src="https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory\imgs\logoGrammer.png"><br>
            </div>
            <div>
                <span><small>GRAMMER AUTOMOTIVE PUEBLA S. A. DE C. V.</small></span>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="containerPruebaR" >
        <div class="row">
            <div id="divTablePrueba">
                <h5 id="titleTablaP">DATOS GENERALES</h5>
                <table class="table table-bordered table-hover table-sm table-responsive" id="datosGeneralesTable">
                    <tbody>
                        <tr class="bg-primary">
                            <th class="p-2 mb-2">No. de solicitud: </th>
                            <td id="numeroPruebaR"> </td>
                            <th class="p-2 mb-2" > Fecha de Solicitud: </th>
                            <td id="fechaSolicitudR"> </td>
                        </tr>
                        <tr>
                            <th class="p-2 mb-2">Tipo de Prueba: </th>
                            <td id="tipoPruebaSolicitudR" ></td>
                            <th class="p-2 mb-2"> Solicitante:</th>
                            <td id="solicitanteR"> </td>
                        </tr>
                        <tr>
                            <th class="p-2 mb-2">Norma: </th>
                            <td id="normaNombreR"></td>
                            <th class="p-2 mb-2">Documento de la norma: </th>
                            <td><a id="archivoNormaR" href="">Archivo pdf</a></td>
                        </tr>
                        <tr>
                            <th class="p-2 mb-2">Observaciones del solicitante:</th>
                            <td id="observacionesSolR" colspan="3"></td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div id="divTableResume">
                <h5 id="materialRTittle">MATERIAL PARA MEDICIÓN</h5>
                <table class="table table-striped table-responsive" id="materialesResumen">
                    <thead>
                    <tr>
                        <th>No. de Parte</th>
                        <th>Material</th>
                        <th>Cantidad</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div id="divTablePrueba">
                <h5 id="titleTablaP">RESULTADOS</h5>
                <table class="table table-bordered table-hover table-sm table-responsive" id="resultadosTable">
                    <tbody>
                    <tr>
                        <th class="p-2 mb-2 ">Fecha de Respuesta:</th>
                        <td id="fechaRespuestaR"></td>
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
                        <th class="p-2 mb-2">Observaciones del laboratorio:</th>
                        <td id="observacionesLabR" colspan="3"></td>
                    </tr>
                    <tr>
                        <th class="p-2 mb-2">Resultados:</th>
                        <td id="rutaResultadosR"  colspan="3"></td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</main>