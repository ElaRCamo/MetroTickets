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

function idPrueba() {
    return new Promise(function(resolve, reject) {
        $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoIdSolicitud.php', function(data) {
            let idMaximo = data.data[0].max_id_prueba;
            var idMaxPartes = idMaximo.split("-");
            var anioIdMax = parseInt(idMaxPartes[0]); // Convertir a número
            var consecutivoId = idMaxPartes[1];
            var fecha = new Date();
            var anio = fecha.getFullYear();
            var nuevoId;

            if (anioIdMax === anio) {
                nuevoId = anioIdMax + "-" + (parseInt(consecutivoId) + 1).toString().padStart(4, '0');
            } else {
                nuevoId = anio + "-0001"; // Asumiendo que el consecutivo inicia en 1
            }
            resolve(nuevoId); // Resolver la promesa con el nuevo ID
        });
    });
}


function registrarSolicitud(){

    const dataForm = new FormData();

    var tipoPrueba         = id("tipoPrueba");
    var norma              = id("norma");
    var normaFile          = id("normaFile");
    var tipoPruebaEspecial = id("tipoPruebaEspecial");
    var otroPrueba         = id("otroPrueba");
    var numPiezas          = id("numPiezas");
    var especificaciones   = id ("especificaciones");

    // Para agregar material por número de parte
    var numParte           = id('numParte');
    var descMaterial       = id('descMaterial');
    var cdadMaterial       = id('cdadMaterial');

    var fechaSolicitud= new Date();
    var fechaFormateada = fechaSolicitud.getFullYear() + '-' + (fechaSolicitud.getMonth() + 1) + '-' + fechaSolicitud.getDate();



    dataForm.append('tipoPrueba', tipoPrueba.value.trim());
    dataForm.append('norma', norma.value.trim());
    dataForm.append('normaFile', normaFile.value.trim());
    //dataForm.append('tipoPruebaEspecial', tipoPruebaEspecial.value.trim());
    //dataForm.append('otroPrueba', otroPrueba.value.trim());
    //dataForm.append('numPiezas', numPiezas.value.trim());
    dataForm.append('especificaciones', especificaciones.value.trim());
    dataForm.append('numParte', numParte.value.trim());
    dataForm.append('descMaterial', descMaterial.value.trim());
    dataForm.append('cdadMaterial', cdadMaterial.value.trim());
    dataForm.append('fechaSolicitud', fechaFormateada);

    var id_prueba;
    idPrueba().then(function(nuevoId) {
        id_prueba = nuevoId;
        console.log("El nuevo ID es:", id_prueba);
        /*dataForm.append('id_prueba', id_prueba);*/
    });

    console.log("../../dao/requestRegister.php/?tipoPrueba="+tipoPrueba.value+"&norma="+norma.value+"&normaFile="+normaFile.value+"&especificaciones="+especificaciones.value+"&numParte="+numParte.value+"&descMaterial="+descMaterial.value+"&cdadMaterial="+cdadMaterial+"&fechaSolicitud="+fechaFormateada+"&id_prueba="+id_prueba);

     fetch('../../dao/requestRegister.php', {
         method: 'POST',
         body: dataForm
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