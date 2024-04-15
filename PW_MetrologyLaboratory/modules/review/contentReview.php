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
                <table class="table table-bordered table-hover table-sm">
                    <tbody>
                        <tr class="bg-primary">
                            <th class="p-2 mb-2 bg-secondary text-white">No. de solicitud: </th>
                            <td id="numeroPruebaR"> </td>
                            <th class="p-2 mb-2 bg-secondary text-white" > Fecha de Solicitud: </th>
                            <td id="fechaSolicitudR"> </td>
                        </tr>
                        <tr>
                            <th class="p-2 mb-2 bg-secondary text-white">Tipo de Prueba: </th>
                            <td id="tipoPruebaSolicitudR" ></td>
                            <th class="p-2 mb-2 bg-secondary text-white"> Solicitante:</th>
                            <td id="solicitanteR"> </td>
                        </tr>
                        <tr>
                            <th class="p-2 mb-2 bg-secondary text-white">Norma: </th>
                            <td id="normaNombreR"></td>
                            <th class="p-2 mb-2 bg-secondary text-white">Documento de la norma: </th>
                            <td><a id="archivoNormaR" href="">Archivo pdf</a></td>
                        </tr>
                        <tr>
                            <th class="p-2 mb-2 bg-secondary text-white">Observaciones del solicitante:</th>
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
                <table class="table table-bordered table-hover table-sm">
                    <tbody>
                    <tr>
                        <th class="p-2 mb-2 bg-secondary text-white">Fecha de Respuesta:</th>
                        <td id="fechaRespuestaR"></td>
                        <th class="p-2 mb-2 bg-secondary text-white">Metrólogo:</th>
                        <td id="metrologoR"> </td>
                    </tr>
                    <tr>
                        <th class="p-2 mb-2 bg-secondary text-white">Estatus: </th>
                        <td id="estatusSolicitudR" ></td>
                        <th class="p-2 mb-2 bg-secondary text-white">Prioridad:</th>
                        <td id="prioridadR"> </td>
                    </tr>
                    <tr>
                        <th class="p-2 mb-2 bg-secondary text-white">Observaciones del laboratorio:</th>
                        <td id="observacionesLabR" colspan="3"></td>
                    </tr>
                    <tr>
                        <th class="p-2 mb-2 bg-secondary text-white">Resultados:</th>
                        <td id="rutaResultadosR"  colspan="3"></td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</main>