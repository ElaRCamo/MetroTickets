<main>
    <div class="page-header">
        <h1>Administrar esta página</h1>
        <nav>
            <ul>
                <li><a href="#clientes">Clientes</a></li>
                <li><a href="#plataformas">Plataformas</a></li>
                <li><a href="#materiales">Materiales</a></li>
            </ul>
        </nav>
    </div>

    <div class="page-content">
        <div class="container table-responsive">
            <!-- Clientes -->
            <section >
                <h3 id="clientes" >Clientes</h3>
                <div class="row justify-content-end">
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoCliente"><i class="las la-plus-circle"></i>Nuevo cliente</a>
                    </div>
                </div>

                <table class="table table-sm mt-4" id="tablaClientes">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descripción</th>
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
                    </div>
                </div>

                <table class="table table-sm table-striped mt-4" id="tablaPlataformas">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descripción</th>
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
                    </div>
                </div>

                <table class="table table-sm table-hover mt-4" id="tablaMateriales">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descripción</th>
                        <th>Plataforma</th>
                        <th>Núm. de parte</th>
                        <th>Imagen</th>
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

