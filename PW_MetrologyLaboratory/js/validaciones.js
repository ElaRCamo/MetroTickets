function validarFormNewRequest(sEvaluacion,sTipoPrueba,iNorma){

    const esEvaluacionValido =  validarSelect(sEvaluacion);
    const esTipoPruebaValido =  validarSelect(sTipoPrueba);
    const esNormaValido = validarInput(iNorma);

    if(esEvaluacionValido && esTipoPruebaValido && esNormaValido){
        alert("inputs validos");
        //validacionSolicitud();
    }
}


function validarSelect(idSelect) {
    const selectElement = document.getElementById(idSelect);
    const selectedValue = selectElement.value;
    const errorMessage = selectElement.getAttribute('data-error');
    console.log("entrando a validarSelect");

    if (!selectedValue) {
        selectElement.classList.add('is-invalid');
        return false;
    } else {
        selectElement.classList.remove('is-invalid');
        return true;
    }
}

function validarInput(idInput) {
    const inputElement = document.getElementById(idInput);
    const inputValue = inputElement.value.trim();

    if (!inputValue) {
        inputElement.classList.add('is-invalid');
        return false;
    } else {
        inputElement.classList.remove('is-invalid');
        return true;
    }
}



