const id = str => document.getElementById(str);

var cbTipo             = id("tipoPrueba");
var divNormaNombre     = id("normaNombre");
var divNormaArchivo    = id("normaArchivo");
var divPruebaEspecial  = id("pruebaEspecial");
var divDetallesPrueba  = id("detallesPrueba");
var divAgregarNumParte = id("agregarNumParte");
<!-- Para agregar material por número de parte -->
var divNumeroParte     = id("numeroParte1");
var divDescripcionMaterial = id("descripcionMaterial1");
var divPlataforma      = id("plataformaDiv1");
var divOEM             = id("div-OEM1");
var divCantidadMaterial= id("cantidadMaterial1");
var cbTipoEva          = id("tipoEvaluacion");
var divSelectTipoPrueba= id("selectTipoPrueba");
var  cbOtroTipo        = id("tipoPruebaEspecial");
var divOtroTipoPrueba  = id("otroTipoPrueba");
var cbDescMaterial     = id("descMaterial");
var divImgMaterial     = id("imgMaterial1");
var botonEnviar        = id("submitRequest");

const mostrarBloque = (elemento, mostrar) => {
    elemento.style.display = mostrar ? "block" : "none";
};

function banderaTipoEvaluacion(){
    if (cbTipoEva.value !== ''){
        divSelectTipoPrueba.style.display = "block";
    }else{
        divSelectTipoPrueba.style.display = "none";
    }
}
/*function banderaTipoPrueba(){
    if(cbTipo.value === '4'){ //dureza FOAM
        divOEM.style.display = "block";
        divNormaNombre.style.display = "block";
        divNormaArchivo.style.display = "block";
        divAgregarNumParte.style.display = "block";
        divNumeroParte.style.display = "block";
        divDescripcionMaterial.style.display = "block";
        divPlataforma.style.display = "block";
        divCantidadMaterial.style.display = "block";
        botonEnviar.style.display = "block";
        divPruebaEspecial.style.display = "none";
        divDetallesPrueba.style.display = "block";
        divOtroTipoPrueba.style.display = "block";

    }else if (cbTipo.value === '5'){ //especiales/otra
        divOEM.style.display = "block";
        divNormaNombre.style.display = "block";
        divNormaArchivo.style.display = "block";
        divPruebaEspecial.style.display = "block";
        divDetallesPrueba.style.display = "block";
        divAgregarNumParte.style.display = "block";
        divNumeroParte.style.display = "block";
        divDescripcionMaterial.style.display = "block";
        divPlataforma.style.display = "block";
        botonEnviar.style.display = "block";
        divCantidadMaterial.style.display = "block";
        divOtroTipoPrueba.style.display = "none";

    }else if (cbTipo.value !== ''){
        divOEM.style.display = "block";
        divAgregarNumParte.style.display = "block";
        divNumeroParte.style.display = "block";
        divDescripcionMaterial.style.display = "block";
        divPlataforma.style.display = "block";
        divCantidadMaterial.style.display = "block";
        divNormaNombre.style.display = "none";
        divNormaArchivo.style.display = "none";
        divPruebaEspecial.style.display = "none";
        divDetallesPrueba.style.display = "block";
        botonEnviar.style.display = "block";
        divOtroTipoPrueba.style.display = "none";

    }else{
        divOEM.style.display = "none";
        divAgregarNumParte.style.display = "none";
        divNumeroParte.style.display = "none";
        divDescripcionMaterial.style.display = "none";
        divPlataforma.style.display = "none";
        divCantidadMaterial.style.display = "none";
        divNormaNombre.style.display = "none";
        divNormaArchivo.style.display = "none";
        divPruebaEspecial.style.display = "none";
        divDetallesPrueba.style.display = "none";
        divImgMaterial.style.display = "none";
        botonEnviar.style.display = "none";
        divOtroTipoPrueba.style.display = "none";
    }

}

function otroTipoPrueba(){
    if (cbOtroTipo.value === '4'){//otroEspecial
        divOtroTipoPrueba.style.display = "block";
    }else{
        divOtroTipoPrueba.style.display = "none";
    }
}*/
let tipo;
function banderaTipoPrueba() {
    tipo = cbTipo.value;

    mostrarBloque(divOEM, tipo !== '');
    mostrarBloque(divAgregarNumParte, tipo !== '');
    mostrarBloque(divNumeroParte, tipo !== '');
    mostrarBloque(divDescripcionMaterial, tipo !== '');
    mostrarBloque(divPlataforma, tipo !== '');
    mostrarBloque(divCantidadMaterial, tipo !== '');

    if (tipo === '4') { // dureza FOAM
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
}

function otroTipoPrueba(){
    const otroTipo = cbOtroTipo.value;
    console.log("tipo:"+ tipo);

    if (tipo === '4' && otroTipo === '4'){//otroEspecial
        console.log("if "+otroTipo);
        mostrarBloque(divOtroTipoPrueba, true);
    }else{
        console.log("else "+otroTipo);
        mostrarBloque(divOtroTipoPrueba, false);
    }
}


// Función para cerrar sesión
function cerrarSesion() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert('Sesión cerrada exitosamente');
            window.location.href = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/sesion/indexSesion.php";
        }
    };
    xhttp.open("POST", "../../dao/login.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("cerrarSesion=true");
}
document.getElementById("cerrarSesion").addEventListener("click", function(event) {
    event.preventDefault(); // Esto evita que el enlace se siga automáticamente
    cerrarSesion();
});
document.getElementById("cerrarS").addEventListener("click", function(event) {
    cerrarSesion();
});

