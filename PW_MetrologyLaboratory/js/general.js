const id = str => document.getElementById(str);

var cbTipo = id("tipoPrueba");
var divNormaNombre = id("normaNombre");
var divNormaArchivo = id("normaArchivo");
var divPruebaEspecial = id("pruebaEspecial");
var divDetallesPrueba = id("detallesPrueba");
var divAgregarNumParte = id("agregarNumParte");
<!-- Para agregar material por número de parte -->
var divNumeroParte = id("numeroParte1");
var divDescripcionMaterial = id("descripcionMaterial1");
var divPlataforma = id("plataformaDiv1");
var divOEM = id("div-OEM1");
var divCantidadMaterial = id("cantidadMaterial1");
var cbTipoEva = id("tipoEvaluacion");
var divSelectTipoPrueba = id("selectTipoPrueba");
var cbOtroTipo = id("tipoPruebaEspecial");
var divOtroTipoPrueba = id("otroTipoPrueba");
var botonEnviar = id("submitRequest");

const mostrarBloque = (elemento, mostrar) => {
    elemento.style.display = mostrar ? "block" : "none";
};

function mostrarDivImagen(j) {
    var cbDescMaterial = id("descMaterial" + j);
    var divImgMaterial = id("imgMaterial" + j);

    if (cbDescMaterial.value !== '') {
        mostrarBloque(divImgMaterial, true);
    } else {
        mostrarBloque(divImgMaterial, false);
    }
}

function banderaTipoEvaluacion() {
    if (cbTipoEva.value !== '') {
        divSelectTipoPrueba.style.display = "block";
    } else {
        divSelectTipoPrueba.style.display = "none";
    }
}

let tipo;

function banderaTipoPrueba() {
    tipo = cbTipo.value;

    mostrarBloque(divOEM, tipo !== '');
    mostrarBloque(divAgregarNumParte, tipo !== '');
    mostrarBloque(divNumeroParte, tipo !== '');
    mostrarBloque(divDescripcionMaterial, tipo !== '');
    mostrarBloque(divPlataforma, tipo !== '');
    mostrarBloque(divCantidadMaterial, tipo !== '');

    if (tipo === '4' || tipo === '3') { // dureza FOAM || dureza insitu
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
        llenarPruebaEspecial();
    } else { // otro caso
        mostrarBloque(divNormaNombre, false);
        mostrarBloque(divNormaArchivo, false);
        mostrarBloque(divPruebaEspecial, false);
        mostrarBloque(divDetallesPrueba, true);
        mostrarBloque(botonEnviar, true);
        mostrarBloque(divOtroTipoPrueba, false);
    }
}

function otroTipoPrueba() {
    const otroTipo = cbOtroTipo.value;

    if (tipo === '5' && otroTipo === '4') {//otroEspecial
        mostrarBloque(divOtroTipoPrueba, true);
    } else {
        mostrarBloque(divOtroTipoPrueba, false);
    }
}
function todoVisible(){
    divSelectTipoPrueba.style.display = "block";
    mostrarBloque(divOEM, true);
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
    mostrarBloque(divOtroTipoPrueba, true);

}

// Función para cerrar sesión
function cerrarSesion() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            Swal.fire("¡Sesión cerrada exitosamente!");
            window.location.href = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/sesion/indexSesion.php";
        }
    };
    xhttp.open("POST", "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/login.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("cerrarSesion=true");
}

document.getElementById("cerrarSesion").addEventListener("click", function (event) {
    event.preventDefault(); // Esto evita que el enlace se siga automáticamente
    cerrarSesion();
});
document.getElementById("cerrarS").addEventListener("click", function (event) {
    cerrarSesion();
});

function redirectToRequestsIndex() {
    window.location.href = "../requests/requestsIndex.php";
}

function ocultarContenido(clase,limiteCaracteres){
    var especificaciones = document.querySelectorAll("."+ clase);
    especificaciones.forEach(function(especificacion) {
        var contenido = especificacion.textContent;
        if (contenido.length > limiteCaracteres) {
            var contenidoRecortado = contenido.substring(0, limiteCaracteres);
            var contenidoRestante = contenido.substring(limiteCaracteres, contenido.length);
            especificacion.innerHTML = contenidoRecortado + '<span class="hidden">' + contenidoRestante + '</span><button class="btn-ver-mas">Ver más...</button>';
        }
    });

    var botonesVerMas = document.querySelectorAll(".btn-ver-mas");
    botonesVerMas.forEach(function(boton) {
        boton.addEventListener("click", function() {
            var contenidoOculto = this.previousElementSibling;
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
    var elementosOcultos = document.querySelectorAll('.resumenHidden');
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
    var button = id(id_button);
    button.style.display = "inline-block";
}

function hideButton(id_button){
    var button = id(id_button);
    button.style.display = "none";
}
/*
function cambiarImg(){
    var divImg = id("divCambiarImg");
    var divImg2 = id("divCambiarImg2");
    divImg.style.display = "inline-block";
    divImg2.style.display = "inline-block";
}
function hideImg(){
    var divImg = id("divCambiarImg");
    var divImg2 = id("divCambiarImg2");
    divImg.style.display = "none";
    divImg2.style.display = "none";
}
*/

