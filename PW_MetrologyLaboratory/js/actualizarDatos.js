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



function cargarPerfilUsuario(){
    $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoConsultarPerfilUsuario.php', function (data) {
        var inputNombre = id("nombrePU");
        inputNombre.value = data.data[0].nombreUsuario;

        var inputCorreo = id("correoPU");
        inputCorreo.value = data.data[0].correoElectronico;

        var inputNomina = id("nominaPU");
        inputNomina.value = data.data[0].id_usuario;

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
    var imagenActualSrc = id('imgActualUsuario').src;

    const data = new FormData();

    // Validar la imagen antes de adjuntarla al FormData
    if (inputFoto.files.length > 0) {
        //validarImagen(inputFoto.files[0]);
        data.append('fotoPerfil', inputFoto.files[0]);
    } else {
        data.append('fotoPerfil', imagenActualSrc);
    }

    fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoActualizarPerfil.php', {
        method: 'POST',
        body: data
    }).then(response => {
        if (!response.ok) {
            throw new Error('Hubo un problema al actualizar el perfil. Por favor, intenta de nuevo más tarde.');
        }
        return response.json();
    }) .then(data => {
        if (data.status === 'success') {
            console.log(data.message);
            Swal.fire({
                title: "¡Perfil actualizado con éxito!",
                icon: "success",
                confirmButtonText: "OK"
            })
            const nuevaUrlFoto = data.fotoUsuario;
            // Actualizar la imagen en el DOM
            document.querySelector('.user-img').src = nuevaUrlFoto + '?' + new Date().getTime();
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