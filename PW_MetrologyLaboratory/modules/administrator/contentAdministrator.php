<div class="main-content">
    <header >
        <div class="header-content">
            <label for="menu-toggle">
                <span class="las la-bars"></span>
            </label>
            <div class="header-menu">
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
            <section id="sectionClientes" >
                <h3 id="clientes" >Clientes</h3>
                <div class="row justify-content-end">
                    <div class="col-auto mt-4 botones">
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoCliente"><i class="las la-plus-circle"></i>Nuevo cliente</a>
                        <a href="#tablaClientes" class="btn btn-secondary" id="btn-clientesDes" onclick="initDataTableClientesDes()"><i class="las la-eye"></i> Desactivados</a>
                        <a href="#tablaClientes" class="btn btn-secondary" id="btn-clientesAct" onclick="initDataTableClientes()"><i class="las la-eye"></i> Activados</a>
                    </div>
                </div>
                    <table class="dataTable table mt-4" id="tablaClientes">
                        <thead>
                            <tr>
                                <th class="centered">Cliente</th>
                                <th class="centered">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaClientesBody"></tbody>
                    </table>
            </section>

            <!-- Plataformas -->
            <section id="sectionPlataformas">
                <h3 id="plataformas" >Plataformas</h3>
                <div class="row justify-content-end">
                    <div class="col-auto botones">
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevaPlataforma"><i class="las la-plus-circle"></i>Nueva plataforma</a>
                        <a href="#" class="btn btn-secondary" id="btn-plataformasDes" onclick="initDataTablePlataformasDes()"><i class="las la-eye"></i> Desactivadas</a>
                        <a href="#" class="btn btn-secondary" id="btn-plataformasAct" onclick="initDataTablePlataformas()"><i class="las la-eye"></i> Activados</a>
                    </div>
                </div>

                <div class="justify-content-end">
                    <table class="dataTable table mt-4" id="tablaPlataformas">
                        <thead>
                            <tr>
                                <!--<th>Identificador</th>-->
                                <th>Plataforma</th>
                                <th>Cliente</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaPlataformasBody"></tbody>
                    </table>
                </div>
            </section>

            <!-- Materiales -->
            <section id="sectionMateriales">
                <h3 id="materiales">Materiales</h3>
                <div class="row justify-content-end">
                    <div class="col-auto botones">
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoMaterial"><i class="las la-plus-circle"></i>Nuevo material</a>
                        <a href="#materiales" class="btn btn-secondary" id="btn-materialesDes" onclick="initDataTableMaterialesDes()"><i class="las la-eye"></i> Desactivados</a>
                        <a href="#materiales" class="btn btn-secondary" id="btn-materialesAct" onclick="initDataTableMateriales()"><i class="las la-eye"></i> Activados</a>
                    </div>
                </div>
                <table class="dataTable table table-sm table-hover mt-4" id="tablaMateriales">
                    <thead>
                        <tr>
                            <th>Descripción</th>
                            <th>No. de parte</th>
                            <th>Imagen</th>
                            <th>Plataforma</th>
                            <th>Cliente</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaMaterialesBody"></tbody>
                </table>
            </section>

            <!-- Usuarios -->
            <section  id="sectionUsuarios">
                <h3 id="usuarios">Usuarios</h3>
                <div class="row justify-content-end">
                    <div class="col-auto botones">
                        <a href="#usuarios" class="btn btn-secondary" id="btn-usuariosDes" onclick="initDataTableUsuariosDes();"><i class="las la-eye"></i> Desactivados</a>
                        <a href="#usuarios" class="btn btn-secondary" id="btn-usuariosAct" onclick="initDataTableUsuarios();"><i class="las la-eye"></i> Activados</a>
                    </div>
                </div>
                <table class="dataTable table table-sm table-hover mt-4" id="tablaUsuarios">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo electrónico</th>
                        <th>Tipo de usuario</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody id="tablaUsuariosBody"></tbody>
                </table>
            </section>
        </div>
    </div>
</main>