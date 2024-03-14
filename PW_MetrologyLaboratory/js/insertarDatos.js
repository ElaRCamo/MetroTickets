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


// Crear id con fecha
var fecha = new Date();
var anio = fecha.getFullYear();

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