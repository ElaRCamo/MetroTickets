<!-- Modal RESULTADOS-->
<div class="modal fade container-fluid" id="modalResultados" aria-hidden="true" aria-labelledby="modalResultadosLabel" tabindex="-1">
    <div class="modal-lg modal-dialog modal-dialog-centered modal-dialog-scrollable ">
        <div class="modal-content">
            <div class="modal-header" id="resultadosModal">
                <h3 class="modal-title" id="modalResultadosLabel"><strong>Responder solicitud</strong></h3><br>
                <button type="button" class="btn-closeModal" id="btnCloseX" data-bs-dismiss="modal" onclick="" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            <div class="modal-body row">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row" id="divTablaResultados">
                        <div>
                            <h5 id="titleGnalResultados">Datos generales</h5>
                            <table class="table table-borderless table-responsive" id="tablaRessultados">
                                <thead id="titleResultadosT">
                                    <tr>
                                        <th>Estatus</th>
                                        <th>Fecha compromiso</th>
                                        <th>Prioridad</th>
                                        <th>Metrólogo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select class="form-control form-control-sm" id="estatusPruebaAdmin" onchange="mostrarReportes()" name="estatusPruebaAdmin" title="" required data-error="Por favor seleccione el estatus">
                                                <option value="">Seleccione estatus de la prueba*</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="date" class="form-control form-control-sm" id="iFechaCompromiso" name="iFechaCompromiso" title="" required data-error="Por favor seleccione la fecha compromiso">
                                        </td>
                                        <td>
                                            <select class="form-control form-control-sm" id="prioridadPruebaAdmin" name="prioridadPruebaAdmin" title="" required data-error="Por favor seleccione la prioridad">
                                                <option value="">Seleccione la prioridad de la prueba*</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control form-control-sm" id="metrologoAdmin" name="metrologoAdmin" title="" required data-error="Por favor asigne la prueba">
                                                <option value="">Asignar prueba*</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <table class="table table-borderless table-responsive" id="tablaObs">
                                <thead id="titleObs">
                                    <tr>
                                        <th>Observaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <textarea type="text" name="observacionesAdmin" id="observacionesAdmin" class="form-control form-control-sm"  rows="4"  onchange="" required></textarea>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="divTablaPiezas">
                            <h5 id="titleResPiezasEstatus">Piezas</h5>
                            <table class="table table-borderless table-responsive" id="piezasEstatus">
                                <thead>
                                <tr>
                                    <th>No. de Parte</th>
                                    <th>Estatus</th>
                                    <th>Reporte</th>
                                </tr>
                                </thead>
                                <tbody id="tbodyPiezas"></tbody>
                            </table>
                        </div>
                        <div id="divTablaPersonal">
                            <h5 id="titleResPersonal">Personal</h5>
                            <table class="table table-borderless table-responsive" id="tableAdminPersonal">
                                <thead>
                                <tr>
                                    <th>Nómina</th>
                                    <th>Nombre</th>
                                    <th>Reporte</th>
                                </tr>
                                </thead>
                                <tbody id="tbodyPersonalAdmin"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="">Close</button>
                        <button type="button" class="btn btn-primary" id="btnGuardarResultados" onclick="validarResultados(id_review,id_user)" data-bs-dismiss="modal"><i class="las la-save"></i>Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
