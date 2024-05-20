function validarFormNewRequest(idSelect){
    alert("entrando a validarFormNewRequest");

    //validarSelect(idSelect);

    //validacionSolicitud();

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




