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

        // SUBTIPO
        let tipoPrueba = data.id_tipoPrueba;

        if(tipoPrueba !== '3') { // DIMENSIONAL
            rowSubtipo();

            $('#subtipoR').text(data.descripcion);

            if (data.id_subtipo === '2') { // Cotas especificas
                id("imagenCotasR").href = data.descripcion;
                $('#textImgR').text("Ver imagen");
            } else if (data.id_subtipo === '1') { //Full layout
                id("imagenCotasR").style.pointerEvents = "none";
                $('#textImgR').text("No aplica");
            }
        } else {
            id("trSubtipo").style.display = "none";
        }

        // NORMA
        if (tipoPrueba !== '1' && tipoPrueba !== '2' && tipoPrueba !== '6') { // ILD/IFD | SOFTNESS | OTRO
            id("trNorma").style.display = "block";
            $('#normaNombreR').text(data.normaNombre);

            var normaArchivo = data.normaArchivo;

            /*if (normaArchivo !== "No aplica" || normaArchivo !== "Ningún archivo seleccionado") {
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
            }*/
        }else {
            id("trNorma").style.display = "none";
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

    // Añadir la fila a la tabla
    var tbody = document.querySelector('#miTabla tbody');
    tbody.appendChild(fila);
}

function updateLinkActualizar(id, estatus) {
    if(tipoUser === '3'){
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