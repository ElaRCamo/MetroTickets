<div class="main-content">
    <header >
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
                    <?php global $nombreUser; echo '<input type="text" id="nombreUser" value="' . $nombreUser . '">'; ?>
                </div>
                <div class="user">
                    <div><img class="user-img bg-img" alt="User" src="<?php global $fotoUsuario; echo $fotoUsuario; ?>"></div>
                </div>
                <div class="bg-img" id="cerrarS">
                    <span class="las la-power-off"></span>
                </div>
            </div>
        </div>
        <div class="page-header" id="containerNavAdmin">
            <nav>
                <ul>
                    <li><a href="#clientes"><h5>Clientes</h5></a></li>
                    <li><a href="#plataformas"><h5>Plataformas</h5></a></li>
                    <li><a href="#materiales"><h5>Materiales</h5></a></li>
                    <li><a href="#usuarios"><h5>Usuarios</h5></a></li>
                </ul>
            </nav>
        </div>

    </header>

    <main>
    <div class="page-content">
        <div class="container table-responsive">
            <!-- Clientes -->
            <section>
                <h3 id="clientes" >Clientes</h3>
                <div class="row justify-content-end">
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoCliente"><i class="las la-plus-circle"></i>Nuevo cliente</a>
                        <a href="#" class="btn btn-secondary"><i class="las la-eye"></i> Desactivados</a>
                    </div>
                </div>

                <table class="table mt-4" id="tablaClientes">
                    <thead>
                        <tr>
                            <th>Identificador</th>
                            <th>Cliente</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </section>

            <!-- Plataformas -->
            <section >
                <h3 id="plataformas" >Plataformas</h3>
                <div class="row justify-content-end">
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevaPlataforma"><i class="las la-plus-circle"></i>Nueva plataforma</a>
                        <a href="#" class="btn btn-secondary""><i class="las la-eye"></i> Desactivadas</a>
                    </div>
                </div>

                <table class="table mt-4" id="tablaPlataformas">
                    <thead>
                        <tr>
                            <th>Identificador</th>
                            <th>Plataforma</th>
                            <th>Cliente</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </section>

            <!-- Materiales -->
            <section >
                <h3 id="materiales">Materiales</h3>
                <div class="row justify-content-end">
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoMaterial"><i class="las la-plus-circle"></i>Nuevo material</a>
                        <a href="#" class="btn btn-secondary"><i class="las la-eye"></i> Desactivados</a>
                    </div>
                </div>

                <table class="table table-sm table-hover mt-4" id="tablaMateriales">
                    <thead>
                        <tr>
                            <th>Identificador</th>
                            <th>Descripción</th>
                            <th>Núm. de parte</th>
                            <th>Imagen</th>
                            <th>Plataforma</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </section>

            <!-- Usuarios -->
            <section >
                <h3 id="usuarios">Usuarios</h3>
                <table class="table table-sm table-hover mt-4" id="tablaUsuarios">
                    <a href="#" class="btn btn-secondary" onclick="TablaAdminClientesDes()"><i class="las la-eye"></i> Desactivados</a>
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo electrónico</th>
                        <th>Tipo de usuario</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</main>

