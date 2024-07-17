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
        let cumplimiento = data.data[0].porcentajeCumplimiento;
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