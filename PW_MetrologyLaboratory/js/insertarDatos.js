function registrarUsuario(){

    var nomina = id("nomina");
    var nombreUsuario = id("nombreUsuario");
    var correo = id("correo");
    var password = id("password");

    const data = new FormData();

    data.append('numNomina', nomina.value.trim());
    data.append('nombreUsuario', nombreUsuario.value.trim());
    data.append('correo', correo.value.trim());
    data.append('password', password.value.trim());

    fetch('../../dao/userRegister.php', {
        method: 'POST',
        body: data
    })
        .then(function (response) {
            if (response.ok) { //respuesta
                window.location.href = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/sesion/Index.php";
            } else {
                throw "Error en la llamada Ajax";
            }
        })
        .then(function (texto) {
            console.log(texto);
        })
        .catch(function (err) {
            console.log(err);
        });
}

function idSolicitud(){
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoIdSolicitud.php', function (data) {
        let idMaximo = data.data[0].max_id_prueba;
        var idMaxPartes = idMaximo.split("-");
        var anioIdMax = parseInt(idMaxPartes[0]); // Convertir a número
        var consecutivoId = idMaxPartes[1];
        var fecha = new Date();
        var anio = fecha.getFullYear();

        var nuevoId;
        if (anioIdMax === anio) {
            nuevoId = anioIdMax + "-" + (parseInt(consecutivoId) + 1);
        } else {
            nuevoId = anio + "-0001"; // Asumiendo que el consecutivo inicia en 1
        }

        alert('nuevoId: ' + nuevoId);
        console.log('anioId: ' + anioIdMax + ' consecutivoId: ' + consecutivoId + ' año actual:' + anio);
        console.log(anioIdMax === anio);
    });

}


function registrarSolicitud(){

    const dataForm = new FormData();

    var tipoEvaluacion = id("tipoEvaluacion");
    var tipoPrueba = id("tipoPrueba");

    <!-- Formulario dependiendo tipo de prueba -->
    var norma = id("norma");
    var normaFile = id("normaFile");
    var tipoPruebaEspecial = id("tipoPruebaEspecial");
    var otroPrueba = id("otroPrueba");
    var numPiezas = id("numPiezas");
    var especificaciones = id ("especificaciones");

    <!-- Para agregar material por número de parte-->




}