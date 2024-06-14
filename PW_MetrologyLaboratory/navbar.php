<div class="main-content">
    <header>
        <div class="header-content">
            <label for="menu-toggle">
                <span class="las la-bars"></span>
            </label>
            <div class="header-menu">
                    <!--<span class="las la-search"></span>
                <div class="notify-icon">
                    <span class="las la-bell"></span>
                    <span class="notify">3</span>
                </div>-->
                <div class="userDiv">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#editarPerfilUsuario">
                        <?php global $nombreUser; echo '<input type="text" id="nombreUser" value="' . $nombreUser . '">'; ?>
                    </a>
                </div>
                <div class="user">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#editarPerfilUsuario">
                    <div><img class="user-img bg-img" alt="User" src="<?php global $fotoUsuario; echo $fotoUsuario; ?>"></div>
                    </a>
                </div>
                <div class="bg-img" id="cerrarS">
                    <span class="las la-power-off"></span>
                </div>
            </div>
        </div>
    </header>

    <script>
        document.getElementById("cerrarS").addEventListener("click", function (event) {
            cerrarSesion();
        });
    </script>



    <!-- Modal Editar Perfil de Usuario-->
    <div class="modal fade container-fluid" id="editarPerfilUsuario" aria-hidden="true" aria-labelledby="editarPerfilLabel" tabindex="-1">
        <div class="modal-lg modal-dialog modal-dialog-centered modal-dialog-scrollable ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarPerfilLabel">Actualiza tu perfil</h5><br>
                    <button type="button" class="btn-close" id="" data-bs-dismiss="modal" onclick="" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <form method="POST" enctype="multipart/form-data" id="formEditarPerfilUsuario">

                        <table class="table table-borderless">
                            <tbody>
                            <tr class="align-middle">
                                <th rowspan="3" >
                                    <div class="text-center justify-content-center " id="divImagenPerfil">
                                        <img src="" class="col-md-6 mb-3 ms-md-3 rounded img-fluid img-thumbnail" id="imgActualUsuario" alt="Foto de perfil">
                                    </div>
                                </th>
                                <th>
                                    <div class="mb-3">
                                        <label for="nombreE" class="form-label">Nombre: </label>
                                        <input type="text" name="nombreE" id="nombreE" class="form-control" readonly>
                                    </div>
                                </th>
                            </tr>
                            <tr class="align-middle">
                                <th>
                                    <div class="mb-3">
                                        <label for="correoE" class="form-label">Correo: </label>
                                        <input id="correoE" name="correoE" type="email" class="form-control" readonly>
                                    </div>
                                </th>
                            </tr>
                            <tr class="align-middle">
                                <th>
                                    <div class="mb-3">
                                        <label for="nominaE" class="form-label">Núm. de nómina: </label>
                                        <input class="form-control" id="nominaE" name="nominaE" readonly>
                                    </div>
                                </th>
                            </tr>
                            <tr class="align-middle" >
                                <th>
                                    <div class="mb-3" >
                                        <label for="fotoPerfilE" class="form-label">Nueva imagen: </label>
                                        <input type="file" class="form-control" id="fotoPerfilE" name="fotoPerfilE">
                                    </div>
                                </th>
                                <th>
                                    <div class="mb-3">
                                        <div class="help-block with-errors"></div>
                                        <label for="passwordE" class="form-label">Contraseña: </label>
                                        <input class="form-control" id="passwordE" name="passwordE" required data-error="Por favor ingrese su contraseña" >
                                    </div>
                                </th>
                            </tr>
                            </tbody>
                        </table>
                        <div class="row justify-content-end">
                            <div class="">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="">Close</button>
                                <button type="button" class="btn btn-secondary" id="btn-updPerfil" data-bs-dismiss="modal"><i class="las la-save"></i>Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>