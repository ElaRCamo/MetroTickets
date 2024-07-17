/*****************************************************************************************
 * **************************FUNCIONES PARA TABLA CLIENTES********************************
 * ***************************************************************************************/

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


/*****************************************************************************************
 * **************************FUNCIONES PARA TABLA PLATAFORMAS*****************************
 * ***************************************************************************************/


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


/*****************************************************************************************
 * **************************FUNCIONES PARA TABLA USUARIOS********************************
 * ***************************************************************************************/

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
}
/*****************************************************************************************
 * **************************FUNCIONES VENTANAS MODALES***********************************
 * ***************************************************************************************/

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
