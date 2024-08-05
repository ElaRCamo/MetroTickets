let tipoPruebaSol;
let estatusSol;
let fechaCompromisoSol;
let solicitantePrueba;
let emailSolicitante;
let indiceRowNorma=false; //Para que la fila se genere una sola vez
let indiceRowSubtipo=false;
let indiceTabla=false;
let indicePiezas = false;
let indicePersonal = false;
let dao = '';

/*****************************************************************************************
 * ****************************FUNCIONES PARA CARGAR DATOS *******************************
 * ***************************************************************************************/
function consultaTipoPrueba(id_prueba){
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoConsultarTipoPrueba.php?id_prueba=' + id_prueba, function (response) {
        let tipoPrueba = response.data[0].id_tipoPrueba;
        if(tipoPrueba === '5'){
            dao = 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoResumenPruebaMunsell.php?id_prueba='+ id_prueba;
        }else{
            dao = 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoResumenPrueba.php?id_prueba='+ id_prueba;
        }
        resumenPrueba(dao);
    });
}
function resumenPrueba(dao){
    let id_estatusSol;

    $.getJSON(dao, function (response) {
        //codigo para actualizar campos
        var data = response.data[0]; // primer objeto dentro de 'data'

        $('#numeroPruebaR').text(data.id_prueba);

        let fechaSolicitudFormateada = formatearFecha(data.fechaSolicitud);
        $('#fechaSolicitudR').text(fechaSolicitudFormateada);

        $('#tipoPruebaSolicitudR').text(data.descripcionPrueba);
        $('#solicitanteR').text(data.nombreSolic);

        tipoPruebaSol = data.id_tipoPrueba;

        // SUBTIPO
        if(tipoPruebaSol === '3') { // DIMENSIONAL
            rowSubtipo();
            $('#subtipoR').text(data.descripcion);

            if (data.id_subtipo === '2') { // Cotas especificas
                id("imagenCotasR").href = data.imagenCotas;
                $('#textImgR').text("Ver imagen");
            } else if (data.id_subtipo === '1') { //Full layout
                id("imagenCotasR").style.pointerEvents = "none";
                $('#textImgR').text("No aplica");
            }
        }

        // NORMA
        if (tipoPruebaSol === '1' || tipoPruebaSol === '2' || tipoPruebaSol === '6') { // ILD/IFD | SOFTNESS | OTRO
            rowNorma();

            $('#normaNombreR').text(data.normaNombre);
            var normaArchivo = data.normaArchivo;

            if (isValidURL(normaArchivo)) {
                // Se agrega texto del enlace
                id("archivoNormaR").href = normaArchivo;
                var nombreArchivo = normaArchivo.substring(normaArchivo.lastIndexOf('/') + 1);
                var numeroReferencia = nombreArchivo.split('-')[1];
                var nombreArchivoSinPDF = nombreArchivo.substring(0, nombreArchivo.lastIndexOf('.')); // Eliminar la extensión .pdf

               // alert("nombreArchivo: "+nombreArchivo+"\n numeroReferencia: "+numeroReferencia+ "\nnombreArchivoSinPDF: "+nombreArchivoSinPDF)
                id("nombreArchivo").textContent = nombreArchivoSinPDF.substring(numeroReferencia.length + 1);
                id("archivoNormaR").href = normaArchivo;
            } else {
                id("archivoNormaR").textContent = normaArchivo;
                id("archivoNormaR").style.pointerEvents = "none"; // Deshabilitar el clic en el enlace
            }
        }

        let fechaCompromisoFormateada = formatearFecha(data.fechaCompromiso);
        $('#fechaCompromisoR').text(fechaCompromisoFormateada);
        let fechaRespFormateada = formatearFecha(data.fechaRespuesta);
        $('#fechaRespuestaR').text(fechaRespFormateada);

        $('#observacionesSolR').text(data.especificaciones);
        $('#metrologoR').text(data.nombreMetro);
        $('#estatusSolicitudR').text(data.descripcionEstatus);
        $('#prioridadR').text(data.descripcionPrioridad);
        $('#observacionesLabR').text(data.especificacionesLab);


        id_estatusSol = data.id_estatusPrueba;
        estatusSol = data.descripcionEstatus;
        fechaCompromisoSol = data.fechaCompromiso;
        solicitantePrueba = data.nombreSolic;
        emailSolicitante = data.emailSol;

        //console.log("resumenPrueba: id_estatusSol"+id_estatusSol, "estatusSol "+estatusSol);

        var tabla = document.getElementById("materialesResumen");
        var tbody = tabla.getElementsByTagName("tbody")[0];

        // Limpiar contenido previo de la tabla
        tbody.innerHTML = '';

        if(tipoPruebaSol === '5'){//MUNSELL
            let titulo = 'PERSONAL';
            let headers = ['No. de Nómina', 'Nombre', 'Área','Reporte'];
            tablaPiezasyPersonal(titulo, headers);

            for (var j = 0; j < response.data.length; j++) {
                var fila = document.createElement("tr");

                var numNomina = document.createElement("td");
                numNomina.textContent = response.data[j].nomina;
                fila.appendChild(numNomina);

                var nombre = document.createElement("td");
                nombre.textContent = response.data[j].nombre;
                fila.appendChild(nombre);

                var area = document.createElement("td");
                area.textContent = response.data[j].area;
                fila.appendChild(area);

                var reporte = document.createElement("td");
                reporte.textContent = response.data[j].reportePersonal;
                fila.appendChild(reporte);

                tbody.appendChild(fila);
            }
        }else{
            let titulo = 'PIEZAS PARA MEDICIÓN';
            let headers = ['No. de Parte', 'Cantidad', 'Cliente', 'Plataforma', 'Revisión de Dibujo', 'Modelo Matemático', 'Estatus','Reporte'];
            tablaPiezasyPersonal(titulo, headers);

            // Iterar sobre los materiales y crear filas y celdas de tabla
            for (var j = 0; j < response.data.length; j++) {
                var fila = document.createElement("tr");

                var numeroDeParteT = document.createElement("td");
                numeroDeParteT.textContent = response.data[j].numParte;
                fila.appendChild(numeroDeParteT);

                var cdadMaterialesT = document.createElement("td");
                cdadMaterialesT.textContent = response.data[j].cantidad;
                fila.appendChild(cdadMaterialesT);

                var clienteMaterialesT = document.createElement("td");
                clienteMaterialesT.textContent = response.data[j].descripcionCliente;
                fila.appendChild(clienteMaterialesT);

                var plataformaMaterialesT = document.createElement("td");
                plataformaMaterialesT.textContent = response.data[j].descripcionPlataforma;
                fila.appendChild(plataformaMaterialesT);

                var revisionDibujoT = document.createElement("td");
                revisionDibujoT.textContent = response.data[j].revisionDibujo;
                fila.appendChild(revisionDibujoT);

                var modMatematicoT = document.createElement("td");
                modMatematicoT.textContent = response.data[j].modMatematico;
                fila.appendChild(modMatematicoT);

                var estatusMaterialT = document.createElement("td");
                estatusMaterialT.textContent = response.data[j].estatusMaterial;
                fila.appendChild(estatusMaterialT);

                var reporte = document.createElement("td");
                reporte.textContent = response.data[j].reportePieza;
                fila.appendChild(reporte);

                tbody.appendChild(fila);
            }
        }
    }).then(function (){
        updateLinkActualizar(id_estatusSol,estatusSol);
    });
}

function tablaPiezasyPersonal(titulo, headers) {
    if(!indiceTabla){
        // Crear el título
        var h5 = id("materialRTittle");
        h5.textContent = titulo;

        // Crear la tabla
        var table = id("materialesResumen");

        // Crear el encabezado de la tabla
        var thead = document.createElement('thead');
        var tr = document.createElement('tr');

        headers.forEach(function(header) {
            var th = document.createElement('th');
            th.textContent = header;
            tr.appendChild(th);
        });
        thead.appendChild(tr);

        // Crear el cuerpo de la tabla
        var tbody = document.createElement('tbody');

        // Añadir el encabezado y el cuerpo a la tabla
        table.appendChild(thead);
        table.appendChild(tbody);

        indiceTabla = true;
    }
}

function rowSubtipo(){

    if(!indiceRowSubtipo){
        // Crear la fila
        var fila = document.createElement('tr');

        // Crear las celdas y sus contenidos
        var thSubtipo = document.createElement('th');
        thSubtipo.className = "p-2 mb-2";
        thSubtipo.textContent = 'Subtipo:';
        var tdSubtipo = document.createElement('td');
        tdSubtipo.id = 'subtipoR';

        var thImagen = document.createElement('th');
        thImagen.className = "p-2 mb-2";
        thImagen.textContent = 'Imagen Cotas:';
        var tdImagen = document.createElement('td');
        var link = document.createElement('a');
        link.id = 'imagenCotasR';
        link.href = '#'; // Puedes cambiar el enlace
        var span = document.createElement('span');
        span.id = 'textImgR';
        link.appendChild(span);
        tdImagen.appendChild(link);

        // Añadir las celdas a la fila
        fila.appendChild(thSubtipo);
        fila.appendChild(tdSubtipo);
        fila.appendChild(thImagen);
        fila.appendChild(tdImagen);

        // Seleccionar el cuerpo de la tabla y la fila de referencia
        var tbody = document.querySelector('#datosGeneralesTable tbody');
        var filaReferencia = document.querySelector('#trTipoPrueba');

        // Insertar la nueva fila después de la fila de referencia
        if (filaReferencia && filaReferencia.nextSibling) {
            tbody.insertBefore(fila, filaReferencia.nextSibling);
        } else {
            tbody.appendChild(fila);
        }
        indiceRowSubtipo = true;
    }
}

function rowNorma() {

    if(!indiceRowNorma){
        // Crear la fila
        var fila = document.createElement('tr');
        fila.id = 'trNorma';

        // Crear las celdas y sus contenidos
        var thNorma = document.createElement('th');
        thNorma.className = "p-2 mb-2";
        thNorma.textContent = 'Norma:';
        var tdNorma = document.createElement('td');
        tdNorma.id = 'normaNombreR';

        var thDocumento = document.createElement('th');
        thDocumento.className = "p-2 mb-2";
        thDocumento.textContent = 'Documento de la norma:';
        var tdDocumento = document.createElement('td');
        var link = document.createElement('a');
        link.id = 'archivoNormaR';
        link.href = '#'; // Puedes cambiar el enlace
        var span = document.createElement('span');
        span.id = 'nombreArchivo';
        link.appendChild(span);
        tdDocumento.appendChild(link);

        // Añadir las celdas a la fila
        fila.appendChild(thNorma);
        fila.appendChild(tdNorma);
        fila.appendChild(thDocumento);
        fila.appendChild(tdDocumento);

        // Seleccionar el cuerpo de la tabla y la fila de referencia
        var tbody = document.querySelector('#datosGeneralesTable tbody');
        var filaReferencia = document.querySelector('#trTipoPrueba');

        // Insertar la nueva fila después de la fila de referencia
        if (filaReferencia && filaReferencia.nextSibling) {
            tbody.insertBefore(fila, filaReferencia.nextSibling);
        } else {
            tbody.appendChild(fila);
        }
        indiceRowNorma = true;
    }
}

function updateLinkActualizar(id, estatus) {
    if (tipoUser === '3') {
        var link = document.getElementById('updateBtnS');

        if (link) {
            if (id === '1' || id === '5') { // Pendiente de aprobación || Rechazado
                link.setAttribute('onclick', 'updatePrueba();');
                link.style.pointerEvents = 'auto';
                link.style.cursor = 'pointer';
            } else {
                // Cambia el texto del enlace
                link.innerHTML = '<i class="lar la-lightbulb"></i>Estatus: ' + estatus + '<br>(No es posible actualizar)';
                link.removeAttribute('onclick');
                link.removeAttribute('href');
                link.style.pointerEvents = 'none';
                link.style.cursor = 'default';
            }
        }
    }
}

/*****************************************************************************************
 * *********************FUNCIONES PARA ACTUALIZAR DATOS ADMIN ****************************
 * ***************************************************************************************/

function llenarPrioridadPrueba(prioridad){
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoPrioridadPrueba.php', function (data){
        var selectS = id("prioridadPruebaAdmin");
        selectS.innerHTML = ""; //limpiar contenido

        for (var j = 0; j < data.data.length; j++) {
            var createOption = document.createElement("option");
            createOption.value = data.data[j].id_prioridad;
            createOption.text = data.data[j].descripcionPrioridad;
            selectS.appendChild(createOption);
            if (data.data[j].id_prioridad === prioridad) {
                createOption.selected = true;
            }
        }
    });
}

function llenarEstatusPrueba(estatus){
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoEstatusPrueba.php', function (data){
        var selectS = id("estatusPruebaAdmin");
        selectS.innerHTML = ""; //limpiar contenido

        for (var j = 0; j < data.data.length; j++) {
            var createOption = document.createElement("option");
            createOption.value = data.data[j].id_estatusPrueba;
            createOption.text = data.data[j].descripcionEstatus;
            selectS.appendChild(createOption);
            // Si el valor actual coincide con id_estatusSol, se selecciona por defecto
            if (data.data[j].id_estatusPrueba === estatus) {
                createOption.selected = true;
            }
        }
    });
}

function llenarFechaCompromiso(fechaCompromiso){
    var inputFecha = document.getElementById('iFechaCompromiso');
    inputFecha.value = fechaCompromiso;
    fFechaCompromiso(fechaCompromiso);
}

function consultarMetrologos(metrologo){
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoMetrologos.php', function (data){
        var selectS = id("metrologoAdmin");
        selectS.innerHTML = ""; //limpiar contenido

        for (var j = 0; j < data.data.length; j++) {
            var createOption = document.createElement("option");
            createOption.value = data.data[j].id_usuario;
            createOption.text = data.data[j].nombreUsuario;
            selectS.appendChild(createOption);
            if (data.data[j].id_usuario === metrologo) {
                createOption.selected = true;
            }
        }
    });
}


function validarResultados(id_review, id_user){
    var estatusPruebaAdmin = id("estatusPruebaAdmin");
    var metrologoAdmin = id("metrologoAdmin");
    var fechaCompromiso = id("iFechaCompromiso");
    var observacionesAdmin = id("observacionesAdmin");

    //alert("fechaCompromiso: "+fechaCompromiso.value+"\nestatusPruebaAdmin: "+estatusPruebaAdmin.value )

    if(estatusPruebaAdmin.value !== '1' && metrologoAdmin.value === '00000000'){
        Swal.fire({
            title: "Error",
            text: "Debe asignar un metrologo.",
            icon: "error"
        });
        //return;
    }else if(estatusPruebaAdmin.value === '2' && (fechaCompromiso.value === '' || fechaCompromiso.value === null)){
        Swal.fire({
            title: "Error",
            text: "Debe asignar fecha compromiso.",
            icon: "error"
        });
    }else if(estatusPruebaAdmin.value === '5' && (observacionesAdmin.value === '' || observacionesAdmin.value === 'Sin observaciones')){
        Swal.fire({
            title: "Error",
            text: "Debe asignar observaciones.",
            icon: "error"
        });
    }else{
        updatePruebaAdmin(id_review, id_user, estatusPruebaAdmin,metrologoAdmin,fechaCompromiso, observacionesAdmin);
    }
}

function  updatePruebaAdmin(id_review, id_user, estatusPruebaAdmin,metrologoAdmin, fechaCompromiso, observacionesAdmin){
    var prioridadPruebaAdmin = id("prioridadPruebaAdmin");

    const data = new FormData();

    data.append('id_prueba', id_review);
    data.append('estatusPruebaAdmin', estatusPruebaAdmin.value.trim());
    data.append('prioridadPruebaAdmin', prioridadPruebaAdmin.value.trim());
    data.append('metrologoAdmin', metrologoAdmin.value.trim());
    data.append('observacionesAdmin', observacionesAdmin.value.trim());
    data.append('id_user', id_user);
    data.append('tipoPrueba', tipoPruebaSol);

    if(estatusPruebaAdmin.value==='2'){
        data.append('fechaCompromiso', fechaCompromiso.value.trim());
    }

    let filas;
    if(tipoPruebaSol !== '5'){
        // Arrays para almacenar los valores
        let numPartes = [];
        let estatusPartes = [];

        // Obtener todas las filas del tbody
        filas = document.querySelectorAll("#tbodyPiezas tr");

        // Iterar sobre las filas
        filas.forEach((fila, index) => {
            // Obtener el número de parte
            let numParte = document.querySelector(`#tdNumParteId_${index}`).innerText;

            // Obtener el valor del estatus seleccionado
            let estatusSelect = document.querySelector(`#estatusSelect_${index}`);
            let estatus = estatusSelect.value;

            // Agregar los valores a los arrays
            numPartes.push(numParte);
            estatusPartes.push(estatus);
        });

        // Agregamos los arrays al FormData
        data.append('estatuss', estatusPartes.join(','));
        data.append('piezas', numPartes.join(','));

        // Mostrar los valores de los arreglos estatuss y piezas
        //mostrarValores(numPartes, 'Estatus');
        //mostrarValores(estatusPartes, 'Piezas');
    }else {
        // Arrays para almacenar los valores
        let nominas = [];

        // Obtener todas las filas del tbody
        filas = document.querySelectorAll("#tbodyPersonalAdmin tr");

        filas.forEach((fila, index) => {
            let nomina = document.querySelector(`#tdNomina_${index}`).innerText;
            nominas.push(nomina);
        });
        data.append('nominas', nominas.join(','));
    }

    //Guardar reportes
    filas.forEach((fila, index) => {
        let reportes = [];
        // Obtener el doccumento cargado en el input si es que hay uno
        let inputElement = document.querySelector(`#inputReporte_${index}`);
        let files = inputElement.files;

        let reporte = "Sin resultados";
        if (files.length > 0) {
            reporte = files[0];
        }
        reportes.push(reporte);
        data.append('reportes', reportes.join(','));

        // Imprimir cada elemento de reportes en un alert
       /* reportes.forEach(reporte => {
            alert(reporte === "Sin resultados" ? reporte : reporte.name);
        });*/
    });
    //alert("fechaCompromiso " + fechaCompromiso.value.trim()+"estatusPruebaAdmin: "+estatusPruebaAdmin.value.trim() +", prioridadPruebaAdmin: "+prioridadPruebaAdmin.value.trim()+", metrologoAdmin: "+metrologoAdmin.value.trim()+", observacionesAdmin  "+observacionesAdmin.value.trim());

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: "¿Confirmar cambios?",
        text: "Se actualizará la información de la prueba y se notificará al solicitante.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "¡Sí, confirmar!",
        cancelButtonText: "¡No, cancelar!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoActualizarPruebaAdmin.php',{
                method: 'POST',
                body: data
            }).then(res => {
                consultaTipoPrueba(id_review);
                if(!res.ok){
                    console.log('Problem');
                    return;
                }
                return res.json();
            }).then(data => {
                    console.log('Success');
                    swalWithBootstrapButtons.fire({
                        title: "¡Prueba actualizada!",
                        text: "Se han guardado los cambios.",
                        icon: "success"
                    });
                resumenPrueba(dao);
            }).then(function (){
                correoActualizacionPrueba(estatusPruebaAdmin.value,id_review, solicitantePrueba, emailSolicitante);
            }).then(function (){
                correoActualizacionPruebaLab(id_review);
            }).catch(error =>{
                console.log(error);
            });
        } else if (
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire({
                title: "Cancelado",
                text: "Cambios no guardados.",
                icon: "error"
            });
        }
    });
}

function actualizarTitulo() {
    var titulo5 = document.querySelector("#modalResultadosLabel");
    if (titulo5) {
        titulo5.textContent = "Responder Solicitud " + id_review;
    }
}
function fFechaCompromiso(fechaCompromisoSol){
    const inputFechaCompromiso = document.getElementById('iFechaCompromiso');
    const today = new Date().toISOString().split('T')[0]; // Obtiene la fecha de hoy

    if (fechaCompromisoSol !== '0000-00-00') {
        inputFechaCompromiso.readOnly = true;
    }else {
        inputFechaCompromiso.readOnly = false;
        inputFechaCompromiso.min = today;
    }
}

function fEstatusPiezas(selectElement, estatusSelecionado) {
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoEstatusPiezas.php', function (data) {
        selectElement = id(selectElement);
        selectElement.innerHTML = ""; // Limpiar contenido

        for (var j = 0; j < data.data.length; j++) {
            var createOption = document.createElement("option");
            createOption.value = data.data[j].id_estatus;
            createOption.text = data.data[j].descripcionEstatus;
            selectElement.appendChild(createOption);
            if (data.data[j].id_estatus === estatusSelecionado) {
                createOption.selected = true;
            }
        }
    });
}

function cargarDatosResultados(dao) {

    let tipoPrueba;
    let estatus;
    let fechaCom;
    let prioridad;
    let metrologo;

    mostrarReportes();

    $.getJSON(dao, function (response) {
        let data = response.data[0];

        tipoPrueba = data.id_tipoPrueba;
        estatus = data.id_estatusPrueba;
        fechaCom = data.fechaCompromiso;
        alert("fecha:"+fechaCom);
        prioridad = data.id_prioridad;
        metrologo = data.id_metrologo;
        document.getElementById("observacionesAdmin").value = data.especificacionesLab;

        if(tipoPrueba !== '5' ){

            if (!indicePiezas) {
                // Obtener la referencia al tbody donde se agregarán las filas
                var tbodyPiezas = document.getElementById("tbodyPiezas");

                // Iterar sobre los materiales y crear filas y celdas de tabla
                for (var j = 0; j < response.data.length; j++) {
                    var fila = document.createElement("tr");

                    var numeroDeParteT = document.createElement("td");
                    numeroDeParteT.textContent = response.data[j].numParte;

                    var tdNumParte = 'tdNumParteId_' + j;
                    numeroDeParteT.id = tdNumParte;
                    fila.appendChild(numeroDeParteT);

                    var estatusMaterialT = document.createElement("td");

                    // Crear el elemento select
                    var select = document.createElement("select");
                    select.classList.add("form-control");
                    select.classList.add("form-control-sm");

                    // Generar un id único para el select
                    var selectId = 'estatusSelect_' + j;
                    select.id = selectId;
                    estatusMaterialT.appendChild(select);
                    fila.appendChild(estatusMaterialT);

                    var reporte = document.createElement("td");
                    var inputFile = document.createElement("input");
                    inputFile.type = "file";
                    inputFile.id = 'inputReporte_' + j;
                    inputFile.classList.add("form-control", "form-control-sm", "reporteInput");
                    inputFile.accept = "application/pdf";  // Opcional: solo permitir PDFs
                    reporte.appendChild(inputFile);
                    fila.appendChild(reporte);

                    tbodyPiezas.appendChild(fila);

                    // Llamar a la función estatusPiezas para llenar el select
                    let estatusPiezas = response.data[j].id_estatus;
                    fEstatusPiezas(selectId, estatusPiezas);
                }
                indicePiezas = true;
            }
        }else{
            if (!indicePersonal) {
                // Obtener la referencia al tbody donde se agregarán las filas
                var tbodyPiezas = document.getElementById("tbodyPersonalAdmin");

                for (var j = 0; j < response.data.length; j++) {
                    var fila = document.createElement("tr");

                    var nomina = document.createElement("td");
                    nomina.textContent = response.data[j].nomina;
                    nomina.id = 'tdNomina_'+ j;
                    fila.appendChild(nomina);

                    var nombre = document.createElement("td");
                    nombre.textContent = response.data[j].nombre;
                    fila.appendChild(nombre);

                    var reporte = document.createElement("td");

                    // Crear el input de tipo file con id basado en el número de nómina
                    var inputFile = document.createElement("input");
                    inputFile.type = "file";
                    inputFile.id = 'inputReporte_' + j;
                    inputFile.classList.add("form-control", "form-control-sm", "reporteInput");
                    inputFile.accept = "application/pdf";

                    reporte.appendChild(inputFile);
                    fila.appendChild(reporte);

                    tbodyPiezas.appendChild(fila);
                }
            }
            indicePersonal = true;
        }
    }).then(function (){
        llenarEstatusPrueba(estatus);
        llenarFechaCompromiso(fechaCom);
        llenarPrioridadPrueba(prioridad);
        consultarMetrologos(metrologo);
    });
}

function mostrarReportes(){
    const estatusPrueba = id("estatusPruebaAdmin").value;
    const divTablaPiezas = id("divTablaPiezas");
    const divTablaPersonal = id("divTablaPersonal");
alert("estatusPrueba:"+estatusPrueba +"tipoPruebaSol:"+tipoPruebaSol)
    if(tipoPruebaSol !== '5' && (estatusPrueba==='3' || estatusPrueba==='4')){
        divTablaPiezas.style.display = "block";
    }else if(tipoPruebaSol === '5' && (estatusPrueba==='3' || estatusPrueba==='4')){
        divTablaPersonal.style.display = "block";
    }else{
        divTablaPersonal.style.display = "none";
        divTablaPiezas.style.display = "none";
    }
}

