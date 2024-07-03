

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
