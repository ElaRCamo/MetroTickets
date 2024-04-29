<!-- Modal NuevoMaterial-->
<div class="modal fade container-fluid" id="nuevoMaterial" aria-hidden="true" aria-labelledby="nuevoMateriallLabel" tabindex="-1">
    <div class="modal-lg modal-dialog modal-dialog-centered modal-dialog-scrollable ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevoMateriallLabel">Agregar material</h5><br>
                <button type="button" class="btn-close" id="" data-bs-dismiss="modal" onclick="" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <div class="help-block with-errors"></div>
                        <label for="descMaterialN" class="form-label">Descripción del material: </label>
                        <input type="text" name="descMaterialN" id="descMaterialN" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <div class="help-block with-errors"></div>
                        <label for="numParteN" class="form-label">Número de parte: </label>
                        <input id="numParteN" name="numParteN" type="text" class="form-control" placeholder="Número de parte*" required data-error="Por favor ingresa el número de parte">
                    </div>
                    <div class="mb-3">
                        <div class="help-block with-errors"></div>
                        <label for="imgMaterialN" class="form-label" >Imagen del material: </label>
                        <input type="file" placeholder="Imagen del material" class="form-control" onchange="plataformaModal()" id="imgMaterialN" name="imgMaterialN" required>
                    </div>
                    <div class="mb-3">
                        <div class="help-block with-errors"></div>
                        <label for="descMPlataformaN" class="form-label">Plataforma: </label>
                        <select class="form-control" id="descMPlataformaN" name="descMPlataformaN" required data-error="Por favor seleccione el cliente" >
                            <option value="">Seleccione una plataforma*</option>
                        </select>
                    </div>
                    <div class="row justify-content-end">
                        <div class="">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="">Close</button>
                            <button type="submit" class="btn btn-secondary" onclick="registrarMaterial()"><i class="las la-save"></i>Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal EditarMaterial-->
<div class="modal fade container-fluid" id="editarMaterialModal" aria-hidden="true" aria-labelledby="editarMateriallLabel" tabindex="-1">
    <div class="modal-lg modal-dialog modal-dialog-centered modal-dialog-scrollable ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarMateriallLabel">Actualizar material</h5><br>
                <button type="button" class="btn-close" id="" data-bs-dismiss="modal" onclick="" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <form method="POST" enctype="multipart/form-data">

                    <table class="table table-borderless">
                        <tbody>
                        <tr class="align-middle">
                            <th rowspan="3" >
                                <div class="text-center justify-content-center " id="divImagenMaterialE">
                                    <img src="" class="col-md-6 mb-3 ms-md-3 rounded img-fluid img-thumbnail" id="imagenMaterialE" alt="Imagen Material">
                                    <a id="aCambiarImg" onclick="cambiarImg()"><i class="las la-edit"></i></a>
                                </div>
                            </th>
                            <th>
                                <div class="mb-3">
                                    <div class="help-block with-errors"></div>
                                    <label for="descMaterialE" class="form-label">Descripción del material: </label>
                                    <input type="text" name="descMaterialE" id="descMaterialE" class="form-control" required>
                                </div>
                            </th>
                        </tr>
                        <tr class="align-middle">
                            <th>
                                <div class="mb-3">
                                    <div class="help-block with-errors"></div>
                                    <label for="numParteE" class="form-label">Número de parte: </label>
                                    <input id="numParteE" name="numParteE" type="text" class="form-control" placeholder="Número de parte*" required data-error="Por favor ingresa el número de parte">
                                </div>
                            </th>
                        </tr>
                        <tr class="align-middle">
                            <th>
                                <div class="mb-3">
                                    <div class="help-block with-errors"></div>
                                    <label for="descMPlataformaE" class="form-label">Plataforma: </label>
                                    <select class="form-control" id="descMPlataformaE" name="descMPlataformaE" required data-error="Por favor seleccione el cliente" >
                                        <option value="">Seleccione una plataforma*</option>
                                    </select>
                                </div>
                            </th>
                        </tr>
                        <tr class="align-middle" id="divCambiarImg">
                            <th colspan="2">
                                <div class="mb-3" >
                                    <div class="help-block with-errors"></div>
                                    <a id="aHideImg" onclick="hideImg()"><i class="las la-times"></i></a>
                                    <label for="imgMaterialE" class="form-label" >Nueva imagen: </label>
                                </div>
                            </th>
                            <th>
                                <div class="mb-3" >
                                    <input type="file" placeholder="Imagen del material" class="form-control" id="imgMaterialE" name="imgMaterialE" required>
                                </div>
                            </th>
                        </tr>
                        </tbody>
                    </table>
                    <div class="row justify-content-end">
                        <div class="">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="">Close</button>
                            <button type="submit" class="btn btn-secondary" id="btn-updMaterial"><i class="las la-save"></i>Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>