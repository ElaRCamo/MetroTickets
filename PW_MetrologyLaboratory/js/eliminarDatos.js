
function eliminarCliente(id_cliente) {
    console.log("id_cliente para eliminar: " + id_cliente);

    fetch('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/eliminarMaterial.php?id_cliente='+id_cliente,{
        method: 'DELETE'
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

function eliminarPlataforma(id_plataforma){
    console.log("id_plataforma para eliminar: " + id_plataforma);
}

function eliminarMaterial(id_descripcion){
    console.log("id_descripcion para eliminar: " + id_descripcion);
}