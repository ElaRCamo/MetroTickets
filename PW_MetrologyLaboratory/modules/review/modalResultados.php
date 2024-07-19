<!-- Modal RESULTADOS-->
<div class="modal fade container-fluid" id="modalResultados" aria-hidden="true" aria-labelledby="modalResultadosLabel" tabindex="-1">
    <div class="modal-lg modal-dialog modal-dialog-centered modal-dialog-scrollable ">
        <div class="modal-content">
            <div class="modal-header" id="resultadosModal">
                <h3 class="modal-title" id="modalResultadosLabel"><strong>Responder solicitud</strong></h3><br>
                <button type="button" class="btn-close" id="" data-bs-dismiss="modal" onclick="" aria-label="Close"></button>
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
                                            <select class="form-control form-control-sm" id="estatusPruebaAdmin" onchange="cambiarResultado(); fechaCompromiso();" name="estatusPruebaAdmin" title="" required data-error="Por favor seleccione el estatus">
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
                            <h5 id="titleResPiezasEstatus">Estatus de las piezas</h5>
                            <table class="table table-borderless table-responsive" id="piezasEstatus">
                                <thead>
                                <tr>
                                    <th>No. de Parte</th>
                                    <th>Estatus</th>
                                </tr>
                                </thead>
                                <tbody id="tbodyPiezas"></tbody>
                            </table>
                        </div>
                        <div id="divResultados">
                            <h5 id="titResultados">Resultados</h5>
                            <div class="help-block with-errors"></div>
                            <table class="table table-borderless table-responsive" id="">
                                <tr>
                                    <td colspan="3"><a href="#" id="resultadosGuardados" class="form-control form-control-sm"></a></td>
                                    <td><button type="button" id="btnCambiarResultados" onclick="checkedInput()" class="btn btn-primary btn-primary btn-sm"><i class="las la-edit"></i></button></td>
                                </tr>
                            </table>
                            <div id="divCambiarResultados">
                                <table class="table table-borderless table-responsive" id="updateResultados">
                                    <thead id="">
                                    <tr>
                                        <th>Actualizar resultados:</th>
                                        <th>
                                            <!-- Checkbox for selecting the type -->
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="resultadoTipo" id="rutaRadio" value="ruta" onchange="selectInputResultado()" checked>
                                                <label class="form-check-label" for="rutaRadio">Ruta</label>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="resultadoTipo" id="archivoRadio" value="archivo" onchange="selectInputResultado()">
                                                <label class="form-check-label" for="archivoRadio">Archivo PDF</label>
                                            </div>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td colspan="4">
                                            <!-- Input fields that will be shown/hidden -->
                                            <input type="text" name="resultadosAdmin" id="resultadosAdminRuta" class="form-control form-control-sm mt-2" placeholder="Escriba la ruta">
                                            <input type="file" name="resultadosAdmin" id="resultadosAdminArchivo" class="form-control form-control-sm mt-2" accept="application/pdf">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="">Close</button>
                        <button type="button" class="btn btn-primary" id="btnGuardarResultados" onclick="validarResultados(id_review,id_user)" data-bs-dismiss="modal"><i class="las la-save"></i>Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


                <!--<div class="row align-items-start">
                        <div class="mb-3 col">
                            <div class="help-block with-errors"></div>
                            <label for="estatusPruebaAdmin" class="form-label" >Estatus: </label>
                            <select class="form-control" id="estatusPruebaAdmin" onchange="cambiarResultado(); fechaCompromiso();" name="estatusPruebaAdmin" title="" required data-error="Por favor seleccione el estatus" >
                                <option value="">Seleccione estatus de la prueba*</option>
                            </select>
                        </div>
                        <div class="mb-3 col" id="divFechaCompromiso">
                            <div class="help-block with-errors"></div>
                            <label for="iFechaCompromiso" class="form-label" >Fecha compromiso: </label>
                            <input type="date" class="form-control" id="iFechaCompromiso" name="iFechaCompromiso" title="" required data-error="Por favor seleccione la fecha compromiso" >
                        </div>
                        <div class="mb-3 col">
                            <div class="help-block with-errors"></div>
                            <label for="prioridadPruebaAdmin" class="form-label">Prioridad: </label>
                            <select class="form-control" id="prioridadPruebaAdmin" name="prioridadPruebaAdmin" title="" required data-error="Por favor seleccione la prioridad" >
                                <option value="">Seleccione la prioridad de la prueba*</option>
                            </select>
                        </div>
                        <div class="mb-3 col">
                            <div class="help-block with-errors"></div>
                            <label for="metrologoAdmin" class="form-label">Metrólogo: </label>
                            <select class="form-control" id="metrologoAdmin" onchange=""  name="metrologoAdmin" title="" required data-error="Por favor asigne la prueba" >
                                <option value="">Asignar prueba*</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="help-block with-errors"></div>
                        <label for="observacionesAdmin" class="form-label">Observaciones: </label>
                        <textarea type="text" name="observacionesAdmin" id="observacionesAdmin" class="form-control"  rows="4"  onchange="" required></textarea>
                    </div>
                    <div class="mb-3" id="divResultados">
                        <div class="help-block with-errors"></div>
                        <div class="d-flex align-items-center">
                            <label for="resultadosAdmin" class="form-label me-2">Resultados:</label>
                            <a  href="#" id="resultadosGuardados" class="form-control me-2"></a>
                            <button type="button" id="btnCambiarResultados" onclick="checkedInput()" class="btn btn-primary"><i class="las la-edit"></i></button>
                        </div>
                        <div class="" id="divCambiarResultados">
                            <div class="">
                                <-- Checkbox for selecting the type ->
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="resultadoTipo" id="rutaRadio" value="ruta" onchange="selectInputResultado()" checked>
                            <label class="form-check-label" for="rutaRadio">Ruta</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="resultadoTipo" id="archivoRadio" value="archivo" onchange="selectInputResultado() ">
                            <label class="form-check-label" for="archivoRadio">Archivo PDF</label>
                        </div>
                    </div>
                    <div class="">
                        <-- Input fields that will be shown/hidden ->
                        <input type="text" name="resultadosAdmin" id="resultadosAdminRuta" class="form-control mt-2" placeholder="Escriba la ruta">
                        <input type="file" name="resultadosAdmin" id="resultadosAdminArchivo" class="form-control mt-2" accept="application/pdf">
                    </div>
                        </div>
                    </div>
                    -->