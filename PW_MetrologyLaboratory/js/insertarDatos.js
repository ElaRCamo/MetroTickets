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


function showResult(result) {
    // Código para manejar el resultado exitoso
    console.log('Result: ', result);
}

function showError(error) {
    // Código para manejar el error98ik
    console.error('Error: ', error);
}


