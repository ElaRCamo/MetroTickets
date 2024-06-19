<!-- Modal RESULTADOS-->
<div class="modal fade container-fluid" id="modalResultados" aria-hidden="true" aria-labelledby="modalResultadosLabel" tabindex="-1">
    <div class="modal-lg modal-dialog modal-dialog-centered modal-dialog-scrollable ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalResultadosLabel">Responder solicitud </h5><br>
                <button type="button" class="btn-close" id="" data-bs-dismiss="modal" onclick="" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row align-items-start">
                        <div class="mb-3 col">
                            <div class="help-block with-errors"></div>
                            <label for="estatusPruebaAdmin" class="form-label" >Estatus: </label>
                            <select class="form-control" id="estatusPruebaAdmin" onchange="cambiarResultado()" name="estatusPruebaAdmin" title="" required data-error="Por favor seleccione el estatus" >
                                <option value="">Seleccione estatus de la prueba*</option>
                            </select>
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
                        <div class="d-flex align-items-center" id="divCambiarResultados">
                            <div class="">
                                <!-- Checkbox for selecting the type -->
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
                                <!-- Input fields that will be shown/hidden -->
                                <input type="text" name="resultadosAdmin" id="resultadosAdminRuta" class="form-control mt-2" placeholder="Escriba la ruta">
                                <input type="file" name="resultadosAdmin" id="resultadosAdminArchivo" class="form-control mt-2" accept="application/pdf">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="">Close</button>
                        <button type="button" class="btn btn-secondary" onclick="updatePruebaAdmin(id_review,id_user)"><i class="las la-save"></i>Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>