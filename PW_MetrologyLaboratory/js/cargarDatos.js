llenarEvaluacion();
function llenarEvaluacion(){
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoTipoEvaluacion.php', function (data){
        var select = document.getElementById("tipoEvaluacion");
        for (var i = 0; i < data.data.length; i++) {
            var createOption = document.createElement("option");
            createOption.value = data.data[i].id_tipoEvaluacion;
            createOption.text = data.data[i].descripcionEvaluacion;
            select.appendChild(createOption);
        }
    });
}

function llenarTipoPrueba() {
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoTipoPrueba.php?id_tipoEvaluacion=' + document.getElementById("tipoEvaluacion").value, function (data) {
        var selectS = document.getElementById("tipoPrueba");
        //selectS.innerHTML = ""; //limpiar contenido

        for (var i = 0; i < data.data.length; i++) {
            var createOptionS = document.createElement("option");
            createOptionS.value = data.data[i].id_tipoPrueba;
            createOptionS.text = data.data[i].descripcionPrueba;
            selectS.appendChild(createOptionS);
        }
    });
}


function llenarCliente(){
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoTipoPrueba.php', function (data){
        var select = document.getElementById("cliente");
        for (var i = 0; i < data.data.length; i++) {
            var createOption = document.createElement("option");
            createOption.value = data.data[i].id_cliente;
            createOption.text = data.data[i].descripcionCliente;
            select.appendChild(createOption);
        }
    });
}

function llenarPlataforma() {
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoPlataforma.php?id_cliente=' + document.getElementById("cliente").value, function (data) {
        var selectS = document.getElementById("plataforma");
        selectS.innerHTML = ""; //limpiar contenido

        for (var i = 0; i < data.data.length; i++) {
            var createOptionS = document.createElement("option");
            createOptionS.value = data.data[i].id_plataforma;
            createOptionS.text = data.data[i].descripcionPlataforma;
            selectS.appendChild(createOptionS);
        }
    });
}

function llenarDescMaterial() {
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoDescMaterial.php?id_plataforma=' + document.getElementById("plataforma").value, function (data) {
        var selectS = document.getElementById("descMaterial");
        selectS.innerHTML = "";

        for (var i = 0; i < data.data.length; i++) {
            var createOptionS = document.createElement("option");
            createOptionS.value = data.data[i].id_descripcion;
            createOptionS.text = data.data[i].descripcionMaterial;
            selectS.appendChild(createOptionS);
        }
    });
}
