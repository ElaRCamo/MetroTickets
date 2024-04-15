<main>
    <div class="page-header row headerLogo">
        <div class="col divTitle">
            <h1>Resumen de Solicitud </h1>
            <button type="button" class="btn btn-secondary" onclick="descargarPDF()">Descargar solicitud en pdf</button>
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
                            <th scope="row">No. de solicitud: </th>
                            <td id="numeroPruebaR"> </td>
                            <th scope="row"> Fecha de Solicitud: </th>
                            <td id="fechaSolicitudR"> </td>
                        </tr>
                        <tr>
                            <th scope="row">Tipo de Prueba: </th>
                            <td id="tipoPruebaSolicitudR" class="bg-success"></td>
                            <th scope="row"> Solicitante:</th>
                            <td id="solicitanteR"> </td>
                        </tr>
                        <tr>
                            <th scope="row">Norma: </th>
                            <td id="normaNombreR" class="bg-success"></td>
                            <th scope="row">Documento de la norma: </th>
                            <td><a id="archivoNormaR" href="">Archivo pdf</a></td>
                        </tr>
                        <tr>
                            <th scope="row" >Observaciones del solicitante:</th>
                            <td id="observacionesSolR" colspan="3"></td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <div class="row">
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
                <div class=""></div>
            </div>

            <div id="divTablePrueba">
                <h5 id="titleTablaP">RESULTADOS</h5>
                <table class="table table-bordered table-hover table-sm">
                    <tbody>
                    <tr>
                        <th scope="row">Fecha de Respuesta:</th>
                        <td id="fechaRespuestaR" class="bg-success"></td>
                        <th scope="row">Metrólogo:</th>
                        <td id="metrologoR"> </td>
                    </tr>
                    <tr>
                        <th "estatusSolicitudR" scope="row">Estatus: </th>
                        <td class="bg-success"></td>
                        <th scope="row">Prioridad:</th>
                        <td id="prioridadR"> </td>
                    </tr>
                    <tr>
                        <th id="observacionesLabR" scope="row" >Observaciones del laboratorio:</th>
                        <td colspan="3"></td>
                    </tr>
                    <tr>
                        <th id="rutaResultadosR" scope="row">Resultados:</th>
                        <td colspan="3"></td>
                    </tr>
                    </tbody>
                </table>
            </div>



            <!--<div class="col p-3 ">
                <p><strong>No. de solicitud:       </strong><span id="numeroPruebaR"></span></p>
                <p><strong>Fecha de Solicitud:     </strong><span id="fechaSolicitudR"></span></p>
                <p><strong>Fecha de Respuesta:     </strong><span id="fechaRespuestaR"></span></p>
                <p><strong>Solicitante:            </strong><span id="solicitanteR"></span></p>
                <p><strong>Metrólogo:              </strong><span id="metrologoR"></span></p>
                <p><strong>Tipo de Prueba:         </strong><span id="tipoPruebaSolicitudR"></span></p>
            </div>
            <div class="col p-3">
                <p><strong>Norma:                           </strong><span id="normaNombreR"></span></p>
                <p class="resumenHidden"><strong>Documento de la norma:  </strong><span ><a id="archivoNormaR" href="">Archivo pdf</a></span></p><br>
                <p><strong>Observaciones del solicitante:   </strong><span id="observacionesSolR"></span></p>
                <p><strong>Estatus de la solicitud:         </strong><span id="estatusSolicitudR"></p>
                <p><strong>Prioridad:                       </strong><span id="prioridadR"></p>
            </div>
            <div class="row">
                <p><strong>Observaciones del laboratorio:  </strong><span id="observacionesLabR"></span></p>
                <p><strong>Resultados:                     </strong><span id="rutaResultadosR"></span></p>
            </div>
                <!-->

        </div>
    </div>
</main>