const id = str => document.getElementById(str);

var cbTipo            = id("tipoPrueba");
var divNormaNombre    = id("normaNombre");
var divNormaArchivo   = id("normaArchivo");
var divPruebaEspecial = id("pruebaEspecial");
var divNumeroPiezas   = id("numeroPiezas");
var divDetallesPrueba = id("detallesPrueba");
var divAgregarNumParte= id("agregarNumParte");
<!-- Para agregar material por número de parte -->
var divNumeroParte    = id("numeroParte");
var divDescripcionMaterial = id("descripcionMaterial");
var divPlataforma     = id("plataformaDiv");
var divOEM            = id("div-OEM");
var divCantidadMaterial= id("cantidadMaterial");

var cbTipoEva         = id("tipoEvaluacion");
var divSelectTipoPrueba = id("selectTipoPrueba");

var  cbOtroTipo       = id("tipoPruebaEspecial");
var divOtroTipoPrueba = id("otroTipoPrueba");

var cbDescMaterial = id("descMaterial");
var divImgMaterial = id("imgMaterial");
var botonEnviar = id("submitRequest");

function banderaTipoEvaluacion(){
    if (cbTipoEva.value !== ''){
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
        botonEnviar.style.display = "block";
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
        botonEnviar.style.display = "block";
        divCantidadMaterial.style.display = "block";
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
        divNumeroPiezas.style.display = "none";
        divDetallesPrueba.style.display = "none";
        botonEnviar.style.display = "block";

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
        divNumeroPiezas.style.display = "none";
        divDetallesPrueba.style.display = "none";
        divImgMaterial.style.display = "none";
        botonEnviar.style.display = "none";
    }

}

/*function mostrarNombreArchivo() {

    var nombreArchivo = id('normaFile').files[0].name;

    // Obtener el elemento de etiqueta y actualizar su contenido
    var labelArchivo = document.querySelector('.file-label');
    labelArchivo.innerHTML = 'Archivo cargado: ' + nombreArchivo;
}*/

// Agregar el event listener al input de tipo file
document.getElementById('normaFile').addEventListener('change', function() {
    var nombreArchivoInput = this.files[0].name;
    mostrarNombreArchivo(nombreArchivoInput);
});

// Función para mostrar el nombre del archivo
function mostrarNombreArchivo(nombreArchivo) {
    var spanNombreArchivo = document.getElementById('nombreArchivoSeleccionado');
    if (spanNombreArchivo) {
        spanNombreArchivo.textContent = 'Archivo cargado: ' + nombreArchivo;
    }
}



function otroTipoPrueba(){
    if (cbOtroTipo.value === '4'){//otroEspecial
        divOtroTipoPrueba.style.display = "block";
    }else{
        divOtroTipoPrueba.style.display = "none";
    }
}


function agregarNumParte() {
    // Clonar los divs
    var cloneNumeroParte = divNumeroParte.cloneNode(true);
    var cloneDescripcionMaterial = divDescripcionMaterial.cloneNode(true);
    var clonePlataforma = divPlataforma.cloneNode(true);
    var cloneCantidadMaterial = divCantidadMaterial.cloneNode(true);
    var cloneOEM = divOEM.cloneNode(true);
    var cloneImgMaterial = divImgMaterial.cloneNode(true);


    // Obtener el contenedor donde se agregarán los nuevos divs
    var divContenedor = id("agregarNumParte");

    // Agregar los clones al contenedor
    divContenedor.after(cloneImgMaterial);
    divContenedor.after(cloneCantidadMaterial);
    divContenedor.after(cloneDescripcionMaterial);
    divContenedor.after(clonePlataforma);
    divContenedor.after(cloneOEM);
    divContenedor.after(cloneNumeroParte);
}

/*
const btn_agregar = id("addNumParte");
btn_agregar.addEventListener("click", function ( ){

    //div para NumeroParte
    const divNumeroParte  = D.create('div', {class:" form-group col-sm-4"});
    const selectNP = D.create('input',{type:"text",name:"numPartes[]", class:"form-control", onchange:"llenarCliente()", placeholder:"Número de parte*"});
    D.append(selectNP,divNumeroParte);

    //div para OEM
    const divOEM = D.create('div',{class:" form-group col-sm-4"});
    const selectOEM = D.create('select', {name:"clientes[]", class:"form-control", onchange:"llenarPlataforma()"});
    D.append(selectOEM,divOEM);

    // div para Plataforma
    const divPlataforma = D.create('div',{class:" form-group col-sm-4"});
    const selectPlataforma = D.create('select', {name:"plataformas[]", class:"form-control", id:"plataforma",  onchange:"llenarDescMaterial()"});
    D.append(selectPlataforma,divPlataforma);

    //div para DescripcionMaterial
    const divDescripcionMaterial = D.create('div', {class:" form-group col-sm-6"});
    const selectDescMaterial = D.create('select', {name:"descripciones[]", class:"form-control", id:"descMaterial", onchange:"descripcionMaterial()"});
    D.append(selectDescMaterial,divDescripcionMaterial);

    //div para CantidadMaterial
    const divCantidadMaterial = D.create('div', {class:" form-group col-sm-6"});
    const inputCantidad= D.create('input',{type:"number", class:"form-control", id:"cdadesMaterial[]", placeholder:"Cantidad*"});
    D.append(inputCantidad,divCantidadMaterial);

    //div para ImgMaterial
    const divImgMaterial = D.create('div', {class:" form-group col-sm-12"});
    const imagenMaterial = D.create('img',{src:"../../imgs/cabecera.png", class:"imgsMaterial", alt:"Imagen Material"});
    D.append(imagenMaterial, divImgMaterial);


    //Boton para eliminar este div
    const borrar = D.create('a',{href: 'javascript:void(0)', innerHTML:'x', onclick: function ( ){
        D.remove(divNumeroParte);
        D.remove(divOEM);
        D.remove(divPlataforma);
        D.remove(divDescripcionMaterial);
        D.remove(divCantidadMaterial);
        D.remove(divImgMaterial);
        }})

    // Obtener el contenedor donde se agregarán los nuevos divs
    var divContenedor = document.getElementById("agregarNumParte");
    D.append(divNumeroParte, divContenedor);
    D.append(divOEM, divContenedor)
    D.append(divPlataforma, divContenedor);
    D.append(divDescripcionMaterial, divContenedor)
    D.append(divCantidadMaterial, divContenedor);
    D.append(divImgMaterial, divContenedor);
    D.append(borrar, divContenedor);


})
*/

function descripcionMaterial(){
    if (cbDescMaterial.value != null){
        divImgMaterial.style.display = "block";
        $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoImgMaterial.php?id_descripcion=' + id("descMaterial").value, function (data) {
            id("imagenMaterial").src = data.data[0].imgMaterial;
        });
    }else{
        divImgMaterial.style.display = "none";
    }
}



