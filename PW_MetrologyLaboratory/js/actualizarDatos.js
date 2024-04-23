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

function editarMaterial(id_descripcion){
    console.log("id_descripcion para editar: " + id_descripcion);
}

function editarPlataforma(id_plataforma){
    console.log("id_plataforma para editar: " + id_plataforma);
}