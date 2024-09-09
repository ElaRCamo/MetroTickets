// DataTables
let dataTable;
let dataTableIsInitialized = false;

const dataTableOptions = {
    lengthMenu: [10, 20, 50, 100],
    columnDefs:[
        {className: "centered", targets: [0,1,2,3,4,5,6,7,8]},
        {orderable: false, targets: [1,3,5,8]},
        {width: "8%", targets: [0,1,2,5,6,7]},
        {width: "12%", targets: [3,4]},
        {searchable: true, targets: [0,1,2,3,4,5,6,7,8] }
    ],
    pageLength:10,
    destroy: true,
    order: [[0, 'desc']], // Ordenar por la columna 0
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
        const response = await fetch(`https://grammermx.com/Metrologia/MetroTickets/dao/daoConsultaPruebasSolicitante.php?id_solicitante=${id_solicitante}`);

        if (!response.ok) {
            throw new Error(`Error en la solicitud: ${response.status} ${response.statusText}`);
        }

        const result = await response.json();

        let content = '';
        result.data.forEach((item) => {

            // Formatea las fechas de solicitud y compromiso
            let fechaSolicitudFormateada = formatearFecha(item.fechaSolicitud);
            let fechaCompromisoFormateada = formatearFecha(item.fechaCompromiso);

            content += `
                    <tr>
                        <td onclick="reviewPage('${item.id_prueba}')" class="idEnlace">${item.id_prueba}</td>
                        <td>${item.descripcionPrueba}</td>
                        <td>${fechaSolicitudFormateada}</td>
                        <td>${item.nombreSolic}</td>
                        <td>${fechaCompromisoFormateada}</td>
                        <td>${item.nombreMetro}</td>
                        <td>${item.estatusVisual}</td>
                        <td>${item.prioridadVisual}</td>
                        <td>
                            <button class="btn btn-success" onclick="reviewPage('${item.id_prueba}')">
                                <i class="las la-eye"></i><span>Consultar</span>
                            </button>
                            <button class="btn btn-secondary" onclick="reviewPDF('${item.id_prueba}')">
                                <i class="las la-file-pdf"></i><span>PDF</span>
                            </button>`;

            // Verifica si id_estatusPrueba no es 4 ni 9 antes de agregar el botón de cancelar
            if (item.id_estatusPrueba !== 4 && item.id_estatusPrueba !== 6 && item.id_estatusPrueba !== 9) {
                content += `
                            <button class="btn btn-danger" onclick="cancelarSolicitud('${item.id_prueba}')">
                                <i class="las la-trash"></i><span>Cancelar</span>
                            </button>`;
            }

            content += `
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
        const response = await fetch(`https://grammermx.com/Metrologia/MetroTickets/dao/daoConsultaPruebasAdmin.php`);
        const result = await response.json();

        if (!Array.isArray(result.data)) {
            throw new Error('La respuesta del servidor no es un array.');
        }

        let content = '';
        result.data.forEach((item) => {
            // Formatea las fechas de solicitud y compromiso
            let fechaSolicitudFormateada = formatearFecha(item.fechaSolicitud);
            let fechaCompromisoFormateada = formatearFecha(item.fechaCompromiso);

            content += `
                <tr>
                    <td onclick="reviewPage('${item.id_prueba}')" class="idEnlace">${item.id_prueba}</td>
                    <td>${item.descripcionPrueba}</td>
                    <td>${fechaSolicitudFormateada}</td>
                    <td>${item.nombreSolic}</td>
                    <td>${fechaCompromisoFormateada}</td>
                    <td>${item.nombreMetro}</td>
                    <td>${item.estatusVisual}</td>
                    <td>${item.prioridadVisual}</td>
                    <td>
                        <button class="btn btn-success" onclick="reviewPage('${item.id_prueba}')">
                            <i class="las la-eye"></i><span>Consultar</span>
                        </button>
                        <button class="btn btn-secondary" onclick="reviewPDF('${item.id_prueba}')">
                            <i class="las la-file-pdf"></i><span>PDF</span>
                        </button>`;

                    if (item.estatusSolicitud === '4') {
                        content += `
                        <button class="btn btn-warning" onclick="finalizarSolicitud('${item.id_prueba}', '${item.id_tipoPrueba}')">
                            <i class="las la-check"></i><span>Finalizar proceso</span>
                        </button>`;
                    }
                    content += `
                    </td>
                </tr>`;
        });

        listadoPruebasBody.innerHTML = content;
        ocultarContenido("textVerMas", 40);
    } catch (ex) {
        console.error('Error:', ex);
    }
};

function finalizarSolicitud(id_prueba, id_tipoPrueba) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "No podrás revertir esta acción",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#005195',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, finalizar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const dataForm = new FormData();
            dataForm.append('id_prueba', id_prueba);
            dataForm.append('id_tipoPrueba', id_tipoPrueba);

            fetch(rutaBase + '/dao/daoFinalizarSolicitud.php', {
                method: 'POST',
                body: dataForm
            }).then(function (response) {
                if (!response.ok) {
                    //console.log('Problem');
                    return;
                }
                return response.json();
            }).then(async function (data) {
                if (data.status === 'success') {
                    Swal.fire({
                        title: "Éxito",
                        text: data.message,
                        icon: "success",
                        confirmButtonText: "OK"
                    })
                    // recargar tabla
                    await initDataTable(id_solicitante);
                } else if (data.status === 'error') {
                    Swal.fire({
                        title: "Error",
                        text: data.message,
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            }).catch(error => {
                Swal.fire({
                    title: "Error",
                    text: error.message,
                    icon: "error",
                    confirmButtonText: "OK"
                });
            });
        }
    });
}


function reviewPage(ID_PRUEBA){
    window.location.href = rutaBase + "/modules/review/index.php?id_prueba=" + ID_PRUEBA;
}

function cancelarSolicitud(id_prueba){
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: "¿Estás seguro(a)?",
        text: "Si cancelas la solicitud y necesitas recuperarla, tendrás que crear una nueva.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "¡Sí!",
        cancelButtonText: "¡No!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(rutaBase +  '/dao/daoCancelarSolicitud.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id_prueba: id_prueba })
            }).then(res => {
                if(!res.ok){
                    console.log('Problem');
                    return;
                }
                return res.json();
            })
                .then(data => {
                    console.log('Success');
                    swalWithBootstrapButtons.fire({
                        title: "¡Cancelada!",
                        text: "La solicitud ha sido cancelada.",
                        icon: "success"
                    });
                })
                .catch(error => {
                    console.log(error);
                }).then(function(data) {
                initDataTable(id_solicitante);
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire({
                title: "¡Detenido!",
                text: "La solicitud sigue activa.",
                icon: "error"
            });
        }
    });
}

