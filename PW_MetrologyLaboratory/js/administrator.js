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

/*****************************************************************************************
 * ************************FUNCIONES CLIENTES: AGREGAR/MODIFICAR *************************
 * ***************************************************************************************/


function registrarCliente(){
    var descClienteN= id("descClienteN");
    const dataForm = new FormData();
    dataForm.append('descClienteN', descClienteN.value.trim());

    fetch('../../dao/daoNuevoCliente.php', {
        method: 'POST',
        body: dataForm
    })
        .then(function (response) {
            if (response.ok) { //respuesta
                Swal.fire({
                    title: "¡Cliente agregado exitosamente!",
                    icon: "success"
                });
                initDataTableClientes();
            } else {
                throw "Error en la llamada Ajax";
            }
        })
        .then(function (texto) {
            console.log(texto);
        })
        .catch(function (err) {
            console.log(err);
        });
}


function editarCliente(id_cliente){

    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoConsultarUnCliente.php?id_cliente=' + id_cliente, function (data) {
        var inputCliente = id("descClienteE");
        inputCliente.value = data.data[0].descripcionCliente;
    });

    var btnActualizarCliente = document.getElementById('btn-updCliente');
    if (btnActualizarCliente) { // Verifica que el botón exista en el DOM
        btnActualizarCliente.onclick = function () {
            actualizarCliente(id_cliente);
        };
    }
}

function actualizarCliente(id_cliente){
    console.log("id_cliente para editar: " + id_cliente);
    var descClienteE= id("descClienteE");
    const data = new FormData();
    data.append('id_cliente',id_cliente);
    data.append('descClienteE',descClienteE.value.trim());

    //alert ("id:"+id_cliente+" desc: "+descClienteE.value.trim())

    fetch('../../dao/daoActualizarCliente.php', {
        method: 'POST',
        body: data
    })
        .then(function (response) {
            if (response.ok) { //respuesta
                Swal.fire({
                    title: "¡Cliente actualizado exitosamente!",
                    icon: "success"
                });
                initDataTableClientes();
                initDataTablePlataformas();
            } else {
                throw "Error en la llamada Ajax";
            }
        })
        .then(function (texto) {
            console.log(texto);
        })
        .catch(function (err) {
            console.log(err);
        });
}
function activarCliente(id_cliente){
    fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoActivarCliente.php?id_cliente='+id_cliente,{
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(id_cliente)
    }).then(res => {
        initDataTableClientesDes();
        initDataTablePlataformasDes();
        if(!res.ok){
            console.log('Problem');
            return;
        }
        return res.json();
    })
        .then(data => {
            Swal.fire("¡Cliente activado!");
        })
        .catch(error =>{
            console.log(error);
        });
}
function desactivarCliente(id_cliente) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: "¿Estás seguro(a)?",
        text: "El cliente y sus plataformas ya no estarán disponibles para hacer solicitudes.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "¡Sí, desactivar!",
        cancelButtonText: "¡No, cancelar!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/desactivarCliente.php?id_cliente='+id_cliente,{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(id_cliente)
            }).then(res => {
                if(res.ok){
                    swalWithBootstrapButtons.fire({
                        title: "¡Desactivado!",
                        text: "El cliente ha sido desactivado.",
                        icon: "success"
                    });
                    initDataTableClientes();
                    initDataTablePlataformas();
                }else{
                    console.log('Problem');
                    return;
                }
                return res.json();
            }).catch(error =>{
                Swal.fire({
                    title: "Error",
                    text: error.message,
                    icon: "error",
                    confirmButtonText: "OK"
                });
            });
        } else if (
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire({
                title: "Cancelado",
                text: "El cliente sigue activo y disponible para hacer solicitudes.",
                icon: "error"
            });
        }
    });
}

/*****************************************************************************************
 * **************************FUNCIONES PLATAFORMA: AGREGAR/MODIFICAR *********************
 * ***************************************************************************************/

function registrarPlataforma(){
    var descPlataformaN= id("descPlataformaN");
    var descPClienteN =  id("descPClienteN");
    const dataForm = new FormData();
    dataForm.append('descPlataformaN', descPlataformaN.value.trim());
    dataForm.append('descPClienteN', descPClienteN.value.trim());

    fetch('../../dao/daoNuevaPlataforma.php', {
        method: 'POST',
        body: dataForm
    }).then(function (response) {
        if (response.ok) { //respuesta
            Swal.fire({
                title: "¡Plataforma agregada con éxito!",
                icon: "success"
            });
            initDataTablePlataformas();
        } else {
            throw "Error en la llamada Ajax";
        }
    }).then(function (texto) {
        console.log(texto);
    }).catch(function (err) {
        console.log(err);
    });
}

function editarPlataforma(id_plataforma){
    console.log("id_plataforma para editar: " + id_plataforma);
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoConsultarUnaPlataforma.php?id_plataforma=' + id_plataforma, function (data) {
        var inputPlataforma = id("descPlataformaE");
        inputPlataforma.value = data.data[0].descripcionPlataforma;

        var selectS = id("descPClienteE");
        selectS.innerHTML = ""; //limpiar contenido

        for (var j = 0; j < data.data.length; j++) {
            var createOption = document.createElement("option");
            createOption.value = data.data[j].id_cliente;
            createOption.text = data.data[j].descripcionCliente;
            selectS.appendChild(createOption);
            if (data.data[j].id_plataforma === id_plataforma) {
                createOption.selected = true;
            }
        }
    });

    var btnActualizarPlataforma = document.getElementById('btn-updPlataforma');
    if (btnActualizarPlataforma) { // Verifica que el botón exista en el DOM
        btnActualizarPlataforma.onclick = function() {
            actualizarPlataforma(id_plataforma);
        };
    }
}
function  actualizarPlataforma(id_plataforma){
    console.log("id_plataforma para actualizar: " + id_plataforma);

    var descPlataformaE= id("descPlataformaE");
    var descPClienteE= id("descPClienteE");

    const data = new FormData();
    data.append('id_plataforma',id_plataforma);
    data.append('descPlataformaE',descPlataformaE.value.trim());
    data.append('descPClienteE',descPClienteE.value.trim());

    //alert ("id:"+id_plataforma+" desc Plata: "+descPlataformaE.value.trim()+" desc cliente: "+descPClienteE.value.trim())

    fetch('../../dao/daoActualizarPlataforma.php', {
        method: 'POST',
        body: data
    })
        .then(function (response) {
            if (response.ok) { //respuesta
                Swal.fire({
                    title: "¡Plataforma actualizada exitosamente!",
                    icon: "success"
                });
                initDataTablePlataformas();
            } else {
                throw "Error en la llamada Ajax";
            }
        })
        .then(function (texto) {
            console.log(texto);
        })
        .catch(function (err) {
            console.log(err);
        });

}
function activarPlataforma(id_plataforma){
    fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoActivarPlataforma.php?id_plataforma='+id_plataforma,{
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(id_plataforma)
    }).then(res => {
        initDataTablePlataformasDes();
        if(!res.ok){
            console.log('Problem');
            return;
        }
        return res.json();
    })
        .then(data => {
            Swal.fire("¡Plataforma activada!");
        })
        .catch(error =>{
            console.log(error);
        });
}

function desactivarPlataforma(id_plataforma) {
    const data = new FormData();
    data.append('id_plataforma',id_plataforma);

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: "¿Estás seguro(a)?",
        text: "La plataforma ya no estará disponible para hacer solicitudes.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "¡Sí, desactivar!",
        cancelButtonText: "¡No, cancelar!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/desactivarPlataforma.php',{
                method: 'POST',
                body: data
            }).then(res => {
                if(res.ok){
                    swalWithBootstrapButtons.fire({
                        title: "¡Desactivada!",
                        text: "La platafroma ha sido desactivada.",
                        icon: "success"
                    });
                    initDataTablePlataformas();
                }else{
                    console.log('Problem');
                    return;
                }
                return res.json();
            }).catch(error =>{
                    //console.log(error);
                    Swal.fire({
                        title: "Error",
                        text: error.message,
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                });
        } else if ( result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire({
                title: "Cancelado",
                text: "La plataforma sigue activa y visible para todos.",
                icon: "error"
            });
        }
    });
}

/*****************************************************************************************
 * ***********************FUNCIONES USUARIOS: MODIFICAR/DESACTIVAR ***********************
 * ***************************************************************************************/


function editarUsuario(id_usuario){
    console.log("id_usuario para editar: " + id_usuario);


    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoConsultarUnUsuario.php?id_usuario=' + id_usuario, function (data) {
        var inputNombre = id("nombreUsuarioE");
        inputNombre.value = data.data[0].nombreUsuario;

        var inputCorreo = id("correoE");
        inputCorreo.value = data.data[0].correoElectronico;

        //imgActual
        id("fotoUsuarioE").src = data.data[0].foto;

        var selectS = id("tipoDeUsuarioE");
        selectS.innerHTML = ""; //limpiar contenido

        for (var j = 0; j < data.data.length; j++) {
            var createOption = document.createElement("option");
            createOption.value = data.data[j].id_tipoUsuario;
            createOption.text = data.data[j].descripcionTipo;
            selectS.appendChild(createOption);
            if (data.data[j].id_usuario === id_usuario) {
                createOption.selected = true;
            }
        }
    });

    var btnActualizarUsuario = document.getElementById('btn-updUsuario');
    if (btnActualizarUsuario) { // Verifica que el botón exista en el DOM
        btnActualizarUsuario.onclick = function() {
            actualizarUsuario(id_usuario);
        };
    }
}
function actualizarUsuario(id_usuario){
    console.log("actualizar user: " + id_usuario);

    var tipoDeUsuarioE= id("tipoDeUsuarioE");
    const data = new FormData();
    data.append('id_usuario',id_usuario);
    data.append('tipoDeUsuarioE',tipoDeUsuarioE.value.trim());

    //alert ("id:"+id_usuario+" tipoDeUsuarioE: "+tipoDeUsuarioE.value.trim())

    fetch('../../dao/daoActualizarUsuario.php', {
        method: 'POST',
        body: data
    })
        .then(function (response) {
            if (response.ok) { //respuesta
                Swal.fire({
                    title: "¡Usuario actualizado exitosamente!",
                    icon: "success"
                });
                initDataTableUsuarios();
            } else {
                throw "Error en la llamada Ajax";
            }
        })
        .then(function (texto) {
            console.log(texto);
        })
        .catch(function (err) {
            console.log(err);
        });
}
function activarUsuario(id_usuario){
    fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoActivarUsuario.php?id_usuario='+id_usuario,{
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(id_usuario)
    }).then(res => {
        initDataTableUsuariosDes();
        if(!res.ok){
            console.log('Problem');
            return;
        }
        return res.json();
    })
        .then(data => {
            Swal.fire("¡Perfil de usuario activado!");
        })
        .catch(error =>{
            console.log(error);
        });
}


function desactivarUsuario(id_usuario){
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: "¿Estás seguro(a)?",
        text: "Al desactivar el perfil del usuario ya no podrá hacer solicitudes.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "¡Sí, desactivar!",
        cancelButtonText: "¡No, cancelar!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/desactivarUsuario.php?id_usuario='+id_usuario,{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(id_usuario)
            }).then(res => {
                initDataTableUsuarios();
                if(!res.ok){
                    console.log('Problem');
                    return;
                }
                return res.json();
            })
                .then(data => {
                    console.log('Success');
                    swalWithBootstrapButtons.fire({
                        title: "¡Desactivado!",
                        text: "El perfil del usuario ha sido desactivado.",
                        icon: "success"
                    });
                })
                .catch(error =>{
                    console.log(error);
                });
        } else if (
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire({
                title: "Cancelado",
                text: "El perfil del usuario sigue activo.",
                icon: "error"
            });
        }
    });
}
