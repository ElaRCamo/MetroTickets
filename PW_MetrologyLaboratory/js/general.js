const id = str => document.getElementById(str);

let cbTipo = id("tipoPrueba");
let divNormaNombre = id("normaNombre");
const divNormaArchivo = id("normaArchivo");
const divPruebaEspecial = id("pruebaEspecial");
const divDetallesPrueba = id("detallesPrueba");
const divAgregarNumParte = id("agregarNumParte");
<!-- Para agregar material por número de parte -->
const divNumeroParte = id("numeroParte1");
const divDescripcionMaterial = id("descripcionMaterial1");
const divPlataforma = id("plataformaDiv1");
const divOEM = id("div-OEM1");
const divCantidadMaterial = id("cantidadMaterial1");
const cbTipoEva = id("tipoEvaluacion");
const divSelectTipoPrueba = id("selectTipoPrueba");
const cbOtroTipo = id("tipoPruebaEspecial");
const divOtroTipoPrueba = id("otroTipoPrueba");
const botonEnviar = id("submitRequest");

const mostrarBloque = (elemento, mostrar) => {
    elemento.style.display = mostrar ? "block" : "none";
};

let tipo;

function banderaTipoPrueba() {
    tipo = cbTipo.value;

    mostrarBloque(divOEM, tipo !== '');
    mostrarBloque(divAgregarNumParte, tipo !== '');
    mostrarBloque(divNumeroParte, tipo !== '');
    mostrarBloque(divDescripcionMaterial, tipo !== '');
    mostrarBloque(divPlataforma, tipo !== '');
    mostrarBloque(divCantidadMaterial, tipo !== '');

    if(tipo === '4' || tipo === '3') { // dureza FOAM || dureza insitu
        mostrarBloque(divNormaNombre, true);
        mostrarBloque(divNormaArchivo, true);
        mostrarBloque(divAgregarNumParte, true);
        mostrarBloque(divNumeroParte, true);
        mostrarBloque(divDescripcionMaterial, true);
        mostrarBloque(divPlataforma, true);
        mostrarBloque(botonEnviar, true);
        mostrarBloque(divPruebaEspecial, false);
        mostrarBloque(divDetallesPrueba, true);

    } else if (tipo === '5') { // especiales/otra
        mostrarBloque(divNormaNombre, true);
        mostrarBloque(divNormaArchivo, true);
        mostrarBloque(divPruebaEspecial, true);
        mostrarBloque(divDetallesPrueba, true);
        mostrarBloque(divAgregarNumParte, true);
        mostrarBloque(divNumeroParte, true);
        mostrarBloque(divDescripcionMaterial, true);
        mostrarBloque(divPlataforma, true);
        mostrarBloque(botonEnviar, true);
        mostrarBloque(divCantidadMaterial, true);
        mostrarBloque(divOtroTipoPrueba, false);
    } else { // otro caso
        mostrarBloque(divNormaNombre, false);
        mostrarBloque(divNormaArchivo, false);
        mostrarBloque(divPruebaEspecial, false);
        mostrarBloque(divDetallesPrueba, true);
        mostrarBloque(botonEnviar, true);
        mostrarBloque(divOtroTipoPrueba, false);
    }

    if (esActualizacion === true){
        mostrarBloque(botonEnviar, false);
    }
}

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