<div class="modal fade container-fluid" id="nuevoModal" aria-hidden="true" aria-labelledby="nuevoModalLabel" tabindex="-1">
    <div class="modal-lg modal-dialog modal-dialog-centered modal-dialog-scrollable ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevoModalLabel">Agregar registros</h5><br>
                <button type="button" class="btn-close" id="buttonClose" data-bs-dismiss="modal" onclick="" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="descClienteN" class="form-label">Descripción del cliente: </label>
                        <input type="text" name="descClienteN" id="descClienteN" class="form-control" required>

                    </div>
                    <div class="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="">Close</button>
                        <button type="button" class="btn btn-secondary" onclick=""><i class="las la-save"></i>Guardar</button>
                    </div>
                </form>
        </div>
    </div>
</div>