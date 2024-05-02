function desactivarCliente(id_cliente) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: "¿Estás seguro(a)?",
        text: "Todas las plataformas y materiales asociados a este cliente también se desactivarán.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "¡Sí, desactivar!",
        cancelButtonText: "¡No, cancelar!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/desactivarCliente.php?id_cliente='+id_cliente,{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(id_cliente)
            }).then(res => {
                TablaAdminClientes();
                TablaAdminMateriales();
                TablaAdminPlataformas();
                if(!res.ok){
                    console.log('Problem');
                    return;
                }
                return res.json();
            })
                .then(data => {
                    console.log('Success');
                    swalWithBootstrapButtons.fire({
                        title: "¡Desactivado!",
                        text: "El cliente ha sido desactivado.",
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
                text: "El cliente sigue activo y visible para todos.",
                icon: "error"
            });
        }
    });
}

function desactivarPlataforma(id_plataforma) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: "¿Estás seguro(a)?",
        text: "Todos los materiales asociados a esta plataforma también se desactivarán.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "¡Sí, desactivar!",
        cancelButtonText: "¡No, cancelar!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/desactivarPlataforma.php?id_plataforma='+id_plataforma,{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(id_plataforma)
            }).then(res => {
                TablaAdminPlataformas();
                TablaAdminMateriales();
                if(!res.ok){
                    console.log('Problem');
                    return;
                }
                return res.json();
            })
                .then(data => {
                    console.log('Success');
                    swalWithBootstrapButtons.fire({
                        title: "¡Desactivado!",
                        text: "La plataforma ha sido desactivada.",
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
                text: "La plataforma sigue activa y visible para todos.",
                icon: "error"
            });
        }
    });
}

function desactivarMaterial(id_descripcion){
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: "¿Estás seguro(a)?",
        text: "Al desactivar el material ya no estará disponible para solicitudes.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "¡Sí, desactivar!",
        cancelButtonText: "¡No, cancelar!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/desactivarMaterial.php?id_descripcion='+id_descripcion,{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(id_descripcion)
            }).then(res => {
                TablaAdminMateriales();
                if(!res.ok){
                    console.log('Problem');
                    return;
                }
                return res.json();
            })
                .then(data => {
                    console.log('Success');
                    swalWithBootstrapButtons.fire({
                        title: "¡Desactivado!",
                        text: "El material ha sido desactivado.",
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
                text: "El material sigue activo y visible para todos.",
                icon: "error"
            });
        }
    });
}

function desactivarUsuario(id_usuario){
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: "¿Estás seguro(a)?",
        text: "Al desactivar el perfil del usuario ya no podrá hacer solicitudes.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "¡Sí, desactivar!",
        cancelButtonText: "¡No, cancelar!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/desactivarUsuario.php?id_usuario='+id_usuario,{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(id_usuario)
            }).then(res => {
                TablaAdminUsuarios();
                if(!res.ok){
                    console.log('Problem');
                    return;
                }
                return res.json();
            })
                .then(data => {
                    console.log('Success');
                    swalWithBootstrapButtons.fire({
                        title: "¡Desactivado!",
                        text: "El perfil del usuario ha sido desactivado.",
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
                text: "El perfil del usuario sigue activo.",
                icon: "error"
            });
        }
    });
}