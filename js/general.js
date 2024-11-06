const id = str => document.getElementById(str);
const rutaBase = "https://grammermx.com/Metrologia/MetroTickets";

function reviewPDF(ID_PRUEBA) {
    var url = rutaBase + "/modules/review/pruebaPDF.php?id_prueba=" + ID_PRUEBA;
    window.open(url, '_blank');
}

function llenarTipoPruebaUpdate(idTipoPrueba, subtipo, imgCotas) {
    $.getJSON( rutaBase + '/dao/daoTipoPrueba.php', function (data) {
        var selectS = id("tipoPrueba");
        selectS.innerHTML = ""; //limpiar contenido

        var createOptionDef = document.createElement("option");
        createOptionDef.text = "Seleccione el tipo de prueba*";
        createOptionDef.value = "";
        selectS.appendChild(createOptionDef);

        for (var i = 0; i < data.data.length; i++) {
            var createOptionS = document.createElement("option");
            createOptionS.value = data.data[i].id_tipoPrueba;
            createOptionS.text = data.data[i].descripcionPrueba;
            selectS.appendChild(createOptionS);
            if (data.data[i].id_tipoPrueba === idTipoPrueba) {
                createOptionS.selected = true;
            }
        }
        banderaTipoPrueba();
    }).then(function() {
        if(idTipoPrueba === '3'){
            llenarSubtipoUpdate(idTipoPrueba, subtipo);
            if(subtipo === '2'){
                const divCotas = id("divCotas");
                const divPreview = id("divImgCotas");
                mostrarBloque(divCotas, true);
                mostrarBloque(divPreview, true);
                id("capturaCotas").src = imgCotas;
            }
        }
    }).catch(function(error) {
        // Manejar errores si la solicitud falla
        console.error('Error en la solicitud JSON: ', error);
    });
}

function isValidURL(url) {
    var regex = /^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([\/\w .-]*)*\/?$/;
    return regex.test(url);
}


function showButton(id_button){
    const button = id(id_button);
    button.style.display = "inline-block";
}

function hideButton(id_button){
    const button = id(id_button);
    button.style.display = "none";
}


function cargarPerfilUsuario(){
    $.getJSON( rutaBase + '/dao/daoConsultarPerfilUsuario.php', function (data) {
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

    fetch(rutaBase + '/dao/daoActualizarPerfil.php', {
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

function correoActualizacionPrueba(estatusPrueba, id_prueba, solicitantePrueba, emailSolicitante){
    const data = new FormData();
    let dao = rutaBase + '/Mailer/MailerActualizacionPrueba.php';

    data.append('id_prueba',id_prueba);
    data.append('solicitante',solicitantePrueba);
    data.append('emailSolicitante',emailSolicitante);
    //alert("estatus: "+estatusPrueba)

    if(estatusPrueba === '4'){
        dao = rutaBase + '/Mailer/MailerPruebaCompletada.php';
    }

    fetch(dao,{
        method: 'POST',
        body: data
    })
        .then(function (response){
            if (response.ok){
                //alert('Correo Actualizacion: prueba: ' +id_prueba+ 'user: ' + solicitantePrueba +' email: ' + emailSolicitante);
            }else{
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
function correoActualizacionPruebaLab(id_prueba){
    const data = new FormData();

    data.append('id_prueba',id_prueba);

    fetch(rutaBase + '/Mailer/MailerActualizacionPruebaLab.php',{
        method: 'POST',
        body: data
    })
        .then(function (response){
            if (response.ok){
                //alert('Correo Actualizacion: prueba: ' +id_prueba+ 'user: ' + solicitantePrueba);
                console.log("Correos enviados");
            }else{
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

const formatearFecha = (fecha) => {
    if (fecha !== '0000-00-00') {
        // Descomponemos la cadena de fecha en año, mes y día
        let [anio, mes, dia] = fecha.split('-');
        // Creamos la fecha usando estos valores para evitar problemas de zona horaria
        let date = new Date(anio, mes - 1, dia);

        let meses = ["ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep", "oct", "nov", "dic"];
        return `${date.getDate()}/${meses[date.getMonth()]}/${date.getFullYear()}`;
    } else {
        return 'No asignada';
    }
};



/*****************************************
 * funciones no validadas ---> ****************************
 * ********************************************/


function esURL(cadena) {
    let urlRegex = /^(ftp|http|https):\/\/[^ "]+$/;  // Expresión regular para verificar si resultadosSol es una URL
    let esUrl;
    esUrl = urlRegex.test(cadena);
    return esUrl;
}

function checkedInput() {
    const rutaRadio = document.getElementById('rutaRadio');
    const archivoRadio = document.getElementById('archivoRadio');
    const divResultados = document.getElementById('divCambiarResultados');
    let esUrl = esURL(resultadosSol);

    divResultados.style.display = 'block';

    if (esUrl) { // Es una url
        archivoRadio.checked = true;
    } else { // Es una ruta local
        rutaRadio.checked = true;
    }
}

function cambiarResultado(){
    const divResultados = document.getElementById('divResultados');
    const selectEstatus = document.getElementById('estatusPruebaAdmin');

    if (selectEstatus.value === '4') {
        divResultados.style.display = 'block';
        selectInputResultado();
    } else {
        divResultados.style.display = 'none';
    }
}

function selectInputResultado() {
    const rutaRadio = document.getElementById('rutaRadio');
    const archivoRadio = document.getElementById('archivoRadio');
    const resultadosAdminRuta = document.getElementById('resultadosAdminRuta');
    const resultadosAdminArchivo = document.getElementById('resultadosAdminArchivo');

    if (rutaRadio.checked) {
        resultadosAdminRuta.style.display = 'block';
        resultadosAdminArchivo.style.display = 'none';
    } else if (archivoRadio.checked) {
        resultadosAdminRuta.style.display = 'none';
        resultadosAdminArchivo.style.display = 'block';
    }
}


// Función para mostrar los valores del arreglo en un alert
function mostrarValores(arreglo, nombreArreglo) {
    let mensaje = nombreArreglo + ":\n";
    for (let i = 0; i < arreglo.length; i++) {
        mensaje += arreglo[i] + "\n";
    }
    alert(mensaje);
}


function capturarResultados(estatusPruebaAdmin){
    var divInputsResultados = id("divCambiarResultados");
    const rutaRadio = document.getElementById('rutaRadio');
    const archivoRadio = document.getElementById('archivoRadio');
    const enlaceResultados = document.getElementById('resultadosGuardados');
    var resultados = "Sin resultados";

    //Validar estatus de la prueba
    if (estatusPruebaAdmin.value === '4' && divInputsResultados !== null && divInputsResultados.offsetParent !== null ){ //Estatus completado(hay resultados)
        const resultadosAdminRuta = document.getElementById('resultadosAdminRuta');
        const resultadosAdminArchivo = document.getElementById('resultadosAdminArchivo');
        if (rutaRadio.checked && resultadosAdminRuta !== null && resultadosAdminRuta.value !== '') {
            resultados = resultadosAdminRuta.value.trim();
        }else if (archivoRadio.checked && resultadosAdminArchivo !== null && resultadosAdminArchivo.value !== '') {
            resultados = resultadosAdminArchivo.files[0];
        }
    }else if(enlaceResultados !== null) {
        if (rutaRadio.checked) {
            resultados = enlaceResultados.textContent;
        }else if(archivoRadio.checked) {
            resultados = enlaceResultados.href;
        }
    }

    if(resultados === "Sin resultados"){
        Swal.fire({
            title: "Error",
            text: "Debe indicar los resultados de la prueba.",
            icon: "error"
        });
        return;
    }
    return resultados;
}
function llenarResultados(){
    const inputResultadosGuardados = document.getElementById('resultadosGuardados');
    const btnResultados = document.getElementById('btnCambiarResultados');
    const divResultados = document.getElementById('divCambiarResultados');
    let enlaceResultados = document.getElementById('resultadosGuardados');

    if (resultadosSol === null || resultadosSol === '') {
        inputResultadosGuardados.style.display = 'none';
        btnResultados.style.display = 'none';
    }else {
        let esUrl = esURL(resultadosSol);
        if (esUrl) {
            enlaceResultados.href = resultadosSol;
            enlaceResultados.textContent = `${resultadosSol}`;
        } else {
            enlaceResultados.removeAttribute('href');  // Remueve el href para que no sea un enlace
            enlaceResultados.textContent = `${resultadosSol}`;
        }
        divResultados.style.display = 'none';
    }
}

function actualizarEnlaceResultados(id, resultadosPrueba) {
    // Obtiene el elemento usando el id proporcionado
    let enlaceResultados = document.getElementById(id);

    // Verifica si resultadosPrueba es una URL
    let esUrl = esURL(resultadosPrueba);

    if (esUrl) {
        // Si es una URL, actualiza el href del enlace
        enlaceResultados.href = resultadosPrueba;
        enlaceResultados.style.pointerEvents = "auto"; // Asegura que el enlace sea clickeable
        enlaceResultados.textContent = ""; // Limpia el texto si es una URL
    } else {
        // Si no es una URL, quita el href y desactiva el enlace
        enlaceResultados.removeAttribute('href');
        enlaceResultados.style.pointerEvents = "none";
        enlaceResultados.textContent = resultadosPrueba;
    }
}

function validarCorreo(id,div){
    const correoInput = document.getElementById(id);
    const correo = correoInput.value.trim();
    const dominioPermitido = '@grammer.com';

    if (!correo.endsWith(dominioPermitido)) {
        document.getElementById(div).innerHTML="<label id='lError' style='color:red; font-size:0.7rem;text-align: center;'>El correo debe tener el dominio '@grammer.com'</label>";
        return false;
    }else{
        if(document.getElementById('lError')) {
            document.getElementById('lError').style.display = "none";
        }

        return true;
    }

}

function validarPasswords(p1,p2,div){
    var password1 = document.getElementById(p1).value;
    var password2 = document.getElementById(p2).value;

    if (password1 !== password2) {
        document.getElementById(div).innerHTML="<label id='lbError' style='color:red;  text-align: center;'>Las contraseñas no coinciden.</label>";
        return false;
    }else{
        if(document.getElementById('lbError')) {
            document.getElementById('lbError').style.display = "none";
        }

        return true;
    }
}

function validarFormulario() {
    let isValid = true;

    // Validar que los campos no estén vacíos
    let inputs = document.querySelectorAll('#registrarseForm input[required]');
    inputs.forEach(function(input) {
        if (!input.value.trim()) {
            showErrorMessage(input, input.dataset.error);
            isValid = false;
        }else if (input.value.trim()) {
            hideErrorMessage(input);
        }
    });

    return isValid;
}

function showErrorMessage(input, message) {
    let errorDiv = input.nextElementSibling.nextElementSibling;
    errorDiv.textContent = message;
    errorDiv.style.display = 'block';
}

function hideErrorMessage(input) {
    let errorDiv = input.nextElementSibling.nextElementSibling;
    errorDiv.style.display = 'none';
}


// Función para cerrar sesión
function cerrarSesion() {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            Swal.fire("¡Sesión cerrada exitosamente!");
            window.location.href = rutaBase + "/modules/sesion/indexSesion.php";
        }
    };
    xhttp.open("POST", rutaBase + "/dao/login.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("cerrarSesion=true");
}

function ocultarContenido(clase,limiteCaracteres){
    const especificaciones = document.querySelectorAll("." + clase);
    especificaciones.forEach(function(especificacion) {
        const contenido = especificacion.textContent;
        if (contenido.length > limiteCaracteres) {
            const contenidoRecortado = contenido.substring(0, limiteCaracteres);
            const contenidoRestante = contenido.substring(limiteCaracteres, contenido.length);
            especificacion.innerHTML = contenidoRecortado + '<span class="hidden">' + contenidoRestante + '</span><button class="btn-ver-mas">Ver más...</button>';
        }
    });

    const botonesVerMas = document.querySelectorAll(".btn-ver-mas");
    botonesVerMas.forEach(function(boton) {
        boton.addEventListener("click", function() {
            const contenidoOculto = this.previousElementSibling;
            contenidoOculto.classList.toggle("hidden");
            if (this.textContent === "Ver más...") {
                this.textContent = "Ver menos";
            } else {
                this.textContent = "Ver más...";
            }
        });
    });
}

function validarSelect(idSelect) {
    const selectElement = document.getElementById(idSelect);
    const selectedValue = selectElement ? selectElement.value : null;
    // Utiliza nextElementSibling.nextElementSibling para obtener el div correcto
    const feedbackElement = selectElement ? selectElement.nextElementSibling.nextElementSibling : null;

    if (!selectedValue) {
        if (selectElement) {
            selectElement.parentElement.classList.add('has-error');
            selectElement.classList.add('is-invalid');
            if (feedbackElement) {
                feedbackElement.textContent = selectElement.getAttribute('data-error');
                feedbackElement.style.display = 'block';
            }
        }
        return false;
    } else {
        if (selectElement) {
            selectElement.parentElement.classList.remove('has-error');
            selectElement.classList.remove('is-invalid');
            if (feedbackElement) {
                feedbackElement.style.display = 'none';
            }
        }
        return true;
    }
}


function validarInput(idInput) {
    const inputElement = document.getElementById(idInput);
    if (inputElement) {
        const inputValue = inputElement.value.trim();
        const feedbackElement = inputElement.parentElement.querySelector('.invalid-feedback');

        if (!inputValue) {
            inputElement.classList.add('is-invalid');
            inputElement.parentElement.classList.add('has-error');
            if (feedbackElement) {
                feedbackElement.textContent = inputElement.getAttribute('data-error');
                feedbackElement.style.display = 'block';
            }
            return false;
        } else {
            inputElement.classList.remove('is-invalid');
            inputElement.parentElement.classList.remove('has-error');
            if (feedbackElement) {
                feedbackElement.style.display = 'none';
            }
            return true;
        }
    } else {
        console.log(`Elemento con id ${idInput} no encontrado.`);
        return false;
    }
}

function validarImagen(file) {
    const allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if (!allowedExtensions.exec(file.name)) {
        throw "Solo se permiten files de imagen con extensiones .jpg, .jpeg, .png, o .gif";
    }

    const maxSizeInBytes = 5 * 1024 * 1024; // 10 MB
    if (file.size > maxSizeInBytes) {
        throw "El tamaño del archivo es demasiado grande. Por favor seleccione una imagen más pequeña (menos de 10 MB).";
    }
}
