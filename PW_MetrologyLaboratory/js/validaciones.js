function validarFormNewRequest(indexMaterial,sEvaluacion,sTipoPrueba,iNorma,iArchivo,iEspecial,iOtro,iEspecificaciones){
    const esEvaluacionValido =  validarSelect(sEvaluacion);
    const esTipoPruebaValido =  validarSelect(sTipoPrueba);
    const esNormaValido = validarInput(iNorma);
    const esArchivoValido = validarInput(iArchivo);
    const esPEspecialValido = validarInput(iEspecial);
    const esPOtroValido = validarInput(iOtro);
    const esObservacionesValido = validarInput(iEspecificaciones);

    var MaterialesValidos = [];
    var sonMaterialesValidos= false;
    for(var i=0; i<indexMaterial; i++){
        var esMaterialValido = false;
        var esClienteValido = validarSelect('cliente' + indexMaterial);
        alert("esClienteValido:"+esClienteValido);
        var esPlataformaValida = validarSelect('plataforma' + indexMaterial);
        alert("esPlataformaValida:"+esPlataformaValida);
        var esDescValida = validarSelect('descMaterial' + indexMaterial);
        alert("esDescValida:"+esDescValida);
        var esCdadValida = validarInput('cdadMaterial' + indexMaterial);
        alert("esCdadValida:"+esCdadValida);

        esMaterialValido = esClienteValido && esPlataformaValida && esDescValida && esCdadValida;
        MaterialesValidos.push(esMaterialValido);
    }
    for(var j=0; j<indexMaterial; j++){
        sonMaterialesValidos =++MaterialesValidos[j];
    }
    console.log("sonMaterialesValidos: "+sonMaterialesValidos);
    return sonMaterialesValidos;

    //const materialesValidos = validarMateriales(indexMaterial);
    //alert("materialesValidos: "+materialesValidos);

    if(esEvaluacionValido && esTipoPruebaValido && esObservacionesValido){
        //&& esNormaValido && esArchivoValido && esPEspecialValido && esPOtroValido
        alert("inputs validos");

    }
}

function validarMateriales(indexMaterial){
    var MaterialesValidos = [];
    var sonMaterialesValidos= false;
    for(var i=0; i<indexMaterial; i++){
        var esMaterialValido = false;
        var esClienteValido = validarSelect('cliente' + indexMaterial);
        var esPlataformaValida = validarSelect('plataforma' + indexMaterial);
        var esDescValida = validarSelect('descMaterial' + indexMaterial);
        var esCdadValida = validarInput('cdadMaterial' + indexMaterial);

        esMaterialValido = esClienteValido && esPlataformaValida && esDescValida && esCdadValida;
        MaterialesValidos.push(esMaterialValido);
    }
    for(var j=0; j<indexMaterial; j++){
        sonMaterialesValidos =++MaterialesValidos[j];
    }
    console.log("sonMaterialesValidos: "+sonMaterialesValidos);
    return sonMaterialesValidos;
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
    if( document.getElementById(idInput)!== null){
    const inputElement =  document.getElementById(idInput);
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
    }else{
        console.log("validacion temporal");
        return true;
    }
}
