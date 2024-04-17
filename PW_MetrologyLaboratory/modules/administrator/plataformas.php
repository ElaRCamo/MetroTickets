<!-- Modal NuevaPlataforma-->
<div class="modal fade container-fluid" id="nuevaPlataforma" aria-hidden="true" aria-labelledby="nuevoPlataformaLabel" tabindex="-1">
    <div class="modal-lg modal-dialog modal-dialog-centered modal-dialog-scrollable ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevoPlataformaLabel">Agregar registros</h5><br>
                <button type="button" class="btn-close" id="" data-bs-dismiss="modal" onclick="" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <div class="help-block with-errors"></div>
                        <label for="descPlataformaN" class="form-label">Descripción de la plataforma: </label>
                        <input type="text" name="descPlataformaN" id="descPlataformaN" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <div class="help-block with-errors"></div>
                        <label for="descPClienteN" class="form-label">Cliente: </label>
                        <select class="form-control" id="descPClienteN" onchange=""  name="descPClienteN" title="Cliente" required data-error="Por favor seleccione el cliente" >
                            <option value="">Seleccione un cliente*</option>
                        </select>
                    </div>
                    <div class="row justify-content-end">
                        <div class="">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="">Close</button>
                            <button type="button" class="btn btn-secondary" onclick=""><i class="las la-save"></i>Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>