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
                    window.location.href = "../sesion/indexSesion.php";
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

function idPrueba() {
    return new Promise(function(resolve, reject) {
        $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoIdSolicitud.php', function(data) {
            var fecha = new Date();
            var anio = fecha.getFullYear();
            var nuevoId;
            let idMaximo = data.data[0].max_id_prueba;

            if (idMaximo == null) {
                nuevoId = anio + "-0001";
            }else{
                var idMaxPartes = idMaximo.split("-");
                var anioIdMax = parseInt(idMaxPartes[0]); // Convertir a número
                var consecutivoId = idMaxPartes[1];

                if (anioIdMax === anio) {
                    nuevoId = anioIdMax + "-" + (parseInt(consecutivoId) + 1).toString().padStart(4, '0');
                } else {//cambio de año
                    nuevoId = anio + "-0001"; // Asumiendo que el consecutivo inicia en 1
                }
            }
            resolve(nuevoId); // Resolver la promesa con el nuevo ID
        });
    });
}

function obtenerNuevoId() {
    return idPrueba().then(function(nuevoId) {
        console.log("obtenerNuevoId-Nuevo ID:", nuevoId);
        return nuevoId;
    }).catch(function(error) {
        console.error("Error al obtener el nuevo ID:", error);
    });
}

function obtenerSesion() {
    return new Promise(function(resolve, reject) {
        $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoSesionIniciada.php', function(data) {
            let sesionIniciada = data.sesionIniciada;
            resolve(sesionIniciada); // Resolver la promesa con el nuevo ID
        });
    });
}
function validarSesion() {
    return obtenerSesion().then(function(sesionIniciada) {
        console.log("Obterner estatus de la sesión: ", sesionIniciada);
        return sesionIniciada;

    }).catch(function(error) {
        console.error("Error al validar la sesión", error);
    });
}

async function registrarSolicitud() {

    var sesionIniciada = await validarSesion();

    if (!sesionIniciada) {
        // Si la sesión no está iniciada, redirigir al usuario a la página de inicio de sesión
        window.location.replace("https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/sesion/indexSesion.php");
        alert("La sesión no está iniciada.");
        return;
    }
        try {
            var id_prueba = await obtenerNuevoId(); // Esperar a que se resuelva la promesa y obtener el nuevo ID
            const dataForm = new FormData();

            var tipoPrueba         = id("tipoPrueba");
            var norma              = id("norma");
            var inputArchivo       = id('normaFile');
            var idNomina           = id("idUsuario");
            var tipoPruebaEspecial = id("tipoPruebaEspecial");
            var otroPrueba         = id("otroPrueba");
            var especificaciones   = id ("especificaciones");

            var fechaSolicitud= new Date();
            var fechaFormateada = fechaSolicitud.getFullYear() + '-' + (fechaSolicitud.getMonth() + 1) + '-' + fechaSolicitud.getDate();

            dataForm.append('tipoPrueba', tipoPrueba.value.trim());
            dataForm.append('norma', norma.value.trim());
            dataForm.append('normaFile', inputArchivo.files[0]);
            dataForm.append('idUsuario', idNomina.value.trim());
            dataForm.append('tipoPruebaEspecial', tipoPruebaEspecial.value.trim());
            dataForm.append('otroPrueba', otroPrueba.value.trim());
            dataForm.append('especificaciones', especificaciones.value.trim());
            dataForm.append('fechaSolicitud', fechaFormateada);
            dataForm.append('id_prueba', id_prueba);

            var materiales = [];
            var cantidades = [];

            alert("otroPrueba ="+otroPrueba.value.trim());

            for (var k = 1; k <= i; k++) {
                // Para agregar material por número de parte
                var descMaterial       = id('descMaterial' + k);
                var cdadMaterial       = id('cdadMaterial' + k);

                // Añadimos los valores a los arrays correspondientes
                materiales.push(descMaterial.value.trim());
                cantidades.push(cdadMaterial.value.trim());
            }
            // Agregamos los arrays al FormData
            dataForm.append('materiales', materiales.join(', '));
            dataForm.append('cantidades', cantidades.join(', '));

            //alert("Materiales son: " + materiales + "\nCantidades con: " + cantidades );

            //alert("../../dao/requestRegister.php/?tipoPrueba="+tipoPrueba.value+"&tipoPruebaEspecial="+tipoPruebaEspecial.value+"&otroEspecial="+otroPrueba.value+"&norma="+norma.value+"&normaFile="+normaFile.value+"&idNomina="+idNomina.value+"&especificaciones="+especificaciones.value+"&numParte="+numParte.value+"&descMaterial="+descMaterial.value+"&cdadMaterial="+cdadMaterial+"&fechaSolicitud="+fechaFormateada+"&id_prueba="+id_prueba);

            fetch('../../dao/requestRegister.php', {
                method: 'POST',
                body: dataForm
            })
                .then(function (response) {
                    if (response.ok) { //respuesta
                        enviarCorreoNuevaSolicitud(id_prueba, idNomina, emailUsuario);
                        resumenPrueba(id_prueba);
                        //window.location.href = "../requests/requestsIndex.php";
                        //setTimeout(function(){ window.location.href = '../requests/requestsIndex.php'; }, 10000);
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

        } catch (error) {
            console.error("Error al registrar la solicitud:", error);
        }
}
function enviarCorreoNuevaSolicitud(id_prueba, id_solicitante, emailUsuario){
    const data = new FormData();

    data.append('id_prueba',id_prueba);
    data.append('id_solicitante',id_solicitante);
    data.append('emailUsuario',emailUsuario);

    fetch('https://arketipo.mx/MailerSolicitudPrueba.php',{
        method: 'POST',
        body: data
    })
        .then(function (response){
            if (response.ok){
                console.log("Correos enviados");
            }else{
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