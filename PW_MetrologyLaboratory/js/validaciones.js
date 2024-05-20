function validarSelect() {
    const selectElement = document.getElementById('tipoEvaluacion');
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




