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
                    <a href="#" onclick="cargarPerfilUsuario()" class="enlaceUpdPerfil" data-bs-toggle="modal" data-bs-target="#editarPerfilUsuario">
                        <?php global $nombreUser; echo '<input type="text" id="nombreUser" value="' . $nombreUser . '">'; ?>
                    </a>
                </div>
                <div class="user">
                    <a href="#" onclick="cargarPerfilUsuario()" class="enlaceUpdPerfil" data-bs-toggle="modal" data-bs-target="#editarPerfilUsuario">
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
                                        <label for="nombrePU" class="form-label">Nombre: </label>
                                        <input type="text" name="nombrePU" id="nombrePU" class="form-control" readonly>
                                    </div>
                                </th>
                            </tr>
                            <tr class="align-middle">
                                <th>
                                    <div class="mb-3">
                                        <label for="correoPU" class="form-label">Correo: </label>
                                        <input id="correoPU" name="correoPU" type="email" class="form-control" readonly>
                                    </div>
                                </th>
                            </tr>
                            <tr class="align-middle">
                                <th>
                                    <div class="mb-3">
                                        <label for="nominaPU" class="form-label">Núm. de nómina: </label>
                                        <input class="form-control" id="nominaPU" name="nominaPU" readonly>
                                    </div>
                                </th>
                            </tr>
                            <tr class="align-middle" >
                                <th>
                                    <div class="mb-3" >
                                        <label for="fotoPerfilU" class="form-label">Nueva foto de perfil: </label>
                                        <input type="file" class="form-control" id="fotoPerfilU" name="fotoPerfilU" onchange="previewImage(event)">
                                    </div>
                                </th>
                                <th>
                                    <div class="mb-3">
                                        <div class="help-block with-errors"></div>
                                        <label for="passwordPU" class="form-label">Contraseña: </label>
                                        <input type="password" class="form-control" id="passwordPU" name="passwordPU" required data-error="Por favor ingrese su contraseña" >
                                    </div>
                                </th>
                            </tr>
                            </tbody>
                        </table>
                        <div class="row justify-content-end">
                            <div class="">
                                <button type="button" class="btn btn-secondary" <!--data-bs-dismiss="modal"--> onclick="">Close</button>
                                <button type="button" class="btn btn-secondary" id="btn-updPerfil" data-bs-dismiss="modal"><i class="las la-save"></i>Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    //Previsualizar imagen
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('imgActualUsuario');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

    <script src="https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/js/actualizarDatos.js"></script>