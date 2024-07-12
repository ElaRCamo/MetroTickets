

function clienteModal(){
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoCliente.php', function (data){
        var selectS = id("descPClienteN");
        selectS.innerHTML = "";

        var createOptionDef = document.createElement("option");
        createOptionDef.text = "Especifique el cliente*";
        createOptionDef.value = "";
        selectS.appendChild(createOptionDef);

        for (var j = 0; j < data.data.length; j++) {
            var createOption = document.createElement("option");
            createOption.value = data.data[j].id_cliente;
            createOption.text = data.data[j].descripcionCliente;
            selectS.appendChild(createOption);

        }
    });
}

function consultarPlataformas() {
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoPlataforma.php?id_cliente=' + id("descMClienteE").value, function (data) {
        var selectS = id("descMPlataformaE");
        selectS.innerHTML = ""; //limpiar contenido

        var createOptionDef = document.createElement("option");
        createOptionDef.text = "Seleccione la plataforma*";
        createOptionDef.value = "";
        selectS.appendChild(createOptionDef);

        for (var j = 0; j < data.data.length; j++) {
            var createOptionS = document.createElement("option");
            createOptionS.value = data.data[j].id_plataforma;
            createOptionS.text = data.data[j].descripcionPlataforma;
            selectS.appendChild(createOptionS);
        }
    });
}
function plataformaModal(){
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoPlataformasT.php', function (data){
        var selectS = id("descMPlataformaN");
        selectS.innerHTML = "";

        var createOptionDef = document.createElement("option");
        createOptionDef.text = "Especifique la plataforma*";
        createOptionDef.value = "";
        selectS.appendChild(createOptionDef);

        for (var j = 0; j < data.data.length; j++) {
            var createOption = document.createElement("option");
            createOption.value = data.data[j].id_plataforma;
            createOption.text = data.data[j].descripcionPlataforma;
            selectS.appendChild(createOption);
        }
    });
}


// DataTables
let dataTable;
let dataTableIsInitialized = false;

const dataTableOptions = {
    lengthMenu: [10, 20, 50, 100],
    columnDefs:[
        {className: "centered", targets: [0,1,2,3,4,5,6,7,8]},
        {orderable: false, targets: [3,4,5,6,7,8]},
        {width: "8%", targets: [0,1,2,5,6,7]},
        {width: "12%", targets: [3,4]},
        {searchable: true, targets: [0,1,2,3,4,5,6,7,8] }
    ],
    pageLength:10,
    destroy: true,
    language:{
        lengthMenu: "Mostrar _MENU_ registros pór página",
        sZeroRecords: "Ninguna prueba encontrada",
        info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
        infoEmpty: "Ninguna prueba encontrada",
        infoFiltered: "(filtrados desde _MAX_ registros totales)",
        search: "Buscar: ",
        loadingRecords: "Cargando...",
        paginate:{
            first:"Primero",
            last: "Último",
            next: "Siguiente",
            previous: "Anterior"
        }
    }
};

const initDataTable = async (solicitante) => {
    if (dataTableIsInitialized) {
        dataTable.destroy();
    }

    if(tipoUsuario === '3'){
        await TablaPruebasSolicitante(solicitante);
    }else if(tipoUsuario === '1' || tipoUsuario === '2'){
        await TablaPruebasAdmin();
    }

    dataTable = $("#listadoPruebas").DataTable(dataTableOptions);

    dataTableIsInitialized = true;

    var filtroListadoPruebas = document.getElementById("listadoPruebas_filter");
    var contenedor = filtroListadoPruebas.parentNode;
    contenedor.style.padding = "0";

    var filtroListadoPruebas2 = document.getElementById("listadoPruebas_length");
    var contenedor2 = filtroListadoPruebas2.parentNode;
    contenedor2.style.padding = "0";
};

const TablaPruebasSolicitante = async (id_solicitante) => {
    try {
        const response = await fetch(`https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoConsultaPruebasSolicitante.php?id_solicitante=${id_solicitante}`);

        if (!response.ok) {
            throw new Error(`Error en la solicitud: ${response.status} ${response.statusText}`);
        }

        const result = await response.json();

        let content = '';
        result.data.forEach((item) => {
            content += `
                <tr>
                    <td onclick="reviewPage('${item.id_prueba}')" class="idEnlace">${item.id_prueba}</td>
                    <td>${item.fechaSolicitud}</td>
                    <td>${item.fechaCompromiso}</td>
                    <td>${item.descripcionEstatus}</td>
                    <td>${item.descripcionPrueba}</td>
                    <td>${item.descripcionPrioridad}</td>
                    <td>${item.nombreSolic}</td>
                    <td>${item.nombreMetro}</td>
                    <td>
                        <button class="btn btn-success" onclick="reviewPage('${item.id_prueba}')">
                            <i class="las la-eye"></i><span>Consultar</span>
                        </button>
                        <button class="btn btn-secondary" onclick="reviewPDF('${item.id_prueba}')">
                            <i class="las la-file-pdf"></i><span>PDF</span>
                        </button>
                        <button class="btn btn-danger" onclick="cancelarSolicitud('${item.id_prueba}')">
                            <i class="las la-trash"></i></i><span>Cancelar</span>
                        </button>
                    </td>
                </tr>`;
        });

        listadoPruebasBody.innerHTML = content;
        ocultarContenido("textVerMas", 40);
    } catch (error) {
        console.error('Error:', error);
    }
};


const TablaPruebasAdmin = async () => {
    try {
        const response = await fetch(`https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoConsultaPruebasAdmin.php`);
        const result = await response.json();

        if (!Array.isArray(result.data)) {
            throw new Error('La respuesta del servidor no es un array.');
        }

        let content = '';
        result.data.forEach((item) => {
            content += `
                <tr>
                    <td onclick="reviewPage('${item.id_prueba}')" class="idEnlace">${item.id_prueba}</td>
                    <td>${item.fechaSolicitud}</td>
                    <td>${item.fechaCompromiso}</td>
                    <td>${item.descripcionEstatus}</td>
                    <td>${item.descripcionPrueba}</td>
                    <td>${item.descripcionPrioridad}</td>
                    <td>${item.nombreSolic}</td>
                    <td>${item.nombreMetro}</td>
                    <td>
                        <button class="btn btn-success" onclick="reviewPage('${item.id_prueba}')">
                            <i class="las la-eye"></i><span>Consultar</span>
                        </button>
                        <button class="btn btn-secondary" onclick="reviewPDF('${item.id_prueba}')">
                            <i class="las la-file-pdf"></i><span>PDF</span>
                        </button>
                    </td>
                </tr>`;
        });

        listadoPruebasBody.innerHTML = content;
        ocultarContenido("textVerMas", 40);
    } catch (ex) {
        console.error('Error:', ex);
    }
};


function reviewPage(ID_PRUEBA){
    window.location.href = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/review/index.php?id_prueba=" + ID_PRUEBA;
}



const dataTableOptionsClientes = {
    lengthMenu: [5,10,20,50],
    columnDefs:[
        {className: "centered", targets: [0,1]},
        {orderable: false, targets: [1]},
        {width: "50%", targets: [0,1]},
        {searchable: true, targets: [0] }
    ],
    pageLength:5,
    destroy: true,
    language:{
        lengthMenu: "Mostrar _MENU_ registros",
        sZeroRecords: "Ningún cliente encontrado",
        info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
        infoEmpty: "Ningún cliente encontrado",
        infoFiltered: "(filtrados desde _MAX_ registros totales)",
        search: "Buscar: ",
        loadingRecords: "Cargando...",
        paginate:{
            first:"Primero",
            last: "Último",
            next: "Siguiente",
            previous: "Anterior"
        }
    }
};

let dataTableClientes;
let dataTableIsInitializedClientes = false;
const initDataTableClientes = async () => {

    if (dataTableIsInitializedClientes) {
        dataTableClientes.destroy();
    }
    await TablaAdminClientes();

    dataTableClientes = $("#tablaClientes").DataTable(dataTableOptionsClientes);

    dataTableIsInitializedClientes = true;

    var filtro = document.getElementById("tablaClientes_filter");
    var contenedor = filtro.parentNode;
    contenedor.style.padding = "0";

    var filtro2 = document.getElementById("tablaClientes_length");
    var contenedor2 = filtro2.parentNode;
    contenedor2.style.padding = "0";
};


const TablaAdminClientes = async () => {
    try {
        const response = await fetch(`https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoCliente.php`);
        const result = await response.json();

        if (!Array.isArray(result.data)) {
            throw new Error('La respuesta del servidor no es un array.');
        }

        let content = '';
        result.data.forEach((item) => {
            content += `
                <tr>
                    <td>${item.descripcionCliente}</td>
                    <td class="">
                        <button class="btn btn-warning btnEditar" onclick="editarCliente('${item.id_cliente}')" data-bs-toggle="modal" data-bs-target="#editarClienteModal">
                            <i class="las la-edit"></i> <span>Editar</span>
                        </button>
                        <button class="btn btn-danger btnDesactivar" onclick="desactivarCliente('${item.id_cliente}')">
                            <i class="las la-times-circle"></i> <span>Desactivar</span>
                        </button>
                    </td>
                </tr>`;
        });
        tablaClientesBody.innerHTML = content;
        showButton("btn-clientesDes");
        hideButton("btn-clientesAct");

    } catch (ex) {
        console.error('Error:', ex);
    }
};

const initDataTableClientesDes = async () => {

    if (dataTableIsInitializedClientes) {
        dataTableClientes.destroy();
    }
    await TablaAdminClientesDes();

    dataTableClientes = $("#tablaClientes").DataTable(dataTableOptionsClientes);

    dataTableIsInitializedClientes = true;

    var filtro = document.getElementById("tablaClientes_filter");
    var contenedor = filtro.parentNode;
    contenedor.style.padding = "0";

    var filtro2 = document.getElementById("tablaClientes_length");
    var contenedor2 = filtro2.parentNode;
    contenedor2.style.padding = "0";
};

const TablaAdminClientesDes = async () => {
    try {
        const response = await fetch(`https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoClienteDes.php`);
        const result = await response.json();

        if (!Array.isArray(result.data)) {
            throw new Error('La respuesta del servidor no es un array.');
        }

        let content = '';
        result.data.forEach((item) => {
            content += `
                <tr>
                    <td>${item.descripcionCliente}</td>
                    <td>
                        <button class="btn btn-success btnActivar" onclick="activarCliente('${item.id_cliente}')">
                            <i class="las la-power-off"></i> Activar
                        </button>
                    </td>
                </tr>`;
        });
        tablaClientesBody.innerHTML = content;
        showButton("btn-clientesAct");
        hideButton("btn-clientesDes");

    } catch (ex) {
        console.error('Error:', ex);
    }
};

const dataTableOptionsPlataformas = {
    lengthMenu: [5,10,20,50],
    columnDefs:[
        {className: "centered", targets: [0,1,2]},
        {orderable: false, targets: [2]},
        {searchable: true, targets: [0,1] }
    ],
    pageLength:5,
    destroy: true,
    language:{
        lengthMenu: "Mostrar _MENU_ registros",
        sZeroRecords: "Ninguna plataforma encontrada",
        info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
        infoEmpty: "Ninguna plataforma encontrada",
        infoFiltered: "(filtrados desde _MAX_ registros totales)",
        search: "Buscar: ",
        loadingRecords: "Cargando...",
        paginate:{
            first:"Primero",
            last: "Último",
            next: "Siguiente",
            previous: "Anterior"
        }
    }
};
let dataTablePlataformas;
let dataTableIsInitPlataformas = false;
const initDataTablePlataformas = async () => {

    if (dataTableIsInitPlataformas) {
        dataTablePlataformas.destroy();
    }
    await TablaAdminPlataformas();

    dataTablePlataformas = $("#tablaPlataformas").DataTable(dataTableOptionsPlataformas);

    dataTableIsInitPlataformas = true;

    var filtro = document.getElementById("tablaPlataformas_filter");
    var contenedor = filtro.parentNode;
    contenedor.style.padding = "0";

    var filtro2 = document.getElementById("tablaPlataformas_length");
    var contenedor2 = filtro2.parentNode;
    contenedor2.style.padding = "0";
};

const TablaAdminPlataformas = async () => {
    try {
        const response = await fetch(`https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoPlataformasT.php`);
        const result = await response.json();

        if (!Array.isArray(result.data)) {
            throw new Error('La respuesta del servidor no es un array.');
        }

        let content = '';
        result.data.forEach((item) => {
            content += `
                <tr>
                    <td>${item.descripcionPlataforma}</td>
                    <td>${item.descripcionCliente}</td>
                    <td>
                        <button class="btn btn-warning btnEditar" onclick="editarPlataforma('${item.id_plataforma}')" data-bs-toggle="modal" data-bs-target="#editarPlataformaModal">
                            <i class="las la-edit"></i> <span>Editar</span>
                        </button>
                        <button class="btn btn-danger btnDesactivar" onclick="desactivarPlataforma('${item.id_plataforma}')">
                            <i class="las la-times-circle"></i> <span>Desactivar</span>
                        </button>
                    </td>
                </tr>`;
        });
        tablaPlataformasBody.innerHTML = content;
        hideButton("btn-plataformasAct");
        showButton("btn-plataformasDes");

    } catch (ex) {
        console.error('Error:', ex);
    }
};

const initDataTablePlataformasDes = async () => {

    if (dataTableIsInitPlataformas) {
        dataTablePlataformas.destroy();
    }
    await TablaAdminPlataformasDes();

    dataTablePlataformas = $("#tablaPlataformas").DataTable(dataTableOptionsPlataformas);

    dataTableIsInitPlataformas = true;

    var filtro = document.getElementById("tablaPlataformas_filter");
    var contenedor = filtro.parentNode;
    contenedor.style.padding = "0";

    var filtro2 = document.getElementById("tablaPlataformas_length");
    var contenedor2 = filtro2.parentNode;
    contenedor2.style.padding = "0";
};

const TablaAdminPlataformasDes = async () => {
    try {
        const response = await fetch(`https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoPlataformasTDes.php`);
        const result = await response.json();

        if (!Array.isArray(result.data)) {
            throw new Error('La respuesta del servidor no es un array.');
        }

        let content = '';
        result.data.forEach((item) => {
            content += `
                <tr>
                    <td>${item.descripcionPlataforma}</td>
                    <td>${item.descripcionCliente}</td>
                    <td>
                        <button class="btn btn-success btnActivar" onclick="activarPlataforma('${item.id_plataforma}')">
                            <i class="las la-check-circle"></i> Activar
                        </button>
                    </td>
                </tr>`;
        });
        tablaPlataformasBody.innerHTML = content;
        showButton("btn-plataformasAct");
        hideButton("btn-plataformasDes");

    } catch (ex) {
        console.error('Error:', ex);
    }
};

const dataTableOptionsMateriales = {
    lengthMenu: [5,10,20,50],
    columnDefs:[
        {className: "centered", targets: [0,1,2,3,4,5]},
        {orderable: false, targets: [2,5]},
        {searchable: true, targets: [0,1,3,4]},
        {width: "25%", targets: [5]}
    ],
    pageLength:5,
    destroy: true,
    language:{
        lengthMenu: "Mostrar _MENU_ registros",
        sZeroRecords: "Ningún material encontrado",
        info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
        infoEmpty: "Ningún material encontrado",
        infoFiltered: "(filtrados desde _MAX_ registros totales)",
        search: "Buscar: ",
        loadingRecords: "Cargando...",
        paginate:{
            first:"Primero",
            last: "Último",
            next: "Siguiente",
            previous: "Anterior"
        }
    }
};

let dataTableMateriales;
let dataTableIsInitMateriales = false;
const initDataTableMateriales = async () => {

    if (dataTableIsInitMateriales) {
        dataTableMateriales.destroy();
    }
    await TablaAdminMateriales();

    dataTableMateriales = $("#tablaMateriales").DataTable(dataTableOptionsMateriales);

    dataTableIsInitMateriales = true;

    var filtro = document.getElementById("tablaMateriales_filter");
    var contenedor = filtro.parentNode;
    contenedor.style.padding = "0";

    var filtro2 = document.getElementById("tablaMateriales_length");
    var contenedor2 = filtro2.parentNode;
    contenedor2.style.padding = "0";
};

const TablaAdminMateriales = async () => {
    try {
        const response = await fetch(`https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoConsultaMateriales.php`);
        const result = await response.json();

        if (!Array.isArray(result.data)) {
            throw new Error('La respuesta del servidor no es un array.');
        }

        let content = '';
        result.data.forEach((item) => {
            content += `
                <tr>
                    <td>${item.descripcionMaterial}</td>
                    <td>${item.numeroDeParte}</td>
                    <td>
                        <img class="col-md-6 mb-3 ms-md-3 rounded img-fluid img-thumbnail" src="${item.imgMaterial}">
                    </td>
                    <td>${item.descripcionPlataforma}</td>
                    <td>${item.descripcionCliente}</td>
                    <td>
                        <button class="btn btn-warning btnEditar" onclick="editarMaterial('${item.id_descripcion}')" data-bs-toggle="modal" data-bs-target="#editarMaterialModal">
                            <i class="las la-edit"></i> <span>Editar</span>
                        </button>
                        <button class="btn btn-danger btnDesactivar" onclick="desactivarMaterial('${item.id_descripcion}')">
                            <i class="las la-times-circle"></i> <span>Desactivar</span>
                        </button>
                    </td>
                </tr>`;
        });
        tablaMaterialesBody.innerHTML = content;
        hideButton("btn-materialesAct");
        showButton("btn-materialesDes");
    } catch (ex) {
        console.error('Error:', ex);
    }
};

const initDataTableMaterialesDes = async () => {
    if (dataTableIsInitMateriales) {
        dataTableMateriales.destroy();
    }
    await TablaAdminMaterialesDes();

    dataTableMateriales = $("#tablaMateriales").DataTable(dataTableOptionsMateriales);

    dataTableIsInitMateriales = true;

    var filtro = document.getElementById("tablaMateriales_filter");
    var contenedor = filtro.parentNode;
    contenedor.style.padding = "0";

    var filtro2 = document.getElementById("tablaMateriales_length");
    var contenedor2 = filtro2.parentNode;
    contenedor2.style.padding = "0";
};

const TablaAdminMaterialesDes = async () => {
    try {
        const response = await fetch(`https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoConsultaMaterialesDes.php`);
        const result = await response.json();

        if (!Array.isArray(result.data)) {
            throw new Error('La respuesta del servidor no es un array.');
        }

        let content = '';
        result.data.forEach((item) => {
            content += `
                <tr>
                    <td>${item.descripcionMaterial}</td>
                    <td>${item.numeroDeParte}</td>
                    <td>
                        <img class="col-md-6 mb-3 ms-md-3 rounded img-fluid img-thumbnail" src="${item.imgMaterial}">
                    </td>
                    <td>${item.descripcionPlataforma}</td>
                    <td>${item.descripcionCliente}</td>
                    <td>
                        <button class="btn btn-success btnActivar" onclick="activarMaterial('${item.id_descripcion}')">
                            <i class="las la-check-circle"></i> Activar
                        </button>
                    </td>
                </tr>`;
        });
        tablaMaterialesBody.innerHTML = content;
        showButton("btn-materialesAct");
        hideButton("btn-materialesDes");
    } catch (ex) {
        console.error('Error:', ex);
    }
};

const dataTableOptionsUsuarios = {
    lengthMenu: [5,10,20,50],
    columnDefs:[
        {className: "centered", targets: [0,1,2,3]},
        {orderable: false, targets: [0,1,2]},
        {searchable: true, targets: [3]}
    ],
    pageLength:5,
    destroy: true,
    language:{
        lengthMenu: "Mostrar _MENU_ registros",
        sZeroRecords: "Ningún usuario encontrado",
        info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
        infoEmpty: "Ningún usuario encontrado",
        infoFiltered: "(filtrados desde _MAX_ registros totales)",
        search: "Buscar: ",
        loadingRecords: "Cargando...",
        paginate:{
            first:"Primero",
            last: "Último",
            next: "Siguiente",
            previous: "Anterior"
        }
    }
};

let dataTableUsuarios;
let dataTableIsInitUsuarios = false;

const initDataTableUsuarios = async () => {
    if (dataTableIsInitUsuarios) {
        dataTableUsuarios.destroy();
    }
    await TablaAdminUsuarios();

    dataTableUsuarios = $("#tablaUsuarios").DataTable(dataTableOptionsUsuarios);

    dataTableIsInitUsuarios = true;

    var filtro = document.getElementById("tablaUsuarios_filter");
    var contenedor = filtro.parentNode;
    contenedor.style.padding = "0";

    var filtro2 = document.getElementById("tablaUsuarios_length");
    var contenedor2 = filtro2.parentNode;
    contenedor2.style.padding = "0";
}
const TablaAdminUsuarios = async () => {
    try {
        const response = await fetch(`https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoConsultaUsuarios.php`);
        const result = await response.json();

        if (!Array.isArray(result.data)) {
            throw new Error('La respuesta del servidor no es un array.');
        }

        let content = '';
        result.data.forEach((item) => {
            content += `
                <tr>
                    <td>${item.nombreUsuario}</td>
                    <td>${item.correoElectronico}</td>
                    <td>${item.descripcionTipo}</td>
                    <td>
                        <button class="btn btn-warning btnEditar" onclick="editarUsuario('${item.id_usuario}')" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal">
                            <i class="las la-edit"></i><span>Editar</span>
                        </button>
                        <button class="btn btn-danger btnDesactivar" onclick="desactivarUsuario('${item.id_usuario}')">
                            <i class="las la-times-circle"></i><span>Desactivar</span>
                        </button>
                    </td>
                </tr>`;
        });
        tablaUsuariosBody.innerHTML = content;
        showButton("btn-usuariosDes");
        hideButton("btn-usuariosAct");
    } catch (ex) {
        console.error('Error:', ex);
    }
};
const initDataTableUsuariosDes = async () => {
    if (dataTableIsInitUsuarios) {
        dataTableUsuarios.destroy();
    }
    await TablaAdminUsuariosDes();

    dataTableUsuarios = $("#tablaUsuarios").DataTable(dataTableOptionsUsuarios);

    dataTableIsInitUsuarios = true;

    var filtro = document.getElementById("tablaUsuarios_filter");
    var contenedor = filtro.parentNode;
    contenedor.style.padding = "0";

    var filtro2 = document.getElementById("tablaUsuarios_length");
    var contenedor2 = filtro2.parentNode;
    contenedor2.style.padding = "0";
}
const TablaAdminUsuariosDes = async () => {
    try {
        const response = await fetch(`https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoConsultaUsuariosDes.php`);
        const result = await response.json();

        if (!Array.isArray(result.data)) {
            throw new Error('La respuesta del servidor no es un array.');
        }

        let content = '';
        result.data.forEach((item) => {
            content += `
                <tr>
                    <td>${item.nombreUsuario}</td>
                    <td>${item.correoElectronico}</td>
                    <td>${item.descripcionTipo}</td>
                    <td>
                        <button class="btn btn-success btnActivar" onclick="activarUsuario('${item.id_usuario}')">
                            <i class="las la-check-circle"></i> Activar
                        </button>
                    </td>
                </tr>`;
        });
        tablaUsuariosBody.innerHTML = content;
        showButton("btn-usuariosAct");
        hideButton("btn-usuariosDes");
    } catch (ex) {
        console.error('Error:', ex);
    }
};


function pruebasRealizadasMesActual(){
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoPruebasMes.php', function (data){
        var numPruebasMesActual = data.data[0]['COUNT(*)']; // Obtener el número de pruebas
        document.getElementById("numeroPruebas").innerText = numPruebasMesActual;
        console.log("numPruebas: "+ data.data[0]['COUNT(*)']);

    });
}

function pruebasPendientes(){
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoPruebasPendientes.php', function (data){
        var numPruebasPendientes = data.data[0]['COUNT(*)']; // Obtener el número de pruebas
        document.getElementById("pruebasPendientes").innerText = numPruebasPendientes;
    });
}

function tiempoRespuesta(){
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoPruebasTiempoRespuesta.php', function (data){
        var tiempoRespuesa = data.data[0].tiempoPromedioRespuestaDias;
        document.getElementById("tiempoRespuesaSpan").innerText = tiempoRespuesa;
    });
}

function pruebasPorDia(){
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoPruebasPorDia.php', function (data){
        var pruebasPorDia = data.data[0].eficienciaOperativa;
        document.getElementById("pruebasPorDiaSpan").innerText = pruebasPorDia;
    });
}

function cumplimientoFechaResp() {
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoCumplimientoFechaResp.php', function (data){
        var cumplimiento = data.data[0].porcentajeCumplimiento;
        document.getElementById("cumplimiento").innerText = cumplimiento + ' %';
    });
}


/*Queda pendiente de integracion 23/04/2024
function estatusMateriales(k){
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoEstatusMaterial.php', function (data){
        var selectS = id("selEstMat" + k);
        selectS.innerHTML = ""; //limpiar contenido

        for (var j = 0; j < data.data.length; j++) {
            var createOption = document.createElement("option");
            createOption.value = data.data[j].id_estatusMaterial;
            createOption.text = data.data[j].descripcionEstatus;
            selectS.appendChild(createOption);
            if (data.data[j].id_estatusMaterial === id_metrologoSol) {
                createOption.selected = true;
            }
        }
    });
}*/



function llenarAnio(){
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoAnio.php', function (data){
        var selectS = id("anioR");
        selectS.innerHTML = "";

        for (var i = 0; i < data.data.length; i++) {
            var createOption = document.createElement("option");
            createOption.value = data.data[i].anio;
            createOption.text = data.data[i].anio;
            selectS.appendChild(createOption);
        }
    });
}


function llenarMes() {
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoAnioMes.php?anio=' + id("anioR").value, function (data) {
        var selectS = id("mesR");
        selectS.innerHTML = ""; //limpiar contenido

        var createOptionDef = document.createElement("option");
        createOptionDef.text = "Seleccione el mes*";
        createOptionDef.value = "";
        selectS.appendChild(createOptionDef);

        let meses = {"1": "Enero","2": "Febrero","3": "Marzo","4": "Abril","5": "Mayo","6": "Junio",
                           "7": "Julio","8": "Agosto","9": "Septiembre","10": "Octubre","11": "Noviembre","12": "Diciembre"};

        for (var i = 0; i < data.data.length; i++) {
            var createOptionS = document.createElement("option");
            createOptionS.value = data.data[i].mes;
            createOptionS.text =meses[data.data[i].mes];
            selectS.appendChild(createOptionS);
        }
    });
}

function generarReporte() {
    const esTipo = validarSelect('tipoReporte');
    const esAnio = validarSelect('anioR');
    const esMes = validarSelect('mesR');

    if(esTipo && esAnio && esMes) {

        var tipo = id("tipoReporte");
        var anio = id("anioR");
        var mes = id("mesR");

        if(tipo.value === '1'){
            var url = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/reports/reportePDF.php?anio=" + anio.value + "&mes=" + mes.value;

        }else if(tipo.value === '2'){
            var url = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/reports/reportePDF.php?anio=" + anio.value + "&mes=" + mes.value;
        }
        console.log(url);
        window.location.href = url;
    }
}