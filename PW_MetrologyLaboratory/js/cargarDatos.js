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

        var selectA = document.getElementById("descMaterial");
        selectA.innerHTML = "";


        var createOptionDef = document.createElement("option");
        createOptionDef.text = "Seleccione";
        createOptionDef.value = "";
        selectS.appendChild(createOptionDef);

        for (var i = 0; i < data.data.length; i++) {
            var createOptionS = document.createElement("option");
            createOptionS.value = data.data[i].id_plataforma;
            createOptionS.text = data.data[i].descripcionPlataforma;
            selectS.appendChild(createOptionS);
        }
    });
}

/*
function llenarSuper() {
    $.getJSON('https://arketipo.mx/RH/Entrevistas/dao/daoSupervisor.php?APU=' + document.getElementById("cbEncargado").value, function (data) {
        var selectS = document.getElementById("cbSupervisor");
        selectS.innerHTML = "";

        var selectA = document.getElementById("cbShiftLeader");
        selectA.innerHTML = "";


        var createOptionDef = document.createElement("option");
        createOptionDef.text = "Seleccione";
        createOptionDef.value = "";
        selectS.appendChild(createOptionDef);

        for (var i = 0; i < data.data.length; i++) {
            var createOptionS = document.createElement("option");
            createOptionS.text = data.data[i].Supervisor;
            createOptionS.value = data.data[i].Supervisor;
            selectS.appendChild(createOptionS);
        }
    });
}

function llenarShift() {
    $.getJSON('https://arketipo.mx/RH/Entrevistas/dao/daoShiftLeader.php?APU=' + document.getElementById("cbSupervisor").value, function (data) {
        var selectS = document.getElementById("cbShiftLeader");
        selectS.innerHTML = "";

        var createOptionDefS = document.createElement("option");
        createOptionDefS.text = "Seleccione";
        createOptionDefS.value = "";
        selectS.appendChild(createOptionDefS);

        for (var i = 0; i < data.data.length; i++) {
            var createOptionS = document.createElement("option");
            createOptionS.text = data.data[i].ShiftLeader;
            createOptionS.value = data.data[i].ShiftLeader;
            selectS.appendChild(createOptionS);
        }
    });
}
/
 */