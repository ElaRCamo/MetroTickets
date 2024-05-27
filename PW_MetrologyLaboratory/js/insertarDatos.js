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

function validacionSolicitud() {
    const id_pruebaPromise      = obtenerNuevoId(); // Obtener el nuevo ID de forma asíncrona
    const sesionIniciadaPromise = validarSesion(); // Validar la sesión de forma asíncrona

    Promise.all([id_pruebaPromise, sesionIniciadaPromise])
        .then(respuestas => {
            const id_prueba      = respuestas[0];
            const sesionIniciada = respuestas[1];

            if (sesionIniciada && id_prueba !== null && id_prueba !== undefined) {
                alert("Se ejecuta registrarSolicitud "+id_prueba)
                registrarSolicitud(id_prueba);
            } else if(sesionIniciada === false) {
                // Si la sesión no está iniciada, mostrar un mensaje de error
                Swal.fire("¡La sesión no está iniciada!");
            }
        })
        .catch(error => {
            Swal.fire("¡Error al validar la solicitud!");
        });
}
function showResult(result) {
    // Código para manejar el resultado exitoso
    console.log('Result: ', result);
}

function showError(error) {
    // Código para manejar el error
    console.error('Error: ', error);
}

function registrarSolicitud(nuevoId) {

        const dataForm = new FormData();

        var idNomina           = id("idUsuario");
        var tipoPrueba         = id("tipoPrueba");
        var especificaciones   = id ("especificaciones");
        var fechaSolicitud    = new Date();
        var fechaFormateada  = fechaSolicitud.getFullYear() + '-' + (fechaSolicitud.getMonth() + 1) + '-' + fechaSolicitud.getDate();

        dataForm.append('id_prueba', nuevoId);
        dataForm.append('fechaSolicitud', fechaFormateada);
        dataForm.append('tipoPrueba', tipoPrueba.value.trim());
        dataForm.append('idUsuario', idNomina.value.trim());
        dataForm.append('especificaciones', especificaciones.value.trim());

        var tipoPruebaEspecial, otroPrueba, norma, inputArchivo;
        if(tipoPrueba && tipoPrueba.value === '5'){
            norma             = id("norma");
            inputArchivo      = id('normaFile');
            dataForm.append('norma', norma.value.trim());
            dataForm.append('normaFile', inputArchivo.files[0]);

            tipoPruebaEspecial = id("tipoPruebaEspecial");
            dataForm.append('tipoPruebaEspecial', tipoPruebaEspecial.value.trim());

            if(tipoPruebaEspecial && tipoPruebaEspecial.value === '4'){
                otroPrueba = id("otroPrueba");
                dataForm.append('otroPrueba', otroPrueba.value.trim());
                alert("otroPrueba con tipoPruebaEspecial= 4 :"+otroPrueba.value.trim());
            }else{
                otroPrueba = "No aplica";
                dataForm.append('otroPrueba con tipoPruebaEspecial :', otroPrueba);
                alert("otroPrueba ="+otroPrueba);
            }
        }else if((tipoPrueba && tipoPrueba.value === '4') || (tipoPrueba && tipoPrueba.value === '3')){
            norma             = id("norma");
            inputArchivo      = id('normaFile');
            dataForm.append('norma', norma.value.trim());
            dataForm.append('normaFile', inputArchivo.files[0]);
        }else{
            tipoPruebaEspecial = 5;
            norma              = "No aplica";
            inputArchivo       = "No aplica";
            dataForm.append('norma', norma);
            dataForm.append('normaFile', inputArchivo);
            dataForm.append('tipoPruebaEspecial', tipoPruebaEspecial);
        }

        var materiales = [];
        var cantidades = [];

        for (var k = 1; k <= indexMaterial; k++) {
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
        let formDataString = "FormData: \n";
        for (let pair of dataForm.entries()) {
            formDataString += pair[0]+ ', ' + pair[1] + '\n';
        }
        alert(formDataString);

    fetch('../../dao/requestRegister.php', {
        method: 'POST',
        body: dataForm
    })
        .then(function(response) {
            console.log('response.ok: ', response.ok);
            if (response.ok) {
                return response.text().then(showResult);
            } else {
                showError('status code: ' + response.status);
                throw new Error('Error en la solicitud: ' + response.status);
            }
        })
        .then(function(data) {
            // Retraso de tiempo de 1 segundo antes de ejecutar más acciones
            return new Promise(function(resolve, reject) {
                setTimeout(() => {
                    let todoCorrecto = true;
                    if (todoCorrecto) {
                        resolve('Todo ha ido bien');
                    } else {
                        reject('Algo ha fallado')
                    }
                }, 9000)
            });
        })
        .then(function(data) {
            resumenSolicitud(nuevoId);
        }).then(function(data) {
            // Si la inserción de datos fue exitosa, llamar a las funciones
            enviarCorreoNuevaSolicitud(nuevoId, solicitante, emailUsuario);
        }).catch(function(error) {
            if (error instanceof TypeError && error.message.includes('Error')) {
                console.error('Error en el procesamiento de datos:', error);
            } else {
                console.error('Error al insertar datos:', error);
            }
        });
}


/*
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

            for (var k = 1; k <= indexMaterial; k++) {
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
                        enviarCorreoNuevaSolicitud(id_prueba, solicitante, emailUsuario);
                        resumenSolicitud(id_prueba);
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
}*/
function enviarCorreoNuevaSolicitud(id_prueba, solicitante, emailUsuario){
    const data = new FormData();

    data.append('id_prueba',id_prueba);
    data.append('solicitante',solicitante);
    data.append('emailUsuario',emailUsuario);

    fetch('https://arketipo.mx/MailerSolicitudPruebaS.php',{
        method: 'POST',
        body: data
    })
        .then(function (response){
            if (response.ok){
                //alert('Correo Solicitante: prueba: ' +id_prueba+ 'user: ' + solicitante +' email: ' + emailUsuario);
                enviarCorreoNuevaSolicitudLab(id_prueba, solicitante);
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

function enviarCorreoNuevaSolicitudLab(id_prueba, solicitante){
    const data = new FormData();

    data.append('id_prueba',id_prueba);
    data.append('solicitante',solicitante);

    fetch('https://arketipo.mx/MailerSolicitudPruebaLab.php',{
        method: 'POST',
        body: data
    })
        .then(function (response){
            if (response.ok){
                //alert('Correo Lab: prueba: ' +id_prueba+ 'user: ' + solicitante);
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
function validarImagen(file) {
    const allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if (!allowedExtensions.exec(file.name)) {
        throw "Solo se permiten archivos de imagen con extensiones .jpg, .jpeg, .png, o .gif";
    }

    const maxSizeInBytes = 5 * 1024 * 1024; // 10 MB
    if (file.size > maxSizeInBytes) {
        throw "El tamaño del archivo es demasiado grande. Por favor seleccione una imagen más pequeña (menos de 10 MB).";
    }
}

function registrarMaterial() {
    var descMaterialN = id("descMaterialN");
    var numParteN = id("numParteN");
    var imgMaterialN = id("imgMaterialN");
    var descMPlataformaN = id("descMPlataformaN");

    const dataForm = new FormData();
    dataForm.append('descMaterialN', descMaterialN.value.trim());
    dataForm.append('numParteN', numParteN.value.trim());

    // Validar la imagen antes de adjuntarla al FormData
    if (imgMaterialN.files.length > 0) {
        validarImagen(imgMaterialN.files[0]);
        dataForm.append('imgMaterialN', imgMaterialN.files[0]);
    } else {
        throw "Por favor seleccione una imagen";
    }

    dataForm.append('descMPlataformaN', descMPlataformaN.value.trim());
    //console.log("DataForm enviado:", dataForm);

    fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoNuevoMaterial.php', {
        method: 'POST',
        body: dataForm
    }).then(function (response) {
        if (response.ok) { //respuesta
            Swal.fire({
                icon: "success",
                title: "¡Material guardado con éxito!",
                showConfirmButton: true
            });
            TablaAdminMateriales();
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

function registrarCliente(){
    var descClienteN= id("descClienteN");
    const dataForm = new FormData();
    dataForm.append('descClienteN', descClienteN.value.trim());

    fetch('../../dao/daoNuevoCliente.php', {
        method: 'POST',
        body: dataForm
    })
        .then(function (response) {
            if (response.ok) { //respuesta
                Swal.fire({
                    title: "¡Cliente agregado exitosamente!",
                    icon: "success"
                });
                TablaAdminClientes();
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

function registrarPlataforma(){
    var descPlataformaN= id("descPlataformaN");
    var descPClienteN =  id("descPClienteN");
    const dataForm = new FormData();
    dataForm.append('descPlataformaN', descPlataformaN.value.trim());
    dataForm.append('descPClienteN', descPClienteN.value.trim());

    fetch('../../dao/daoNuevaPlataforma.php', {
        method: 'POST',
        body: dataForm
    }).then(function (response) {
            if (response.ok) { //respuesta
                Swal.fire({
                    title: "¡Plataforma agregada con éxito!",
                    icon: "success"
                });
                TablaAdminPlataformas();
            } else {
                throw "Error en la llamada Ajax";
            }
    }).then(function (texto) {
            console.log(texto);
    }).catch(function (err) {
            console.log(err);
    });
}

function correoActualizacionPrueba(id_prueba, solicitantePrueba, emailSolicitante){
    const data = new FormData();

    data.append('id_prueba',id_prueba);
    data.append('solicitante',solicitantePrueba);
    data.append('emailSolicitante',emailSolicitante);

    fetch('https://arketipo.mx/MailerActualizacionPrueba.php',{
        method: 'POST',
        body: data
    })
        .then(function (response){
            if (response.ok){
                alert('Correo Actualizacion: prueba: ' +id_prueba+ 'user: ' + solicitantePrueba +' email: ' + emailSolicitante);
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
function correoActualizacionPruebaLab(id_prueba){
    const data = new FormData();

    data.append('id_prueba',id_prueba);

    fetch('https://arketipo.mx/MailerActualizacionPruebaLab.php',{
        method: 'POST',
        body: data
    })
        .then(function (response){
            if (response.ok){
                //alert('Correo Actualizacion: prueba: ' +id_prueba+ 'user: ' + solicitantePrueba);
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