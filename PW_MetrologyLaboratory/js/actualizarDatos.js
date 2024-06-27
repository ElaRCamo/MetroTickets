function actualizarPassword(){
    var passwordValida =  validarPasswords('passwordR','passwordR2','avisoRestablecer');

    if(passwordValida) {
        var queryString = window.location.search; // Obtener la cadena de consulta de la URL actual
        var searchParams = new URLSearchParams(queryString); // Crear un nuevo objeto URLSearchParams con la cadena de consulta
        var id_usuario = searchParams.get('id');
        var token = searchParams.get('token');

        // console.log('Token:', token , ' usuario:', id_usuario);
        if (token && id_usuario) {

            var newPassword = id("passwordR");
            const data = new FormData;
            data.append('newPassword', newPassword.value.trim());
            data.append('token', token);
            data.append('id_usuario', id_usuario);

            console.log('Token:', token , ' usuario:', id_usuario);

            fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoRestablecerPassword.php',{
                method: 'POST',
                body: data
            }).then(res => {
                if(!res.ok){
                    throw new Error('Hubo un problema al actualizar la contraseña. Por favor, intenta de nuevo más tarde.');
                }
                return res.json();
            }).then(data => {
                if (data.status === 'success') {
                    console.log(data.message);
                    Swal.fire({
                        title: "Contraseña actualizada",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "../sesion/indexSesion.php";
                        }
                    });
                } else if (data.status === 'error') {
                    console.log(data.message);
                    Swal.fire({
                        title: "Error",
                        text: data.message,
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            }).catch(error =>{
                console.log(error);
                Swal.fire({
                    title: "Error",
                    text: error,
                    icon: "error"
                });
            });
        } else {
            Swal.fire({
                title: "Enlace no válido",
                icon: "error"
            });
        }
    }else{
        Swal.fire({
            title:"Datos incorrectos",
            text: "Revise su información",
            icon: "error"

        });
    }
}

function updateLinkActualizar(id, estatus) {
    if(tipoUser === '3'){
        var link = document.getElementById('updateBtnS');

        if (link) {
            if (id === '5' || id === '7') {
                link.setAttribute('onclick', 'updatePrueba();');
                link.style.pointerEvents = 'auto';
                link.style.cursor = 'pointer';
            } else {
                // Cambia el texto del enlace
                link.innerHTML = '<i class="lar la-lightbulb"></i>Estatus: ' + estatus + '<br>(No es posible actualizar)';
                link.removeAttribute('onclick');
                link.removeAttribute('href');
                link.style.pointerEvents = 'none';
                link.style.cursor = 'default';
            }
        }
    }
}

function  updatePruebaAdmin(id_review, id_user){

    var estatusPruebaAdmin = id("estatusPruebaAdmin");
    var prioridadPruebaAdmin = id("prioridadPruebaAdmin");
    var metrologoAdmin = id("metrologoAdmin");
    var observacionesAdmin = id("observacionesAdmin");
    var fechaCompromiso = id("iFechaCompromiso");
    var fechaUpdate= new Date();
    var fechaFormateada = fechaUpdate.getFullYear() + '-' + (fechaUpdate.getMonth() + 1) + '-' + fechaUpdate.getDate();
    var resultados = capturarResultados(estatusPruebaAdmin);
    const data = new FormData();

    data.append('resultadosAdmin', resultados);
    data.append('estatusPruebaAdmin', estatusPruebaAdmin.value.trim());
    data.append('prioridadPruebaAdmin', prioridadPruebaAdmin.value.trim());
    data.append('metrologoAdmin', metrologoAdmin.value.trim());
    data.append('observacionesAdmin', observacionesAdmin.value.trim());
    data.append('fechaUpdate', fechaFormateada);
    data.append('id_user', id_user);

    if(estatusPruebaAdmin.value==='2'){
        data.append('fechaCompromiso', fechaCompromiso.value.trim());
    }
    alert("fechaCompromiso " + fechaCompromiso.value.trim()+"estatusPruebaAdmin: "+estatusPruebaAdmin.value.trim() +", prioridadPruebaAdmin: "+prioridadPruebaAdmin.value.trim()+", metrologoAdmin: "+metrologoAdmin.value.trim()+", observacionesAdmin  "+observacionesAdmin.value.trim()+", resultadosAdmin : "+resultados+", fechaUpdate "+ fechaFormateada);


    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: "¿Confirmar cambios?",
        text: "Se actualizará la información de la prueba y se notificará al solicitante.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "¡Sí, confirmar!",
        cancelButtonText: "¡No, cancelar!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoActualizarPruebaAdmin.php?id_prueba='+id_review,{
                method: 'POST',
                body: data
            }).then(res => {
                resumenPrueba(id_review);
                if(!res.ok){
                    console.log('Problem');
                    return;
                }
                return res.json();
            })
                .then(data => {
                    console.log('Success');
                    swalWithBootstrapButtons.fire({
                        title: "¡Prueba actualizada!",
                        text: "Se han guardado los cambios.",
                        icon: "success"
                    });
                }).then(function (){
                    correoActualizacionPrueba(estatusPruebaAdmin.value,id_review, solicitantePrueba, emailSolicitante);
                }).then(function (){
                    correoActualizacionPruebaLab(id_review);
            }).catch(error =>{
                    console.log(error);
                });
        } else if (
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire({
                title: "Cancelado",
                text: "Cambios no guardados.",
                icon: "error"
            });
        }
    });
}

function capturarResultados(estatusPruebaAdmin){

    var divInputsResultados = id("divCambiarResultados");
    const rutaRadio = document.getElementById('rutaRadio');
    const archivoRadio = document.getElementById('archivoRadio');
    const enlaceResultados = document.getElementById('resultadosGuardados');
    var resultados = "Sin resultados";

    //Validar estatus de la prueba
    if (estatusPruebaAdmin.value === '4' && divInputsResultados !== null && divInputsResultados.offsetParent !== null ){ //Estatus completado(hay resultados)
        const resultadosAdminRuta = document.getElementById('resultadosAdminRuta');
        const resultadosAdminArchivo = document.getElementById('resultadosAdminArchivo');
        if (rutaRadio.checked && resultadosAdminRuta !== null && resultadosAdminRuta.value !== '') {
            resultados = resultadosAdminRuta.value.trim();
        }else if (archivoRadio.checked && resultadosAdminArchivo !== null && resultadosAdminArchivo.value !== '') {
            resultados = resultadosAdminArchivo.files[0];
        }
    }else if(enlaceResultados !== null) {
        if (rutaRadio.checked) {
            resultados = enlaceResultados.textContent;
        }else if(archivoRadio.checked) {
            resultados = enlaceResultados.href;
        }
    }
    return resultados;
}
function actualizarSolicitud(){
    const dataForm = new FormData();

    var idNomina           = id("idUsuario");
    var tipoPrueba         = id("tipoPrueba");
    var especificaciones   = id ("especificaciones");
    var fechaSolicitud    = new Date();
    var fechaFormateada  = fechaSolicitud.getFullYear() + '-' + (fechaSolicitud.getMonth() + 1) + '-' + fechaSolicitud.getDate();

    dataForm.append('id_prueba', id_update);
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
            //alert("otroPrueba con tipoPruebaEspecial= 4 :"+otroPrueba.value.trim());
        }else{
            otroPrueba = "No aplica";
            dataForm.append('otroPrueba con tipoPruebaEspecial :', otroPrueba);
            //alert("otroPrueba ="+otroPrueba);
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
    //alert(formDataString);

    fetch('../../dao/daoActualizacionRequest.php', {
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
                })
            });
        })
        .then(function(data) {
            resumenSolicitud(id_update);
        }).then(function(data) {
            // Si la inserción de datos fue exitosa, llamar a las funciones
            correoActualizacionPrueba(5,id_update, solicitante, emailUsuario);
            correoActualizacionPruebaLab(id_update);
        })
        .catch(function(error) {
            if (error instanceof TypeError && error.message.includes('Error')) {
                console.error('Error en el procesamiento de datos:', error);
            } else {
                console.error('Error al insertar datos:', error);
            }
        });
}


function editarCliente(id_cliente){

    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoConsultarUnCliente.php?id_cliente=' + id_cliente, function (data) {
        var inputCliente = id("descClienteE");
        inputCliente.value = data.data[0].descripcionCliente;
    });

    var btnActualizarCliente = document.getElementById('btn-updCliente');
    if (btnActualizarCliente) { // Verifica que el botón exista en el DOM
        btnActualizarCliente.onclick = function () {
            actualizarCliente(id_cliente);
        };
    }
}

function actualizarCliente(id_cliente){
    console.log("id_cliente para editar: " + id_cliente);
    var descClienteE= id("descClienteE");
    const data = new FormData();
    data.append('id_cliente',id_cliente);
    data.append('descClienteE',descClienteE.value.trim());

    //alert ("id:"+id_cliente+" desc: "+descClienteE.value.trim())

    fetch('../../dao/daoActualizarCliente.php', {
        method: 'POST',
        body: data
    })
        .then(function (response) {
            if (response.ok) { //respuesta
                Swal.fire({
                    title: "¡Cliente actualizado exitosamente!",
                    icon: "success"
                });
                initDataTableClientes();
                initDataTablePlataformas();
                initDataTableMateriales();
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
function activarCliente(id_cliente){
    fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoActivarCliente.php?id_cliente='+id_cliente,{
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(id_cliente)
    }).then(res => {
        initDataTableClientesDes();
        initDataTablePlataformasDes();
        initDataTableMaterialesDes();
        if(!res.ok){
            console.log('Problem');
            return;
        }
        return res.json();
    })
        .then(data => {
            Swal.fire("¡Cliente activado!");
        })
        .catch(error =>{
            console.log(error);
        });
}

function editarPlataforma(id_plataforma){
    console.log("id_plataforma para editar: " + id_plataforma);
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoConsultarUnaPlataforma.php?id_plataforma=' + id_plataforma, function (data) {
        var inputPlataforma = id("descPlataformaE");
        inputPlataforma.value = data.data[0].descripcionPlataforma;

        var selectS = id("descPClienteE");
        selectS.innerHTML = ""; //limpiar contenido

        for (var j = 0; j < data.data.length; j++) {
            var createOption = document.createElement("option");
            createOption.value = data.data[j].id_cliente;
            createOption.text = data.data[j].descripcionCliente;
            selectS.appendChild(createOption);
            if (data.data[j].id_plataforma === id_plataforma) {
                createOption.selected = true;
            }
        }
    });

    var btnActualizarPlataforma = document.getElementById('btn-updPlataforma');
    if (btnActualizarPlataforma) { // Verifica que el botón exista en el DOM
        btnActualizarPlataforma.onclick = function() {
            actualizarPlataforma(id_plataforma);
        };
    }
}
function  actualizarPlataforma(id_plataforma){
    console.log("id_plataforma para actualizar: " + id_plataforma);

    var descPlataformaE= id("descPlataformaE");
    var descPClienteE= id("descPClienteE");

    const data = new FormData();
    data.append('id_plataforma',id_plataforma);
    data.append('descPlataformaE',descPlataformaE.value.trim());
    data.append('descPClienteE',descPClienteE.value.trim());

    //alert ("id:"+id_plataforma+" desc Plata: "+descPlataformaE.value.trim()+" desc cliente: "+descPClienteE.value.trim())

    fetch('../../dao/daoActualizarPlataforma.php', {
        method: 'POST',
        body: data
    })
        .then(function (response) {
            if (response.ok) { //respuesta
                Swal.fire({
                    title: "¡Plataforma actualizada exitosamente!",
                    icon: "success"
                });
                initDataTablePlataformas();
                initDataTableMateriales();
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
function activarPlataforma(id_plataforma){
    fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoActivarPlataforma.php?id_plataforma='+id_plataforma,{
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(id_plataforma)
    }).then(res => {
        initDataTablePlataformasDes();
        initDataTableMaterialesDes();
        if(!res.ok){
            console.log('Problem');
            return;
        }
        return res.json();
    })
        .then(data => {
            Swal.fire("¡Plataforma activada!");
        })
        .catch(error =>{
            console.log(error);
        });
}


function editarMaterial(descripcion){
    //console.log("para editar: " + descripcion);
    let opcionesClientes= [];

    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoConsultarUnMaterial.php?id_descripcion=' + descripcion, function (data) {
        var inputMaterial = id("descMaterialE");
        inputMaterial.value = data.data[0].descripcionMaterial;

        var inputNumParte = id("numParteE");
        inputNumParte.value = data.data[0].numeroDeParte;

        //imgActual
        id("imagenActual").src = data.data[0].imgMaterial;

        var selectS = id("descMPlataformaE");
        selectS.innerHTML = ""; //limpiar contenido

        var selectC = id("descMClienteE");
        selectC.innerHTML = ""; //limpiar contenido

        let plataforma, cliente;

        for (var j = 0; j < data.data.length; j++) {
            if (data.data[j].id_descripcion === descripcion) {
                plataforma = data.data[j].id_plataforma;
                cliente = data.data[j].id_cliente;
            }

            //Solo se generan las plataformas que pertenezcan al mismo cliente que ya esta preseleccionado
            if (data.data[j].id_cliente === cliente){
                var createOption = document.createElement("option");
                createOption.value = data.data[j].id_plataforma;
                createOption.text = data.data[j].descripcionPlataforma;
                selectS.appendChild(createOption);
                if (data.data[j].id_descripcion === descripcion) {
                    createOption.selected = true;
                }
            }
        //Si el cliente no tiene asignada una plataforma, no saldra en el listado, ya que tampoco se podra asignar material.
            var createOptionC = document.createElement("option");
            createOptionC.value = data.data[j].id_cliente;
            createOptionC.text = data.data[j].descripcionCliente;

            if( !opcionesClientes.includes(createOptionC.value)){
                selectC.appendChild(createOptionC);
                opcionesClientes.push(createOptionC.value);
                if (data.data[j].id_plataforma === plataforma) {
                    createOptionC.selected = true;
                }
            }
        }
        //alert(opcionesClientes);
    });
    var btnActualizarMaterial = document.getElementById('btn-updMaterial');
    if (btnActualizarMaterial) { // Verifica que el botón exista en el DOM
        btnActualizarMaterial.onclick = function() {
            actualizarMaterial(descripcion);
        };
    }

}


function actualizarMaterial(id_descripcion){
    //console.log("ACTUALIZAR: " + id_descripcion);

    var descMaterialE = id("descMaterialE");
    var numParteE = id("numParteE");
    var imgMaterialE = id("imgMaterialE");
    var descMPlataformaE = id("descMPlataformaE");
    var imagenActualSrc = id('imagenActual').src;

    const dataForm = new FormData();
    dataForm.append('id_descripcion', id_descripcion);
    dataForm.append('descMaterialE', descMaterialE.value.trim());
    dataForm.append('numParteE', numParteE.value.trim());


    // Validar la imagen antes de adjuntarla al FormData
    if (imgMaterialE.files.length > 0) {
        validarImagen(imgMaterialE.files[0]);
        dataForm.append('imgMaterialE', imgMaterialE.files[0]);
    } else {
        dataForm.append('imagenActual', imagenActualSrc);
    }

    dataForm.append('descMPlataformaE', descMPlataformaE.value.trim());

    //console.log("DataForm paara actualizar:", dataForm);

    fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoActualizarMaterial.php', {
        method: 'POST',
        body: dataForm
    }).then(response => {
        if (!response.ok) {
            throw new Error('Hubo un problema al actualizar el material. Por favor, intenta de nuevo más tarde.');
        }
        return response.json();
    }) .then(data => {
        if (data.status === 'success') {
            console.log(data.message);
            Swal.fire({
                title: "¡Material actualizado con éxito!",
                icon: "success",
                confirmButtonText: "OK"
            })
        } else {
            throw new Error('Hubo un problema al actualizar el material. Por favor, intenta de nuevo más tarde.');
        }
    }).then(function () {
        initDataTableMateriales();
    }).catch(error => {
        console.error(error);
        Swal.fire({
            title: "Error",
            text: error.message,
            icon: "error",
            confirmButtonText: "OK"
        });
    });
}
function activarMaterial(id_descripcion){
    fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/  dao/daoActivarMaterial.php?id_descripcion='+id_descripcion,{
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(id_descripcion)
    }).then(res => {
        initDataTableMaterialesDes();
        if(!res.ok){
            console.log('Problem');
            return;
        }
        return res.json();
    })
        .then(data => {
            Swal.fire("¡Material activado!");
        })
        .catch(error =>{
            console.log(error);
        });
}

function editarUsuario(id_usuario){
    console.log("id_usuario para editar: " + id_usuario);


    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoConsultarUnUsuario.php?id_usuario=' + id_usuario, function (data) {
        var inputNombre = id("nombreUsuarioE");
        inputNombre.value = data.data[0].nombreUsuario;

        var inputCorreo = id("correoE");
        inputCorreo.value = data.data[0].correoElectronico;

        //imgActual
        id("fotoUsuarioE").src = data.data[0].foto;

        var selectS = id("tipoDeUsuarioE");
        selectS.innerHTML = ""; //limpiar contenido

        for (var j = 0; j < data.data.length; j++) {
            var createOption = document.createElement("option");
            createOption.value = data.data[j].id_tipoUsuario;
            createOption.text = data.data[j].descripcionTipo;
            selectS.appendChild(createOption);
            if (data.data[j].id_usuario === id_usuario) {
                createOption.selected = true;
            }
        }
    });

    var btnActualizarUsuario = document.getElementById('btn-updUsuario');
    if (btnActualizarUsuario) { // Verifica que el botón exista en el DOM
        btnActualizarUsuario.onclick = function() {
            actualizarUsuario(id_usuario);
        };
    }
}
function actualizarUsuario(id_usuario){
    console.log("actualizar user: " + id_usuario);

    var tipoDeUsuarioE= id("tipoDeUsuarioE");
    const data = new FormData();
    data.append('id_usuario',id_usuario);
    data.append('tipoDeUsuarioE',tipoDeUsuarioE.value.trim());

    //alert ("id:"+id_usuario+" tipoDeUsuarioE: "+tipoDeUsuarioE.value.trim())

    fetch('../../dao/daoActualizarUsuario.php', {
        method: 'POST',
        body: data
    })
        .then(function (response) {
            if (response.ok) { //respuesta
                Swal.fire({
                    title: "¡Usuario actualizado exitosamente!",
                    icon: "success"
                });
                initDataTableUsuarios();
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
function activarUsuario(id_usuario){
    fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoActivarUsuario.php?id_usuario='+id_usuario,{
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(id_usuario)
    }).then(res => {
        initDataTableUsuariosDes();
        if(!res.ok){
            console.log('Problem');
            return;
        }
        return res.json();
    })
        .then(data => {
            Swal.fire("¡Perfil de usuario activado!");
        })
        .catch(error =>{
            console.log(error);
        });
}

function cargarPerfilUsuario(){
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoConsultarPerfilUsuario.php', function (data) {
        var inputNombre = id("nombrePU");
        inputNombre.value = data.data[0].nombreUsuario;

        var inputCorreo = id("correoPU");
        inputCorreo.value = data.data[0].correoElectronico;

        var inputNomina = id("nominaPU");
        inputNomina.value = data.data[0].id_usuario;

        var inputPassword = id("passwordPU");
        inputPassword.value = data.data[0].passwordHash;

        //imgActual
        id("imgActualUsuario").src = data.data[0].foto;
    });

    var btnActualizarUsuario = document.getElementById('btn-updPerfil');
    if (btnActualizarUsuario) { // Verifica que el botón exista en el DOM
        btnActualizarUsuario.onclick = function() {
            updatePerfilUsuario();
        };
    }
}
function updatePerfilUsuario(){

    var inputFoto= id("fotoPerfilU");
    var inputPassword= id("passwordPU");
    var imagenActualSrc = id('imgActualUsuario').src;

    const data = new FormData();
    data.append('inputPassword',inputPassword.value.trim());

    // Validar la imagen antes de adjuntarla al FormData
    if (inputFoto.files.length > 0) {
        //validarImagen(inputFoto.files[0]);
        data.append('fotoPerfil', inputFoto.files[0]);
        alert("inputFoto");
    } else {
        data.append('fotoPerfil', imagenActualSrc);
        alert("imagenActualSrc: "+imagenActualSrc);
    }

    fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoActualizarPerfil.php', {
        method: 'POST',
        body: data
    }).then(respuesta => {
        if (!respuesta.ok) {
            throw new Error('Hubo un problema al actualizar el perfil. Por favor, intenta de nuevo más tarde.');
        }
        return respuesta.json();
    }) .then(data => {
        if (data.status === 'success') {
            console.log(data.message);
            Swal.fire({
                title: "¡Perfil actualizado con éxito!",
                icon: "success",
                confirmButtonText: "OK"
            })
        } else {
            throw new Error('Hubo un problema al actualizar el perfil. Por favor, intenta de nuevo más tarde.');
        }
    }).catch(error => {
        console.error(error);
        Swal.fire({
            title: "Error",
            text: error.message,
            icon: "error",
            confirmButtonText: "OK"
        });
    });
}