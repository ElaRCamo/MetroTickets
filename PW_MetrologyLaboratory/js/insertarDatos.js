function registrarUsuario(){

    var nomina = document.getElementById("nomina");
    var nombreUsuario = document.getElementById("nombreUsuario");
    var correo = document.getElementById("correo");
    var password = document.getElementById("password");

    const data = new FormData();

    data.append('numNomina', nomina.value.trim());
    data.append('nombreUsuario', nombreUsuario.value.trim());
    data.append('correo', correo.value);
    data.append('password', password.value);

    fetch('../../dao/userRegister.php', {
        method: 'POST',
        body: data
    })
        .then(function (response) {
            if (response.ok) { //respuesta
                console.log ('Usuario registrado')
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