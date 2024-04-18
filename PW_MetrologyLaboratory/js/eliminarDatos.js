
function eliminarCliente(id_cliente) {
    console.log("id_cliente para eliminar: " + id_cliente);
    // Crear un objeto con los datos a enviar
    var datos = {
        id_descripcion: id_cliente
    };

    // Realizar una solicitud AJAX para eliminar el registro
    $.ajax({
        url: 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/eliminarMaterial.php',
        type: 'POST',
        dataType: 'json', // Esperamos una respuesta JSON del servidor
        contentType: 'application/json', // Especificamos el tipo de contenido que estamos enviando
        data: JSON.stringify(datos), // Convertimos el objeto a una cadena JSON
        success: function(response) {
            // Manejar la respuesta del servidor aquí
            console.log(response); // Puedes mostrar un mensaje de éxito o realizar alguna otra acción
        },
        error: function(xhr, status, error) {
            // Manejar errores de la solicitud AJAX aquí
            console.error(xhr.responseText);
        }
    });
}

function eliminarPlataforma(id_plataforma){
    console.log("id_plataforma para eliminar: " + id_plataforma);
}

function eliminarMaterial(id_descripcion){
    console.log("id_descripcion para eliminar: " + id_descripcion);
}