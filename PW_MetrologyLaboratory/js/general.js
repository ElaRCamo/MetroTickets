var cbTipo = document.getElementById("tipoPrueba");
var divNormaNombre = document.getElementById("normaNombre");
var divNormaArchivo = document.getElementById("normaArchivo");
var divPruebaEspecial = document.getElementById("pruebaEspecial");
var divOtroTipoPrueba = document.getElementById("otroTipoPrueba");
var divNumeroPiezas = document.getElementById("numeroPiezas");
var divDetallesPrueba = document.getElementById("detallesPrueba");
var divOEM = document.getElementById("div-OEM");

var divAgregarNumParte = document.getElementById("agregarNumParte");
<!-- Para agregar material por número de parte -->
var divNumeroParte = document.getElementById("numeroParte");
var divDescripcionMaterial = document.getElementById("descripcionMaterial");
var divPlataforma = document.getElementById("plataformaDiv");
var divCantidadMaterial = document.getElementById("cantidadMaterial");


function banderaTipoPrueba(){
    if(cbTipo.value === "durezaFOAM"){
        divOEM.style.display = "block";
        divNormaNombre.style.display = "block";
        divNormaArchivo.style.display = "block";
        divAgregarNumParte.style.display = "block";
        divNumeroParte.style.display = "block";
        divDescripcionMaterial.style.display = "block";
        divPlataforma.style.display = "block";
        divCantidadMaterial.style.display = "block";

        divPruebaEspecial.style.display = "none";
        divOtroTipoPrueba.style.display = "none";
        divNumeroPiezas.style.display = "none";
        divDetallesPrueba.style.display = "none";

    }else if (cbTipo.value === "especiales"){
        divOEM.style.display = "block";
        divNormaNombre.style.display = "block";
        divNormaArchivo.style.display = "block";
        divPruebaEspecial.style.display = "block";
        divOtroTipoPrueba.style.display = "block";
        divNumeroPiezas.style.display = "block";
        divDetallesPrueba.style.display = "block";
        divAgregarNumParte.style.display = "block";
        divNumeroParte.style.display = "block";
        divDescripcionMaterial.style.display = "block";
        divPlataforma.style.display = "block";
        divCantidadMaterial.style.display = "block";
    }else if (cbTipo.value != null){
        divOEM.style.display = "block";
        divAgregarNumParte.style.display = "block";
        divNumeroParte.style.display = "block";
        divDescripcionMaterial.style.display = "block";
        divPlataforma.style.display = "block";
        divCantidadMaterial.style.display = "block";
        divNormaNombre.style.display = "none";
        divNormaArchivo.style.display = "none";
        divPruebaEspecial.style.display = "none";
        divOtroTipoPrueba.style.display = "none";
        divNumeroPiezas.style.display = "none";
        divDetallesPrueba.style.display = "none";
    }
}

function agregarNumParte() {
    // Clonar los divs
    var cloneNumeroParte = divNumeroParte.cloneNode(true);
    var cloneDescripcionMaterial = divDescripcionMaterial.cloneNode(true);
    var clonePlataforma = divPlataforma.cloneNode(true);
    var cloneCantidadMaterial = divCantidadMaterial.cloneNode(true);

    // Obtener el contenedor donde se agregarán los nuevos divs
    var divContenedor = document.getElementById("agregarNumParte");

    // Agregar los clones al contenedor
    divContenedor.after(cloneNumeroParte);
    divContenedor.after(cloneDescripcionMaterial);
    divContenedor.after(clonePlataforma);
    divContenedor.after(cloneCantidadMaterial);
}

