<main>
    <div class="page-content">
        <div id="tittle">
            <div class="LAB">
                <img id="logoInicio" src="../../imgs/Grammer_Logo.ico" alt="Logo Grammer">
            </div>
            <div class="LAB">
                <h1 class="">LABORATORIO DE</h1>
            </div>
            <div class="text-box">
                <h1 class="">METROLOGÍA</h1>
            </div>
        </div>
        <div class="wrapper">
            <form id="formInicioSesion" action="../../dao/login.php" method="post"  >
                <h2 id="iniciarSesion">Iniciar Sesión</h2>
                <div class="input-box form-group">
                    <input type="text" class="form-control" name="numNomina" id="numNomina" placeholder="No. de nómina" required data-error="Ingrese un número de nómina válido.">
                    <i class="las la-user"></i>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="input-box form-group">
                    <input type="password" class="form-control" name="password"  id="password" placeholder="Contraseña" required data-error="Ingrese una contraseña válida.">
                    <i class="las la-lock"></i>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox">Recuérdame</label>
                    <a href="recuperarPassword.php">¿Has olvidado la contraseña?</a>
                </div>

                <button type="submit" class="btn login" name="iniciarSesionBtn">Iniciar Sesión</button>

                <div class="register-link">
                    <p>¿No tienes cuenta? <a href="register.php">REGÍSTRATE</a> </p>
                </div>
            </form>
        </div>
    </div>
</main>
<footer class="footer_section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4 text-center">
                <small> Laboratorio de Metrología </small>
            </div>
            <div class="col-sm-4 text-center" >
                <small> © Grammer Querétaro. </small>
            </div>
            <div class="col-sm-4 text-center">
                <small> Soporte </small>
            </div>
        </div>
    </div>
</footer>
