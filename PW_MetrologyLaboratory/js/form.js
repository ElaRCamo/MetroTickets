/*****************************************************************************************
 * *********************FUNCIONES DE ESTILOS PARA EL FORMULARIO***************************
 * ***************************************************************************************/
const mostrarBloque = (elemento, mostrar) => {
    elemento.style.display = mostrar ? "block" : "none";
};
function banderaTipoPrueba() {

    const selTipoPrueba = id("tipoPrueba");
    const divSubtipoPrueba = id("divSubtipoPrueba");
    const divNormaNombre = id("normaNombre");
    const divNormaArchivo = id("normaArchivo");
    const divDetallesPrueba = id("detallesPrueba");
    const divTitlePiezas = id("agregarNumParte");
    const divRegistroPiezas = id("newRow1");
    const botonEnviar = id("submitRequest");
    const divCotas = id("divCotas");
    const divImgCotas = id("divImgCotas");
    const divTitlePersonal = id("addPersonalTitle");
    const divAddPersonal = id("newPerRow1");

    let tipoPrueba = selTipoPrueba.value;

    if(tipoPrueba === '1' || tipoPrueba === '2' || tipoPrueba === '6') { // IDL/IFD | SOFTNESS | OTRO
        mostrarBloque(divNormaNombre, true);
        mostrarBloque(divNormaArchivo, true);
        mostrarBloque(divDetallesPrueba, true);
        mostrarBloque(divTitlePiezas, true);
        mostrarBloque(divRegistroPiezas, true);
        mostrarBloque(botonEnviar, true);
        mostrarBloque(divSubtipoPrueba, false);
        mostrarBloque(divCotas, false);
        mostrarBloque(divImgCotas, false);
        mostrarBloque(divTitlePersonal, false);
        mostrarBloque(divAddPersonal, false);

    } else if (tipoPrueba === '3') { // DIMENSIONAL
        mostrarBloque(divSubtipoPrueba, true);
        mostrarBloque(divDetallesPrueba, true);
        mostrarBloque(divTitlePiezas, true);
        mostrarBloque(divRegistroPiezas, true);
        mostrarBloque(botonEnviar, true);
        llenarSubtipoPrueba();
        mostrarBloque(divNormaNombre, false);
        mostrarBloque(divNormaArchivo, false);
        mostrarBloque(divTitlePersonal, false);
        mostrarBloque(divAddPersonal, false);

    } else if(tipoPrueba === '4'){ // COLOR
        mostrarBloque(divDetallesPrueba, true);
        mostrarBloque(divTitlePiezas, true);
        mostrarBloque(divRegistroPiezas, true);
        mostrarBloque(botonEnviar, true);
        mostrarBloque(divNormaNombre, false);
        mostrarBloque(divNormaArchivo, false);
        mostrarBloque(divSubtipoPrueba, false);
        mostrarBloque(divCotas, false);
        mostrarBloque(divImgCotas, false);
        mostrarBloque(divTitlePersonal, false);
        mostrarBloque(divAddPersonal, false);
    }else if(tipoPrueba === '5') { //MUNSELL
        mostrarBloque(divTitlePiezas, false);
        mostrarBloque(divRegistroPiezas, false);
        mostrarBloque(divNormaNombre, false);
        mostrarBloque(divNormaArchivo, false);
        mostrarBloque(divSubtipoPrueba, false);
        mostrarBloque(divCotas, false);
        mostrarBloque(divImgCotas, false);
        mostrarBloque(divDetallesPrueba, true);
        mostrarBloque(divTitlePersonal, true);
        mostrarBloque(divAddPersonal, true);
        mostrarBloque(botonEnviar, true);
    }

    if (esActualizacion === true){
        mostrarBloque(botonEnviar, false);
    }
}

function fsubtipoPrueba(){
    const divCotas = id("divCotas");
    let subtipo= id("subtipoPrueba").value;

    if(subtipo === '2'){ //Dimensional-cotas especificas
        mostrarBloque(divCotas, true);
    }else{
        mostrarBloque(divCotas, false);
    }
}

function previewImageCotas(event) {
    const divImagenCotas = id("divImgCotas");
    let subtipo = id("subtipoPrueba").value;
    if(subtipo === '2'){ //Dimensional-cotas especificas
        mostrarBloque(divImagenCotas, true);
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('capturaCotas');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }else{
        mostrarBloque(divImagenCotas, false);
    }
}
function initTooltips() {
    var tooltipsMod = document.querySelectorAll("[id^='tooltipModelo']");
    var imgModMate = 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/varios/modeloMatematico.png';

    tooltipsMod.forEach(function(tooltip) {
        mostrarImagenTooltip(tooltip, imgModMate, 300,180);
    });

    var tooltipsDibujo = document.querySelectorAll("[id^='tooltipDibujo']");
    var imgRevDib = 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/varios/revDibujo.png';
    tooltipsDibujo.forEach(function(tooltip) {
        mostrarImagenTooltip(tooltip, imgRevDib,250,120);
    });
}

function mostrarImagenTooltip(tooltip, imageUrl, width, height) {
    tippy(tooltip, {
        trigger: 'click',
        animation: 'shift-away',
        theme: 'light',
        onShow(instance) {
            fetch(imageUrl)
                .then((response) => response.blob())
                .then((blob) => {
                    // Convert the blob into a URL
                    const url = URL.createObjectURL(blob);
                    const image = new Image();
                    image.width = width;
                    image.height = height;
                    image.style.display = 'block';
                    image.style.margin = '0 auto'; // Center the image
                    image.src = url;

                    const container = document.createElement('div');
                    container.style.textAlign = 'start'; // Center align text
                    container.style.fontSize = '0.7rem'; // Smaller font size
                    container.appendChild(image);

                    // Update the tippy content with the container
                    instance.setContent(container);
                })
                .catch((error) => {
                    // Fallback if the network request failed
                    instance.setContent(`Request failed. ${error}`);
                });
        },
        arrow: true, // Enable arrow
    });
}


function agregarPieza() {
    indexMaterial++;

    const newRow = $("<div id=\"newRow" + indexMaterial + '" class="row row-cols-xl-3 clearfix">'
        + '<div class="col-xl-12">'
        + '<div class="row">'
        + '<div class="col-sm-4">'
        + '<div class="" id="div-OEM' + indexMaterial + '">'
        + '<label for="cliente'+ indexMaterial + '">Cliente*</label>'
        + '<div class="form-group" >'
        + '<select id="cliente' + indexMaterial + '" name="cliente'+ indexMaterial + '" class="form-control" onclick="" onchange="llenarPlataforma(' + indexMaterial + ')" required data-error="Por favor ingresa el area solicitante">'
        + '<option value="">Seleccione el cliente</option>'
        + '</select>'
        + '<div class="input-group-icon"><i class="las la-car"></i></div>'
        + '<div class="invalid-feedback"></div>'
        + '</div>'
        + '</div>'
        + '</div>'
        + '<div class="col-sm-4">'
        + '<div class="" id="plataformaDiv' + indexMaterial + '">'
        + '<label for="plataforma'+ indexMaterial + '">Plataforma*</label>'
        + '<div class="form-group" >'
        + '<select id="plataforma' + indexMaterial + '" name="plataformas'+ indexMaterial + '" class="form-control" required data-error="Por favor ingresa la plataforma">'
        + '<option value="">Seleccione la plataforma*</option>'
        + '</select>'
        + '<div class="input-group-icon"><i class="las la-warehouse"></i></div>'
        + '<div class="invalid-feedback"></div>'
        + '</div>'
        + '</div>'
        + '</div>'
        + '<div class="col-sm-4">'
        + '<div class="" id="divNumeroParte'+ indexMaterial + '">'
        + '<label for="numeroParte'+ indexMaterial + '">Número de parte*</label>'
        + '<div class="form-group">'
        + '<input id="numeroParte'+ indexMaterial + '" name="numeroParte'+ indexMaterial + '" type="text" class="form-control" placeholder="Número de Parte*" required data-error="Por favor ingresa el número de parte">'
        + '<div class="input-group-icon"><i class="las la-cubes"></i></div>'
        + '<div class="invalid-feedback"></div>'
        + '</div>'
        + '</div>'
        + '</div>'
        + '<div class="col-sm-4">'
        + '<div class="" id="cantidadMaterial'+ indexMaterial + '">'
        + '<label for="cdadMaterial'+ indexMaterial + '">Cantidad*</label>'
        + '<div class="form-group">'
        + '<input id="cdadMaterial'+ indexMaterial + '" name="cdadMaterial'+ indexMaterial + '" type="number" class="form-control" placeholder="Cantidad*" required data-error="Por favor ingresa la cantidad">'
        + '<div class="input-group-icon"><i class="las la-cubes"></i></div>'
        + '<div class="invalid-feedback"></div>'
        + '</div>'
        + '</div>'
        + '</div>'
        + '<div class="col-sm-4">'
        + '<div class="" id="divDibujo'+ indexMaterial + '">'
        + '<label for="revDibujo'+ indexMaterial + '">Revisión de dibujo*</label>'
        + '<div class="form-group">'
        + '<input id="revDibujo'+ indexMaterial + '" name="revDibujo'+ indexMaterial + '" type="text" maxlength="3" class="form-control" placeholder="Revisión de dibujo*" required data-error="Por favor ingresa la revisión de dibujo">'
        + '<i class="far fa-question-circle position-absolute" id="tooltipDibujo'+ indexMaterial + '"></i>'
        + '<div class="input-group-icon"><i class="las la-cubes"></i></div>'
        + '<div class="invalid-feedback"></div>'
        + '</div>'
        + '</div>'
        + '</div>'
        + '<div class="col-sm-4">'
        + '<div class="" id="divModMate'+ indexMaterial + '">'
        + '<label for="modeloMate'+ indexMaterial + '">Mod. matemático*</label>'
        + '<div class="form-group">'
        + '<input id="modeloMate'+ indexMaterial + '" name="modeloMate'+ indexMaterial + '" type="text" maxlength="3" class="form-control" placeholder="Mod. Matemático*" required data-error="Por favor ingresa el modelo matemático">'
        + '<i class="far fa-question-circle position-absolute" id="tooltipModelo'+ indexMaterial + '"></i>'
        + '<div class="input-group-icon"><i class="las la-cubes"></i></div>'
        + '<div class="invalid-feedback"></div>'
        + '</div>'
        + '</div>'
        + '</div>'
        + '</div>'
        + '</div>'
        + '<div class="col-xl-4">'
        + '</div>'
        + '<div class="col-xl-4">'
        + '</div>'
        + '<div class="col-xl-4 buttons-container" id="divButtons' + indexMaterial + '">'
        + '<a href="#" class="remove-lnk-num-parte removeBtn" id="' + indexMaterial + '" ><i class="las la-trash-alt"></i></a>'
        + '<a href="#" class="agregarButton" onclick="fAddPersonal(); return false;" id="addNumParte' + indexMaterial + '"><i class="las la-plus-square"></i></a>'
        + '</div>'
        + '</div>');
    newRow.appendTo('#contenedorFormulario');
}

function agregarPersonal() {
    indexPersonal++;

    const newPerRow = $('<div id=\"newPerRow' + indexPersonal + '" class="row row-cols-xl-3 clearfix">'
        + '<div class="col-xl-12">'
        + '<div class="row">'
        + '<div class="col-sm-4">'
        + '<div class="" id="divNumNomina' + indexPersonal + '">'
        + '<label for="numNomina' + indexPersonal + '">Número de nómina*</label>'
        + '<div class="form-group">'
        + '<input id="numNomina' + indexPersonal + '" name="numNomina' + indexPersonal + '" type="text" class="form-control" placeholder="Número de nómina*" required data-error="Por favor ingresa el número de nómina">'
        + '<div class="input-group-icon"><i class="las la-cubes"></i></div>'
        + '<div class="invalid-feedback"></div>'
        + '</div>'
        + '</div>'
        + '</div>'
        + '<div class="col-sm-4">'
        + '<div class="" id="divNombrePersonal' + indexPersonal + '">'
        + '<label for="nombrePersonal' + indexPersonal + '">Nombre de inspector/operador*</label>'
        + '<div class="form-group">'
        + '<input id="nombrePersonal' + indexPersonal + '" name="nombrePersonal' + indexPersonal + '" type="text" class="form-control" placeholder="Nombre de inspector/operador*" required data-error="Por favor ingresa el nombre del inspector/operador">'
        + '<div class="input-group-icon"><i class="las la-cubes"></i></div>'
        + '<div class="invalid-feedback"></div>'
        + '</div>'
        + '</div>'
        + '</div>'
        + '<div class="col-sm-4">'
        + '<div class="" id="divArea' + indexPersonal + '">'
        + '<label for="area' + indexPersonal + '">Área/linea de producción*</label>'
        + '<div class="form-group">'
        + '<input id="area' + indexPersonal + '" name="area' + indexPersonal + '" type="text" class="form-control" placeholder="Área/linea de produccion*" required data-error="Por favor ingresa el área/linea de producción">'
        + '<div class="input-group-icon"><i class="las la-cubes"></i></div>'
        + '<div class="invalid-feedback"></div>'
        + '</div>'
        + '</div>'
        + '</div>'
        + '</div>'
        + '</div>'
        + '<div class="col-xl-4">'
        + '</div>'
        + '<div class="col-xl-4">'
        + '</div>'
        + '<div class="col-xl-4 buttons-container" id="divButtons' + indexPersonal + '">'
        + '<a href="#" class="remove-lnk-personal removeBtn" id="' + indexPersonal + '"><i class="las la-trash-alt"></i></a>'
        + '<a href="#" class="agregarButton" onclick="fAddPersonal(event)" id="addPersonal' + indexPersonal + '"><i class="las la-plus-square"></i></a>'
        + '</div>'
        + '</div>');
    newPerRow.appendTo('#contenedorFormulario');
}

/*****************************************************************************************
 * *********************FUNCIONES PARA CARGAR DATOS A LOS INPUTS**************************
 * ***************************************************************************************/
function llenarTipoPrueba() {
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoTipoPrueba.php', function (data) {
        var selectS = id("tipoPrueba");
        selectS.innerHTML = ""; //limpiar contenido

        var createOptionDef = document.createElement("option");
        createOptionDef.text = "Seleccione el tipo de prueba*";
        createOptionDef.value = "";
        selectS.appendChild(createOptionDef);

        for (var i = 0; i < data.data.length; i++) {
            var createOptionS = document.createElement("option");
            createOptionS.value = data.data[i].id_tipoPrueba;
            createOptionS.text = data.data[i].descripcionPrueba;
            selectS.appendChild(createOptionS);
        }
    });
}

function llenarSubtipoPrueba() {
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoSubtipoPrueba.php?id_tipoPrueba=' + id("tipoPrueba").value, function (data) {
        var selectS = id("subtipoPrueba");
        selectS.innerHTML = ""; //limpiar contenido

        var createOptionDef = document.createElement("option");
        createOptionDef.text = "Seleccione el subtipo de prueba*";
        createOptionDef.value = "";
        selectS.appendChild(createOptionDef);

        for (var i = 0; i < data.data.length; i++) {
            var createOptionS = document.createElement("option");
            createOptionS.value = data.data[i].id_subtipo;
            createOptionS.text = data.data[i].descripcion;
            selectS.appendChild(createOptionS);
        }
    });
}


let dataClientes;
function llenarCliente(i){
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoCliente.php', function (data){
        var selectS = id("cliente" + i);
        selectS.innerHTML = ""; //limpiar contenido

        var createOptionDef = document.createElement("option");
        createOptionDef.text = "Especifique el cliente(OEM)*";
        createOptionDef.value = "";
        selectS.appendChild(createOptionDef);

        for (var j = 0; j < data.data.length; j++) {
            var createOption = document.createElement("option");
            createOption.value = data.data[j].id_cliente;
            createOption.text = data.data[j].descripcionCliente;
            selectS.appendChild(createOption);
        }
        dataClientes = data;
    });
}


function llenarPlataforma(i) {
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoPlataforma.php?id_cliente=' + id("cliente" + i).value, function (data) {
        var selectS = id("plataforma"+ i);
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

/*****************************************************************************************
 * *********************FUNCIONES PARA VALIDAR UNA NUEVA SOLICITUD************************
 * ***************************************************************************************/

function validarFormNewRequest() {
    let tipoPrueba = id("tipoPrueba").value;
    const esTipoPruebaValido = validarSelect('tipoPrueba');
    const esObservacionesValido = validarInput('especificaciones');

    if(tipoPrueba === '5'){
        let idsPersonal = obtenerRowIds("newPerRow");
        let personal = validarPersonal(idsPersonal);
        let sonDatosValidosPersonal = (
            personal.esNominaValido && personal.esNombreValida && personal.esAreaValida
        );

        if(esTipoPruebaValido && esObservacionesValido && sonDatosValidosPersonal){
            initGuardarDatos();
        }
    }else if(tipoPrueba !== '' && tipoPrueba !== null){
        const esSubtipoValido = validarSelect('subtipoPrueba');
        const esInputImgValido = validarInput('imgCotas');
        const esNormaValido = validarInput('norma');
        //const esArchivoValido = validarInput('normaFile');//No es obligatorio
        let idsPiezas = obtenerRowIds("newRow");
        let piezas = validarPiezas(idsPiezas);
        let sonTodasPiezasValidas = (
            piezas.esClienteValido && piezas.esPlataformaValida && piezas.esNumParteValido &&
            piezas.esCdadValida && piezas.esrevDibujoValido && piezas.esmodeloMateValido
        );
        let sonPiezasValidasColor = (
            piezas.esClienteValido && piezas.esPlataformaValida && piezas.esNumParteValido && piezas.esCdadValida
        );
        let subtipo= id("subtipoPrueba").value;

        //Validacion dependiendo el tipo de prueba
        if(tipoPrueba === '1' || tipoPrueba === '2' || tipoPrueba === '6') { // IDL/IFD | SOFTNESS | OTRO
            if(esTipoPruebaValido && esNormaValido && esObservacionesValido && sonTodasPiezasValidas){
                initGuardarDatos();
            }
        } else if (tipoPrueba === '3') { // DIMENSIONAL
            if(subtipo === '2'){ //Dimensional-cotas especificas
                if(esTipoPruebaValido && esSubtipoValido && esInputImgValido && sonTodasPiezasValidas){
                    initGuardarDatos();
                }
            }else{
                if(esTipoPruebaValido && esObservacionesValido && sonTodasPiezasValidas){
                    initGuardarDatos();
                }
            }
        } else if(tipoPrueba === '4'){ // COLOR
            if(esTipoPruebaValido && esObservacionesValido && sonPiezasValidasColor){
                initGuardarDatos();
            }
        }
    } else {
        console.log("Hay campos sin completar.");
    }
}

function obtenerRowIds(row){
    // Selecciona todos los divs cuyo id empieza con row
    var divs = document.querySelectorAll('div[id^="'+row+'"]');
    var numeros = [];

    // Recorre los divs seleccionados
    divs.forEach(function(div) {
        // Obtiene el id del div
        var id = div.id;
        // Extrae el número
        var numero = id.replace(row, '');

        // Agrega el número al array
        numeros.push(numero);
    });
    return numeros;
}

function validarPiezas(idsPiezas) {
    let esClienteValido = true;
    let esPlataformaValida = true;
    let esNumParteValido = true;
    let esCdadValida = true;
    let esrevDibujoValido = true;
    let esmodeloMateValido = true;

    idsPiezas.forEach(function (id){
        esClienteValido = esClienteValido && validarSelect('cliente' + id);
        esPlataformaValida = esPlataformaValida && validarSelect('plataforma' + id);
        esNumParteValido = esNumParteValido && validarInput('numeroParte' + id);
        esCdadValida = esCdadValida && validarInput('cdadMaterial' + id);
        esrevDibujoValido = esrevDibujoValido && validarInput('revDibujo' + id);
        esmodeloMateValido = esmodeloMateValido && validarInput('modeloMate' + id);
    });

    // Devuelve un objeto con el resultado final de cada validación
    return {
        esClienteValido: esClienteValido,
        esPlataformaValida: esPlataformaValida,
        esNumParteValido: esNumParteValido,
        esCdadValida: esCdadValida,
        esrevDibujoValido: esrevDibujoValido,
        esmodeloMateValido: esmodeloMateValido
    };
}


function validarPersonal(idsPersonal) {
    let esNominaValido = true;
    let esNombreValida = true;
    let esAreaValida = true;

    idsPersonal.forEach(function (idRow) {
        esNominaValido = esNominaValido && validarInput('numNomina' + idRow);
        esNombreValida = esNombreValida && validarInput('nombrePersonal' + idRow);
        esAreaValida = esAreaValida && validarInput('area' + idRow);
    });

    // Devuelve un objeto con el resultado final de cada validación
    return {
        esNominaValido: esNominaValido,
        esNombreValida: esNombreValida,
        esAreaValida: esAreaValida
    };
}

/*****************************************************************************************
 * ******************FUNCIONES PARA GUARDAR/ACTUALIZAR UNA SOLICITUD**********************
 * ***************************************************************************************/

function initGuardarDatos(){
    if(esActualizacion){
        let daoUpdate = '../../dao/daoActualizacionRequest.php';
        actualizarSolicitud(id_update, daoUpdate, true);
    }else{
        validacionSolicitud();
    }
}

function validacionSolicitud() {
    const id_pruebaPromise      = obtenerNuevoId(); // Obtener el nuevo ID de forma asíncrona
    const sesionIniciadaPromise = validarSesion(); // Validar la sesión de forma asíncrona

    Promise.all([id_pruebaPromise, sesionIniciadaPromise])
        .then(respuestas => {
            const id_prueba      = respuestas[0];
            const sesionIniciada = respuestas[1];

            if (sesionIniciada && id_prueba !== null && id_prueba !== undefined) {
                //alert("Se ejecuta registrarSolicitud "+id_prueba)
                let daoRegistro = '../../dao/requestRegister.php';
                actualizarSolicitud(id_prueba, daoRegistro,false);

                //registrarSolicitud(id_prueba);
            } else if(sesionIniciada === false) {
                // Si la sesión no está iniciada, mostrar un mensaje de error
                Swal.fire("¡La sesión no está iniciada!");
            }
        })
        .catch(error => {
            Swal.fire("¡Error al validar la solicitud!");
        });
}

function obtenerNuevoId() {
    return idPrueba().then(function(nuevoId) {
        //console.log("obtenerNuevoId-Nuevo ID:", nuevoId);
        return nuevoId;
    }).catch(function(error) {
        console.error("Error al obtener el nuevo ID:", error);
    });
}
function idPrueba() {
    return new Promise(function(resolve, reject) {
        $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoIdSolicitud.php', function(data) {
            var fecha = new Date();
            var anio = fecha.getFullYear();
            var nuevoId;
            let idMaximo = data.data[0].max_id_prueba;

            if (idMaximo == null) {
                nuevoId = anio + "-0001";
            }else{
                var idMaxPartes = idMaximo.split("-");
                var anioIdMax = parseInt(idMaxPartes[0]); // Convertir a número
                var consecutivoId = idMaxPartes[1];

                if (anioIdMax === anio) {
                    nuevoId = anioIdMax + "-" + (parseInt(consecutivoId) + 1).toString().padStart(4, '0');
                } else {//cambio de año
                    nuevoId = anio + "-0001"; // Asumiendo que el consecutivo inicia en 1
                }
            }
            resolve(nuevoId); // Resolver la promesa con el nuevo ID
        });
    });
}

function validarSesion() {
    return obtenerSesion().then(function(sesionIniciada) {
        //console.log("Obterner estatus de la sesión: ", sesionIniciada);
        return sesionIniciada;
    }).catch(function(error) {
        console.error("Error al validar la sesión", error);
    });
}

function obtenerSesion() {
    return new Promise(function(resolve, reject) {
        $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoSesionIniciada.php', function(data) {
            let sesionIniciada = data.sesionIniciada;
            resolve(sesionIniciada); // Resolver la promesa con el nuevo ID
        });
    });
}

function actualizarSolicitud(id_prueba, dao, esActualizacion){
    const dataForm = new FormData();

    var idNomina           = id("idUsuario");
    var tipoPrueba         = id("tipoPrueba");
    var especificaciones   = id ("especificaciones");
    var fechaSolicitud    = new Date();
    var fechaFormateada  = fechaSolicitud.getFullYear() + '-' + (fechaSolicitud.getMonth() + 1) + '-' + fechaSolicitud.getDate();

    dataForm.append('id_prueba', id_prueba);
    dataForm.append('actualizacion', esActualizacion);
    dataForm.append('fechaSolicitud', fechaFormateada);
    dataForm.append('tipoPrueba', tipoPrueba.value.trim());
    dataForm.append('idUsuario', idNomina.value.trim());
    dataForm.append('especificaciones', especificaciones.value.trim());

    if (tipoPrueba.value === '1' || tipoPrueba.value === '2' || tipoPrueba.value === '6') { // IDL/IFD | SOFTNESS | OTRO
        let norma = id("norma");
        dataForm.append('norma', norma.value.trim());

        let inputArchivo = id('normaFile');
        // Verificar si hay archivos seleccionados
        if (inputArchivo.files.length > 0) { // Hay archivos cargados
            dataForm.append('normaFile', inputArchivo.files[0]);

        } else { // No hay archivos cargados
            inputArchivo = "Ningún archivo seleccionado"
            dataForm.append('normaFile', inputArchivo);
        }
    } else if (tipoPrueba.value === '3') { // DIMENSIONAL
        let subtipo = id("subtipoPrueba");
        if (subtipo.value === '2') { //Dimensional-cotas especificas
            let imagenCotas = id("imgCotas");
            dataForm.append('imagenCotas', imagenCotas.files[0]);
        }
        dataForm.append('subtipoPrueba', subtipo.value.trim());
    }

    if(tipoPrueba.value === '5') { //MUNSELL
        let idsRowPer = obtenerRowIds("newPerRow");
        let nominas = [];
        let nombres = [];
        let areas = [];

        idsRowPer.forEach (function(idRow) {
            // Para agregar material por número de parte
            var nomina = id('numNomina' + idRow);
            var nombre = id('nombrePersonal' + idRow);
            var area = id('area' + idRow);


            // Añadimos los valores a los arrays correspondientes
            nominas.push(nomina.value.trim());
            nombres.push(nombre.value.trim());
            areas.push(area.value.trim());

        });

        if(!validarNoRepetidos(nominas)){
            Swal.fire({
                title: "Error",
                text: "Números de parte duplicados",
                icon: "error",
                confirmButtonText: "OK"
            });
        }

        // Agregamos los arrays al FormData
        dataForm.append('nominas', nominas.join(', '));
        dataForm.append('nombres', nombres.join(', '));
        dataForm.append('areas', areas.join(', '));

    }else{ //Cualquier otro tipo de prueba
        let idsRow = obtenerRowIds("newRow");
        let plataformas = [];
        let numsParte = [];
        let cantidades = [];
        let revDibujos = [];
        let modMatematicos = [];

        idsRow.forEach (function(idRow) {
            // Para agregar material por número de parte
            var plataforma = id('plataforma' + idRow);
            var numeroParte = id('numeroParte' + idRow);
            var cdadMaterial = id('cdadMaterial' + idRow);
            var revDibujo = id('revDibujo' + idRow);
            var modeloMate = id('modeloMate' + idRow);

            // Añadimos los valores a los arrays correspondientes
            plataformas.push(plataforma.value.trim());
            numsParte.push(numeroParte.value.trim());
            cantidades.push(cdadMaterial.value.trim());
            revDibujos.push(revDibujo.value.trim());
            modMatematicos.push(modeloMate.value.trim());
        });

        if(!validarNoRepetidos(numsParte)){
            Swal.fire({
                title: "Error",
                text: "Números de parte duplicados",
                icon: "error",
                confirmButtonText: "OK"
            });
        }

            // Agregamos los arrays al FormData
            dataForm.append('plataformas', plataformas.join(', '));
            dataForm.append('numsParte', numsParte.join(', '));
            dataForm.append('cantidades', cantidades.join(', '));
            dataForm.append('revDibujos', revDibujos.join(', '));
            dataForm.append('modMatematicos', modMatematicos.join(', '));
    }


    let formDataString = "FormData: \n";
    for (let pair of dataForm.entries()) {
        formDataString += pair[0] + ', ' + pair[1] + '\n';
    }
    alert(formDataString);

    fetch(dao, {
        method: 'POST',
        body: dataForm
    }).then(function (response) {
        if (!response.ok) {
            console.log('Problem');
            return;
        }
        return response.json();
    }).then(function (data) {
        if (data.status === 'success') {
            console.log(data.message);
            // Si la inserción de datos fue exitosa, llamar a las funciones

            if (tipoPrueba.value === '5'){
                resumenMunsell(id_prueba);
            }else{
                resumenSolicitud(id_prueba);
            }

            if (esActualizacion){
                correoActualizacionPrueba(5,id_prueba, solicitante, emailUsuario);
                correoActualizacionPruebaLab(id_prueba);
            }else{
                enviarCorreoNuevaSolicitud(id_prueba, solicitante, emailUsuario);
            }
        } else if (data.status === 'error') {
            console.log(data.message);
            Swal.fire({
                title: "Error",
                text: data.message,
                icon: "error",
                confirmButtonText: "OK"
            });
        }
    }).catch(error => {
        //console.error(error);
        Swal.fire({
            title: "Error",
            text: error.message,
            icon: "error",
            confirmButtonText: "OK"
        });
    });
}

function validarNoRepetidos(array) {
    let elementosUnicos = new Set(array); //se crea un set (donde no se pueden repetir elementos)
    return elementosUnicos.size === array.length; //(si length son iguales entonces no hay elemntos repetidos)
}

function enviarCorreoNuevaSolicitud(id_prueba, solicitante, emailUsuario){
    const data = new FormData();

    data.append('id_prueba',id_prueba);
    data.append('solicitante',solicitante);
    data.append('emailUsuario',emailUsuario);

    fetch('https://arketipo.mx/MailerSolicitudPruebaS.php',{
        method: 'POST',
        body: data
    })
        .then(function (response){
            if (response.ok){
                //alert('Correo Solicitante: prueba: ' +id_prueba+ 'user: ' + solicitante +' email: ' + emailUsuario);
                enviarCorreoNuevaSolicitudLab(id_prueba, solicitante);
            }else{
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

function enviarCorreoNuevaSolicitudLab(id_prueba, solicitante){
    const data = new FormData();

    data.append('id_prueba',id_prueba);
    data.append('solicitante',solicitante);

    fetch('https://arketipo.mx/MailerSolicitudPruebaLab.php',{
        method: 'POST',
        body: data
    })
        .then(function (response){
            if (response.ok){
                //alert('Correo Lab: prueba: ' +id_prueba+ 'user: ' + solicitante);
                console.log("Correos enviados");
            }else{
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


/*****************************************************************************************
 * *******************FUNCIONES PARA CONFIRMAR UNA NUEVA SOLICITUD************************
 * ***************************************************************************************/


function resumenSolicitud(id_prueba) {

    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoSolicitudPrueba.php?id_prueba=' + id_prueba, function (response) {
        var data = response.data[0]; // Aquí ya estás accediendo al primer objeto dentro de 'data'
        let TP = data.id_tipoPrueba;

        // Actualizar el contenido de la ventana modal con los datos obtenidos
        $('#solicitudNumero').text(data.id_prueba);
        $('#fechaSolicitud').text(data.fechaSolicitud);
        $('#solicitante').text(data.nombreSolic);
        $('#tipoPruebaSolicitud').text(data.descripcionPrueba);
        $('#observacionesSolicitud').text(data.especificaciones);
        $('#estatusSolicitud').text(data.descripcionEstatus);
        $('#normaNombreSol').text(data.normaNombre);

        let archivo = data.normaArchivo;
        id("archivoNormaSol").href = archivo;

        var tabla = document.getElementById("piezasSolicitud");
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

            var plataformaT = document.createElement("td");
            plataformaT.textContent = response.data[j].descripcionPlataforma;
            fila.appendChild(plataformaT);

            var clienteT = document.createElement("td");
            clienteT .textContent = response.data[j].descripcionCliente;
            fila.appendChild(clienteT );

            var revDibujoT = document.createElement("td");
            revDibujoT .textContent = response.data[j].revisionDibujo;
            fila.appendChild(revDibujoT );

            var modMateT = document.createElement("td");
            modMateT .textContent = response.data[j].ModMatematico;
            fila.appendChild(modMateT );

            tbody.appendChild(fila);
        }
        id_review = id_prueba;
        // Mostrar la ventana modal con id RequestReview
        $('#RequestReview').modal('show');
        mostrarOpciones(TP,archivo);
        ocultarContenido("obs",20);
    });

}

/**********************************************************************************
 ******************FALTA VALIDAR:function mostrarOpciones**************************
 * *******************************************************************************/
function mostrarOpciones(TP,archivo){
    const elementosOcultos = document.querySelectorAll('.resumenHidden');
    if (TP === '1' || TP === '2' || TP === '6') {
        elementosOcultos.forEach(function(elemento) {
            elemento.style.display = 'block';
        });
        id("spanNorma").text = archivo;
    }else{
        elementosOcultos.forEach(function(elemento) {
            elemento.style.display = 'none';
        });
    }
}
/* *******************************************************************************/
function resumenMunsell(id_prueba) {

    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoSolMunsellPrueba.php?id_prueba=' + id_prueba, function (response) {
        var data = response.data[0]; // Aquí ya estás accediendo al primer objeto dentro de 'data'
        let TP = data.id_tipoPrueba;

        // Actualizar el contenido de la ventana modal con los datos obtenidos
        $('#solicitudNumeroM').text(data.id_prueba);
        $('#fechaSolicitudM').text(data.fechaSolicitud);
        $('#solicitanteM').text(data.nombreSolic);
        $('#tipoPruebaSolicitudM').text(data.descripcionPrueba);
        $('#observacionesSolicitudM').text(data.especificaciones);
        $('#estatusSolicitudM').text(data.descripcionEstatus);

        var tabla = document.getElementById("personalSolicitud");
        var tbody = tabla.getElementsByTagName("tbody")[0];

        // Limpiar contenido previo de la tabla
        tbody.innerHTML = '';

        // Iterar sobre los materiales y crear filas y celdas de tabla
        for (var j = 0; j < response.data.length; j++) {
            var fila = document.createElement("tr");

            var nominaMunsell = document.createElement("td");
            nominaMunsell.textContent = response.data[j].nomina;
            fila.appendChild(nominaMunsell);

            var nombreMunsell = document.createElement("td");
            nombreMunsell.textContent = response.data[j].nombre;
            fila.appendChild(nombreMunsell);

            var areaMunsell = document.createElement("td");
            areaMunsell.textContent = response.data[j].area;
            fila.appendChild(areaMunsell);

            tbody.appendChild(fila);
        }
        id_review = id_prueba;
        // Mostrar la ventana modal con id RequestReview
        $('#RequestReviewMunsell').modal('show');
        ocultarContenido("obs",20);
    });

}

/*****************************************************************************************
 * ************************FUNCIONES PARA ACTUALIZAR UNA SOLICITUD************************
 * ***************************************************************************************/
function cualEsTipoPrueba(id_prueba){
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoTipoPruebaConID.php?id_prueba=' + id_prueba,  function (response) {
        let tipoPrueba = response.data[0].id_tipoPrueba;
        if (tipoPrueba === '5') { // Munsell
            cargarDatosPruebaMunsell(id_prueba);
        }else{
            cargarDatosPrueba(id_prueba);
        }
    }).catch(function(error) {
        // Manejar errores si la solicitud falla
        console.error('Error en la solicitud JSON: ', error);
    });
}

function cargarDatosPrueba(id_update){

    let divSelectTipoPrueba = id("selectTipoPrueba");
    divSelectTipoPrueba.style.display = "block";

    var idCliente, idPlataforma;

    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoCargarDatosPruebaSol.php?id_prueba=' + id_update,  function (response) {
        let data = response.data[0];

        let idTipoPrueba = data.id_tipoPrueba;
        let subtipo = data.id_subtipo;
        let imgCotas = data.imagenCotas;
        llenarTipoPruebaUpdate(idTipoPrueba, subtipo, imgCotas);

        if(idTipoPrueba === '1' || idTipoPrueba === '2' || idTipoPrueba === '6' ){
            var norma = id("norma");
            norma.value = data.normaNombre;
        }
        var especificaciones = id("especificaciones");
        especificaciones.value = data.especificaciones;


        //-----------------------PIEZAS---------------------------
        for (var i = 0; i < response.data.length; i++) {

            idCliente = response.data[i].id_cliente;
            idPlataforma = response.data[i].id_plataforma;

            llenarClientesUpdate(indexMaterial, idCliente)

            llenarPlataformaUpdate(indexMaterial, idCliente, idPlataforma);

            var numParte = id("numeroParte" + indexMaterial);
            numParte.value = response.data[i].numParte;

            var cdadMaterial = id("cdadMaterial" + indexMaterial);
            cdadMaterial.value = response.data[i].cantidad;

            var revisionDibujo = id("revDibujo" + indexMaterial);
            revisionDibujo.value = response.data[i].revisionDibujo;

            var modMatematico = id("modeloMate" + indexMaterial);
            modMatematico.value = response.data[i].modMatematico;

            if ((i + 1) < response.data.length) {
                agregarPieza();
                llenarClientesUpdate(indexMaterial, idCliente)
            }
        }
    }).then(function() {

    }).catch(function(error) {
        // Manejar errores si la solicitud falla
        console.error('Error en la solicitud JSON: ', error);
    });
}

function cargarDatosPruebaMunsell(id_prueba){

    let divSelectTipoPrueba = id("selectTipoPrueba");
    divSelectTipoPrueba.style.display = "block";

    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoSolMunsellPrueba.php?id_prueba=' + id_update,  function (response) {
        let data = response.data[0];

        let idTipoPrueba = data.id_tipoPrueba;
        llenarTipoPruebaUpdate(idTipoPrueba, 0, "NA");

        var especificaciones = id("especificaciones");
        especificaciones.value = data.especificaciones;

        //-----------------------PERSONAL---------------------------
        for (var i = 0; i < response.data.length; i++) {

            var nominaM = id("numNomina" + indexPersonal);
            nominaM.value = response.data[i].nomina;

            var nombreM = id("nombrePersonal" + indexPersonal);
            nombreM.value = response.data[i].nombre;

            var areaM = id("area" + indexPersonal);
            areaM.value = response.data[i].area;

            if ((i + 1) < response.data.length) {
                agregarPersonal();
            }
        }
    }).catch(function(error) {
        // Manejar errores si la solicitud falla
        console.error('Error en la solicitud JSON: ', error);
    });
}

function llenarSubtipoUpdate(tipoPrueba, subtipo) {
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoSubtipoPrueba.php?id_tipoPrueba=' + tipoPrueba, function (data) {
        var selectS = id("subtipoPrueba");
        selectS.innerHTML = ""; //limpiar contenido

        var createOptionDef = document.createElement("option");
        createOptionDef.text = "Seleccione el subtipo de prueba*";
        createOptionDef.value = "";
        selectS.appendChild(createOptionDef);

        for (var i = 0; i < data.data.length; i++) {
            var createOptionS = document.createElement("option");
            createOptionS.value = data.data[i].id_subtipo;
            createOptionS.text = data.data[i].descripcion;
            selectS.appendChild(createOptionS);
            if (data.data[i].id_subtipo === subtipo) {
                createOptionS.selected = true;
            }
        }
    });
}

function llenarClientesUpdate(i, idCliente) {

    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoCliente.php')
        .then(function(data) {
            var selectS = id("cliente" + i);
            selectS.innerHTML = ""; //limpiar contenido

            var createOptionDef = document.createElement("option");
            createOptionDef.text = "Especifique el cliente(OEM)*";
            createOptionDef.value = "";
            selectS.appendChild(createOptionDef);

            for (var j = 0; j < data.data.length; j++) {
                var createOption = document.createElement("option");
                createOption.value = data.data[j].id_cliente;
                createOption.text = data.data[j].descripcionCliente;
                selectS.appendChild(createOption);
                if (data.data[j].id_cliente === idCliente) {
                    createOption.selected = true;
                }
            }
        }).catch(function(error) {
        // Manejar errores si la solicitud falla
        console.error('Error en la solicitud JSON: ', error);
    });
}


function llenarPlataformaUpdate(i, idCliente, idPlataforma) {
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoPlataforma.php?id_cliente=' + idCliente)
        .then(function(data) {
            var selectS = id("plataforma"+ i);
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
                if (data.data[j].id_plataforma === idPlataforma) { // Corregido el índice
                    createOptionS.selected = true;
                }
            }
        }).catch(function(error) {
            // Manejar errores si la solicitud falla
            console.error('Error en la solicitud JSON: ', error);
        });
}

function actualizarTituloH1(id_update) {
    const divh1 = document.querySelector("#divh1");
    const titulo1 = divh1.querySelector("h1");
    const aviso = divh1.querySelector("span");

    if (titulo1) {
        titulo1.textContent = "Actualizar Solicitud " + id_update;
    }
    if (aviso){
        aviso.textContent = " ";
    }
}


function showButton(id_button){
    const button = id(id_button);
    button.style.display = "inline-block";
}

function hideButton(id_button){
    const button = id(id_button);
    button.style.display = "none";
}

function correoActualizacionPrueba(estatusPrueba, id_prueba, solicitantePrueba, emailSolicitante){
    const data = new FormData();
    let dao = 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/Mailer/MailerActualizacionPrueba.php';

    data.append('id_prueba',id_prueba);
    data.append('solicitante',solicitantePrueba);
    data.append('emailSolicitante',emailSolicitante);

    if(estatusPrueba === '4'){
        dao = 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/Mailer/MailerPruebaCompletada.php';
    }

    fetch(dao,{
        method: 'POST',
        body: data
    })
        .then(function (response){
            if (response.ok){
                //alert('Correo Actualizacion: prueba: ' +id_prueba+ 'user: ' + solicitantePrueba +' email: ' + emailSolicitante);
            }else{
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
function correoActualizacionPruebaLab(id_prueba){
    const data = new FormData();

    data.append('id_prueba',id_prueba);

    fetch('https://arketipo.mx/MailerActualizacionPruebaLab.php',{
        method: 'POST',
        body: data
    })
        .then(function (response){
            if (response.ok){
                //alert('Correo Actualizacion: prueba: ' +id_prueba+ 'user: ' + solicitantePrueba);
                console.log("Correos enviados");
            }else{
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
/*****************************************
 *************************************************
 * ***************************************************
 * ***************************************************
 * funciones no validadas ---> ****************************
 * ********************************************************
 * ****************************************************
 * *************************************************
 * ********************************************/



function redirectToRequestsIndex() {
    window.location.href = "../requests/requestsIndex.php";
}


