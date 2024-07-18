function registrarUsuario() {
    var inputsValidos = validarFormulario() && validarCorreo('correo','aviso') && validarPasswords('password','password2','aviso');

    if (inputsValidos) {
        var nombreUsuario = id("nombreUsuario");
        var correo        = id("correo");
        var numNomina     = id("numNomina");
        var password      = id("password");

        const data = new FormData();

        data.append('nombreUsuario', nombreUsuario.value.trim());
        data.append('correo', correo.value.trim());
        data.append('numNomina', numNomina.value.trim());
        data.append('password', password.value.trim());

        //alert('nombreUsuario: '+nombreUsuario.value.trim()+' correo: '+correo.value.trim()+' numNomina: '+numNomina.value.trim()+' password: '+ password.value.trim());

        fetch('../../dao/userRegister.php', {
            method: 'POST',
            body: data
        })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(error => {
                        throw new Error(error.message);
                    });
                    // throw new Error('Hubo un problema al registrar el usuario. Por favor, intenta de nuevo más tarde.');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    //console.log(data.message);
                    Swal.fire({
                        title: "¡Usuario registrado exitosamente!",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            enviarCorreoNuevoUsuario(nombreUsuario.value.trim(), numNomina.value.trim(), correo.value.trim());
                            window.location.href = "../sesion/indexSesion.php";
                        }
                    });
                }else if (data.status === 'error') {
                    console.log(data.message);
                    Swal.fire({
                        title: "Error",
                        text: data.message,
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            }).catch(error => {
            //console.error(error);
            Swal.fire({
                title: "Error",
                text: error.message,
                icon: "error",
                confirmButtonText: "OK"
            });
        });
    }else{
        Swal.fire({
            title: "Datos incorrectos",
            text: "Revise su información",
            icon: "error"

        });
    }
}
function enviarCorreoNuevoUsuario(nombre, id, correo){
    const data = new FormData();

    data.append('nombre',nombre);
    data.append('id',id);
    data.append('correo',correo);

    fetch('https://arketipo.mx/MailerNuevoUsuario.php',{
        method: 'POST',
        body: data
    })
        .then(function (response){
            if (!response.ok){
                throw "Error en la llamada Ajax";
            }
        })
        .catch(function (error) {
            //console.log(err);
            Swal.fire({
                title: "Error",
                text: error.message,
                icon: "error",
                confirmButtonText: "OK"
            });
        });
}
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


function recuperarPassword() {
    var esCorreoValido = validarCorreo('correoRecuperacion','avisoR');

    if (esCorreoValido) {
        var correoRecuperacion = id("correoRecuperacion");

        const data = new FormData();
        data.append('correoRecuperacion', correoRecuperacion.value.trim());

        fetch('../../dao/daoRecuperacionPassword.php', {
            method: 'POST',
            body: data
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Hubo un problema al recuperar la contraseña. Por favor, intenta de nuevo más tarde.');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    console.log(data.message);
                    Swal.fire({
                        title: "Solicitud exitosa",
                        text: "Hemos enviado un correo electrónico a "  + correoRecuperacion.value +" para restablecer tu contraseña.",
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
            })
            .catch(error => {
                //console.error(error);
                Swal.fire({
                    title: "Error",
                    text: "Hubo un problema al procesar tu solicitud. Por favor, intenta de nuevo más tarde.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            });
    } else {
        Swal.fire({
            title: "Correo no válido",
            text: "Revise su información",
            icon: "error"
        });
    }
}

