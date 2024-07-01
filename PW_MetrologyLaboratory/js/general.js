const id = str => document.getElementById(str);

const mostrarBloque = (elemento, mostrar) => {
    elemento.style.display = mostrar ? "block" : "none";
};

function banderaTipoPrueba() {

    const selTipoPrueba = id("tipoPrueba");
    const divSubtipoPrueba = id("subtipoPrueba");
    const divNormaNombre = id("normaNombre");
    const divNormaArchivo = id("normaArchivo");
    const divDetallesPrueba = id("detallesPrueba");
    const divRegistroPiezas = id("newRow1");
    const botonEnviar = id("submitRequest");

    let tipoPrueba = selTipoPrueba.value;

    if(tipoPrueba === '1' || tipoPrueba === '2' || tipoPrueba === '6') { // IDL/IFD | SOFTNESS | OTRO
        mostrarBloque(divNormaNombre, true);
        mostrarBloque(divNormaArchivo, true);
        mostrarBloque(divDetallesPrueba, true);
        mostrarBloque(divRegistroPiezas, true);

    } else if (tipoPrueba === '3') { // DIMENSIONAL
        mostrarBloque(divSubtipoPrueba, true);
        mostrarBloque(divDetallesPrueba, true);
        mostrarBloque(divRegistroPiezas, true);
        llenarSubtipoPrueba();

    } else { // otro caso
        mostrarBloque(divDetallesPrueba, true);
        mostrarBloque(divRegistroPiezas, true);
    }

    if (esActualizacion === true){
        mostrarBloque(botonEnviar, false);
    }
}

function subtipoPrueba(){
    const divCotas = id("divCotas");
    const selSubtipo = id("subtipoPrueba");
    let subtipoPrueba = selSubtipo.value;

    if(subtipoPrueba === '1'){ //Dimensional-cotas especificas
        mostrarBloque(divCotas, true);
    }
}

function previewImageCotas(event) {
    const divImagenCotas = id("divImgCotas");
    const reader = new FileReader();
    reader.onload = function() {
        const output = document.getElementById('capturaCotas');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
    mostrarBloque(divImagenCotas, true);
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




<!-- Para agregar material por número de parte -->
const divNumeroParte = id("numeroParte1");
const divDescripcionMaterial = id("descripcionMaterial1");
const divPlataforma = id("plataformaDiv1");
const divOEM = id("div-OEM1");
const divCantidadMaterial = id("cantidadMaterial1");




let tipo;


// Función para cerrar sesión
function cerrarSesion() {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            Swal.fire("¡Sesión cerrada exitosamente!");
            window.location.href = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/sesion/indexSesion.php";
        }
    };
    xhttp.open("POST", "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/login.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("cerrarSesion=true");
}

function redirectToRequestsIndex() {
    window.location.href = "../requests/requestsIndex.php";
}

function ocultarContenido(clase,limiteCaracteres){
    const especificaciones = document.querySelectorAll("." + clase);
    especificaciones.forEach(function(especificacion) {
        const contenido = especificacion.textContent;
        if (contenido.length > limiteCaracteres) {
            const contenidoRecortado = contenido.substring(0, limiteCaracteres);
            const contenidoRestante = contenido.substring(limiteCaracteres, contenido.length);
            especificacion.innerHTML = contenidoRecortado + '<span class="hidden">' + contenidoRestante + '</span><button class="btn-ver-mas">Ver más...</button>';
        }
    });

    const botonesVerMas = document.querySelectorAll(".btn-ver-mas");
    botonesVerMas.forEach(function(boton) {
        boton.addEventListener("click", function() {
            const contenidoOculto = this.previousElementSibling;
            contenidoOculto.classList.toggle("hidden");
            if (this.textContent === "Ver más...") {
                this.textContent = "Ver menos";
            } else {
                this.textContent = "Ver más...";
            }
        });
    });
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