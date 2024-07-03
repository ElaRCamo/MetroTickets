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
        mostrarBloque(divDetallesPrueba, true);
        mostrarBloque(divTitlePiezas, true);
        mostrarBloque(divRegistroPiezas, true);
        mostrarBloque(botonEnviar, true);
        mostrarBloque(divNormaNombre, false);
        mostrarBloque(divNormaArchivo, false);
        mostrarBloque(divSubtipoPrueba, false);
        mostrarBloque(divCotas, false);
        mostrarBloque(divImgCotas, false);
        mostrarBloque(divTitlePersonal, true);
        mostrarBloque(divAddPersonal, true);
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

tippy('#tooltipModelo'+indexMaterial, {
    trigger: 'click',
    animation: 'shift-away',
    theme: 'light',
    onShow(instance) {
        fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/varios/modeloMatematico.png')
            .then((response) => response.blob())
            .then((blob) => {
                // Convert the blob into a URL
                const url = URL.createObjectURL(blob);
                // Create an image
                const image = new Image();
                image.width = 300;
                image.height = 180;
                image.style.display = 'block';
                image.style.margin = '0 auto'; // Center the image
                image.src = url;

                // Create a container div
                const container = document.createElement('div');
                container.style.textAlign = 'start'; // Center align text
                container.style.fontSize = '0.7rem'; // Smaller font size

                // Add the image to the container
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