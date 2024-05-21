function validarFormNewRequest(sEvaluacion,sTipoPrueba,iNorma,iArchivo,iEspecial){

    const esEvaluacionValido =  validarSelect(sEvaluacion);
    const esTipoPruebaValido =  validarSelect(sTipoPrueba);
    const esNormaValido = validarInput(iNorma);
    const esArchivoValido = validarInput(iArchivo);
    const esPEspecialValido = validarInput(iEspecial);

    if(esEvaluacionValido && esTipoPruebaValido && esNormaValido && esArchivoValido && esPEspecialValido){
        alert("inputs validos");
        //validacionSolicitud();
    }
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
    const inputValue = inputElement.value.trim();
    const feedbackElement = inputElement ? inputElement.nextElementSibling.nextElementSibling : null;
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
}
