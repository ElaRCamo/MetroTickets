<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../../imgs/Grammer_Logo.ico" type="image/x-icon">
    <title>LM | Regístro </title>
    <!--Enlace de iconos: icons8, licencia con mención -->
    <link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" >
    <!--Fuente -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!--Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<main>
    <div class="page-content">
        <div id="tittle3">
            <div class="LAB">
                <img id="logoInicio3" src="../../imgs/Grammer_Logo.ico" alt="Logo Grammer">
            </div>
            <div class="LAB">
                <h1 class="">LABORATORIO DE</h1>
            </div>
            <div class="text-box"  id="divTitle3">
                <h1 class="">METROLOGÍA</h1>
            </div>
        </div>
        <div class="wrapper wrapper-register" id="divRegistro" >
            <form id="registrarseForm" method="POST">
                <h2 id="registrarseh2">Regístrarse</h2>
                <div id=aviso style='align-content:center;'></div>
                <div class="input-box form-group">
                    <input type="text" id="nombreUsuario" name="nombreUsuario" placeholder="Nombre Completo" required data-error="Por favor ingrese su nombre.">
                    <i class="las la-user-alt"></i><div class="invalid-feedback"></div>
                </div>
                <div class="input-box form-group">
                    <input type="text" id="correo" name="correo"  placeholder="Correo electrónico"  onchange="validarCorreo('correo')" required data-error="Por favor ingrese su correo.">
                    <i class="las la-envelope"></i><div class="invalid-feedback"></div>
                </div>
                <div class="input-box form-group">
                    <input type="text" id="numNomina" name="numNomina" placeholder="No. de nómina" required data-error="Por favor ingrese su número de nómina.">
                    <i class="las la-briefcase"></i><div class="invalid-feedback"></div>
                </div>
                <div class="input-box form-group">
                    <input type="password" id="password" name="password" placeholder="Contraseña" required data-error="Por favor ingrese su contraseña.">
                    <i class="las la-lock"></i><div class="invalid-feedback"></div>
                </div>
                <div class="input-box form-group">
                    <input type="password" id="password2" name="password2" placeholder="Confirmar contraseña" onchange="validarPasswords()" required data-error="Por favor ingrese su contraseña.">
                    <i class="las la-lock"></i><div class="invalid-feedback"></div>
                </div>

                <button type="button" id="registrarse" name="registrarse"  class="btn login" onclick="registrarUsuario()">Regístrarse</button>

                <div class="register-link" id="divIngresar">
                    <p>¿Ya tienes cuenta? <a href="indexSesion.php">INGRESAR</a> </p>
                </div>
            </form>
        </div>
    </div>
</main>

<?php
# Content section
require_once('../../footer.php')
?>

<script src="../../js/general.js"></script>
<script src="../../js/validaciones.js"></script>
<script src="../../js/insertarDatos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>