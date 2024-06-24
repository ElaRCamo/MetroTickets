export function llenarEstatusPrueba() {
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoEstatusPrueba.php', function (data) {
        var selectS = id("estatusPruebaAdmin");
        selectS.innerHTML = ""; //limpiar contenido

        for (var j = 0; j < data.data.length; j++) {
            var createOption = document.createElement("option");
            createOption.value = data.data[j].id_estatusPrueba;
            createOption.text = data.data[j].descripcionEstatus;
            selectS.appendChild(createOption);
            // Si el valor actual coincide con id_estatusSol, se selecciona por defecto
            if (data.data[j].id_estatusPrueba === id_estatusSol) {
                createOption.selected = true;
            }
        }
    });
}