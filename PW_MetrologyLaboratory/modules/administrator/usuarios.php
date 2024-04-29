<!-- Modal EditarUsuario-->
<div class="modal fade container-fluid" id="editarUsuarioModal" aria-hidden="true" aria-labelledby="editarUsuarioLabel" tabindex="-1">
    <div class="modal-lg modal-dialog modal-dialog-centered modal-dialog-scrollable ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarUsuariolLabel">Modificar permisos del usuario</h5><br>
                <button type="button" class="btn-close" id="" data-bs-dismiss="modal" onclick="" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <form method="POST" enctype="multipart/form-data">
                    <div class="col-xl-4 text-center justify-content-center " id="divImagenMaterialE">
                        <label for="fotoUsuarioE" class="form-label" ></label>
                        <img src="" class="col-md-6 mb-3 ms-md-3 rounded img-fluid img-thumbnail" id="fotoUsuarioE" alt="Foto de perfil">
                    </div>
                    <div class="mb-3">
                        <div class="help-block with-errors"></div>
                        <label for="nombreUsuarioE" class="form-label">Nombre:  <input type="text" name="nombreUsuarioE" id="nombreUsuarioE" class="form-control" readonly></label>

                    </div>
                    <div class="mb-3">
                        <div class="help-block with-errors"></div>
                        <label for="correoE" class="form-label">Correo electrónico: <input type="text" name="correoE" id="correoE" class="form-control" readonly></label>

                    </div>
                    <div class="mb-3">
                        <div class="help-block with-errors"></div>
                        <label for="tipoDeUsuarioE" class="form-label">Tipo de usuario: </label>
                        <select class="form-control" id="tipoDeUsuarioE" name="tipoDeUsuarioE"></select>
                    </div>
                    <div class="row justify-content-end">
                        <div class="">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Close</button>
                            <button type="button" class="btn btn-secondary" id="btn-updUsuario"><i class="las la-save"></i>Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>