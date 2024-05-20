function validarFormNewRequest(idSelect){

    validarSelect(idSelect);

}


function validarSelect(idSelect) {
    const selectElement = document.getElementById(idSelect);
    const selectedValue = selectElement.value;
    const errorMessage = selectElement.getAttribute('data-error');

    if (!selectedValue) {
        selectElement.classList.add('is-invalid');
        return false;
    } else {
        selectElement.classList.remove('is-invalid');
        return true;
    }
}




