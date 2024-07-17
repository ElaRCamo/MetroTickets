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


