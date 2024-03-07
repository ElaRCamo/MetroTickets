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

//document.getElementById("tipoEvaluacion").onchange = function() {banderaTipoEvaluacion()};
function banderaTipoEvaluacion(){
    if (cbTipoEva.value === "universal"){
        divSelectTipoPrueba.style.display = "block";
    }else{
        divSelectTipoPrueba.style.display = "none";
    }
    console.log("banderaTipoEvaluacion()");
}

//document.getElementById("tipoPrueba").onchange = function() {banderaTipoPrueba()};
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
        divNumeroPiezas.style.display = "none";
        divDetallesPrueba.style.display = "none";

    }else if (cbTipo.value === "especiales"){
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
    console.log(" banderaTipoPrueba()");
}
//document.getElementById("normaFile").onchange = function() {mostrarNombreArchivo()};
function mostrarNombreArchivo() {
    var inputArchivo = document.getElementById('normaFile');
    var nombreArchivo = inputArchivo.files[0].name;

    // Obtener el elemento de etiqueta y actualizar su contenido
    var labelArchivo = document.querySelector('.file-label');
    labelArchivo.innerHTML = 'Archivo cargado: ' + nombreArchivo;
    console.log("mostrarNombreArchivo");
}
//document.getElementById("tipoPruebaEspecial").onchange = function() {otroTipoPrueba()};
function otroTipoPrueba(){
    if (cbOtroTipo.value === "otroEspecial"){
        divOtroTipoPrueba.style.display = "block";
    }else{
        divOtroTipoPrueba.style.display = "none";
    }
    console.log("otroTipoPrueba()");
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
    console.log("agregarNumParte()");
}

//document.getElementById("descMaterial").onchange = function() {descripcionMaterial()};
function descripcionMaterial(){
    if (cbDescMaterial.value != null){
        divImgMaterial.style.display = "block";
    }else{
        divImgMaterial.style.display = "none";
    }
    console.log("descripcionMaterial()");
}

llenarCliente();
function llenarCliente(){
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoCliente.php', function (data){
        var select = document.getElementById("cliente");
        for (var i = 0; i < data.data.length; i++) {
            var createOption = document.createElement("option");
            createOption.value = data.data[i].id_cliente;
            createOption.text = data.data[i].descripcionCliente;
            select.appendChild(createOption);
        }
    });
}

