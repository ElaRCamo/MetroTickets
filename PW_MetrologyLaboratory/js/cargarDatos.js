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
