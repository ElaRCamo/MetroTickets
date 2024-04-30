function  updatePruebaAdmin(id_review, id_user){

    var estatusPruebaAdmin = id("estatusPruebaAdmin");
    var prioridadPruebaAdmin = id("prioridadPruebaAdmin");
    var metrologoAdmin = id("metrologoAdmin");
    var observacionesAdmin = id("observacionesAdmin");
    var resultadosAdmin = id("resultadosAdmin");
    var fechaUpdate= new Date();
    var fechaFormateada = fechaUpdate.getFullYear() + '-' + (fechaUpdate.getMonth() + 1) + '-' + fechaUpdate.getDate();

    const data = new FormData();
    data.append('estatusPruebaAdmin', estatusPruebaAdmin.value.trim());
    data.append('prioridadPruebaAdmin', prioridadPruebaAdmin.value.trim());
    data.append('metrologoAdmin', metrologoAdmin.value.trim());
    data.append('observacionesAdmin', observacionesAdmin.value.trim());
    data.append('resultadosAdmin', resultadosAdmin.value.trim());
    data.append('fechaUpdate', fechaFormateada);
    data.append('id_user', id_user);
    //alert("estatusPruebaAdmin: "+estatusPruebaAdmin.value.trim() +", prioridadPruebaAdmin: "+prioridadPruebaAdmin.value.trim()+", metrologoAdmin: "+metrologoAdmin.value.trim()+", observacionesAdmin  "+observacionesAdmin.value.trim()+", resultadosAdmin : "+resultadosAdmin.value.trim()+", fechaUpdate "+ fechaFormateada);

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
                    correoActualizacionPrueba(id_review, solicitantePrueba, emailSolicitante);
                    swalWithBootstrapButtons.fire({
                        title: "¡Prueba actualizada!",
                        text: "Se han guardado los cambios.",
                        icon: "success"
                    });
                })
                .catch(error =>{
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

function updatePruebaSol(id_review){

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

    alert ("id:"+id_cliente+" desc: "+descClienteE.value.trim())

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
function activarCliente(id_cliente){
    fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoActivarCliente.php?id_cliente='+id_cliente,{
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(id_cliente)
    }).then(res => {
        TablaAdminClientesDes();
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

    alert ("id:"+id_plataforma+" desc Plata: "+descPlataformaE.value.trim()+" desc cliente: "+descPClienteE.value.trim())

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
                TablaAdminPlataformas();
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
        TablaAdminPlataformasDes();
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
    console.log("para editar: " + descripcion);

    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoConsultarUnMaterial.php?id_descripcion=' + descripcion, function (data) {
        var inputMaterial = id("descMaterialE");
        inputMaterial.value = data.data[0].descripcionMaterial;

        var inputNumParte = id("numParteE");
        inputNumParte.value = data.data[0].numeroDeParte;

        //imgActual
        id("imagenMaterialE").src = data.data[0].imgMaterial;

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

            if (data.data[j].id_cliente === cliente){
                var createOption = document.createElement("option");
                createOption.value = data.data[j].id_plataforma;
                createOption.text = data.data[j].descripcionPlataforma;
                selectS.appendChild(createOption);
                if (data.data[j].id_descripcion === descripcion) {
                    createOption.selected = true;
                }
            }

            var createOptionC = document.createElement("option");
            createOptionC.value = data.data[j].id_cliente;
            createOptionC.text = data.data[j].descripcionCliente;
            selectC.appendChild(createOptionC);
            if (data.data[j].id_plataforma === plataforma) {
                createOptionC.selected = true;
            }
        }

    });

    var btnActualizarMaterial = document.getElementById('btn-updMaterial');
    if (btnActualizarMaterial) { // Verifica que el botón exista en el DOM
        btnActualizarMaterial.onclick = function() {
            actualizarMaterial(id_descripcion);
        };
    }

}
function actualizarMaterial(id_descripcion){
    console.log("ACTUALIZAR: " + id_descripcion);

    var descMaterialE = id("descMaterialE");
    var numParteE = id("numParteE");
    var imgMaterialE = id("imgMaterialE");
    var descMPlataformaE = id("descMPlataformaE");

    const dataForm = new FormData();
    dataForm.append('id_descripcion', id_descripcion);
    dataForm.append('descMaterialE', descMaterialE.value.trim());
    dataForm.append('numParteE', numParteE.value.trim());

    // Validar la imagen antes de adjuntarla al FormData
    if (imgMaterialE.files.length > 0) {
        validarImagen(imgMaterialE.files[0]);
        dataForm.append('imgMaterialE', imgMaterialE.files[0]);
    } else {
        throw "Por favor seleccione una imagen";
    }

    dataForm.append('descMPlataformaE', descMPlataformaE.value.trim());
    console.log("DataForm paara actualizar:", dataForm);

    fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoActualizarMaterial.php', {
        method: 'POST',
        body: dataForm
    }).then(function (response) {
        if (response.ok) { //respuesta
            Swal.fire({
                icon: "success",
                title: "¡Material actualizado con éxito!",
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
function activarMaterial(id_descripcion){
    fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoActivarMaterial.php?id_descripcion='+id_descripcion,{
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(id_descripcion)
    }).then(res => {
        TablaAdminMaterialesDes();
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

    alert ("id:"+id_usuario+" tipoDeUsuarioE: "+tipoDeUsuarioE.value.trim())

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
                TablaAdminUsuarios();
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
        TablaAdminUsuariosDes();
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