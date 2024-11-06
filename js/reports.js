
function llenarAnio() {
    $.getJSON(rutaBase + '/dao/daoAnio.php', function (data) {
        var selectS = document.getElementById("anioR");
        selectS.innerHTML = "";

        // Obtener el año actual
        const anioActual = new Date().getFullYear();

        for (var i = 0; i < data.data.length; i++) {
            var createOption = document.createElement("option");
            createOption.value = data.data[i].anio;
            createOption.text = data.data[i].anio;

            if (data.data[i].anio === anioActual) {
                createOption.selected = true;
            }

            selectS.appendChild(createOption);
        }

        llenarMes();
    });
}



function llenarMes() {
    $.getJSON(rutaBase + '/dao/daoAnioMes.php?anio=' + id("anioR").value, function (data) {
        var selectS = id("mesR");
        selectS.innerHTML = ""; //limpiar contenido

        alert("año: "+id("anioR").value)

        var createOptionDef = document.createElement("option");
        createOptionDef.text = "Seleccione el mes*";
        createOptionDef.value = "";
        selectS.appendChild(createOptionDef);

        let meses = {"1": "Enero","2": "Febrero","3": "Marzo","4": "Abril","5": "Mayo","6": "Junio",
            "7": "Julio","8": "Agosto","9": "Septiembre","10": "Octubre","11": "Noviembre","12": "Diciembre"};

        for (var i = 0; i < data.data.length; i++) {
            var createOptionS = document.createElement("option");
            createOptionS.value = data.data[i].mes;
            createOptionS.text =meses[data.data[i].mes];
            selectS.appendChild(createOptionS);
        }
    });
}

function generarReporte() {
    const esTipo = validarSelect('tipoReporte');
    const esAnio = validarSelect('anioR');
    const esMes = validarSelect('mesR');

    if(esTipo && esAnio && esMes) {

        var tipo = id("tipoReporte");
        var anio = id("anioR");
        var mes = id("mesR");

        if(tipo.value === '1'){
            var url = rutaBase + "/modules/reports/reportePDF.php?anio=" + anio.value + "&mes=" + mes.value;

        }else if(tipo.value === '2'){
            var url = rutaBase + "/modules/reports/reportePDF.php?anio=" + anio.value + "&mes=" + mes.value;
        }
        console.log(url);
        window.location.href = url;
    }
}