
function eliminarCliente(id_cliente) {
    console.log("id_cliente para eliminar: " + id_cliente);

    fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/desactivarCliente.php?id_cliente='+id_cliente,{
        method: 'POST'
        }).then(res => {
            TablaAdminClientes();
            if(!res.ok){
            console.log('Problem');
            return;
        }
            return res.json();
        })
        .then(data => {
            console.log('Success');
        })
        .catch(error =>{
            console.log(error);
        });
}
/*
const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: "btn btn-success",
    cancelButton: "btn btn-danger"
  },
  buttonsStyling: false
});
swalWithBootstrapButtons.fire({
  title: "Are you sure?",
  text: "You won't be able to revert this!",
  icon: "warning",
  showCancelButton: true,
  confirmButtonText: "Yes, delete it!",
  cancelButtonText: "No, cancel!",
  reverseButtons: true
}).then((result) => {
  if (result.isConfirmed) {
    swalWithBootstrapButtons.fire({
      title: "Deleted!",
      text: "Your file has been deleted.",
      icon: "success"
    });
  } else if (
result.dismiss === Swal.DismissReason.cancel
) {
    swalWithBootstrapButtons.fire({
        title: "Cancelled",
        text: "Your imaginary file is safe :)",
        icon: "error"
    });
}
});
 */
function eliminarPlataforma(id_plataforma){
    console.log("id_plataforma para eliminar: " + id_plataforma);
}

function eliminarMaterial(id_descripcion){
    console.log("id_descripcion para eliminar: " + id_descripcion);
}