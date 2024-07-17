

function cancelarSolicitud(id_prueba){
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: "¿Estás seguro(a)?",
        text: "Si cancelas la solicitud y necesitas recuperarla, tendrás que crear una nueva.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "¡Sí!",
        cancelButtonText: "¡No!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoCancelarSolicitud.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id_prueba: id_prueba })
            }).then(res => {
                if(!res.ok){
                    console.log('Problem');
                    return;
                }
                return res.json();
            })
                .then(data => {
                    console.log('Success');
                    swalWithBootstrapButtons.fire({
                        title: "¡Cancelada!",
                        text: "La solicitud ha sido cancelada.",
                        icon: "success"
                    });
                })
                .catch(error => {
                    console.log(error);
                }).then(function(data) {
                    initDataTable(id_solicitante);
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire({
                title: "¡Detenido!",
                text: "La solicitud sigue activa.",
                icon: "error"
            });
        }
    });
}
