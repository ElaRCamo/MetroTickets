function pruebasRealizadasMesActual(){
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoPruebasMes.php', function (data){
        var numPruebasMesActual = data.data[0]['COUNT(*)']; // Obtener el número de pruebas
        document.getElementById("numeroPruebas").innerText = numPruebasMesActual;
        console.log("numPruebas: "+ data.data[0]['COUNT(*)']);

    });
}

function pruebasPendientes(){
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoPruebasPendientes.php', function (data){
        var numPruebasPendientes = data.data[0]['COUNT(*)']; // Obtener el número de pruebas
        document.getElementById("pruebasPendientes").innerText = numPruebasPendientes;
    });
}

function tiempoRespuesta(){
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoPruebasTiempoRespuesta.php', function (data){
        var tiempoRespuesa = data.data[0].tiempoPromedioRespuestaDias;
        document.getElementById("tiempoRespuesaSpan").innerText = tiempoRespuesa;
    });
}

function pruebasPorDia(){
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoPruebasPorDia.php', function (data){
        var pruebasPorDia = data.data[0].eficienciaOperativa;
        document.getElementById("pruebasPorDiaSpan").innerText = pruebasPorDia;
    });
}

function cumplimientoFechaResp() {
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoCumplimientoFechaResp.php', function (data){
        let cumplimiento = data.data[0].porcentajeCumplimiento;
        document.getElementById("cumplimiento").innerText = cumplimiento + ' %';
    });
}
