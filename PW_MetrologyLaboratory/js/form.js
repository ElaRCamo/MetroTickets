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
    const divAddPersonal = id("newRowPer1");

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
function initTooltipModMate() {
    var tooltips = document.querySelectorAll("[id^='tooltipModelo']");

    tooltips.forEach(function(tooltip) {
        tippy(tooltip, {
            trigger: 'click',
            animation: 'shift-away',
            theme: 'light',
            onShow(instance) {
                fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/varios/modeloMatematico.png')
                    .then((response) => response.blob())
                    .then((blob) => {
                        // Convert the blob into a URL
                        const url = URL.createObjectURL(blob);
                        const image = new Image();
                        image.width = 300;
                        image.height = 180;
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
    });
}


function agregarPieza() {
    indexMaterial++;

    var newRow = $('<div id="newRow' + indexMaterial + '" class="row row-cols-xl-3 clearfix">'
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
        + '<select id="plataforma' + indexMaterial + '" name="plataformas'+ indexMaterial + '" class="form-control" onchange="llenarDescMaterial(' + indexMaterial + ')" required data-error="Por favor ingresa la plataforma">'
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
        + '<a href="#" class="remove-lnk removeBtn" id="' + indexMaterial + '"><i class="las la-trash-alt"></i></a>'
        + '<a href="#" class="agregarButton" id="addNumParte' + indexMaterial + '"><i class="las la-plus-square"></i></a>'
        + '</div>'
        + '</div>');
    newRow.appendTo('#contenedorFormulario');
}


function validarFormNewRequest() {
    let tipoPrueba = id("tipoPrueba").value;

    const esTipoPruebaValido = validarSelect('tipoPrueba');
    const esSubtipoValido = validarSelect('subtipoPrueba');
    const esInputImgValido = validarInput('imgCotas');
    const esNormaValido = validarInput('norma');
    const esArchivoValido = validarInput('normaFile');
    const esObservacionesValido = validarInput('especificaciones');


    if(tipoPrueba === '1' || tipoPrueba === '2' || tipoPrueba === '6') { // IDL/IFD | SOFTNESS | OTRO


    } else if (tipoPrueba === '3') { // DIMENSIONAL


    } else if(tipoPrueba === '4'){ // COLOR

    }else if(tipoPrueba === '5') { //MUNSELL

    }else {
        console.log("Hay campos sin completar.");
    }


        console.log("esActualizacion: " + esActualizacion);
        if (esActualizacion === false) {
            validacionSolicitud();
        } else if (esActualizacion === true) {
            actualizarSolicitud();
        }
}

function validarMateriales(indexMaterial) {
    let esClienteValido = true;
    let esPlataformaValida = true;
    let esNumParteValido = true;
    let esCdadValida = true;
    let esrevDibujoValido = true;
    let esmodeloMateValido = true;

    for (let i = 1; i <= indexMaterial; i++) {
        esClienteValido = esClienteValido && validarSelect('cliente' + i);
        esPlataformaValida = esPlataformaValida && validarSelect('plataforma' + i);
        esNumParteValido = esNumParteValido && validarInput('numeroParte' + i);
        esCdadValida = esCdadValida && validarInput('cdadMaterial' + i);
        esrevDibujoValido = esrevDibujoValido && validarInput('revDibujo' + i);
        esmodeloMateValido = esmodeloMateValido && validarInput('modeloMate' + i);
    }
    console.log("esClienteValido: "+ esClienteValido +"\nesPlataformaValida "+esPlataformaValida);
    console.log("esNumParteValido: "+ esNumParteValido +"\nesCdadValida "+esCdadValida);
    console.log("esrevDibujoValido: "+ esrevDibujoValido +"\nesmodeloMateValido "+esmodeloMateValido);

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

function validarPersonal(indexPersonal) {
    let esNominaValido = true;
    let esNombreValida = true;
    let esAreaValida = true;

    for (let i = 1; i <= indexPersonal; i++) {
        esNominaValido = esNominaValido && validarInput('numNomina' + i);
        esNombreValida = esNombreValida && validarInput('nombrePersonal' + i);
        esAreaValida = esAreaValida && validarInput('area' + i);
    }
    console.log("esNominaValido: "+ esNominaValido +"\nesNombreValida "+esNombreValida);
    console.log("esNombreValida: "+ esNombreValida);

    // Devuelve un objeto con el resultado final de cada validación
    return {
        esNominaValido: esNominaValido,
        esNombreValida: esNombreValida,
        esAreaValida: esAreaValida
    };
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

let  esActualizacion = false;
// ¿Se va actualizar una solicitud?
const id_update = new URLSearchParams(window.location.search).get('id_update');
function esActualizacionPrueba(){
    if (id_update !== null && id_update !== '') {
        cargarDatosPrueba(id_update);
        actualizarTituloH1(id_update);
        showButton("updateRequest");
        hideButton("submitRequest");
        esActualizacion = true;
    }else{
        hideButton("updateRequest");
    }
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

<!-- Para agregar material por número de parte -->
const divNumeroParte         = id("numeroParte1");
const divDescripcionMaterial = id("descripcionMaterial1");
const divPlataforma          = id("plataformaDiv1");
const divOEM                 = id("div-OEM1");
const divCantidadMaterial    = id("cantidadMaterial1");
let tipo;


function redirectToRequestsIndex() {
    window.location.href = "../requests/requestsIndex.php";
}

function mostrarOpciones(TP){
    const elementosOcultos = document.querySelectorAll('.resumenHidden');
    if (TP!==3 || TP !== 4 || TP !== 5 ) {
        elementosOcultos.forEach(function(elemento) {
            elemento.style.display = 'none';
        });
    }else{
        elementosOcultos.forEach(function(elemento) {
            elemento.style.display = 'block';
        });
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