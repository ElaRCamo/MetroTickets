<main>
    <div class="page-header">
        <h1>Administrar esta página</h1>
        <small>Selecciona la acción a realizar</small>
    </div>

    <div class="page-content">

    </div>
</main>
<nav>
    <ul>
        <li><a href="#pruebas">Pruebas</a></li>
        <li><a href="#materiales">Materiales</a></li>
        <li><a href="#usuarios">Usuarios</a></li>
        <li><a href="#plataformas">Plataformas</a></li>
        <li><a href="#clientes">Clientes</a></li>
    </ul>
</nav>

<div class="container">
    <!-- Contenido se cargaría aquí -->

    <!-- Pruebas -->
    <section id="pruebas">
        <h2>Tabla de Pruebas</h2>
        <!-- Aquí se mostraría la tabla de Pruebas -->
        <table>
            <!-- Encabezados de la tabla -->
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <!-- Otros encabezados según las columnas de tu tabla -->
            </tr>
            </thead>
            <!-- Cuerpo de la tabla -->
            <tbody>
            <!-- Aquí se mostrarían los datos de la tabla de Pruebas -->
            <tr>
                <td>1</td>
                <td>Prueba 1</td>
                <td>Descripción de la Prueba 1</td>
                <!-- Otros datos de la tabla según las columnas -->
            </tr>
            <tr>
                <td>2</td>
                <td>Prueba 2</td>
                <td>Descripción de la Prueba 2</td>
                <!-- Otros datos de la tabla según las columnas -->
            </tr>
            <!-- Repite estas filas para cada registro de la tabla -->
            </tbody>
        </table>

        <!-- Formulario para agregar o editar una Prueba -->
        <h3>Agregar/Editar Prueba</h3>
        <form action="guardar_prueba.php" method="POST">
            <!-- Campos del formulario -->
            <label for="nombre_prueba">Nombre:</label>
            <input type="text" id="nombre_prueba" name="nombre_prueba">
            <label for="descripcion_prueba">Descripción:</label>
            <textarea id="descripcion_prueba" name="descripcion_prueba"></textarea>
            <!-- Otros campos según las columnas de tu tabla -->
            <button type="submit">Guardar</button>
        </form>
    </section>

    <!-- Repite la estructura para las otras tablas (Materiales, Usuarios, Plataformas, Clientes) -->

    <!-- Materiales -->
    <!-- Usuarios -->
    <!-- Plataformas -->
    <!-- Clientes -->

    <!-- Agrega scripts JavaScript si es necesario -->

</div>


</body>
</html>
