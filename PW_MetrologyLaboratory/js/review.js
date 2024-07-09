let id_estatusSol;
let estatusSol;
let id_prioridadSol;
let id_metrologoSol;
let obs_Solicitud;
let resultadosSol;
let solicitantePrueba;
let emailSolicitante;

function resumenPrueba(ID_PRUEBA){

    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoResumenPrueba.php?id_prueba=' + ID_PRUEBA, function (response) {
        //codigo para actualizar campos
        var data = response.data[0]; // primer objeto dentro de 'data'
        $('#numeroPruebaR').text(data.id_prueba);
        $('#fechaSolicitudR').text(data.fechaSolicitud);
        $('#tipoPruebaSolicitudR').text(data.descripcionPrueba);
        $('#solicitanteR').text(data.nombreSolic);

        let tipoPrueba = data.id_tipoPrueba;

        // SUBTIPO
        if(tipoPrueba === '3') { // DIMENSIONAL
            rowSubtipo();

            $('#subtipoR').text(data.descripcion);

            if (data.id_subtipo === '2') { // Cotas especificas
                id("imagenCotasR").href = data.imagenCotas;
                $('#textImgR').text("Ver imagen");
            } else if (data.id_subtipo === '1') { //Full layout
                id("imagenCotasR").style.pointerEvents = "none";
                $('#textImgR').text(data.imagenCotas);
            }
        }

        // NORMA
        if (tipoPrueba === '1' || tipoPrueba === '2' || tipoPrueba === '6') { // ILD/IFD | SOFTNESS | OTRO
            rowNorma();

            $('#normaNombreR').text(data.normaNombre);
            var normaArchivo = data.normaArchivo;

            if (normaArchivo !== "No aplica" || normaArchivo !== "Ningún archivo seleccionado") {
                // Se agrega texto del enlace
                id("archivoNormaR").href = normaArchivo;
                var nombreArchivo = normaArchivo.substring(normaArchivo.lastIndexOf('/') + 1);
                var numeroReferencia = nombreArchivo.split('-')[1];
                var nombreArchivoSinPDF = nombreArchivo.substring(0, nombreArchivo.lastIndexOf('.')); // Eliminar la extensión .pdf
                id("nombreArchivo").textContent = nombreArchivoSinPDF.substring(numeroReferencia.length + 1);
                id("archivoNormaR").href = normaArchivo;
            } else {
                id("archivoNormaR").textContent = normaArchivo;
                id("archivoNormaR").style.pointerEvents = "none"; // Deshabilitar el clic en el enlace
            }
        }

        $('#observacionesSolR').text(data.especificaciones);
        $('#fechaCompromisoR').text(data.fechaCompromiso);
        $('#metrologoR').text(data.nombreMetro);
        $('#estatusSolicitudR').text(data.descripcionEstatus);
        $('#prioridadR').text(data.descripcionPrioridad);
        $('#fechaRespuestaR').text(data.fechaRespuesta);
        $('#observacionesLabR').text(data.especificacionesLab);

        //Resultados es una ruta o un enlace:
        let enlaceResultados = document.getElementById('rutaResultadosR');
        var resultadosPrueba = data.resultados;
        let esUrl = esURL(resultadosPrueba);
        if (esUrl) {
            enlaceResultados.href = resultadosPrueba;
        } else {
            enlaceResultados.removeAttribute('href');  // Remueve el href para que no sea un enlace
            enlaceResultados.style.pointerEvents = "none";
            enlaceResultados.textContent = resultadosPrueba;
        }

        id_estatusSol = data.id_estatusPrueba;
        estatusSol = data.descripcionEstatus;
        id_prioridadSol = data.id_prioridad;
        id_metrologoSol = data.id_metrologo;
        obs_Solicitud = data.especificacionesLab;
        resultadosSol = data.resultados;
        solicitantePrueba = data.nombreSolic;
        emailSolicitante = data.correoSolic;

        //console.log("resumenPrueba: id_estatusSol"+id_estatusSol, "estatusSol "+estatusSol);

        var tabla = document.getElementById("materialesResumen");
        var tbody = tabla.getElementsByTagName("tbody")[0];

        // Limpiar contenido previo de la tabla
        tbody.innerHTML = '';

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

            tbody.appendChild(fila);
        }
    }).then(function (){
        updateLinkActualizar(id_estatusSol,estatusSol);
    });
}

function rowSubtipo(){
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
}

function rowNorma() {
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
 * *******************FUNCIONES que falta validar************************
 * ***************************************************************************************/
function actualizarTitulo() {
    var titulo5 = document.querySelector("#modalResultados h5");
    if (titulo5) {
        titulo5.textContent = "Responder Solicitud " + id_review;
    }
}



function llenarResultados(){
    const inputResultadosGuardados = document.getElementById('resultadosGuardados');
    const btnResultados = document.getElementById('btnCambiarResultados');
    const divResultados = document.getElementById('divCambiarResultados');
    let enlaceResultados = document.getElementById('resultadosGuardados');

    if (resultadosSol === null || resultadosSol === '') {
        inputResultadosGuardados.style.display = 'none';
        btnResultados.style.display = 'none';
    }else {
        let esUrl = esURL(resultadosSol);
        if (esUrl) {
            enlaceResultados.href = resultadosSol;
            enlaceResultados.textContent = `${resultadosSol}`;
        } else {
            enlaceResultados.removeAttribute('href');  // Remueve el href para que no sea un enlace
            enlaceResultados.textContent = `${resultadosSol}`;
        }
        divResultados.style.display = 'none';
    }
}

function esURL(cadena) {
    let urlRegex = /^(ftp|http|https):\/\/[^ "]+$/;  // Expresión regular para verificar si resultadosSol es una URL
    let esUrl;
    esUrl = urlRegex.test(cadena);
    return esUrl;
}

function checkedInput() {
    const rutaRadio = document.getElementById('rutaRadio');
    const archivoRadio = document.getElementById('archivoRadio');
    const divResultados = document.getElementById('divCambiarResultados');
    let esUrl = esURL(resultadosSol);

    divResultados.style.display = 'block';

    if (esUrl) { // Es una url
        archivoRadio.checked = true;
    } else { // Es una ruta local
        rutaRadio.checked = true;
    }
}

function cambiarResultado(){
    const divResultados = document.getElementById('divResultados');
    const selectEstatus = document.getElementById('estatusPruebaAdmin');

    if (selectEstatus.value === '4') {
        divResultados.style.display = 'block';
        selectInputResultado();
    } else {
        divResultados.style.display = 'none';
    }
}

function selectInputResultado() {
    const rutaRadio = document.getElementById('rutaRadio');
    const archivoRadio = document.getElementById('archivoRadio');
    const resultadosAdminRuta = document.getElementById('resultadosAdminRuta');
    const resultadosAdminArchivo = document.getElementById('resultadosAdminArchivo');

    if (rutaRadio.checked) {
        resultadosAdminRuta.style.display = 'block';
        resultadosAdminArchivo.style.display = 'none';
    } else if (archivoRadio.checked) {
        resultadosAdminRuta.style.display = 'none';
        resultadosAdminArchivo.style.display = 'block';
    }
}

function fechaCompromiso(){
    const selectEstatus = document.getElementById('estatusPruebaAdmin');
    const divFechaCompromiso = document.getElementById('divFechaCompromiso');
    const inputFechaCompromiso = document.getElementById('iFechaCompromiso');
    //fecha de hoy en formato YYYY-MM-DD
    var hoy = new Date().toISOString().split('T')[0];

    if (selectEstatus.value === '2') { //Estatus aprobado
        divFechaCompromiso.style.display = 'block';
        inputFechaCompromiso.setAttribute('min', hoy);
    } else if (selectEstatus.value === '1' || selectEstatus.value === '3' || selectEstatus.value === '4' || selectEstatus.value === '5' || selectEstatus.value === '6'){
        divFechaCompromiso.style.display = 'none';
    }

}
