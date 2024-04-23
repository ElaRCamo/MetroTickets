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
                    <div class="mb-3">
                        <div class="help-block with-errors"></div>
                        <label for="estatusPruebaAdmin" class="form-label">Estatus: </label>
                        <select class="form-control" id="estatusPruebaAdmin" onchange="" name="estatusPruebaAdmin" title="" required data-error="Por favor seleccione el estatus" >
                            <option value="">Seleccione estatus de la prueba*</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="help-block with-errors"></div>
                        <label for="prioridadAdmin" class="form-label">Prioridad: </label>
                        <select class="form-control" id="prioridadAdmin" onchange=""  name="prioridadAdmin" title="" required data-error="Por favor seleccione la prioridad" >
                            <option value="">Seleccione la prioridad de la prueba*</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="help-block with-errors"></div>
                        <label for="metrologoAdmin" class="form-label">Metrólogo: </label>
                        <select class="form-control" id="metrologoAdmin" onchange=""  name="metrologoAdmin" title="" required data-error="Por favor asigne la prueba" >
                            <option value="">Asignar prueba*</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="help-block with-errors"></div>
                        <label for="observacionesAdmin" class="form-label">Observaciones: </label>
                        <input type="text" name="observacionesAdmin" id="observacionesAdmin" class="form-control" onchange="" required>
                    </div>
                    <div class="mb-3">
                        <div class="help-block with-errors"></div>
                        <label for="resultadosAdmin" class="form-label">Resultados: </label>
                        <input type="text" name="resultadosAdmin" id="resultadosAdmin" class="form-control" onchange="" required>
                    </div>
                    <div class="row justify-content-end">
                        <div class="">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="">Close</button>
                            <button type="button" class="btn btn-secondary" onclick="updatePruebaAdmin(id_review)"><i class="las la-save"></i>Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>