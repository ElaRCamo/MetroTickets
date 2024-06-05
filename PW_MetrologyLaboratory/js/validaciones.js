function validarFormNewRequest() {
    const esEvaluacionValido = validarSelect('tipoEvaluacion');
    const esTipoPruebaValido = validarSelect('tipoPrueba');
    const esNormaValido = validarInput('norma');
    const esArchivoValido = validarInput('normaFile');
    const esPEspecialValido = validarInput('tipoPruebaEspecial');
    const esPOtroValido = validarInput('otroPrueba');
    const esObservacionesValido = validarInput('especificaciones');

    // Validación de materiales
    let sonMaterialesValidos = true;

    for (let i = 1; i <= indexMaterial; i++) {
        const esClienteValido = validarSelect('cliente' + i);
        const esPlataformaValida = validarSelect('plataforma' + i);
        const esDescValida = validarSelect('descMaterial' + i);
        const esCdadValida = validarInput('cdadMaterial' + i);

        if (!esClienteValido || !esPlataformaValida || !esDescValida || !esCdadValida) {
            sonMaterialesValidos = false;
        }
    }

    console.log("sonMaterialesValidos: " + sonMaterialesValidos);

    if (esEvaluacionValido && esTipoPruebaValido && esObservacionesValido && sonMaterialesValidos) {
        //Validaciones pendientes, segun el tipo de norma
        //&& esNormaValido && esArchivoValido && esPEspecialValido && esPOtroValido
        console.log("Todos los inputs son válidos.");

        console.log("esActualizacion: " + esActualizacion);
        if (esActualizacion === false) {
            validacionSolicitud();
        } else if (esActualizacion === true) {
            actualizarSolicitud();
        }
    } else {
        console.log("Hay campos sin completar.");
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
        const feedbackElement = inputElement.nextElementSibling ? inputElement.nextElementSibling.nextElementSibling : null;

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


function validarMateriales(indexMaterial) {
    var MaterialesValidos = [];
    var sonMaterialesValidos = false;
    for (var i = 0; i < indexMaterial; i++) {
        var esMaterialValido = false;
        var esClienteValido = validarSelect('cliente' + indexMaterial);
        var esPlataformaValida = validarSelect('plataforma' + indexMaterial);
        var esDescValida = validarSelect('descMaterial' + indexMaterial);
        var esCdadValida = validarInput('cdadMaterial' + indexMaterial);

        esMaterialValido = esClienteValido && esPlataformaValida && esDescValida && esCdadValida;
        MaterialesValidos.push(esMaterialValido);
    }
    for (var j = 0; j < indexMaterial; j++) {
        sonMaterialesValidos = ++MaterialesValidos[j];
    }
    console.log("sonMaterialesValidos: " + sonMaterialesValidos);
    return sonMaterialesValidos;
}
