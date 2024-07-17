<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../../imgs/Grammer_Logo.ico" type="image/x-icon">
    <title>Administrador</title>
    <!--Enlace de iconos: icons8, licencia con mención -->
    <link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" >
    <!--Fuente -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- -Archivos de jQuery-->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <!-- DataTable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" />
</head>
<body>
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
            <div class="container">
                <!-- Clientes -->
                <section id="sectionClientes">
                    <div class="">
                        <h3 id="clientes" >Clientes</h3>
                        <div class="row justify-content-end">
                            <div class="col-auto mt-4 botones">
                                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoCliente"><i class="las la-plus-circle"></i><span>Nuevo cliente</span></a>
                                <a href="#tablaClientes" class="btn btn-secondary" id="btn-clientesDes" onclick="initDataTableClientesDes()"><i class="las la-eye"></i><span>Desactivados</span></a>
                                <a href="#tablaClientes" class="btn btn-secondary" id="btn-clientesAct" onclick="initDataTableClientes()"><i class="las la-eye"></i><span>Activados</span></a>
                            </div>
                        </div>
                        <div class="">
                            <table class="table responsive" id="tablaClientes" style="width: 100%">
                                <thead>
                                <tr>
                                    <th class="centered">Cliente</th>
                                    <th class="centered">Acciones</th>
                                </tr>
                                </thead>
                                <tbody id="tablaClientesBody"></tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>
</div>
    <script>
        window.addEventListener("load",async () => {
            await initDataTableClientes();
            await initDataTablePlataformas();
            await initDataTableMateriales();
            await initDataTableUsuarios();
        })
    </script>
    <script src="../../js/cargarDatos.js"></script>
    <script src="../../js/insertarDatos.js"></script>
    <script src="../../js/eliminarDatos.js"></script>
    <script src="../../js/sesion.js"></script>
    <script src="../../js/general.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <!-- Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- DataTable -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.js"></script>
</body>
</html>