function registrarUsuario(){

    var nomina = document.getElementById("nomina");
    var nombreUsuario = document.getElementById("nombreUsuario");
    var correo = document.getElementById("correo");
    var password = document.getElementById("password");

    const data = new FormData();

    data.append('numNomina', nomina.value.trim());
    data.append('nombreUsuario', nombreUsuario.value.trim());
    data.append('correo', correo.value.trim());
    data.append('password', password.value.trim());

    fetch('../../dao/userRegister.php', {
        method: 'POST',
        body: data
    })
        .then(function (response) {
            if (response.ok) { //respuesta
                alert("Usuario registrado exitosamente");
                window.location.href = "https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/sesion/Index.php";
            } else {
                throw "Error en la llamada Ajax";
            }
        })
        .then(function (texto) {
            console.log(texto);
        })
        .catch(function (err) {
            console.log(err);
        });
}