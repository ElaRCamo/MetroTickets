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
        $('#fechaRespuestaR').text(data.fechaRespuesta);
        $('#fechaCompromisoR').text(data.fechaCompromiso);
        $('#fechaUpdateR').text(data.fechaActualizacion);
        $('#solicitanteR').text(data.nombreSolic);
        $('#metrologoR').text(data.nombreMetro);
        $('#observacionesSolR').text(data.especificaciones);
        $('#estatusSolicitudR').text(data.descripcionEstatus);
        $('#prioridadR').text(data.descripcionPrioridad);
        $('#normaNombreR').text(data.normaNombre);

        if(data.id_tipoPrueba !== '5'){
            $('#tipoPruebaSolicitudR').text(data.descripcionPrueba);
        } else if(data.id_tipoPrueba === '5' && data.id_pruebaEspecial === '4'){
            $('#tipoPruebaSolicitudR').text( data.descripcionPrueba + ": "+ data.otroTipoEspecial);
        }else if(data.id_tipoPrueba === '5'){
            $('#tipoPruebaSolicitudR').text(data.descripcionPrueba + ": "+ data.descripcionEspecial);
        }

        var urlCompleta = data.normaArchivo;

        if (urlCompleta !== "No aplica") {
            // Se agrega texto del enlace
            id("archivoNormaR").href = urlCompleta;
            var nombreArchivo = urlCompleta.substring(urlCompleta.lastIndexOf('/') + 1);
            var numeroReferencia = nombreArchivo.split('-')[1];
            var nombreArchivoSinPDF = nombreArchivo.substring(0, nombreArchivo.lastIndexOf('.')); // Eliminar la extensión .pdf
            id("nombreArchivo").textContent = nombreArchivoSinPDF.substring(numeroReferencia.length + 1);
            id("archivoNormaR").href = urlCompleta;
        }else {
            id("archivoNormaR").textContent = "No aplica";
            id("archivoNormaR").style.pointerEvents = "none"; // Deshabilitar el clic en el enlace
        }

        $('#observacionesLabR').text(data.especificacionesLab);

        //Resultados es una ruta o un enlace:
        let enlaceResultados = document.getElementById('rutaResultadosR');
        var resultadosPrueba = data.rutaResultados;
        let esUrl = esURL(resultadosPrueba);
        if (esUrl) {
            enlaceResultados.href = resultadosPrueba;
        } else {
            enlaceResultados.removeAttribute('href');  // Remueve el href para que no sea un enlace
            enlaceResultados.textContent = resultadosPrueba;
        }

        id_estatusSol = data.id_estatusPrueba;
        estatusSol = data.descripcionEstatus;
        id_prioridadSol = data.id_prioridad;
        id_metrologoSol = data.id_metrologo;
        obs_Solicitud = data.especificacionesLab;
        resultadosSol = data.rutaResultados;
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
            numeroDeParteT.textContent = response.data[j].numeroDeParte;
            fila.appendChild(numeroDeParteT);

            var descMaterialesT = document.createElement("td");
            descMaterialesT.textContent = response.data[j].descripcionMaterial;
            fila.appendChild(descMaterialesT);

            var cdadMaterialesT = document.createElement("td");
            cdadMaterialesT.textContent = response.data[j].cantidad;
            fila.appendChild(cdadMaterialesT);

            var clienteMaterialesT = document.createElement("td");
            clienteMaterialesT.textContent = response.data[j].descripcionCliente;
            fila.appendChild(clienteMaterialesT);

            var plataformaMaterialesT = document.createElement("td");
            plataformaMaterialesT.textContent = response.data[j].descripcionPlataforma;
            fila.appendChild(plataformaMaterialesT);

            var estatusMaterialT = document.createElement("td");
            estatusMaterialT.textContent = response.data[j].estatusMaterial;
            fila.appendChild(estatusMaterialT);

            tbody.appendChild(fila);
        }
    }).then(function (){
        updateLinkActualizar(id_estatusSol,estatusSol);
    });
}
