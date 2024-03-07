var cbTipo = document.getElementById("tipoPrueba");
var divNormaNombre = document.getElementById("normaNombre");
var divNormaArchivo = document.getElementById("normaArchivo");
var divPruebaEspecial = document.getElementById("pruebaEspecial");
var divNumeroPiezas = document.getElementById("numeroPiezas");
var divDetallesPrueba = document.getElementById("detallesPrueba");
var divAgregarNumParte = document.getElementById("agregarNumParte");
<!-- Para agregar material por número de parte -->
var divNumeroParte = document.getElementById("numeroParte");
var divDescripcionMaterial = document.getElementById("descripcionMaterial");
var divPlataforma = document.getElementById("plataformaDiv");
var divOEM = document.getElementById("div-OEM");
var divCantidadMaterial = document.getElementById("cantidadMaterial");

var cbTipoEva = document.getElementById("tipoEvaluacion");
var divSelectTipoPrueba = document.getElementById("selectTipoPrueba");

var  cbOtroTipo = document.getElementById("tipoPruebaEspecial");
var divOtroTipoPrueba = document.getElementById("otroTipoPrueba");

var cbDescMaterial = document.getElementById("descMaterial");
var divImgMaterial = document.getElementById("imgMaterial");

function banderaTipoEvaluacion(){
    if (cbTipoEva.value != null){
        divSelectTipoPrueba.style.display = "block";
    }else{
        divSelectTipoPrueba.style.display = "none";
    }
}
function banderaTipoPrueba(){
    if(cbTipo.value === '4'){ //dureza FOAM
        divOEM.style.display = "block";
        divNormaNombre.style.display = "block";
        divNormaArchivo.style.display = "block";
        divAgregarNumParte.style.display = "block";
        divNumeroParte.style.display = "block";
        divDescripcionMaterial.style.display = "block";
        divPlataforma.style.display = "block";
        divCantidadMaterial.style.display = "block";
        divPruebaEspecial.style.display = "none";
        divNumeroPiezas.style.display = "none";
        divDetallesPrueba.style.display = "none";

    }else if (cbTipo.value === '5'){ //especiales/otra
        divOEM.style.display = "block";
        divNormaNombre.style.display = "block";
        divNormaArchivo.style.display = "block";
        divPruebaEspecial.style.display = "block";
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
        divNumeroPiezas.style.display = "none";
        divDetallesPrueba.style.display = "none";

    }

}

function mostrarNombreArchivo() {
    var inputArchivo = document.getElementById('normaFile');
    var nombreArchivo = inputArchivo.files[0].name;

    // Obtener el elemento de etiqueta y actualizar su contenido
    var labelArchivo = document.querySelector('.file-label');
    labelArchivo.innerHTML = 'Archivo cargado: ' + nombreArchivo;
}
//document.getElementById("tipoPruebaEspecial").onchange = function() {otroTipoPrueba()};
function otroTipoPrueba(){
    if (cbOtroTipo.value === "otroEspecial"){//otroEspecial
        divOtroTipoPrueba.style.display = "block";
    }else{
        divOtroTipoPrueba.style.display = "none";
    }
}

//document.getElementById("addNumParte").onclick = function() {agregarNumParte()};
function agregarNumParte() {
    // Clonar los divs
    var cloneNumeroParte = divNumeroParte.cloneNode(true);
    var cloneDescripcionMaterial = divDescripcionMaterial.cloneNode(true);
    var clonePlataforma = divPlataforma.cloneNode(true);
    var cloneCantidadMaterial = divCantidadMaterial.cloneNode(true);
    var cloneOEM =     divOEM.cloneNode(true);
    var cloneImgMaterial =     divImgMaterial.cloneNode(true);


    // Obtener el contenedor donde se agregarán los nuevos divs
    var divContenedor = document.getElementById("agregarNumParte");

    // Agregar los clones al contenedor
    divContenedor.after(cloneImgMaterial);
    divContenedor.after(cloneCantidadMaterial);
    divContenedor.after(cloneDescripcionMaterial);
    divContenedor.after(clonePlataforma);
    divContenedor.after(cloneOEM);
    divContenedor.after(cloneNumeroParte);
}

//document.getElementById("descMaterial").onchange = function() {descripcionMaterial()};
function descripcionMaterial(){
    if (cbDescMaterial.value != null){
        divImgMaterial.style.display = "block";
    }else{
        divImgMaterial.style.display = "none";
    }
}



