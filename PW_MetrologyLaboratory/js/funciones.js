function llenarEvaluacion(){
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoTipoEvaluacion.php', function (data){
        var selectS = id("tipoEvaluacion");

        for (var i = 0; i < data.data.length; i++) {
            var createOption = document.createElement("option");
            createOption.value = data.data[i].id_tipoEvaluacion;
            createOption.text = data.data[i].descripcionEvaluacion;
            selectS.appendChild(createOption);
        }
    });
}

function banderaTipoEvaluacion() {
    if (cbTipoEva.value !== '') {
        divSelectTipoPrueba.style.display = "block";
    } else {
        divSelectTipoPrueba.style.display = "none";
    }
}

function llenarPruebaEspecial(){
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoTipoPruebaEspecial.php', function (data){
        var selectS = id("tipoPruebaEspecial");
        selectS.innerHTML = ""; //limpiar contenido

        var createOptionDef = document.createElement("option");
        createOptionDef.text = "Especifique el tipo de prueba*";
        createOptionDef.value = "";
        selectS.appendChild(createOptionDef);

        for (var i = 0; i < data.data.length; i++) {
            var createOption = document.createElement("option");
            createOption.value = data.data[i].id_pruebaEspecial;
            createOption.text = data.data[i].descripcionEspecial;
            selectS.appendChild(createOption);
        }
    });
}

function llenarDescMaterial(i) {
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoDescMaterial.php?id_plataforma=' + id("plataforma" + i).value, function (data) {
        var selectS = id("descMaterial"+ i);
        selectS.innerHTML = "";

        var createOptionDef = document.createElement("option");
        createOptionDef.text = "Seleccione la descripcion*";
        createOptionDef.value = "";
        selectS.appendChild(createOptionDef);

        for (var j = 0; j < data.data.length; j++) {
            var createOptionS = document.createElement("option");
            createOptionS.value = data.data[j].id_descripcion;
            createOptionS.text = data.data[j].descripcionMaterial;
            selectS.appendChild(createOptionS);
        }
    });
}

function numeroDeParte(i){
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoNumParte.php?id_descripcion=' + id("descMaterial" + i).value, function (data) {
        var inputId = id("numParte"+ i);
        inputId.value = " Núm. de parte: " + data.data[0].numeroDeParte;
    });
}

function descripcionMaterial(i){
    var divImgMaterial     = id("imgMaterial" + i);
    var cbDescMaterial     = id("descMaterial" + i);
    if (cbDescMaterial.value != null){
        divImgMaterial.style.display = "block";
        $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoImgMaterial.php?id_descripcion=' + id("descMaterial" + i).value, function (data) {
            id("imagenMaterial"+ i).src = data.data[0].imgMaterial;
        });
    }else{
        divImgMaterial.style.display = "none";
    }
}

function mostrarDivImagen(j) {
    var cbDescMaterial = id("descMaterial" + j);
    var divImgMaterial = id("imgMaterial" + j);

    if (cbDescMaterial.value !== '') {
        mostrarBloque(divImgMaterial, true);
    } else {
        mostrarBloque(divImgMaterial, false);
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

//Funcion anterior para agregar un nuevo material
function agregarMaterial() {
    indexMaterial++;

    var newRow = $('<div id="newRow' + indexMaterial + '" class="row row-cols-xl-3 clearfix">'
        + '<div class="col-xl-8">'
        + '<div class="row">'
        + '<div class="col-sm-6">'
        + '<div class="form-group" id="div-OEM' + indexMaterial + '">'
        + '<div class="help-block with-errors" id="divError' + indexMaterial + '"></div>'
        + '<select id="cliente' + indexMaterial + '" name="clientes[]" class="form-control" onclick="" onchange="llenarPlataforma(' + indexMaterial + ')" required data-error="Por favor ingresa el area solicitante">'
        + '<option value="">Seleccione el cliente (OEM)*</option>'
        + '</select>'
        + '<div class="input-group-icon"><i class="las la-car"></i></div>'
        + '</div>'
        + '</div>'
        + '<div class="col-sm-6">'
        + '<div class="form-group" id="plataformaDiv' + indexMaterial + '">'
        + '<div class="help-block with-errors"></div>'
        + '<select id="plataforma' + indexMaterial + '" name="plataformas[]" class="form-control" onchange="llenarDescMaterial(' + indexMaterial + ')" required data-error="Por favor ingresa la plataforma">'
        + '<option value="">Seleccione la plataforma*</option>'
        + '</select>'
        + '<div class="input-group-icon"><i class="las la-warehouse"></i></div>'
        + '</div>'
        + '</div>'
        + '<div class="col-sm-6">'
        + '<div class="form-group" id="descripcionMaterial' + indexMaterial + '">'
        + '<div class="help-block with-errors"></div>'
        + '<select id="descMaterial' + indexMaterial + '" name="descripciones[]" class="form-control" onchange="descripcionMaterial(' + indexMaterial + '); numeroDeParte(' + indexMaterial + ');" required data-error="Por favor ingresa la descripción del material">'
        + '<option value="">Seleccione la descripción*</option>'
        + '</select>'
        + '<div class="input-group-icon"><i class="las la-eye"></i></div>'
        + '</div>'
        + '</div>'
        + '<div class="col-sm-6">'
        + '<div class="form-group" id="numeroParte' + indexMaterial + '">'
        + '<div class="help-block with-errors"></div>'
        + '<input id="numParte' + indexMaterial + '" name="numPartes[]" type="text" class="form-control" placeholder="Número de parte*" required data-error="Por favor ingresa el número de parte" readonly>'
        + '<div class="input-group-icon"><i class="las la-cog"></i></div>'
        + '</div>'
        + '</div>'
        + '<div class="col-sm-6">'
        + '<div class="form-group" id="cantidadMaterial' + indexMaterial + '">'
        + '<div class="help-block with-errors"></div>'
        + '<input id="cdadMaterial' + indexMaterial + '" name="cdadesMaterial[]" type="number" class="form-control" placeholder="Cantidad*" required data-error="Por favor ingresa la cantidad">'
        + '<div class="input-group-icon"><i class="las la-cog"></i></div>'
        + '</div>'
        + '</div>'
        + '<div class="col-sm-6">'
        + '<a href="#" class="btn btn-danger remove-lnk" id="' + indexMaterial + '"><i class="las la-trash-alt"></i>Eliminar</a>'
        + '<button type="button" class="btn btn-success agregarButton" id="addNumParte' + indexMaterial + '"><i class="las la-plus-square"></i>Agregar</button>'
        + '</div>'
        + '</div>'
        + '</div>'
        + '<div class="col-xl-4 text-center">'
        + '<div id="imgMaterial' + indexMaterial + '">'
        + '<img src="" class="col-md-6 mb-3 ms-md-3 rounded img-fluid img-thumbnail" id="imagenMaterial' + indexMaterial + '" alt="Imagen Material">'
        + '</div>'
        + '</div>'
        + '</div>');
    newRow.appendTo('#contenedorFormulario');
}


///funcion mas actual

function agregarMaterial() {
    indexMaterial++;

    var newRow = $('<div id="newRow' + indexMaterial + '" class="row row-cols-xl-3 clearfix">'
        + '<div class="col-xl-8">'
        + '<div class="row">'
        + '<div class="col-sm-6">'
        + '<div class="form-group" id="div-OEM' + indexMaterial + '">'
        + '<select id="cliente' + indexMaterial + '" name="clientes[]" class="form-control" onclick="" onchange="llenarPlataforma(' + indexMaterial + ')" required data-error="Por favor ingresa el area solicitante">'
        + '<option value="">Seleccione el cliente (OEM)*</option>'
        + '</select>'
        + '<div class="input-group-icon"><i class="las la-car"></i></div>'
        + '<div class="invalid-feedback"></div>'
        + '</div>'
        + '</div>'
        + '<div class="col-sm-6">'
        + '<div class="form-group" id="plataformaDiv' + indexMaterial + '">'
        + '<select id="plataforma' + indexMaterial + '" name="plataformas[]" class="form-control" onchange="llenarDescMaterial(' + indexMaterial + ')" required data-error="Por favor ingresa la plataforma">'
        + '<option value="">Seleccione la plataforma*</option>'
        + '</select>'
        + '<div class="input-group-icon"><i class="las la-warehouse"></i></div>'
        + '<div class="invalid-feedback"></div>'
        + '</div>'
        + '</div>'
        + '<div class="col-sm-6">'
        + '<div class="form-group" id="descripcionMaterial' + indexMaterial + '">'
        + '<select id="descMaterial' + indexMaterial + '" name="descripciones[]" class="form-control" onchange="descripcionMaterial(' + indexMaterial + '); numeroDeParte(' + indexMaterial + ');" required data-error="Por favor ingresa la descripción del material">'
        + '<option value="">Seleccione la descripción*</option>'
        + '</select>'
        + '<div class="input-group-icon"><i class="las la-eye"></i></div>'
        + '<div class="invalid-feedback"></div>'
        + '</div>'
        + '</div>'
        + '<div class="col-sm-6">'
        + '<div class="form-group" id="cantidadMaterial' + indexMaterial + '">'
        + '<input id="cdadMaterial' + indexMaterial + '" name="cdadesMaterial[]" type="number" class="form-control" placeholder="Cantidad*" required data-error="Por favor ingresa la cantidad">'
        + '<div class="input-group-icon"><i class="las la-cog"></i></div>'
        + '<div class="invalid-feedback"></div>'
        + '</div>'
        + '</div>'
        + '</div>'
        + '</div>'
        + '<div class="col-xl-4 text-center row " id="imgMaterial' + indexMaterial+'">'
        + '<div class="col">'
        + '<img src="" class="rounded img-fluid img-thumbnail" id="imagenMaterial' + indexMaterial + '" alt="Imagen Material">'
        + '</div>'
        + '<div class="col">'
        + '<div class="" id="numeroParte' + indexMaterial+'">'
        + '<input id="numParte' + indexMaterial + '" name="numPartes[]" type="text" class="numParteInput" placeholder="Número de parte*" readonly>'
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
        + '<select id="plataforma' + indexMaterial + '" name="plataformas'+ indexMaterial + '" class="form-control" required data-error="Por favor ingresa la plataforma">'
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
        + '<i class="far fa-question-circle position-absolute" id="tooltipDibujo'+ indexMaterial + '"></i>'
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
